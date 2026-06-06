<?php

namespace App\Livewire;

use App\Enums\RegisterStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RegistersCta extends Component
{
    use AuthorizesRequests;

    public Model $model;

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
        return view('livewire.registers-cta', [
            'accepted' => $this->model->acceptedRegisters()->with('user')->get(),
            'pending'  => $this->model->pendingRegisters()->with('user')->get(),
            'refused'  => $this->model->refusedRegisters()->with('user')->get(),
        ]);
    }
}
