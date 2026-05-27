@php
    use App\Enums\UserRoles;
@endphp

<div class="flex flex-col gap-4">
    <livewire:widgets::breadcrumb :items="[
        ['label' => __('breadcrumbs.members'), 'url' => route('admin.members.index', ['locale' => app()->getLocale()])],
        ['label' => __('breadcrumbs.create_member')],
    ]" />

    <form wire:submit="save" class="flex flex-col gap-4">
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

    <div>
        <label>Mot de passe</label>
        <input type="password" wire:model="password">
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

    <div>
        <button type="submit">Créer</button>
        <a href="{{ route('admin.members.index', ['locale' => app()->getLocale()]) }}">Annuler</a>
    </div>
    </form>
</div>
