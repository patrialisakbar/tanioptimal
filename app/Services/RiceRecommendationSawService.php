<?php

namespace App\Services;

use App\Models\RiceCriteria;
use App\Models\RiceVariety;
use App\Models\RiceVarietyScore;
use App\Models\RiceVarietyRecommendation;
use App\Models\PlantingSchedule;
use Illuminate\Support\Collection;

/**
 * Service untuk menghitung rekomendasi varietas padi menggunakan metode SAW
 * (Simple Additive Weighting)
 */
class RiceRecommendationSawService
{
    /**
     * Calculate SAW score untuk semua rice varieties berdasarkan criteria
     * 
     * @return array
     */
    public function calculateAllVarietiesScore(): array
    {
        $varieties = RiceVariety::all();
        $criteria = RiceCriteria::orderBy('order')->get();

        $results = [];

        foreach ($varieties as $variety) {
            $results[$variety->id] = [
                'variety' => $variety,
                'scores' => [],
                'final_score' => 0,
            ];

            // Hitung score untuk setiap criteria
            foreach ($criteria as $criterion) {
                $score = RiceVarietyScore::where('rice_variety_id', $variety->id)
                    ->where('criteria_id', $criterion->id)
                    ->first();

                if ($score) {
                    $results[$variety->id]['scores'][$criterion->code] = [
                        'criteria' => $criterion,
                        'raw_score' => $score->score,
                        'weight' => $criterion->weight,
                        'type' => $criterion->type,
                    ];
                }
            }

            // Hitung final score
            $results[$variety->id]['final_score'] = $this->calculateFinalScore($results[$variety->id]['scores']);
        }

        // Sort by final score descending
        usort($results, function ($a, $b) {
            return $b['final_score'] <=> $a['final_score'];
        });

        return $results;
    }

    /**
     * Calculate final SAW score dari individual scores
     * 
     * Formula SAW yang BENAR:
     * 1. Normalisasi untuk setiap kriteria:
     *    - Benefit: R_ij = X_ij / Max(X_ij)
     *    - Cost: R_ij = Min(X_ij) / X_ij
     * 2. Final Score: V_i = Σ(W_j * R_ij)
     * 
     * @param array $scores Array dari criteria scores
     * @return float Final score (0-1, akan dikonversi ke persentase)
     */
    public function calculateFinalScore(array $scores): float
    {
        if (empty($scores)) {
            return 0;
        }

        $weightedSum = 0;
        $totalWeight = 0;

        foreach ($scores as $criteriaCode => $scoreData) {
            $weight = $scoreData['weight'];
            $totalWeight += $weight;

            // Normalize score berdasarkan type (benefit atau cost)
            $normalizedScore = $this->normalizeScore(
                $scoreData['raw_score'],
                $scoreData['type'],
                $criteriaCode
            );

            $weightedSum += $weight * $normalizedScore;
        }

        // Final score = Σ(W_j * R_ij) / Total Weight
        // Dikali 100 untuk persentase jika diperlukan di frontend
        $finalScore = $totalWeight > 0 ? ($weightedSum / $totalWeight) : 0;
        
        return $finalScore;
    }

    /**
     * Normalize score untuk SAW (METODE YANG BENAR)
     * 
     * @param float $score Raw score (1-3)
     * @param string $type 'benefit' atau 'cost'
     * @param string $criteriaCode Code kriteria untuk reference
     * @return float Normalized score (0-1)
     */
    private function normalizeScore(float $score, string $type, string $criteriaCode): float
    {
        // Get max and min score untuk kriteria ini dari semua varietas
        $criteria = RiceCriteria::where('code', $criteriaCode)->first();
        
        if (!$criteria) {
            return 0;
        }

        $allScoresForCriteria = RiceVarietyScore::where('criteria_id', $criteria->id)
            ->pluck('score')
            ->toArray();

        if (empty($allScoresForCriteria)) {
            return 0;
        }

        $maxScore = max($allScoresForCriteria);
        $minScore = min($allScoresForCriteria);

        // Normalisasi berdasarkan type SESUAI METODE SAW
        if ($type === 'benefit') {
            // Benefit: R_ij = X_ij / Max(X_ij)
            return $maxScore > 0 ? $score / $maxScore : 0;
        } else {
            // Cost: R_ij = Min(X_ij) / X_ij
            return $score > 0 ? $minScore / $score : 0;
        }
    }

    /**
     * Generate recommendations untuk planting schedule
     * 
     * @param PlantingSchedule $plantingSchedule
     * @return Collection RiceVarietyRecommendation
     */
    public function generateRecommendations(PlantingSchedule $plantingSchedule): Collection
    {
        // Delete existing recommendations
        RiceVarietyRecommendation::where('planting_schedule_id', $plantingSchedule->id)
            ->delete();

        // Calculate scores untuk semua varieties
        $scoresResult = $this->calculateAllVarietiesScore();

        $recommendations = [];
        $rank = 1;

        foreach ($scoresResult as $varietyId => $result) {
            $suitabilityLevel = $this->determineSuitabilityLevel($result['final_score']);

            $recommendation = RiceVarietyRecommendation::create([
                'planting_schedule_id' => $plantingSchedule->id,
                'rice_variety_id' => $result['variety']->id,
                'suitability_score' => $result['final_score'],
                'normalized_score' => $result['final_score'] * 100, // Convert to percentage
                'rank' => $rank,
                'suitability_level' => $suitabilityLevel,
                'reasons' => $this->generateReasons($result['variety'], $result['scores']),
            ]);

            $recommendations[] = $recommendation;
            $rank++;
        }

        return collect($recommendations);
    }

    /**
     * Determine suitability level berdasarkan score
     * 
     * @param float $score Score (0-1)
     * @return string
     */
    private function determineSuitabilityLevel(float $score): string
    {
        if ($score >= 0.8) {
            return 'Sangat cocok';
        } elseif ($score >= 0.6) {
            return 'Cukup cocok';
        } elseif ($score >= 0.4) {
            return 'Kurang cocok';
        } else {
            return 'Tidak cocok';
        }
    }

    /**
     * Generate readable reasons untuk rekomendasi
     * 
     * @param RiceVariety $variety
     * @param array $scores
     * @return string
     */
    private function generateReasons(RiceVariety $variety, array $scores): string
    {
        $reasons = [];

        foreach ($scores as $criteriaCode => $scoreData) {
            $criteria = $scoreData['criteria'];
            $score = $scoreData['raw_score'];

            if ($score >= 3) {
                $reasons[] = "✓ {$criteria->name} (skor: {$score}/3)";
            } elseif ($score <= 1) {
                $reasons[] = "✗ {$criteria->name} (skor: {$score}/3)";
            }
        }

        return implode("\n", $reasons);
    }

    /**
     * Get top N recommendations
     * 
     * @param PlantingSchedule $plantingSchedule
     * @param int $limit
     * @return Collection
     */
    public function getTopRecommendations(PlantingSchedule $plantingSchedule, int $limit = 3): Collection
    {
        return $plantingSchedule->recommendations()
            ->with('riceVariety')
            ->orderBy('rank')
            ->limit($limit)
            ->get();
    }
}