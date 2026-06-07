<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InfoForm extends Form
{
    public User $user;

    #[Validate('required|min:2|max:255')]
    public string $first_name = '';

    #[Validate('required|min:2|max:255')]
    public string $last_name = '';

    #[Validate('nullable|string')]
    public ?string $phone = null;

    #[Validate('nullable|date')]
    public ?string $birth_date = null;

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->phone = $this->user->phone;
        $this->birth_date = $this->user->birth_date?->format('Y-m-d');
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
        ]);
    }
}
