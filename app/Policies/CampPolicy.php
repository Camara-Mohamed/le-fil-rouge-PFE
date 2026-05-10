<?php

namespace App\Policies;

use App\Models\Camp;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Camp $camp): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isCoordinateur();
    }

    public function update(User $user, Camp $camp): bool
    {
        return $user->isAdmin() || ($user->isCoordinateur() && $camp->user_id === $user->id);
    }

    public function delete(User $user, Camp $camp): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Camp $camp): bool
    {
        return false;
    }

    public function forceDelete(User $user, Camp $camp): bool
    {
        return false;
    }
}
