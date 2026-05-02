<?php

namespace App\Policies;

use App\Models\NewEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewEventPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, NewEvent $newEvent): bool
    {
    }

public
function create(User $user): bool
{
}

public
function update(User $user, NewEvent $newEvent): bool
    {
    }

    public function delete(User $user, NewEvent $newEvent): bool
    {
    }

    public function restore(User $user, NewEvent $newEvent): bool
    {
    }

    public function forceDelete(User $user, NewEvent $newEvent): bool
    {
    }
}
