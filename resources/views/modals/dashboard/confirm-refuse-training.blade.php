<?php

use App\Enums\TrainingStatus;
use App\Events\BroadcastRefresh;
use App\Models\Training;
use App\Notifications\ModelStatusNotification;
use Livewire\Component;

new class extends Component
{
    public string $model_id = '';

    public string $model_type = '';

    public function close(): void
    {
        $this->dispatch('close_modal');
    }

    public function confirm(): void
    {
        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        $training = Training::with('user')->findOrFail((int) $this->model_id);
        $training->update(['status' => TrainingStatus::REFUSED]);

        try {
            $training->user->notify(new ModelStatusNotification($training, 'la formation', published: false));
        } catch (Throwable) {
        }

        $this->dispatch('toast', message: __('toast/trainings.updated'), type: 'error');
        try {
            broadcast(new BroadcastRefresh('dashboard'))->toOthers();
        } catch (Throwable) {
        }
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
