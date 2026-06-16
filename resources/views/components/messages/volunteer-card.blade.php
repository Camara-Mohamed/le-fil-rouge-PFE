@props(['volunteer'])

@php use App\Enums\VolunteerRequestStatus; @endphp

<article
    wire:key="volunteer-{{ $volunteer->id }}"
    class="bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] p-6 flex flex-col gap-4
           {{ !$volunteer->read_at ? 'border-l-4 border-red' : '' }}"
>
    <div class="flex items-start justify-between gap-4 flex-wrap">
        <div class="flex items-center gap-2">
            @if(!$volunteer->read_at)
                <span class="w-2 h-2 rounded-full bg-red inline-block"></span>
            @endif
            <x-public.badge variant="warning">Bénévole</x-public.badge>
            <x-public.badge variant="{{ match($volunteer->status) {
                VolunteerRequestStatus::ACCEPTED => 'success',
                VolunteerRequestStatus::REJECTED => 'danger',
                VolunteerRequestStatus::PENDING  => 'warning',
            } }}">
                {{ $volunteer->status->label() }}
            </x-public.badge>
        </div>
        <p class="font-serif text-sm text-dark-mid">{{ $volunteer->created_at->diffForHumans() }}</p>
    </div>

    <div class="flex flex-col gap-1">
        <h3 class="font-sans font-semibold text-dark">{{ $volunteer->fullName() }}</h3>
        <p class="font-serif text-sm text-dark-mid">{{ $volunteer->email }}</p>
    </div>

    <p class="font-serif text-dark leading-relaxed">{{ $volunteer->message }}</p>

    <div class="flex items-center gap-3 flex-wrap pt-2 border-t border-bg-dark">
        @if(!$volunteer->read_at)
            <button
                type="button"
                wire:click="markAsRead({{ $volunteer->id }}, 'volunteer')"
                class="px-4 py-1.5 rounded-lg border-2 border-dark-light text-dark text-sm font-sans font-medium hover:border-dark transition">
                Marquer comme lu
            </button>
        @endif

        <a href="mailto:{{ $volunteer->email }}"
           wire:click="markAsRead({{ $volunteer->id }}, 'volunteer')"
           class="px-4 py-1.5 rounded-lg bg-red text-white text-sm font-sans font-medium hover:bg-red-mid transition">
            Contacter
        </a>

        @if($volunteer->status === VolunteerRequestStatus::PENDING)
            <button
                type="button"
                wire:click="openCreateMember({{ $volunteer->id }})"
                class="px-4 py-1.5 rounded-lg bg-dark text-white text-sm font-sans font-medium hover:bg-dark-mid transition">
                Créer un compte
            </button>
        @endif

        @if($volunteer->status !== VolunteerRequestStatus::REJECTED)
            <button
                type="button"
                wire:click="openRefuseModal({{ $volunteer->id }})"
                class="px-4 py-1.5 rounded-lg border-2 border-red text-red text-sm font-sans font-medium hover:bg-red-light transition">
                Refuser
            </button>
        @endif

        @if($volunteer->status !== VolunteerRequestStatus::PENDING)
            <button
                type="button"
                wire:click="openResetPendingModal({{ $volunteer->id }})"
                class="px-4 py-1.5 rounded-lg border-2 border-dark-light text-dark-mid text-sm font-sans font-medium hover:border-dark transition">
                Remettre en attente
            </button>
        @endif
    </div>
</article>
