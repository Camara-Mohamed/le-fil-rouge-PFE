<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Mail\NewVolunteerMail;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Nouveau membre')] class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    #[Validate('required|min:2|max:255')]
    public string $first_name = '';

    #[Validate('required|min:2|max:255')]
    public string $last_name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|min:8')]
    public string $password = '';

    #[Validate(['required', new EnumRule(UserRoles::class)])]
    public string $role = UserRoles::ARRIVANT->value;

    #[Validate(['required', new EnumRule(UserStatus::class)])]
    public string $status = UserStatus::PENDING->value;

    #[Validate('nullable|email')]
    public string $send_to = '';

    public function mount(): void
    {
        $this->password = Str::random(8);
    }

    // TODO: prefix input[nom.prenom . span('@'.config('app.member_email_domain'))]
    public function save(): void
    {
        $this->authorize('create', User::class);

        $this->validate([
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'ends_with:@'.config('app.member_email_domain')],
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
            'status' => $this->role === UserRoles::ARRIVANT->value ? UserStatus::INCOMPLETE : $this->status,
        ]);

        if ($this->send_to) {
            try {
                Mail::to($this->send_to)->send(new NewVolunteerMail($user, $this->password));
            } catch (Throwable) {
            }
        }

        $this->redirect(route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $user]));
    }

    public function render()
    {
        return view('pages.members.⚡create.create');
    }
};
