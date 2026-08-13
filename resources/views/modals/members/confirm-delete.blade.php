<?php

use App\Enums\UserStatus;
use App\Models\User;
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
        $member = User::findOrFail((int) $this->model_id);
        $this->authorize('delete', $member);
        $member->update(['status' => UserStatus::ARCHIVED]);

        $this->dispatch('toast', message: __('modals/members.delete_toast'), type: 'success');
        $this->dispatch('close_modal');
        $this->redirectRoute('admin.members.index', ['locale' => app()->getLocale()]);
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/members.delete_title')"
    :message="__('modals/members.delete_message')"
    :confirm-label="__('modals/members.confirm')"
    :cancel-label="__('modals/members.cancel')"
/>
