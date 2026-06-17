@props(['contact'])

<article
    wire:key="contact-{{ $contact->id }}"
    class="bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] p-6 flex flex-col gap-4
           {{ !$contact->read_at ? 'border-l-4 border-red' : '' }}"
>
    <div class="flex items-start justify-between gap-4 flex-wrap">
        <div class="flex items-center gap-2">
            @if(!$contact->read_at)
                <span class="w-2 h-2 rounded-full bg-red inline-block"></span>
            @endif
            <x-public.badge variant="info">Contact</x-public.badge>
        </div>
        <p class="font-serif text-sm text-dark-mid">{{ $contact->created_at->diffForHumans() }}</p>
    </div>

    <div class="flex flex-col gap-1">
        <h3 class="font-sans font-semibold text-dark">{{ $contact->full_name }}</h3>
        <p class="font-serif text-sm text-dark-mid">{{ $contact->email }}</p>
        @if($contact->sujet)
            <p class="font-sans font-medium text-dark-mid text-sm">{{ $contact->sujet }}</p>
        @endif
    </div>

    <p class="font-serif text-dark leading-relaxed whitespace-pre-line">{!! $contact->message !!}</p>

    <div class="flex items-center gap-3 flex-wrap pt-2 border-t border-bg-dark">
        @if(!$contact->read_at)
            <button
                type="button"
                wire:click="markAsRead({{ $contact->id }}, 'contact')"
                class="px-4 py-1.5 rounded-lg border-2 border-dark-light text-dark text-sm font-sans font-medium hover:border-dark transition">
                Marquer comme lu
            </button>
        @endif
        <a href="mailto:{{ $contact->email }}"
           wire:click="markAsRead({{ $contact->id }}, 'contact')"
           class="px-4 py-1.5 rounded-lg bg-red text-white text-sm font-sans font-medium hover:bg-red-mid transition">
            Répondre
        </a>
    </div>
</article>
