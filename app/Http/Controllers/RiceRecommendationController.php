<?php

namespace App\Http\Controllers;

use App\Models\PlantingSchedule;
use App\Models\RiceVariety;
use App\Models\RiceCriteria;
use App\Models\RiceVarietyRecommendation;
use App\Services\RiceRecommendationSawService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RiceRecommendationController extends Controller
{
    protected RiceRecommendationSawService $sawService;

    public function __construct(RiceRecommendationSawService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * Get all rice criteria dengan bobot dan deskripsi
     */
    public function getCriteria(): JsonResponse
    {
        $criteria = RiceCriteria::orderBy('order')->get()->map(fn($c) => [
            'id' => $c->id,
            'code' => $c->code,
            'name' => $c->name,
            'description' => $c->description,
            'weight' => $c->weight,
            'type' => $c->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Criteria retrieved successfully',
            'data' => $criteria,
            'total_weight' => $criteria->sum('weight'),
        ]);
    }

    /**
     * Get semua rice varieties dengan scores mereka
     */
    public function getVarieties(): JsonResponse
    {
        $varieties = RiceVariety::with(['scores.criteria'])->get()->map(fn($v) => [
            'id' => $v->id,
            'name' => $v->name,
            'description' => $v->description,
            'soil_type' => $v->soil_type,
            'rainfall_category' => $v->rainfall_category,
            'temperature_optimal' => $v->temperature_optimal,
            'elevation_category' => $v->elevation_category,
            'water_availability' => $v->water_availability,
            'yield_potential' => $v->yield_potential,
            'maturity_days' => $v->maturity_days,
            'scores' => $v->scores->map(fn($s) => [
                'criteria_code' => $s->criteria->code,
                'criteria_name' => $s->criteria->name,
                'score' => $s->score,
                'weight' => $s->criteria->weight,
            ])->keyBy('criteria_code'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rice varieties retrieved successfully',
            'data' => $varieties,
            'total' => count($varieties),
        ]);
    }

    /**
     * Get SAW scores untuk semua varieties (untuk analysis)
     */
    public function getSawScores(): JsonResponse
    {
        $scoresResult = $this->sawService->calculateAllVarietiesScore();

        $data = array_map(fn($result, $idx) => [
            'rank' => $idx + 1,
            'variety_id' => $result['variety']->id,
            'variety_name' => $result['variety']->name,
            'description' => $result['variety']->description,
            'final_score' => round($result['final_score'], 3),
            'percentage' => round($result['final_score'] * 100, 2) . '%',
            'suitability_level' => $this->determineSuitabilityLevel($result['final_score']),
            'scores_per_criteria' => array_map(fn($s) => [
                'code' => array_key_first([$s]),
                'weight' => $s['weight'],
                'raw_score' => $s['raw_score'],
            ], $result['scores']),
        ], $scoresResult, array_keys($scoresResult));

        return response()->json([
            'success' => true,
            'message' => 'SAW scores calculated successfully',
            'data' => array_values($data),
            'total' => count($data),
        ]);
    }

    /**
     * Generate recommendations untuk planting schedule tertentu
     */
    public function generateRecommendations(PlantingSchedule $plantingSchedule): JsonResponse
    {
        $recommendations = $this->sawService->generateRecommendations($plantingSchedule);

        $data = $recommendations->map(fn($r) => [
            'id' => $r->id,
            'rank' => $r->rank,
            'rice_variety' => [
                'id' => $r->riceVariety->id,
                'name' => $r->riceVariety->name,
                'description' => $r->riceVariety->description,
                'soil_type' => $r->riceVariety->soil_type,
                'water_availability' => $r->riceVariety->water_availability,
                'yield_potential' => $r->riceVariety->yield_potential,
                'maturity_days' => $r->riceVariety->maturity_days,
            ],
            'suitability_score' => round($r->suitability_score, 3),
            'percentage' => round($r->normalized_score, 2) . '%',
            'suitability_level' => $r->suitability_level,
            'reasons' => $r->reasons,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recommendations generated successfully',
            'planting_schedule_id' => $plantingSchedule->id,
            'data' => $data,
            'total' => count($data),
        ]);
    }

    /**
     * Get recommendations untuk planting schedule (yang sudah di-generate)
     */
    public function getRecommendations(PlantingSchedule $plantingSchedule, ?int $limit = null): JsonResponse
    {
        if ($plantingSchedule->recommendations()->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'No recommendations found. Generate recommendations first.',
            ], 404);
        }

        $query = $plantingSchedule->recommendations()->with('riceVariety')->orderBy('rank');
        
        if ($limit) {
            $query->limit($limit);
        }

        $recommendations = $query->get();

        $data = $recommendations->map(fn($r) => [
            'id' => $r->id,
            'rank' => $r->rank,
            'rice_variety' => [
                'id' => $r->riceVariety->id,
                'name' => $r->riceVariety->name,
                'description' => $r->riceVariety->description,
                'soil_type' => $r->riceVariety->soil_type,
                'water_availability' => $r->riceVariety->water_availability,
                'yield_potential' => $r->riceVariety->yield_potential,
                'maturity_days' => $r->riceVariety->maturity_days,
            ],
            'suitability_score' => round($r->suitability_score, 3),
            'percentage' => round($r->normalized_score, 2) . '%',
            'suitability_level' => $r->suitability_level,
            'reasons' => $r->reasons,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recommendations retrieved successfully',
            'planting_schedule_id' => $plantingSchedule->id,
            'data' => $data,
            'total' => count($data),
        ]);
    }

    /**
     * Get top N recommendations untuk planting schedule
     */
    public function getTopRecommendations(PlantingSchedule $plantingSchedule, int $limit = 3): JsonResponse
    {
        $recommendations = $this->sawService->getTopRecommendations($plantingSchedule, $limit);

        if ($recommendations->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No recommendations found.',
            ], 404);
        }

        $data = $recommendations->map(fn($r) => [
            'id' => $r->id,
            'rank' => $r->rank,
            'rice_variety' => [
                'id' => $r->riceVariety->id,
                'name' => $r->riceVariety->name,
                'yield_potential' => $r->riceVariety->yield_potential,
                'maturity_days' => $r->riceVariety->maturity_days,
            ],
            'suitability_score' => round($r->suitability_score, 3),
            'percentage' => round($r->normalized_score, 2) . '%',
            'suitability_level' => $r->suitability_level,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Top recommendations retrieved successfully',
            'planting_schedule_id' => $plantingSchedule->id,
            'limit' => $limit,
            'data' => $data,
            'total' => count($data),
        ]);
    }

    /**
     * Determine suitability level berdasarkan score
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
}
