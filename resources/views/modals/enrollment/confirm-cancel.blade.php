<?php

use Livewire\Component;

new class extends Component
{
    public string $model_id   = '';
    public string $model_type = ''; // 'pending' ou 'accepted'

    public function close(): void
    {
        $this->dispatch('close_modal');
    }

    public function confirm(): void
    {
        $this->dispatch('enrollment_cancel_confirmed');
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
                <h2>
                    @if($model_type === 'accepted')
                        {{ __('modals/enrollment.cancel_title_accepted') }}
                    @else
                        {{ __('modals/enrollment.cancel_title_pending') }}
                    @endif
                </h2>
                <button type="button" wire:click="close">Fermer</button>
            </div>

            <p class="text-sm text-gray-600">
                {{ __('modals/enrollment.cancel_message') }}
            </p>

            <div class="flex justify-end gap-3">
                <button type="button" wire:click="close">
                    {{ __('modals/enrollment.cancel') }}
                </button>
                <button type="button" wire:click="confirm">
                    {{ __('modals/enrollment.confirm') }}
                </button>
            </div>

        </div>
    </dialog>
</div>
