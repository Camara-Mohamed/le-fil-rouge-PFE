<?php

namespace App\Livewire\Forms;

use AllowDynamicProperties;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class InfoForm extends Form
{
    public User $user;

    public string $first_name = '';
    public string $last_name = '';
    public ?string $phone = null;
    public ?string $birth_date = null;

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name'  => ['required', 'min:2', 'max:255'],
            'phone'      => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user       = auth()->user();
        $this->first_name = $this->user->first_name;
        $this->last_name  = $this->user->last_name;
        $this->phone      = $this->user->phone;
        $this->birth_date = $this->user->birth_date?->format('Y-m-d');
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'phone'      => $this->phone,
            'birth_date' => $this->birth_date,
        ]);
    }
}
