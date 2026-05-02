<?php

namespace App\Policies;

use App\Models\FormationUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormationUserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, FormationUser $formationUser): bool {}

    public function create(User $user): bool {}

    public function update(User $user, FormationUser $formationUser): bool {}

    public function delete(User $user, FormationUser $formationUser): bool {}

    public function restore(User $user, FormationUser $formationUser): bool {}

    public function forceDelete(User $user, FormationUser $formationUser): bool {}
}
