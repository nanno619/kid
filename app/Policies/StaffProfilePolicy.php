<?php

namespace App\Policies;

use App\Models\StaffProfile;
use App\Models\User;

class StaffProfilePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('staff-profiles.view');
    }

    public function view(User $user, StaffProfile $staffProfile): bool
    {
        return $user->can('staff-profiles.view')
            || ($staffProfile->user_id === $user->id && $user->can('staff-profiles.view-own'));
    }

    public function update(User $user, StaffProfile $staffProfile): bool
    {
        return $user->can('staff-profiles.edit')
            || ($staffProfile->user_id === $user->id && $user->can('staff-profiles.edit-own'));
    }
}
