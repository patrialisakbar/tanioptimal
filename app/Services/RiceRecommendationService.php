<?php

namespace App\Services;

use App\Models\RiceVariety;
use Illuminate\Support\Collection;

class RiceRecommendationService
{
    /**
     * Get rice variety recommendations based on criteria
     */
    public function getRecommendations(array $criteria): Collection
    {
        $varieties = RiceVariety::all();

        $scored = $varieties->map(function (RiceVariety $variety) use ($criteria) {
            $score = $this->calculateMatchScore($variety, $criteria);
            return (object) [
                'variety' => $variety,
                'score' => $score,
            ];
        })->filter(function ($item) {
            return $item->score > 0;
        })->sortByDesc('score');

        return $scored->take(10)->pluck('variety');
    }

    /**
     * Calculate match score for a variety
     */
    public function calculateMatchScore(RiceVariety $variety, array $criteria): float
    {
        $score = 0;
        $maxScore = 0;

        // Soil type (20%)
        $maxScore += 20;
        if (!empty($criteria['soil_type']) && $variety->soil_type === $criteria['soil_type']) {
            $score += 20;
        }

        // Rainfall category (15%)
        $maxScore += 15;
        if (!empty($criteria['rainfall_category']) && $variety->rainfall_category === $criteria['rainfall_category']) {
            $score += 15;
        }

        // Temperature (15%)
        $maxScore += 15;
        if (!empty($criteria['temperature_optimal']) && $variety->temperature_optimal === $criteria['temperature_optimal']) {
            $score += 15;
        }

        // Elevation (15%)
        $maxScore += 15;
        if (!empty($criteria['elevation_category']) && $variety->elevation_category === $criteria['elevation_category']) {
            $score += 15;
        }

        // Water availability (15%)
        $maxScore += 15;
        if (!empty($criteria['water_availability']) && $variety->water_availability === $criteria['water_availability']) {
            $score += 15;
        }

        // Salinity (10%)
        $maxScore += 10;
        if (!empty($criteria['salinity_category']) && $variety->salinity_category === $criteria['salinity_category']) {
            $score += 10;
        }

        // Threats (10%)
        $maxScore += 10;
        if (!empty($criteria['threats']) && $variety->threats) {
            $varietyThreats = is_array($variety->threats) ? $variety->threats : json_decode($variety->threats, true);
            if (in_array($criteria['threats'], $varietyThreats)) {
                $score += 10;
            }
        }

        return ($score / $maxScore) * 100;
    }

    /**
     * Format variety for response
     */
    public function formatVarietyForResponse(RiceVariety $variety, float $score): array
    {
        $threats = is_array($variety->threats) ? $variety->threats : json_decode($variety->threats, true) ?? [];

        return [
            'id' => $variety->id,
            'name' => $variety->name,
            'description' => $variety->description,
            'soil_type' => $variety->soil_type,
            'rainfall_category' => $variety->rainfall_category,
            'temperature_optimal' => $variety->temperature_optimal,
            'elevation_category' => $variety->elevation_category,
            'water_availability' => $variety->water_availability,
            'salinity_category' => $variety->salinity_category,
            'threats' => $threats,
            'yield_potential' => $variety->yield_potential,
            'maturity_days' => $variety->maturity_days,
            'match_score' => round($score, 1),
        ];
    }
}
