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

<x-modals.confirm-dialog
    :title="$model_type === 'accepted' ? __('modals/enrollment.cancel_title_accepted') : __('modals/enrollment.cancel_title_pending')"
    :message="__('modals/enrollment.cancel_message')"
    :confirm-label="__('modals/enrollment.confirm')"
    :cancel-label="__('modals/enrollment.cancel')"
/>
