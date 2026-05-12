<?php

namespace App\Livewire\Forms;

use App\Enums\Diets;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;

class DietForm extends Form
{
    public User $user;

    public ?string $diet = null;

    public ?string $allergies = null;

    public function rules(): array
    {
        return [
            'diet' => ['required', Rule::enum(Diets::class)],
            'allergies' => ['nullable', 'string'],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = auth()->user();
        $this->diet = $this->user->diet?->value;
        $this->allergies = $this->user->allergies;
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update([
            'diet' => $this->diet,
            'allergies' => $this->allergies,
        ]);
    }
}
