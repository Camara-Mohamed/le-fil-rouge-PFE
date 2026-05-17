<?php

namespace App\Policies;

use App\Models\Training;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Training $training): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isFormateur();
    }

    public function update(User $user, Training $training): bool
    {
        return $user->isAdmin() || ($user->isFormateur() && $training->user_id === $user->id);
    }

    public function delete(User $user, Training $training): bool
    {
        return $user->isAdmin() || ($user->isFormateur() && $training->user_id === $user->id);
    }

    public function restore(User $user, Training $training): bool
    {
        return false;
    }

    public function forceDelete(User $user, Training $training): bool
    {
        return false;
    }
}
