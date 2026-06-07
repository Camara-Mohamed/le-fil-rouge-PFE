<?php

namespace App\Livewire\Forms;

use App\Enums\Provinces;
use App\Models\User;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddressForm extends Form
{
    public User $user;

    #[Validate('nullable|max:255')]
    public string $address = '';

    #[Validate('nullable|max:50')]
    public string $number = '';

    #[Validate('nullable|max:255')]
    public string $city = '';

    #[Validate(['required', new EnumRule(Provinces::class)])]
    public ?string $province = null;

    #[Validate('nullable|max:20')]
    public string $postal_code = '';

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->address = $this->user->address ?? '';
        $this->number = $this->user->number ?? '';
        $this->city = $this->user->city ?? '';
        $this->province = $this->user->province?->value;
        $this->postal_code = $this->user->postal_code ?? '';
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update([
            'address' => $this->address,
            'number' => $this->number,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
        ]);
    }
}
