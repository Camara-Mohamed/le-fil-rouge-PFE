<?php

use App\Models\Announcement;
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
        $announcement = Announcement::findOrFail((int) $this->model_id);
        $this->authorize('delete', $announcement);
        $announcement->delete();

        $this->dispatch('toast', message: __('modals/announcements.delete_toast'), type: 'success');
        $this->dispatch('close_modal');
        $this->redirectRoute('public.announcements.index', ['locale' => app()->getLocale()]);
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/announcements.delete_title')"
    :message="__('modals/announcements.delete_message')"
    :confirm-label="__('modals/announcements.confirm')"
    :cancel-label="__('modals/announcements.cancel')"
/>
