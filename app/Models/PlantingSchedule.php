<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantingSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'location',
        'rice_variety',
        'rice_variety_id',
        'planned_planting_date',
        'planned_harvest_date',
        'field_size_hectares',
        'notes',
        'status',
    ];

    protected $casts = [
        'planned_planting_date' => 'date',
        'planned_harvest_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function riceVariety(): BelongsTo
    {
        return $this->belongsTo(RiceVariety::class, 'rice_variety_id');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['planned', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
