<?php

namespace App\Livewire\Forms;

use App\Enums\Diets;
use App\Enums\Provinces;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProfileForm extends Form
{
    public User $user;

    #[Validate]
    public string $first_name = '';

    #[Validate]
    public string $last_name = '';

    #[Validate]
    public string $email = '';

    public ?string $phone = null;
    public ?string $birth_date = null;
    public string $address = '';
    public string $number = '';
    public string $city = '';
    public ?string $province = null;
    public string $postal_code = '';
    public ?string $diet = null;
    public ?string $allergies = null;


    public function rules(): array
    {
        return [
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'max:255'],
            'number' => ['nullable', 'max:50'],
            'city' => ['nullable', 'max:255'],
            'province' => ['required', Rule::enum(Provinces::class)],
            'postal_code' => ['nullable', 'max:20'],
            'diet' => ['required', Rule::enum(Diets::class)],
            'allergies' => ['nullable'],
        ];
    }

    public function setProfile(User $user): void
    {
        $this->user = auth()->user();
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->birth_date = $this->user->birth_date?->format('Y-m-d');
        $this->address = $this->user->address;
        $this->number = $this->user->number;
        $this->city = $this->user->city;
        $this->province = $this->user->province->value;
        $this->postal_code = $this->user->postal_code;
        $this->diet = $this->user->diet->value;
        $this->allergies = $this->user->allergies;
    }


    public function update(): void
    {
        $this->validate();

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            'address' => $this->address,
            'number' => $this->number,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'diet' => $this->diet,
            'allergies' => $this->allergies,
        ]);
    }
}
