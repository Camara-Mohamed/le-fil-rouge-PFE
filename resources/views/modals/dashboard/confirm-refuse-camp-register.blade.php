<?php

use App\Enums\RegisterStatus;
use App\Models\CampRegister;
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

        $this->dispatch('toast', message: __('toast/enrollments.refuse'), type: 'error');
        $this->dispatch('dashboard_updated');
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
                <h2>{{ __('modals/dashboard.refuse_camp_register_title') }}</h2>
                <button type="button" wire:click="close">Fermer</button>
            </div>

            <p class="text-sm text-gray-600">{{ __('modals/dashboard.refuse_camp_register_message') }}</p>

            <div class="flex justify-end gap-3">
                <button type="button" wire:click="close">{{ __('modals/dashboard.cancel') }}</button>
                <button type="button" wire:click="confirm">{{ __('modals/dashboard.confirm') }}</button>
            </div>

        </div>
    </dialog>
</div>
