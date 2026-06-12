<?php

namespace App\Livewire;

use App\Livewire\Forms\CommentForm;
use Illuminate\Support\Facades\Notification;
use App\Models\Comment;
use App\Notifications\NewCommentNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
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

        try {
            $creator = $this->model->user;
            if ($creator && $creator->id !== auth()->id()) {
                $notif = new NewCommentNotification($this->model, auth()->user());
                $creator->notify($notif);
                Notification::route('mail', config('mail.notification_for_mails'))->notify($notif);
            }
        } catch (\Throwable) {}
    }

    public function openDeleteModal(int $commentId): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::comments.confirm-delete',
            'model_id' => (string) $commentId,
            'model_type' => 'comment',
        ]);
    }

    #[On('comment_delete_confirmed')]
    public function deleteConfirmed(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        $this->authorize('delete', $comment);

        if ($comment->document) {
            Storage::disk('s3')->delete($comment->document);
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
