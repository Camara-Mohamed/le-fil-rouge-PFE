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

<div x-data x-init="$refs.dialog.showModal()">
    <dialog
        x-ref="dialog"
        @close="$wire.close()"
        class="p-0 border-0 rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] w-full max-w-lg m-auto backdrop:bg-dark/50"
    >
        <div class="relative px-8 py-8 flex flex-col gap-6">

            <button type="button" wire:click="close"
                    class="absolute top-4 right-4 text-dark-mid hover:text-dark transition"
                    aria-label="Fermer">
                <x-icons.close class="size-5" />
            </button>

            <h2 class="font-sans font-black text-2xl text-dark">Créer un compte bénévole</h2>

            <form wire:submit="save" class="flex flex-col gap-4">

                <div class="grid grid-cols-2 gap-4">
                    <x-public.form.input label="Prénom" name="first_name" wire:model.live="first_name" required />
                    <x-public.form.input label="Nom" name="last_name" wire:model.live="last_name" required />
                </div>

                <x-public.form.input label="Email" name="email" type="email" wire:model.live="email" required />

                <div x-data="{ show: false }" class="flex flex-col gap-2">
                    <label for="password" class="font-sans font-bold text-base text-dark">
                        Mot de passe <abbr title="{{ __('general.required') }}" class="text-red">*</abbr>
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            :type="show ? 'text' : 'password'"
                            wire:model.live="password"
                            class="h-11 px-4 pr-12 w-full bg-white border border-bg-dark rounded-lg font-serif font-medium text-base text-dark transition duration-200"
                        />
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-dark-mid hover:text-dark transition">
                            <x-icons.eye x-show="!show" class="size-5" />
                            <x-icons.eye-slash x-show="show" class="size-5" />
                        </button>
                    </div>
                    @error('password')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-public.form.select label="Rôle" name="role" wire:model.live="role" :options="UserRoles::cases()" />
                    <x-public.form.select label="Statut" name="status" wire:model.live="status" :options="UserStatus::cases()" />
                </div>

                <x-public.form.input label="Envoyer les identifiants à" name="send_to" type="email" wire:model.live="send_to" placeholder="email@exemple.com" />

                <div class="flex items-center justify-end gap-4 pt-2">
                    <button type="button" wire:click="close"
                            class="px-6 py-2.5 rounded-lg border-2 border-dark-light text-dark font-sans font-medium text-sm hover:border-dark transition">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-red text-white font-sans font-bold text-sm hover:bg-red-mid transition">
                        Créer le compte
                    </button>
                </div>

            </form>
        </div>
    </dialog>
</div>
