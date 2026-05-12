<?php

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Modifier un membre')] class extends Component
{
    use AuthorizesRequests;

    public User $member;

    public string  $first_name = '';
    public string  $last_name  = '';
    public string  $email      = '';
    public string  $role       = '';
    public string  $phone      = '';
    public ?string $birth_date = null;

    public function mount(User $member): void
    {
        $this->member     = $member;
        $this->first_name = $member->first_name;
        $this->last_name  = $member->last_name;
        $this->email      = $member->email;
        $this->role       = $member->role->value;
        $this->phone      = $member->phone ?? '';
        $this->birth_date = $member->birth_date?->format('Y-m-d');
    }

    public function save(): void
    {
        $this->validate([
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name'  => ['required', 'min:2', 'max:255'],
            'email'      => ['required', 'email', Rule::unique('users')->ignore($this->member->id)],
            'role'       => ['required', Rule::enum(UserRoles::class)],
            'phone'      => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
        ]);

        $this->member->update([
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'role'       => $this->role,
            'phone'      => $this->phone,
            'birth_date' => $this->birth_date,
        ]);
    }

    public function render()
    {
        return view('pages.members.⚡edit.edit');
    }
};
