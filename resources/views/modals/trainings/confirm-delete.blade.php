<?php

use App\Models\Training;
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
        $training = Training::findOrFail((int) $this->model_id);
        $this->authorize('delete', $training);
        $training->delete();

        $this->dispatch('toast', message: __('modals/trainings.delete_toast'), type: 'success');
        $this->dispatch('close_modal');
        $this->redirectRoute('public.trainings.index', ['locale' => app()->getLocale()]);
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/trainings.delete_title')"
    :message="__('modals/trainings.delete_message')"
    :confirm-label="__('modals/trainings.confirm')"
    :cancel-label="__('modals/trainings.cancel')"
/>
