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

<div x-data x-init="$refs.dialog.showModal()">
    <dialog
        x-ref="dialog"
        @close="$wire.close()"
        class="rounded-lg shadow-xl w-full max-w-sm p-0 backdrop:bg-black/50"
    >
        <div class="p-6 flex flex-col gap-4">

            <div class="flex justify-between items-center">
                <h2>{{ __('modals/dashboard.refuse_training_title') }}</h2>
                <button type="button" wire:click="close">Fermer</button>
            </div>

            <p class="text-sm text-gray-600">{{ __('modals/dashboard.refuse_training_message') }}</p>

            <div class="flex justify-end gap-3">
                <button type="button" wire:click="close">{{ __('modals/dashboard.cancel') }}</button>
                <button type="button" wire:click="confirm">{{ __('modals/dashboard.confirm') }}</button>
            </div>

        </div>
    </dialog>
</div>
