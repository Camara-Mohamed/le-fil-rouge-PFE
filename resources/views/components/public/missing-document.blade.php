@php
    $user = auth()->user();
@endphp

@if($user->isIncomplete())
    <a href="{{ route('admin.profile', ['locale' => app()->getLocale()]) }}"
       {{ $attributes->class(['px-6 py-4 bg-white rounded-tl-sm rounded-bl-sm shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] border-l-[6px] border-red flex flex-col gap-2.5 hover:bg-red-light transition']) }}>
        <div class="flex flex-col gap-2">
            <p class="font-sans font-black text-base text-dark">Il manque un document</p>
            <p class="font-serif font-medium text-base text-dark">Votre inscription est presque complète. Il vous
                reste envoyer les documents demandées.</p>
        </div>
    </a>

@elseif($user->isPending())
    <a href="{{ route('admin.profile', ['locale' => app()->getLocale()]) }}"
       {{ $attributes->class(['px-6 py-4 bg-white rounded-tl-sm rounded-bl-sm shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] border-l-[6px] border-warning flex flex-col gap-2.5 hover:bg-warning-bg transition']) }}>
        <div class="flex flex-col gap-2">
            <p class="font-sans font-black text-base text-dark">Dossier en attente</p>
            <p class="font-serif font-medium text-base text-dark">Votre document a bien été envoyé. Il est
                en cours de revision.</p>
        </div>
    </a>
@endif
