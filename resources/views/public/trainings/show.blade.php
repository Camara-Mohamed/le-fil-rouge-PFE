<x-public.app title="{{ $training->title }}">

    <livewire:widgets::breadcrumb :items="[
        ['label' => __('breadcrumbs.home'), 'url' => route('public.home', ['locale' => app()->getLocale()])],
        ['label' => __('breadcrumbs.trainings'), 'url' => route('public.trainings.index', ['locale' => app()->getLocale()])],
        ['label' => $training->title],
    ]" />

    @if($training->banner)
        <img src="{{ asset('storage/' . $training->banner) }}" alt="{{ $training->title }}">
    @endif

    <h1>{{ $training->title }}</h1>

    <p>
        Du {{ $training->start_date->format('d/m/Y H:i') }}
        au {{ $training->end_date->format('d/m/Y H:i') }}
    </p>
    <p>{{ $training->type->label() }}</p>

    @if($training->price !== null)
        <p>Prix : {{ $training->getFormattedPrice() }}</p>
    @endif

    @if($training->participants)
        <p>
            {{ $training->participants }}
        </p>
    @endif

    <p>{{ $training->description }}</p>

    @if($training->details)
        <div>{!! $training->details !!}</div>
    @endif

    @if($training->constraints)
        <h3>Prérequis</h3>
        <div>{!! $training->constraints !!}</div>
    @endif

    @if($training->city)
        <p>{{ $training->address }} {{ $training->number }}, {{ $training->postal_code }} {{ $training->city }}</p>
    @endif

    @if($training->galeries->count())
        <div class="grid grid-cols-6 gap-4">
            @foreach($training->galeries as $galerie)
                <a href="{{ asset('storage/' . $galerie->path) }}" data-fancybox="galerie">
                    <img src="{{ asset('storage/' . $galerie->path) }}" alt="{{ $training->title }}">
                </a>
            @endforeach
        </div>
    @endif

    @can('update', $training)
        <a href="{{ route('admin.trainings.edit', ['locale' => app()->getLocale(), 'training' => $training]) }}">
          Modifier cette formation
        </a>
    @endcan

    @auth
        <livewire:comments :model="$training" />
        <livewire:enrollment :model="$training" />

        @if($training->isConfirmed())
            @can('update', $training)
                <a href="{{ route('admin.trainings.pdf', ['locale' => app()->getLocale(), 'training' => $training]) }}" target="_blank">
                    Télécharger le récapitulatif (pdf)
                </a>
            @endcan
        @endif
    @endauth

    // Héro + Retour

    // Details | Description + CTA (Inscription)

    // Galéries

</x-public.app>
