<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\User;
use App\Notifications\MemberChangedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Modifier un membre')]
class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public User $member;

    #[Validate('required|min:2|max:255')]
    public string $first_name = '';

    #[Validate('required|min:2|max:255')]
    public string $last_name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate(['required', new EnumRule(UserRoles::class)])]
    public string $role = '';

    #[Validate(['required', new EnumRule(UserStatus::class)])]
    public string $status = '';

    #[Validate('nullable|string')]
    public string $phone = '';

    #[Validate('nullable|date')]
    public ?string $birth_date = null;

    public function mount(User $member): void
    {
        if ($member->id === auth()->id()) {
            $this->redirectRoute('admin.profile', ['locale' => app()->getLocale()]);

            return;
        }

        $this->member = $member;
        $this->first_name = $member->first_name;
        $this->last_name = $member->last_name;
        $this->email = $member->email;
        $this->role = $member->role->value;
        $this->status = $member->status->value;
        $this->phone = $member->phone ?? '';
        $this->birth_date = $member->birth_date?->format('Y-m-d');
    }

    public function save(): void
    {
        $roleChanged = $this->role !== $this->member->role->value;
        $statusChanged = $this->status !== $this->member->status->value;

        if ($roleChanged) {
            $this->authorize('changeRole', $this->member);
        }

        if ($statusChanged) {
            $this->authorize('changeStatus', $this->member);
        }

        // TODO: prefix input[nom.prenom . span('@'.config('app.member_email_domain'))]
        $this->validate([
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name' => ['required', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'ends_with:@'.config('app.member_email_domain')],
            'role' => ['required', Rule::enum(UserRoles::class)],
            'status' => ['required', Rule::enum(UserStatus::class)],
            'phone' => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
        ]);

        $this->member->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role,
            'status' => $this->role === UserRoles::ARRIVANT->value ? UserStatus::INCOMPLETE->value : $this->status,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
        ]);

        if ($roleChanged || $statusChanged) {
            try {
                $this->member->notify(new MemberChangedNotification(
                    newRole: $roleChanged ? UserRoles::from($this->role)->label() : null,
                    newStatus: $statusChanged ? UserStatus::from($this->status)->label() : null,
                ));
            } catch (Throwable) {
            }
        }

        $this->dispatch('toast', message: __('toast/members.updated', ['name' => $this->member->fullName()]), type: 'success');
    }

    public function render()
    {
        return view('pages.members.⚡edit.edit');
    }
};
