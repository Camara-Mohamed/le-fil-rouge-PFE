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

<div x-data x-init="$refs.dialog.showModal()">
    <dialog
        x-ref="dialog"
        @close="$wire.close()"
        class="p-0 border-0 rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] w-full max-w-lg m-auto backdrop:bg-dark/50"
    >
        <div class="relative px-12 py-8 flex flex-col items-center gap-12">
        <button type="button" wire:click="close" class="absolute top-4 right-4 text-dark-mid hover:text-dark transition" aria-label="Fermer">
            <x-icons.close class="size-5" />
        </button>

            <div class="flex flex-col items-center gap-4 w-full">
                <h2 class="font-sans font-black text-3xl text-dark text-center">
                    {{ __('modals/announcements.delete_title') }}
                </h2>
                <p class="font-serif text-base text-center">
                    {{ __('modals/announcements.delete_message') }}
                </p>
            </div>

            <div class="flex items-center gap-6">
                <button type="button"
                        wire:click="close"
                        class="px-8 py-4 bg-red-light border-2 border-red rounded-lg font-sans font-bold text-sm text-red hover:bg-red hover:text-white transition duration-200">
                    {{ __('modals/announcements.cancel') }}
                </button>
                <button type="button"
                        wire:click="confirm"
                        class="px-8 py-4 bg-red border-2 border-red rounded-lg font-sans font-bold text-sm text-white hover:bg-red-mid hover:border-red-mid transition duration-200">
                    {{ __('modals/announcements.confirm') }}
                </button>
            </div>

        </div>
    </dialog>
</div>
