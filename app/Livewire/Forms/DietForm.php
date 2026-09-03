<?php

namespace App\Livewire\Forms;

use App\Enums\Diets;
use App\Models\User;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DietForm extends Form
{
    public User $user;

    #[Validate(['required', new EnumRule(Diets::class)])]
    public ?string $diet = null;

    public bool $is_gluten_free = false;

    public bool $is_lactose_free = false;

    #[Validate('nullable|string')]
    public ?string $allergies = null;

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->diet = $this->user->diet?->value;
        $this->is_gluten_free = $this->user->is_gluten_free;
        $this->is_lactose_free = $this->user->is_lactose_free;
        $this->allergies = $this->user->allergies;
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update([
            'diet' => $this->diet,
            'is_gluten_free' => $this->is_gluten_free,
            'is_lactose_free' => $this->is_lactose_free,
            'allergies' => $this->allergies,
        ]);
    }
}
