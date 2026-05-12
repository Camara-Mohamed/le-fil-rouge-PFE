<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Form;

class EmailForm extends Form
{
    public User $user;

    public string $email = '';

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = auth()->user();
        $this->email = $this->user->email;
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update(['email' => $this->email]);
    }
}
