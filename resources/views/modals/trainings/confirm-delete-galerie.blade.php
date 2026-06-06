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
        class="p-0 border-0 rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] w-full max-w-lg m-auto backdrop:bg-dark/50"
    >
        <div class="px-12 py-8 flex flex-col items-center gap-12">

            <div class="flex flex-col items-center gap-4 w-full">
                <h2 class="font-sans font-black text-3xl text-dark text-center">
                    {{ __('modals/trainings.delete_galerie_title') }}
                </h2>
                <p class="font-serif text-base text-center">
                    {{ __('modals/trainings.delete_galerie_message') }}
                </p>
            </div>

            <div class="flex items-center gap-6">
                <button type="button"
                        wire:click="close"
                        class="px-8 py-4 bg-red-light border-2 border-red rounded-lg font-sans font-bold text-sm text-red hover:bg-red hover:text-white transition duration-200">
                    {{ __('modals/trainings.cancel') }}
                </button>
                <button type="button"
                        wire:click="confirm"
                        class="px-8 py-4 bg-red border-2 border-red rounded-lg font-sans font-bold text-sm text-white hover:bg-red-mid hover:border-red-mid transition duration-200">
                    {{ __('modals/trainings.confirm') }}
                </button>
            </div>

        </div>
    </dialog>
</div>
