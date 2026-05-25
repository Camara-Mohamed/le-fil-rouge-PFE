<?php

namespace App\Policies;

use App\Models\Comment;
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
        return true;
    }

    public function update(User $user, Comment $comment):
    bool
    {
        return $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($comment->user_id === $user->id) {
            return true;
        }

        if ($comment->training_id && $user->isFormateur()) {
            return $comment->training->user_id === $user->id;
        }

        if ($comment->camp_id && $user->isCoordinateur()) {
            return $comment->camp->user_id === $user->id;
        }

        if ($comment->announcement_id) {
            return $comment->announcement->user_id === $user->id;
        }

        return false;
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
