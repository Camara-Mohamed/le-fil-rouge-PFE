<?php

namespace App\Livewire;

use App\Enums\RegisterStatus;
use App\Enums\UserRoles;
use App\Events\BroadcastRefresh;
use App\Livewire\Concerns\HasRegisterActions;
use App\Models\User;
use App\Notifications\NewRegisterNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Enrollment extends Component
{
    use AuthorizesRequests, HasRegisterActions;

    public Model $model;

    #[Validate('nullable|string|max:2000')]
    public string $notes = '';

    public function enroll(): void
    {
        $user = auth()->user();

        if (! $this->model->isPublished()) {
            return;
        }

        if ($this->model->end_date && $this->model->end_date->isPast()) {
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

        if ($this->model->participants && $this->model->acceptedRegisters()->count() >= $this->model->participants) {
            $this->dispatch('toast', message: __('toast/enrollments.full'), type: 'warning');

            return;
        }

        $this->validate();

        $isCreator = $this->model->user_id === $user->id;

        $this->model->registers()->create([
            'user_id' => $user->id,
            'status' => $isCreator ? RegisterStatus::ACCEPTED : RegisterStatus::PENDING,
            'notes' => $this->notes ?: null,
        ]);

        $this->notes = '';
        $this->dispatch('toast', message: __('toast/enrollments.sent'), type: 'success');

        try {
            broadcast(new BroadcastRefresh($this->channelName()))->toOthers();
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
        try {
            broadcast(new BroadcastRefresh($this->channelName()))->toOthers();
        } catch (\Throwable) {
        }
    }

    #[On('enrollment_cancel_confirmed')]
    public function cancelConfirmed(): void
    {
        $this->cancel();
    }

    public function render()
    {
        $user = auth()->user();

        $register = $this->model->registers()
            ->where('user_id', $user->id)
            ->first();

        $canEnroll = $this->model->isPublished()
            && (! $this->model->end_date || ! $this->model->end_date->isPast())
            && ! $user->isAdmin()
            && ! $user->isArrivant()
            && ($user->isComplete() || $user->isPending())
            && (! $this->model->roles || $this->model->roles($user))
            && (! $this->model->participants || $this->model->acceptedRegisters()->count() < $this->model->participants);

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
