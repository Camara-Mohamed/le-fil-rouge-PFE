<?php

use App\Enums\VolunteerRequestStatus;
use App\Models\VolunteerRequest;
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
        VolunteerRequest::findOrFail((int) $this->model_id)
            ->update(['status' => VolunteerRequestStatus::REJECTED]);

        $this->dispatch('volunteer_rejected');
        $this->dispatch('toast', message: __('modals/volunteer.refuse_toast'), type: 'success');
        $this->dispatch('close_modal');
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/volunteer.refuse_title')"
    :message="__('modals/volunteer.refuse_message')"
    :confirm-label="__('modals/volunteer.confirm')"
    :cancel-label="__('modals/volunteer.cancel')"
/>
