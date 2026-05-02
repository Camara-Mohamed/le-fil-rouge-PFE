<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, UserDocument $userDocument): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, UserDocument $userDocument): bool
    {
    }

    public function delete(User $user, UserDocument $userDocument): bool
    {
    }

    public function restore(User $user, UserDocument $userDocument): bool
    {
    }

    public function forceDelete(User $user, UserDocument $userDocument): bool
    {
    }
}
