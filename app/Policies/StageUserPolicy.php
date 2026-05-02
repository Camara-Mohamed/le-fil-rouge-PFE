<?php

namespace App\Policies;

use App\Models\StageUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StageUserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, StageUser $stageUser): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, StageUser $stageUser): bool
    {
    }

    public function delete(User $user, StageUser $stageUser): bool
    {
    }

    public function restore(User $user, StageUser $stageUser): bool
    {
    }

    public function forceDelete(User $user, StageUser $stageUser): bool
    {
    }
}
