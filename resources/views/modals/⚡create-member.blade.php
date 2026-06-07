<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Enums\VolunteerRequestStatus;
use App\Mail\NewVolunteerMail;
use App\Models\User;
use App\Models\VolunteerRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum as EnumRule;
use Livewire\Attributes\Validate;
use Livewire\Component;

new class extends Component
{
    public string $model_id   = '';
    public string $model_type = '';

    #[Validate('required|min:2|max:255')]
    public string $first_name = '';

    #[Validate('required|min:2|max:255')]
    public string $last_name  = '';

    #[Validate('required|email|ends_with:@lefilrouge.com')]
    public string $email      = '';

    #[Validate('required|min:8')]
    public string $password   = '';

    #[Validate(['required', new EnumRule(UserRoles::class)])]
    public string $role       = UserRoles::ARRIVANT->value;

    #[Validate(['required', new EnumRule(UserStatus::class)])]
    public string $status     = UserStatus::PENDING->value;

    #[Validate('nullable|email')]
    public string $send_to    = '';

    public function mount(): void
    {
        $request = VolunteerRequest::findOrFail((int) $this->model_id);

        $this->first_name = $request->first_name;
        $this->last_name  = $request->last_name;
        $this->send_to    = $request->email;

        // email : prenom.nom@lefilrouge.com
        $firstName   = str_replace(' ', '', strtolower(Str::ascii($request->first_name)));
        $lastName    = str_replace(' ', '', strtolower(Str::ascii($request->last_name)));
        $this->email = "{$firstName}.{$lastName}@lefilrouge.com";

        $this->password = Str::random(8);
    }

    public function close(): void
    {
        $this->dispatch('close_modal');
    }

    public function save(): void
    {
        $this->validate([
            'first_name' => ['required', 'min:2', 'max:255'],
            'last_name'  => ['required', 'min:2', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email', 'ends_with:@lefilrouge.com'],
            'password'   => ['required', 'min:8'],
            'role'       => ['required', Rule::enum(UserRoles::class)],
            'status'     => ['required', Rule::enum(UserStatus::class)],
            'send_to'    => ['nullable', 'email'],
        ]);

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'email'      => $this->email,
            'password'   => $this->password,
            'role'       => $this->role,
            'status'     => $this->status,
        ]);

        if ($this->send_to) {
            Mail::to($this->send_to)->send(new NewVolunteerMail($user, $this->password));
        }

        VolunteerRequest::findOrFail((int) $this->model_id)->update([
            'status' => VolunteerRequestStatus::ACCEPTED,
        ]);

        $this->dispatch('close_modal');
        $this->dispatch('volunteer_accepted');
        $this->dispatch('toast', message: __('toast/messages.member_created'), type: 'success');
    }
};
?>

<div class="fixed inset-0 z-40 flex items-center justify-center bg-black/50">
    <div class="bg-white p-6 flex flex-col gap-4 w-full max-w-md">

        <div class="flex justify-between items-center">
            <h2>Créer un compte bénévole</h2>
            <button wire:click="close">Fermer</button>
        </div>

        <form wire:submit="save" class="flex flex-col gap-3">

            <div>
                <label>Prénom</label>
                <input type="text" wire:model.live="first_name">
                @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Nom</label>
                <input type="text" wire:model.live="last_name">
                @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Email</label>
                <input type="email" wire:model.live="email">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div x-data="{ show: false }">
                <label>Mot de passe</label>
                <input type="password" :type="show ? 'text' : 'password'" wire:model.live="password">
                <button type="button" @click="show = !show">
                    <span x-show="!show">Afficher</span>
                    <span x-show="show">Cacher</span>
                </button>
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Rôle</label>
                <select wire:model.live="role">
                    @foreach(UserRoles::cases() as $role)
                        <option value="{{ $role->value }}">{{ $role->label() }}</option>
                    @endforeach
                </select>
                @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Statut</label>
                <select wire:model.live="status">
                    @foreach(UserStatus::cases() as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Envoyer à :</label>
                <input type="email" wire:model.live="send_to">
                @error('send_to') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit">Créer</button>
                <button type="button" wire:click="close">Annuler</button>
            </div>

        </form>
    </div>
</div>
