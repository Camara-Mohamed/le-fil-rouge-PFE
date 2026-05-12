@php use
    App\Enums\UserRoles;
@endphp

<div>
    <a href="{{ route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $member]) }}">Retour</a>

    <form wire:submit="save" class="flex flex-col gap-4 max-w-md">
        <div>
            <label>Prénom</label>
            <input type="text" wire:model="first_name">
        </div>

        <div>
            <label>Nom</label>
            <input type="text" wire:model="last_name">
        </div>

        <div>
            <label>Email</label>
            <input type="email" wire:model="email">
        </div>

        <div>
            <label>Rôle</label>
            <select wire:model="role">
                @foreach(UserRoles::cases() as $role)
                    <option value="{{ $role->value }}">{{ $role->value }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Téléphone</label>
            <input type="text" wire:model="phone">
        </div>

        <div>
            <label>Date de naissance</label>
            <input type="date" wire:model="birth_date">
        </div>

        <div>
            <button type="submit">Enregistrer</button>
            @if($saved)
                <span class="text-green-500">Mis à jour</span>
            @endif
        </div>
    </form>
</div>
