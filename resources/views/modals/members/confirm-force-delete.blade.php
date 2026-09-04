<?php

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

new class extends Component
{
    use AuthorizesRequests;

    public string $model_id = '';

    public string $model_type = '';

    public function close(): void
    {
        $this->dispatch('close_modal');
    }

    public function confirm(): void
    {
        $member = User::findOrFail((int) $this->model_id);
        $this->authorize('forceDelete', $member);
        $member->delete();

        $this->redirectRoute('admin.members.index', ['locale' => app()->getLocale()]);
    }
};
?>

<x-modals.confirm-dialog
    :title="__('modals/members.force_delete_title')"
    :message="__('modals/members.force_delete_message')"
    :confirm-label="__('modals/members.confirm')"
    :cancel-label="__('modals/members.cancel')"
/>
