<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiceVarietyScore extends Model
{
    protected $table = 'rice_variety_scores';

    protected $fillable = [
        'rice_variety_id',
        'criteria_id',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    /**
     * Get the rice variety
     */
    public function riceVariety(): BelongsTo
    {
        return $this->belongsTo(RiceVariety::class);
    }

    /**
     * Get the criteria
     */
    public function criteria(): BelongsTo
    {
        return $this->belongsTo(RiceCriteria::class);
    }
}
