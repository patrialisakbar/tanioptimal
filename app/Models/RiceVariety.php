<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiceVariety extends Model
{
    protected $table = 'rice_varieties';

    protected $fillable = [
        'name',
        'description',
        'soil_type',
        'rainfall_category',
        'temperature_optimal',
        'elevation_category',
        'water_availability',
        'salinity_category',
        'threats',
        'yield_potential',
        'maturity_days',
    ];

    protected $casts = [
        'threats' => 'array',
        'yield_potential' => 'float',
        'maturity_days' => 'integer',
    ];

    /**
     * Get all SAW scores for this rice variety
     */
    public function scores(): HasMany
    {
        return $this->hasMany(RiceVarietyScore::class);
    }

    /**
     * Get all recommendations for this rice variety
     */
    public function recommendations(): HasMany
    {
        return $this->hasMany(RiceVarietyRecommendation::class);
    }
}
