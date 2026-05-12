<?php

use App\Enums\UserRoles;
use App\Mail\NewVolunteerMail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Nouveau membre')] class extends Component
{
    use AuthorizesRequests;

    public string $first_name  = '';
    public string $last_name   = '';
    public string $email       = '';
    public string $password    = '';
    public string $role        = '';
    public string $send_to = '';

    // TODO: Ajouter un prefix @lefilrouge.com
    public function save(): void
    {
        $this->validate([
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name'  => ['required', 'min:2', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'min:8'],
            'role'       => ['required', Rule::enum(UserRoles::class)],
            'send_to' => ['nullable', 'email'],
        ]);

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'password'   => $this->password,
            'role'       => $this->role,
        ]);

        if ($this->send_to) {
            Mail::to($this->send_to)
                ->send(new NewVolunteerMail($user, $this->password));
        }

        $this->redirect(route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $user]));
    }

    public function render()
    {
        return view('pages.members.⚡create.create');
    }
};
