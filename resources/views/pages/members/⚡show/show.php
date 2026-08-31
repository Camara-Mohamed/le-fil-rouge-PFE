<?php

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\QueryException as QueryExceptionAlias;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public User $member;

    public function mount(User $member): void
    {
        $this->member = $member;

        if ($this->member->id === auth()->id()) {
            $this->redirectRoute('admin.profile', ['locale' => app()->getLocale()]);
        }
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->member);

        $this->member->update(['status' => UserStatus::ARCHIVED]);

        $this->redirectRoute('admin.members.index', [
            'locale' => app()->getLocale(),
        ]);
    }

    public function restore(): void
    {
        $this->authorize('restore', $this->member);

        $this->member->update(['status' => UserStatus::PENDING]);

        $this->dispatch('toast', message: __('toast/members.restored'), type: 'success');
    }

    public function forceDelete(): void
    {
        $this->authorize('forceDelete', $this->member);

        try {
            $this->member->delete();
        } catch (QueryExceptionAlias) {
            $this->dispatch('toast', message: __('toast/members.force_delete_blocked'), type: 'error');

            return;
        }

        $this->redirectRoute('admin.members.index', [
            'locale' => app()->getLocale(),
        ]);
    }

    public function openConfirmDeleteModal(): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::members.confirm-delete',
            'model_id' => (string) $this->member->id,
            'model_type' => 'member',
        ]);
    }

    public function openConfirmForceDeleteModal(): void
    {
        $this->dispatch('open_modal', payload: [
            'form' => 'modals::members.confirm-force-delete',
            'model_id' => (string) $this->member->id,
            'model_type' => 'member',
        ]);
    }

    public function render()
    {
        return view('pages.members.⚡show.show', [
            'trainingRegisters' => $this->member->trainingRegisters()->with('training')->latest()->get(),
            'campRegisters' => $this->member->campRegisters()->with('camp')->latest()->get(),
        ])->title($this->member->fullName());
    }
};
