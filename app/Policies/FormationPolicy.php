<?php

namespace App\Policies;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, Formation $formation): bool {}

    public function create(User $user): bool {}

    public function update(User $user, Formation $formation): bool {}

    public function delete(User $user, Formation $formation): bool {}

    public function restore(User $user, Formation $formation): bool {}

    public function forceDelete(User $user, Formation $formation): bool {}
}
