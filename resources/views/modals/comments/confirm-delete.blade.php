<?php

use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

new class extends Component
{
    use AuthorizesRequests;

    public string $model_id   = '';
    public string $model_type = '';

    public function close(): void
    {
        $this->dispatch('close_modal');
    }

    public function confirm(): void
    {
        $this->authorize('delete', Comment::findOrFail((int) $this->model_id));

        $this->dispatch('comment_delete_confirmed', commentId: (int) $this->model_id);
        $this->dispatch('close_modal');
    }
};
?>

<x-modals.confirm-dialog
    title="{{ __('modals/comments.delete_title') }}"
    message="{{ __('modals/comments.delete_message') }}"
    confirm-label="{{ __('modals/comments.confirm') }}"
    cancel-label="{{ __('modals/comments.cancel') }}"
/>
