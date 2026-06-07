<?php

namespace App\Livewire\Forms;

use App\Enums\Diets;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DietForm extends Form
{
    public User $user;

    #[Validate(['required', new EnumRule(Diets::class)])]
    public ?string $diet = null;

    #[Validate('nullable|string')]
    public ?string $allergies = null;

    public function setUser(User $user): void
    {
        $this->user = $user;
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
