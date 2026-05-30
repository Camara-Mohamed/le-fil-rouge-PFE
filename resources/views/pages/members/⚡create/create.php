<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Mail\NewVolunteerMail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Nouveau membre')] class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public string $first_name = '';

    public string $last_name = '';

    public string $email = '';

    public string $password = '';

    public string $role = UserRoles::ARRIVANT->value;

    public string $status = UserStatus::PENDING->value;

    public string $send_to = '';

    public function mount(): void
    {
        $this->password = Str::random(8);
    }

    // TODO: prefix input[nom.prenom . span('@lefilrouge.com')]
    public function save(): void
    {
        $this->authorize('create', User::class);

        $this->validate([
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'ends_with:@lefilrouge.com'],
            'password' => ['required', 'min:8'],
            'role' => ['required', Rule::enum(UserRoles::class)],
            'status' => ['required', Rule::enum(UserStatus::class)],
            'send_to' => ['nullable', 'email'],
        ]);

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'status' => $this->status,
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
