<x-public.app title="{{ $camp->title }}">

    <livewire:widgets::breadcrumb :items="[
        ['label' => __('breadcrumbs.home'), 'url' => route('public.home', ['locale' => app()->getLocale()])],
        ['label' => __('breadcrumbs.camps'), 'url' => route('public.camps.index', ['locale' => app()->getLocale()])],
        ['label' => $camp->title],
    ]" />

    @if($camp->banner)
        <img src="{{ asset('storage/' . $camp->banner) }}" alt="{{ $camp->title }}">
    @endif

    <h1>{{ $camp->title }}</h1>

    <p>
        Du {{ $camp->start_date->format('d/m/Y H:i') }}
        au {{ $camp->end_date->format('d/m/Y H:i') }}
    </p>
    <p>{{ $camp->type->label() }}</p>

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
                <a href="{{ asset('storage/' . $galerie->path) }}" data-fancybox="galerie">
                    <img src="{{ asset('storage/' . $galerie->path) }}" alt="{{ $camp->title }}">
                </a>
            @endforeach
        </div>
    @endif

    @can('update', $camp)
        <a href="{{ route('admin.camps.edit', ['locale' => app()->getLocale(), 'camp' => $camp]) }}">
            Modifier cette formation
        </a>
    @endcan

    @auth
        <livewire:comments :model="$camp" />
        <livewire:enrollment :model="$camp" />

        @if($camp->isConfirmed())
            @can('update', $camp)
                <a href="{{ route('admin.camps.pdf', ['locale' => app()->getLocale(), 'camp' => $camp]) }}"
                   target="_blank">
                    Télécharger le récapitulatif (pdf)
                </a>
            @endcan
        @endif

        @if($myRegister && $camp->isConfirmed())
            <a href="{{ route('admin.camps.register.pdf', ['locale' => app()->getLocale(), 'camp' => $camp, 'register' => $myRegister]) }}" target="_blank">
                Télécharger mon contrat (pdf)
            </a>
        @endif
    @endauth

    // Héro + Retour

    // Details | Description + CTA (Inscription)

    // Galéries

    <livewire:widgets::modal />

</x-public.app>
