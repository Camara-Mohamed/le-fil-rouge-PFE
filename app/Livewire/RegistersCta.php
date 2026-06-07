<?php

namespace App\Livewire;

use App\Enums\RegisterStatus;
use App\Enums\UserRoles;
use App\Models\Camp;
use App\Models\User;
use App\Notifications\ParticipantsFullNotification;
use App\Notifications\RegisterStatusNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class RegistersCta extends Component
{
    use AuthorizesRequests;

    public Model $model;

    public function accept(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $register = $this->model->registers()->with('user')->findOrFail($registerId);
        $register->update(['status' => RegisterStatus::ACCEPTED]);

        $register->user->notify(new RegisterStatusNotification($this->model, 'accepted'));

        if ($this->model->participants && $this->model->acceptedRegisters()->count() >= $this->model->participants) {
            Notification::send(
                User::where('role', UserRoles::ADMIN->value)->get()->merge([$this->model->user])->unique('id'),
                new ParticipantsFullNotification($this->model, $this->model instanceof Camp ? 'Le camp' : 'La formation')
            );
        }

        $this->dispatch('toast', message: __('toast/enrollments.accept'), type: 'success');
    }

    public function refuse(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $register = $this->model->registers()->with('user')->findOrFail($registerId);
        $register->update(['status' => RegisterStatus::REFUSED]);

        $register->user->notify(new RegisterStatusNotification($this->model, 'refused'));

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
        return view('livewire.registers-cta', [
            'accepted' => $this->model->acceptedRegisters()->with('user')->get(),
            'pending'  => $this->model->pendingRegisters()->with('user')->get(),
            'refused'  => $this->model->refusedRegisters()->with('user')->get(),
        ]);
    }
}
