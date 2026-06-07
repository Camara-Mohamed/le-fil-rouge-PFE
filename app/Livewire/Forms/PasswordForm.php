<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PasswordForm extends Form
{
    public User $user;

    #[Validate('required|current_password')]
    public string $current_password = '';

    #[Validate('required|min:8|different:current_password')]
    public string $password = '';

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update(['password' => Hash::make($this->password)]);

        $this->reset('current_password', 'password');
    }
}
