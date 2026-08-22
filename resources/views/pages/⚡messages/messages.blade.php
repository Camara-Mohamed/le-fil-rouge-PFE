@php
    use App\Enums\VolunteerRequestStatus;
@endphp

<div>

    <x-public.hero title="{{ __('navigation.messages') }}" />

    <div class="flex flex-col gap-8 px-4 py-8 md:px-8">

    {{-- Tabs --}}
    <div class="flex gap-1 bg-bg rounded-lg p-1 self-start">
        <button type="button"
            wire:click="switchTab('contact')"
            class="flex items-center gap-2 px-4 py-2 rounded-md font-sans font-medium text-sm transition
                   {{ $tab === 'contact' ? 'bg-white text-dark shadow-sm' : 'text-dark-mid hover:text-dark' }}">
            {{ __('pages/messages.tab_contacts') }}
            @if($unreadContacts > 0)
                <x-public.badge variant="danger">{{ $unreadContacts }}</x-public.badge>
            @endif
        </button>
        <button type="button"
            wire:click="switchTab('volunteer')"
            class="flex items-center gap-2 px-4 py-2 rounded-md font-sans font-medium text-sm transition
                   {{ $tab === 'volunteer' ? 'bg-white text-dark shadow-sm' : 'text-dark-mid hover:text-dark' }}">
            {{ __('pages/messages.tab_volunteers') }}
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
            placeholder="{{ __('pages/messages.search_placeholder') }}"
            aria-label="{{ __('pages/messages.search_aria') }}"
            class="flex-1 min-w-48 px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark placeholder:text-dark-mid focus:outline-none focus:border-dark"
        />

        <select wire:model.live="filterRead" aria-label="{{ __('pages/messages.filter_read_aria') }}" class="px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark focus:outline-none focus:border-dark">
            <option value="">{{ __('pages/messages.filter_all') }}</option>
            <option value="unread">{{ __('pages/messages.filter_unread') }}</option>
            <option value="read">{{ __('pages/messages.filter_read') }}</option>
        </select>

        @if($tab === 'volunteer')
            <select wire:model.live="filterStatus" aria-label="{{ __('pages/messages.filter_status_aria') }}" class="px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark focus:outline-none focus:border-dark">
                <option value="">{{ __('pages/messages.filter_all_statuses') }}</option>
                @foreach(VolunteerRequestStatus::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                @endforeach
            </select>
        @endif

        @if($search || $filterRead || $filterStatus)
            <button type="button" wire:click="resetFilters" class="px-4 py-2 rounded-lg border border-bg-dark text-dark-mid font-serif text-sm hover:border-dark hover:text-dark transition">
                {{ __('pages/messages.reset_filters') }}
            </button>
        @endif
    </div>

    {{-- Tab Contacts --}}
    @if($tab === 'contact')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            @forelse ($contacts as $contact)
                <x-messages.contact-card :contact="$contact" />
            @empty
                <p class="font-serif text-dark-mid col-span-2">{{ __('pages/messages.empty_contacts') }}</p>
            @endforelse
        </div>

        @if($contacts->hasPages())
            <div class="flex justify-center">{{ $contacts->links() }}</div>
        @endif
    @endif

    {{-- Tab Bénévoles --}}
    @if($tab === 'volunteer')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            @forelse ($volunteers as $volunteer)
                <x-messages.volunteer-card :volunteer="$volunteer" />
            @empty
                <p class="font-serif text-dark-mid col-span-2">{{ __('pages/messages.empty_volunteers') }}</p>
            @endforelse
        </div>

        @if($volunteers->hasPages())
            <div class="flex justify-center">{{ $volunteers->links() }}</div>
        @endif
    @endif

    </div>

</div>
