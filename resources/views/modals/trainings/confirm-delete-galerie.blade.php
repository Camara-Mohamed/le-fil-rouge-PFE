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
        $this->authorize('update', $galerie->training);
        Storage::disk('public')->delete($galerie->path);
        $galerie->delete();

        $this->dispatch('galerie_deleted');
        $this->dispatch('toast', message: __('modals/trainings.delete_galerie_toast'), type: 'success');
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
                <h2>{{ __('modals/trainings.delete_galerie_title') }}</h2>
                <button type="button" wire:click="close">Fermer</button>
            </div>

            <p class="text-sm text-gray-600">{{ __('modals/trainings.delete_galerie_message') }}</p>

            <div class="flex justify-end gap-3">
                <button type="button" wire:click="close">
                    {{ __('modals/trainings.cancel') }}
                </button>
                <button type="button" wire:click="confirm">
                    {{ __('modals/trainings.confirm') }}
                </button>
            </div>

        </div>
    </dialog>
</div>
