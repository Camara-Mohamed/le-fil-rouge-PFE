<?php

namespace App\Livewire\Forms;

use App\Enums\Provinces;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddressForm extends Form
{
    public User $user;

    public string $address = '';

    public string $number = '';

    public string $city = '';

    public ?string $province = null;

    public string $postal_code = '';

    public function rules(): array
    {
        return [
            'address' => ['nullable', 'max:255'],
            'number' => ['nullable', 'max:50'],
            'city' => ['nullable', 'max:255'],
            'province' => ['required', Rule::enum(Provinces::class)],
            'postal_code' => ['nullable', 'max:20'],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = auth()->user();
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
