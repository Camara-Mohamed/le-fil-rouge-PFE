<?php

namespace App\Livewire;

use App\Livewire\Forms\CommentForm;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class Comments extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Model $model;

    public CommentForm $form;

    public function save(): void
    {
        $this->authorize('create', Comment::class);

        $this->form->store($this->model);
    }

    public function delete(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        $this->authorize('delete', $comment);

        $comment->delete();
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->model->comments()->with('user')->get(),
        ]);
    }
}
