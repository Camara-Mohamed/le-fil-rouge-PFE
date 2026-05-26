<?php

namespace App\Livewire;

use App\Enums\RegisterStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Locked;
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

        $this->model->registers()->create([
            'user_id' => $user->id,
            'status' => RegisterStatus::PENDING,
            'notes' => $this->notes ?: null,
        ]);

        $this->notes = '';
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
    }

    public function accept(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $this->model->registers()
            ->findOrFail($registerId)
            ->update(['status' => RegisterStatus::ACCEPTED]);
    }

    public function refuse(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $this->model->registers()
            ->findOrFail($registerId)
            ->update(['status' => RegisterStatus::REFUSED]);
    }

    public function pending(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $this->model->registers()
            ->findOrFail($registerId)
            ->update(['status' => RegisterStatus::PENDING]);
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
