<?php

use App\Enums\CampStatus;
use App\Models\Camp;
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

        Camp::findOrFail((int) $this->model_id)->update(['status' => CampStatus::REFUSED]);

        $this->dispatch('toast', message: __('toast/camps.updated', ['type' => 'camp']), type: 'error');
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
