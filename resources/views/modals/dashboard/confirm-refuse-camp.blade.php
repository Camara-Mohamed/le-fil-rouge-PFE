<?php

use App\Enums\CampStatus;
use App\Events\BroadcastRefresh;
use App\Models\Camp;
use App\Notifications\ModelStatusNotification;
use Livewire\Component;

new class extends Component
{
    public string $model_id   = '';
    public string $model_type = '';

    public function close(): void
    {
        $this->dispatch('close_modal');
    }

    public function confirm(): void
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $camp = Camp::with('user')->findOrFail((int) $this->model_id);
        $camp->update(['status' => CampStatus::REFUSED]);

        try {
            $camp->user->notify(new ModelStatusNotification($camp, 'le camp', published: false));
        } catch (\Throwable) {}

        $this->dispatch('toast', message: __('toast/camps.updated', ['type' => 'camp']), type: 'error');
        broadcast(new BroadcastRefresh('dashboard'))->toOthers();
        $this->dispatch('dashboard_updated');
        $this->dispatch('close_modal');
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/dashboard.refuse_camp_title')"
    :message="__('modals/dashboard.refuse_camp_message')"
    :confirm-label="__('modals/dashboard.confirm')"
    :cancel-label="__('modals/dashboard.cancel')"
/>
