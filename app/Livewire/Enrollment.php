<?php

namespace App\Livewire;

use App\Enums\RegisterStatus;
use App\Enums\UserRoles;
use App\Events\BroadcastRefresh;
use App\Models\User;
use App\Notifications\NewRegisterNotification;
use App\Notifications\ParticipantsFullNotification;
use App\Notifications\RegisterStatusNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class Enrollment extends Component
{
    use AuthorizesRequests;

    public Model $model;

    public string $notes = '';

    protected function channelName(): string
    {
        return strtolower(class_basename($this->model)).'.'.$this->model->id.'.registers';
    }

    public function enroll(): void
    {
        $user = auth()->user();

        if (! $this->model->isPublished()) {
            return;
        }

        if ($user->isAdmin() || $user->isArrivant()) {
            return;
        }

        if (! ($user->isComplete() || $user->isPending())) {
            return;
        }

        if ($this->model->roles && ! $this->model->roles($user)) {
            return;
        }

        if ($this->model->registers()->where('user_id', $user->id)->exists()) {
            $this->dispatch('toast', message: __('toast/enrollments.already_register'), type: 'warning');

            return;
        }

        $isCreator = $this->model->user_id === $user->id;

        $this->model->registers()->create([
            'user_id' => $user->id,
            'status' => $isCreator ? RegisterStatus::ACCEPTED : RegisterStatus::PENDING,
            'notes' => $this->notes ?: null,
        ]);

        $this->notes = '';
        $this->dispatch('toast', message: __('toast/enrollments.sent'), type: 'success');
        broadcast(new BroadcastRefresh($this->channelName()))->toOthers();

        try {
            $label = $this->model->modelLabel();
            $admins = User::where('role', UserRoles::ADMIN->value)->get()->merge([$this->model->user])->unique('id');
            foreach ($admins as $admin) {
                $admin->notify(new NewRegisterNotification($this->model, $label, $user->fullName()));
            }
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new NewRegisterNotification($this->model, $label, $user->fullName()));
        } catch (\Throwable) {
        }
    }

    public function openCancelModal(string $status): void
    {
        $this->dispatch('open_modal', [
            'form' => 'modals::enrollment.confirm-cancel',
            'model_id' => '',
            'model_type' => $status,
        ]);
    }

    public function cancel(): void
    {
        $user = auth()->user();

        if (! $this->model->isPublished()) {
            return;
        }

        if (! ($user->isComplete() || $user->isPending())) {
            return;
        }

        $this->model->registers()
            ->where('user_id', $user->id)
            ->delete();

        $this->dispatch('toast', message: __('toast/enrollments.cancel'), type: 'info');
        broadcast(new BroadcastRefresh($this->channelName()))->toOthers();
    }

    #[On('enrollment_cancel_confirmed')]
    public function cancelConfirmed(): void
    {
        $this->cancel();
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
        $user = auth()->user();

        $register = $this->model->registers()
            ->where('user_id', $user->id)
            ->first();

        $canEnroll = $this->model->isPublished()
            && ! $user->isAdmin()
            && ! $user->isArrivant()
            && ($user->isComplete() || $user->isPending())
            && (! $this->model->roles || $this->model->roles($user));

        $canCancel = $this->model->isPublished()
            && ($user->isComplete() || $user->isPending());

        $accepted = $this->model->acceptedRegisters()->with('user')->get();
        $pending = $this->model->pendingRegisters()->with('user')->get();
        $refused = $this->model->refusedRegisters()->with('user')->get();

        return view('livewire.enrollment', compact(
            'register', 'canEnroll', 'canCancel', 'accepted', 'pending', 'refused'
        ));
    }
}
