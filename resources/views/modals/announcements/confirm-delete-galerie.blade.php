<?php

use App\Models\Galerie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
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
        $galerie = Galerie::findOrFail((int) $this->model_id);
        $this->authorize('update', $galerie->announcement);
        Storage::disk('public')->delete($galerie->path);
        $galerie->delete();

        $this->dispatch('galerie_deleted');
        $this->dispatch('toast', message: __('modals/announcements.delete_galerie_toast'), type: 'success');
        $this->dispatch('close_modal');
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/announcements.delete_galerie_title')"
    :message="__('modals/announcements.delete_galerie_message')"
    :confirm-label="__('modals/announcements.confirm')"
    :cancel-label="__('modals/announcements.cancel')"
/>
