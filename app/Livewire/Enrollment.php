<?php

namespace App\Livewire;

use App\Enums\RegisterStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Enrollment extends Component
{
    use AuthorizesRequests;

    public Model $model;
    public string $notes = '';

    public function enroll(): void
    {
        $user = auth()->user();

        if ($this->model->isConfirmed()) {
            return;
        }

        if (!($user->isComplete() || $user->isPending())) {
            return;
        }

        if ($this->model->roles && !$this->model->roles($user)) {
            return;
        }

        if ($this->model->registers()->where('user_id', $user->id)->exists()) {
            $this->dispatch('toast', message: __('toast/enrollments.already_register'), type: 'warning');
            return;
        }

        $this->model->registers()->create([
            'user_id' => $user->id,
            'status' => RegisterStatus::PENDING,
            'notes' => $this->notes ?: null,
        ]);

        $this->notes = '';
        $this->dispatch('toast', message: __('toast/enrollments.sent'), type: 'success');
    }

    public function openCancelModal(string $status): void
    {
        $this->dispatch('open_modal', [
            'form'       => 'modals::enrollment.confirm-cancel',
            'model_id'   => '',
            'model_type' => $status,
        ]);
    }

    public function cancel(): void
    {
        $user = auth()->user();

        if ($this->model->isConfirmed()) {
            return;
        }

        if (!($user->isComplete() || $user->isPending())) {
            return;
        }

        $this->model->registers()
            ->where('user_id', $user->id)
            ->delete();

        $this->dispatch('toast', message: __('toast/enrollments.cancel'), type: 'info');
    }

    #[On('enrollment_cancel_confirmed')]
    public function cancelConfirmed(): void
    {
        $this->cancel();
    }

    public function accept(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $this->model->registers()
            ->findOrFail($registerId)
            ->update(['status' => RegisterStatus::ACCEPTED]);

        $this->dispatch('toast', message: __('toast/enrollments.accept'), type: 'success');
    }

    public function refuse(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $this->model->registers()
            ->findOrFail($registerId)
            ->update(['status' => RegisterStatus::REFUSED]);

        $this->dispatch('toast', message: __('toast/enrollments.refuse'), type: 'error');
    }

    public function pending(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $this->model->registers()
            ->findOrFail($registerId)
            ->update(['status' => RegisterStatus::PENDING]);

        $this->dispatch('toast', message: __('toast/enrollments.pending'), type: 'info');
    }

    public function render()
    {
        $user = auth()->user();

        $register = $this->model->registers()
            ->where('user_id', $user->id)
            ->first();

        $canEnroll = !$this->model->isConfirmed()
            && ($user->isComplete() || $user->isPending())
            && (!$this->model->roles || $this->model->roles($user));

        $canCancel = !$this->model->isConfirmed()
            && ($user->isComplete() || $user->isPending());

        $accepted = $this->model->acceptedRegisters()->with('user')->get();
        $pending = $this->model->pendingRegisters()->with('user')->get();
        $refused = $this->model->refusedRegisters()->with('user')->get();

        return view('livewire.enrollment', compact(
            'register', 'canEnroll', 'canCancel', 'accepted', 'pending', 'refused'
        ));
    }
}
