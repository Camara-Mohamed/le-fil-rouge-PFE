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
        Storage::disk(config('filesystems.default'))->delete($document->path);
        $document->delete();

        $this->dispatch('document_deleted');
        $this->dispatch('toast', message: __('modals/documents.delete_toast'), type: 'success');
        $this->dispatch('close_modal');
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/documents.delete_title')"
    :message="__('modals/documents.delete_message')"
    :confirm-label="__('modals/documents.confirm')"
    :cancel-label="__('modals/documents.cancel')"
/>
