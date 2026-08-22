<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EmailForm extends Form
{
    public User $user;

    #[Validate('required|email|max:255')]
    public string $email = '';

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->email = $this->user->email;
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update(['email' => $this->email]);
    }
}
