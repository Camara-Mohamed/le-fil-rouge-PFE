@php
    use App\Enums\VolunteerRequestStatus;
@endphp

<div class="flex flex-col gap-8 px-4 py-8 md:px-8">

    <h2 class="font-sans font-black text-3xl text-dark">Les messages</h2>

    {{-- Tabs --}}
    <div class="flex gap-1 bg-bg rounded-lg p-1 self-start">
        <button
            wire:click="switchTab('contact')"
            class="flex items-center gap-2 px-4 py-2 rounded-md font-sans font-medium text-sm transition
                   {{ $tab === 'contact' ? 'bg-white text-dark shadow-sm' : 'text-dark-mid hover:text-dark' }}">
            Contacts
            @if($unreadContacts > 0)
                <x-public.badge variant="danger">{{ $unreadContacts }}</x-public.badge>
            @endif
        </button>
        <button
            wire:click="switchTab('volunteer')"
            class="flex items-center gap-2 px-4 py-2 rounded-md font-sans font-medium text-sm transition
                   {{ $tab === 'volunteer' ? 'bg-white text-dark shadow-sm' : 'text-dark-mid hover:text-dark' }}">
            Bénévoles
            @if($unreadVolunteers > 0)
                <x-public.badge variant="danger">{{ $unreadVolunteers }}</x-public.badge>
            @endif
        </button>
    </div>

    {{-- Recherche + Filtres --}}
    <div class="flex flex-wrap gap-3">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="Rechercher par nom ou email…"
            class="flex-1 min-w-48 px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark placeholder:text-dark-mid focus:outline-none focus:border-dark"
        />

        <select wire:model.live="filterRead" class="px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark focus:outline-none focus:border-dark">
            <option value="">Tous</option>
            <option value="unread">Non lus</option>
            <option value="read">Lus</option>
        </select>

        @if($tab === 'volunteer')
            <select wire:model.live="filterStatus" class="px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark focus:outline-none focus:border-dark">
                <option value="">Tous les statuts</option>
                @foreach(VolunteerRequestStatus::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </select>
        @endif

        @if($search || $filterRead || $filterStatus)
            <button wire:click="resetFilters" class="px-4 py-2 rounded-lg border border-bg-dark text-dark-mid font-serif text-sm hover:border-dark hover:text-dark transition">
                Réinitialiser
            </button>
        @endif
    </div>

    {{-- Tab Contacts --}}
    @if($tab === 'contact')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            @forelse ($contacts as $contact)
                <x-messages.contact-card :contact="$contact" />
            @empty
                <p class="font-serif text-dark-mid col-span-2">Aucun message de contact.</p>
            @endforelse
        </div>

        @if($contacts->hasPages())
            <div>{{ $contacts->links() }}</div>
        @endif
    @endif

    {{-- Tab Bénévoles --}}
    @if($tab === 'volunteer')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            @forelse ($volunteers as $volunteer)
                <x-messages.volunteer-card :volunteer="$volunteer" />
            @empty
                <p class="font-serif text-dark-mid col-span-2">Aucune demande de bénévole.</p>
            @endforelse
        </div>

        @if($volunteers->hasPages())
            <div>{{ $volunteers->links() }}</div>
        @endif
    @endif

</div>
