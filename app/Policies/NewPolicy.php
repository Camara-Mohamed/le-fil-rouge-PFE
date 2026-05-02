<?php

namespace App\Policies;

use App\Models\New;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, new $new): bool
    {
    }

public
function create(User $user): bool
{
}

public
function update(User $user, new $new): bool
    {
    }

    public function delete(User $user, new $new): bool
    {
    }

    public function restore(User $user, new $new): bool
    {
    }

    public function forceDelete(User $user, new $new): bool
    {
    }
}
