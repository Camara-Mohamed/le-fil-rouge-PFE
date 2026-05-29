<?php

use App\Models\Document;
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
        $document = Document::findOrFail((int) $this->model_id);
        $this->authorize('delete', $document);
        Storage::disk('public')->delete($document->path);
        $document->delete();

        $this->dispatch('document_deleted');
        $this->dispatch('toast', message: __('modals/documents.delete_toast'), type: 'success');
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
                <h2>{{ __('modals/documents.delete_title') }}</h2>
                <button type="button" wire:click="close">Fermer</button>
            </div>

            <p class="text-sm text-gray-600">{{ __('modals/documents.delete_message') }}</p>

            <div class="flex justify-end gap-3">
                <button type="button" wire:click="close">
                    {{ __('modals/documents.cancel') }}
                </button>
                <button type="button" wire:click="confirm">
                    {{ __('modals/documents.confirm') }}
                </button>
            </div>

        </div>
    </dialog>
</div>
