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
    title="Supprimer ce commentaire ?"
    message="Cette action est irréversible. Le commentaire ne pourra pas être récupéré."
    confirm-label="Supprimer"
    cancel-label="Annuler"
/>
