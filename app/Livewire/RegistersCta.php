<?php

namespace App\Livewire;

use App\Livewire\Concerns\HasRegisterActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RegistersCta extends Component
{
    use AuthorizesRequests, HasRegisterActions;

    public Model $model;

    public function render()
    {
        return view('livewire.registers-cta', [
            'accepted' => $this->model->acceptedRegisters()->with('user')->get(),
            'pending' => $this->model->pendingRegisters()->with('user')->get(),
            'refused' => $this->model->refusedRegisters()->with('user')->get(),
        ]);
    }
}
