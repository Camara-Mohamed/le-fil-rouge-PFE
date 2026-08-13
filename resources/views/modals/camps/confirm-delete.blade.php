<?php

use App\Models\Camp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

new class extends Component
{
    use AuthorizesRequests;

    public string $model_id   = '';
    public string $model_type = '';
    public string $campType   = '';

    public function mount(): void
    {
        $this->campType = strtolower(Camp::findOrFail((int) $this->model_id)->type->label());
    }

    public function close(): void
    {
        $this->dispatch('close_modal');
    }

    public function confirm(): void
    {
        $camp = Camp::findOrFail((int) $this->model_id);
        $this->authorize('delete', $camp);
        $camp->delete();

        $this->dispatch('toast', message: __('modals/camps.delete_toast', ['type' => strtolower($this->campType)]), type: 'success');
        $this->dispatch('close_modal');
        $this->redirectRoute('public.camps.index', ['locale' => app()->getLocale()]);
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/camps.delete_title', ['type' => $campType])"
    :message="__('modals/camps.delete_message', ['type' => $campType])"
    :confirm-label="__('modals/camps.confirm')"
    :cancel-label="__('modals/camps.cancel')"
/>
