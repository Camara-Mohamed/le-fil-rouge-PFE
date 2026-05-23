<x-public.app title="{{ $camp->title }}">

    <a href="{{ route('public.camps.index', ['locale' => app()->getLocale()]) }}">← Retour aux formations</a>

    @if($camp->banner)
        <img src="{{ asset('storage/' . $camp->banner) }}" alt="{{ $camp->title }}">
    @endif

    <h1>{{ $camp->title }}</h1>

    <p>
        Du {{ $camp->start_date->format('d/m/Y H:i') }}
        au {{ $camp->end_date->format('d/m/Y H:i') }}
    </p>
    <p>{{ $camp->type }}</p>

    @if($camp->price)
        <p>Prix : {{ $camp->getFormattedPrice() }}</p>
        {{-- TODO : Si 0 -> gratuit --}}
    @endif

    @if($camp->participants)
        <p>
            {{ $camp->participants }}
        </p>
    @endif

    <p>{{ $camp->description }}</p>

    @if($camp->details)
        <div>{!! $camp->details !!}</div>
    @endif

    @if($camp->constraints)
        <h3>Prérequis</h3>
        <div>{!! $camp->constraints !!}</div>
    @endif

    @if($camp->city)
        <p>{{ $camp->address }} {{ $camp->number }}, {{ $camp->postal_code }} {{ $camp->city }}</p>
    @endif

    @if($camp->galeries->count())
        <div class="grid grid-cols-6 gap-4">
            @foreach($camp->galeries as $galerie)
                <img src="{{ asset('storage/' . $galerie->path) }}">
            @endforeach
        </div>
    @endif

    @can('update', $camp)
        <a href="{{ route('admin.camps.edit', ['locale' => app()->getLocale(), 'camp' => $camp]) }}">
            Modifier cette formation
        </a>
    @endcan

    // Héro + Retour

    // Details | Description + CTA (Inscription)

    // Galéries

</x-public.app>
