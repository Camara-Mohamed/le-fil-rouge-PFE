<?php

namespace App\Livewire;

use App\Enums\RegisterStatus;
use App\Enums\UserRoles;
use App\Events\BroadcastRefresh;
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

    protected function channelName(): string
    {
        return strtolower(class_basename($this->model)).'.'.$this->model->id.'.registers';
    }

    public function accept(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $register = $this->model->registers()->with('user')->findOrFail($registerId);
        $register->update(['status' => RegisterStatus::ACCEPTED]);

        $this->dispatch('toast', message: __('toast/enrollments.accept'), type: 'success');
        broadcast(new BroadcastRefresh($this->channelName()))->toOthers();
        try {
            $register->user->notify(new RegisterStatusNotification($this->model, 'accepted'));
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new RegisterStatusNotification($this->model, 'accepted'));

            if ($this->model->participants && $this->model->acceptedRegisters()->count() >= $this->model->participants) {
                $admins = User::where('role', UserRoles::ADMIN->value)->get()->merge([$this->model->user])->unique('id');
                foreach ($admins as $admin) {
                    $admin->notify(new ParticipantsFullNotification($this->model, $this->model->modelLabel()));
                }
                Notification::route('mail', config('mail.notification_for_mails'))->notify(new ParticipantsFullNotification($this->model, $this->model->modelLabel()));
            }
        } catch (\Throwable) {
        }
    }

    public function refuse(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $register = $this->model->registers()->with('user')->findOrFail($registerId);
        $register->update(['status' => RegisterStatus::REFUSED]);

        $this->dispatch('toast', message: __('toast/enrollments.refuse'), type: 'error');
        broadcast(new BroadcastRefresh($this->channelName()))->toOthers();
        try {
            $register->user->notify(new RegisterStatusNotification($this->model, 'refused'));
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new RegisterStatusNotification($this->model, 'refused'));
        } catch (\Throwable) {
        }
    }

    public function pending(int $registerId): void
    {
        $this->authorize('update', $this->model);

        $this->model->registers()
            ->findOrFail($registerId)
            ->update(['status' => RegisterStatus::PENDING]);

        $this->dispatch('toast', message: __('toast/enrollments.pending'), type: 'info');
        broadcast(new BroadcastRefresh($this->channelName()))->toOthers();
    }

    public function render()
    {
        return view('livewire.registers-cta', [
            'accepted' => $this->model->acceptedRegisters()->with('user')->get(),
            'pending' => $this->model->pendingRegisters()->with('user')->get(),
            'refused' => $this->model->refusedRegisters()->with('user')->get(),
        ]);
    }
}
