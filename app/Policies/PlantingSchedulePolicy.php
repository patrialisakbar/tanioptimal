<?php

namespace App\Policies;

use App\Models\PlantingSchedule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PlantingSchedulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PlantingSchedule $plantingSchedule): bool
    {
        return $user->id === $plantingSchedule->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PlantingSchedule $plantingSchedule): bool
    {
        return $user->id === $plantingSchedule->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PlantingSchedule $plantingSchedule): bool
    {
        return $user->id === $plantingSchedule->user_id;
    }
}
