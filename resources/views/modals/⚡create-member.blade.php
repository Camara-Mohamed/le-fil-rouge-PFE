<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Enums\VolunteerRequestStatus;
use App\Mail\NewVolunteerMail;
use App\Models\User;
use App\Models\VolunteerRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Livewire\Component;

new class extends Component
{
    public string $model_id   = '';
    public string $model_type = '';

    public string $first_name = '';
    public string $last_name  = '';
    public string $email      = '';
    public string $password   = '';
    public string $role       = '';
    public string $status     = '';
    public string $send_to    = '';

    public function mount(): void
    {
        $request = VolunteerRequest::findOrFail((int) $this->model_id);

        $this->first_name = $request->first_name;
        $this->last_name  = $request->last_name;
        $this->send_to    = $request->email;
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
                <input type="text" wire:model="first_name">
                @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Nom</label>
                <input type="text" wire:model="last_name">
                @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Email</label>
                <input type="email" wire:model="email">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div x-data="{ show: false }">
                <label>Mot de passe</label>
                <input :type="show ? 'text' : 'password'" wire:model="password">
                <button type="button" @click="show = !show">
                    <span x-show="!show">Afficher</span>
                    <span x-show="show">Cacher</span>
                </button>
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Rôle</label>
                <select wire:model="role">
                    <option value="">Choisir un role</option>
                    @foreach(UserRoles::cases() as $role)
                        <option value="{{ $role->value }}">{{ $role->label() }}</option>
                    @endforeach
                </select>
                @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label>Envoyer à :</label>
                <input type="email" wire:model="send_to">
                @error('send_to') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit">Créer</button>
                <button type="button" wire:click="close">Annuler</button>
            </div>

        </form>
    </div>
</div>
