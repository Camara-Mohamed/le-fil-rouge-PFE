@php
    use App\Enums\UserRoles;
@endphp

<div class="flex flex-col gap-4">

    <div class="flex gap-2">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Rechercher"
        >

        <select wire:model.live="role">
            <option value="">Tous</option>

            @foreach(UserRoles::cases() as $role)
                <option value="{{ $role->value }}">
                    {{ $role->label() }}
                </option>
            @endforeach
        </select>

        <a href="{{ route('admin.members.create', ['locale' => app()->getLocale()]) }}">
            Ajouter un membre
        </a>
    </div>

    <table>
        <thead>
        <tr>
            <th class="px-4 py-2">Avatar</th>
            <th class="px-4 py-2">Nom</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Rôle</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
        </thead>

        <tbody>
        @forelse($members as $member)

            @php
                $initials = strtoupper($member->first_name[0] . $member->last_name[0]);
            @endphp

            <tr>
                <td class="px-4 py-2">

                    @if($member->avatar_path)
                        <a
                            href="{{ asset('storage/avatars/originals/' . $member->avatar_path) }}"
                            data-fancybox="members"
                        >
                            <img
                                src="{{ asset('storage/avatars/originals/' . $member->avatar_path) }}"
                                alt="{{ $member->fullName() }}"
                                class="w-10 h-10 rounded-full"
                            >
                        </a>
                    @else
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center border">
                            {{ $initials }}
                        </div>
                    @endif

                </td>

                <td class="px-4 py-2">
                    {{ $member->fullName() }}
                </td>

                <td class="px-4 py-2">
                    {{ $member->email }}
                </td>

                <td class="px-4 py-2">
                    {{ $member->role->value }}
                </td>

                <td class="px-4 py-2 flex gap-2">
                    <a href="{{ route('admin.members.show', [
                                'locale' => app()->getLocale(),
                                'member' => $member
                            ]) }}">
                        Voir
                    </a>

                    <a href="{{ route('admin.members.edit', ['locale' => app()->getLocale(),'member' => $member]) }}">
                        Modifier
                    </a>
                </td>
            </tr>

        @empty
            <tr>
                <td class="px-4 py-4">
                    Aucun membre
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $members->links() }}

</div>
