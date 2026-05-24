@php
    use App\Models\Camp;
@endphp

<x-public.app title="La liste des stages et séjours">

    <h2>Liste des stages et séjours</h2>

    @can('create', Camp::class)
        <a href="{{ route('admin.camps.create', ['locale' => app()->getLocale()]) }}">Ajouter une camp</a>
    @endcan

    <div class="grid grid-cols-3 gap-8">
        @forelse($camps as $camp)
            <a href="{{ route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $camp->id]) }}">
                <article>
                    @if($camp->banner)
                        <img src="{{ asset('storage/' . $camp->banner) }}" alt="{{ $camp->title }}">
                    @endif
                    <h3>{{ $camp->title }}</h3>
                    <p>{{ $camp->start_date->format('d/m/Y H:i') }} — {{ $camp->end_date->format('d/m/Y H:i') }}</p>
                    @if($camp->city)
                        <p>{{ $camp->city }}</p>
                    @endif
                    <p>{{ $camp->description }}</p>
                    @auth
                        <span>{{ $camp->status->label() }}</span>
                    @endauth
                </article>
            </a>
        @empty
            <p>Aucun stage</p>
        @endforelse
    </div>

    <div>{{ $camps->links() }}</div>

    // Héro

    // Recherche | Filtres | Tri

    // Liste des camps (Date - Desc) + Pagination

    // Compositions + Texte

    // Galéries

</x-public.app>
