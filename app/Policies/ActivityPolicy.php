<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;

class ActivityPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any activity.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the activity.
     *
     * @param User $user
     * @param Activity $activity
     * @return bool
     */
    public function view(User $user, Activity $activity): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create activities.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the activity.
     *
     * @param User $user
     * @param Activity $activity
     * @return bool
     */
    public function update(User $user, Activity $activity): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the activity.
     *
     * @param User $user
     * @param Activity $activity
     * @return bool
     */
    public function delete(User $user, Activity $activity): bool
    {
        return $user->hasRole('admin');
    }
}
