<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Form;

class PasswordForm extends Form
{
    public User $user;

    public string $current_password = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'min:8', 'different:current_password'],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = auth()->user();
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update(['password' => Hash::make($this->password)]);

        $this->reset('current_password', 'password');
    }
}
