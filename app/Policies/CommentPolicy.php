<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Comment;
use App\Models\Training;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Comment $comment): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Comment $comment):
    bool
    {
        return $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment, Training $training, Camp $camp, Announcement $announcement): bool
    {
        return $user->isAdmin() || ($comment->user_id === $user->id) || ($user->isFormateur() && $training->user_id
                === $user->id) || ($user->isCoordinateur() && $camp->user_id === $user->id) || ($announcement->user_id === $user->id);
    }

    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
