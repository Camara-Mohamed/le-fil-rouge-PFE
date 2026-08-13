<?php

use App\Enums\TrainingStatus;
use App\Models\Training;
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

        Training::findOrFail((int) $this->model_id)->update(['status' => TrainingStatus::REFUSED]);

        $this->dispatch('toast', message: __('toast/trainings.updated'), type: 'error');
        $this->dispatch('dashboard_updated');
        $this->dispatch('close_modal');
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/dashboard.refuse_training_title')"
    :message="__('modals/dashboard.refuse_training_message')"
    :confirm-label="__('modals/dashboard.confirm')"
    :cancel-label="__('modals/dashboard.cancel')"
/>
