<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiceCriteria extends Model
{
    protected $table = 'rice_criteria';

    protected $fillable = [
        'code',
        'name',
        'description',
        'weight',
        'type',
        'order',
    ];

    protected $casts = [
        'weight' => 'float',
        'order' => 'integer',
    ];

    /**
     * Get all scores for this criteria
     */
    public function scores(): HasMany
    {
        return $this->hasMany(RiceVarietyScore::class, 'criteria_id');
    }
}
