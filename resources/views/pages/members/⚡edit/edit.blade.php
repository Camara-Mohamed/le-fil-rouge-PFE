@php
    use App\Enums\UserRoles;
    use App\Enums\UserStatus;
@endphp

<div>
    <livewire:widgets::breadcrumb :items="[
        ['label' => __('breadcrumbs.members'), 'url' => route('admin.members.index', ['locale' => app()->getLocale()])],
        ['label' => $member->fullName(), 'url' => route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $member])],
        ['label' => __('breadcrumbs.edit')],
    ]" />

    @if(session('success'))
        <div class="text-green-500">{{ session('success') }}</div>
    @endif

    <form wire:submit="save" class="flex flex-col gap-4 max-w-md">
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

        @can('changeRole', $member)
        <div>
            <label>Rôle</label>
            <select wire:model.live="role">
                @foreach(UserRoles::cases() as $role)
                    <option value="{{ $role->value }}">{{ $role->label() }}</option>
                @endforeach
            </select>
            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        @endcan

        <div>
            <label>Téléphone</label>
            <input type="text" wire:model.live="phone">
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Date de naissance</label>
            <input type="date" wire:model.live="birth_date">
            @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @can('changeStatus', $member)
        <div>
            <label>Statut</label>
            <select wire:model.live="status">
                @foreach(UserStatus::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </select>
            @error('status') <p>{{ $message }}</p> @enderror
        </div>
        @endcan

        <div>
            <button type="submit">Enregistrer</button>
        </div>
    </form>
</div>
