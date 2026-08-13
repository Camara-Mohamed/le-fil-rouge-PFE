<?php

use App\Enums\RegisterStatus;
use App\Models\CampRegister;
use App\Notifications\RegisterStatusNotification;
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
        $user     = auth()->user();
        $register = CampRegister::with('camp')->findOrFail((int) $this->model_id);

        if ($register->camp->user_id !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $register->update(['status' => RegisterStatus::REFUSED]);

        try {
            $register->user->notify(new RegisterStatusNotification($register->camp, 'refused'));
        } catch (\Throwable) {}

        $this->dispatch('toast', message: __('toast/enrollments.refuse'), type: 'error');
        $this->dispatch('dashboard_updated');
        $this->dispatch('close_modal');
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/dashboard.refuse_camp_register_title')"
    :message="__('modals/dashboard.refuse_camp_register_message')"
    :confirm-label="__('modals/dashboard.confirm')"
    :cancel-label="__('modals/dashboard.cancel')"
/>
