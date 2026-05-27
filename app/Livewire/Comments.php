<?php

namespace App\Livewire;

use App\Livewire\Forms\CommentForm;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
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
        $this->dispatch('toast', message: __('toast/comments.created'), type: 'success');
    }

    public function delete(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        $this->authorize('delete', $comment);

        if ($comment->document) {
            Storage::disk('public')->delete($comment->document);
        }

        $comment->delete();

        $this->dispatch('toast', message: __('toast/comments.deleted'), type: 'success');
    }

    public function render()
    {
        return view('livewire.comments', [
            'comments' => $this->model->comments()->with('user')->get(),
        ]);
    }
}
