@props(['title', 'message', 'confirmLabel', 'cancelLabel'])

<div x-data x-init="$refs.dialog.showModal()">
    <dialog
        x-ref="dialog"
        @close="$wire.close()"
        aria-labelledby="confirm-dialog-title"
        aria-describedby="confirm-dialog-message"
        class="p-0 border-0 rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] w-full max-w-lg m-auto backdrop:bg-dark/50"
    >
        <div class="relative px-12 py-8 flex flex-col items-center gap-12">
            <button type="button" wire:click="close" class="absolute top-4 right-4 text-dark-mid hover:text-dark transition" aria-label="{{ __('general.close') }}">
                <x-icons.close class="size-5" />
            </button>

            <div class="flex flex-col items-center gap-4 w-full">
                <h2 id="confirm-dialog-title" class="font-sans font-black text-3xl text-dark text-center">{{ $title }}</h2>
            </div>

            <p id="confirm-dialog-message" class="font-serif text-base text-center">{{ $message }}</p>

            <div class="flex items-center gap-6">
                <button type="button" wire:click="close" class="px-8 py-4 bg-red-light border-2 border-red rounded-lg font-sans font-bold text-sm text-red hover:bg-red hover:text-white transition duration-200">
                    {{ $cancelLabel }}
                </button>
                <button type="button" wire:click="confirm" class="px-8 py-4 bg-red border-2 border-red rounded-lg font-sans font-bold text-sm text-white hover:bg-red-mid hover:border-red-mid transition duration-200">
                    {{ $confirmLabel }}
                </button>
            </div>
        </div>
    </dialog>
</div>
