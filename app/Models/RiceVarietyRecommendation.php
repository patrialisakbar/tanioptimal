<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiceVarietyRecommendation extends Model
{
    protected $table = 'rice_variety_recommendations';

    protected $fillable = [
        'planting_schedule_id',
        'rice_variety_id',
        'suitability_score',
        'normalized_score',
        'rank',
        'suitability_level',
        'reasons',
    ];

    protected $casts = [
        'suitability_score' => 'decimal:3',
        'normalized_score' => 'decimal:3',
        'rank' => 'integer',
    ];

    /**
     * Get the planting schedule
     */
    public function plantingSchedule(): BelongsTo
    {
        return $this->belongsTo(PlantingSchedule::class);
    }

    /**
     * Get the rice variety
     */
    public function riceVariety(): BelongsTo
    {
        return $this->belongsTo(RiceVariety::class);
    }
}