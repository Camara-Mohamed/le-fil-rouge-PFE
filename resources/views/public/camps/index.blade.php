<x-public.app title="La liste des stages et séjours">

    <h2>Liste des stages et séjours</h2>

    @can('create', App\Models\Camp::class)
        <a href="{{ route('admin.camps.create', ['locale' => app()->getLocale()]) }}">Ajouter une camp</a>
    @endcan

    <div class="grid grid-cols-3 gap-8">
        @auth
            @can('view-any', App\Models\Camp::class)
                @forelse($allCamps as $camp)
                    <a href="{{ route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $camp->id]) }}">
                        <article>
                            @if($camp->banner)
                                <img src="{{ asset('storage/' . $camp->banner) }}" alt="{{ $camp->title }}">
                            @endif
                            <h3>{{ $camp->title }}</h3>
                            <p>{{ $camp->start_date->format('d/m/Y H:i') }}
                                — {{ $camp->end_date->format('d/m/Y H:i')  }}</p>
                            @if($camp->city)
                                <p>{{ $camp->city }}</p>
                            @endif
                            <p>{{ $camp->description }}</p>
                            @if($camp->price)
                                <p>{{ $camp->getFormattedPrice() }}</p>
                                {{-- TODO : Si 0 -> gratuit --}}
                            @endif
                        </article>
                    </a>
                @empty
                    <p>Aucune formation </p>
                @endforelse
            @endcan
        @endauth


        @guest
            @forelse($camps as $camp)
                <a href="{{ route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $camp->id]) }}">
                    <article>
                        @if($camp->banner)
                            <img src="{{ asset('storage/' . $camp->banner) }}" alt="{{ $camp->title }}">
                        @endif
                        <h3>{{ $camp->title }}</h3>
                        <p>{{ $camp->start_date->format('d/m/Y H:i') }}
                            — {{ $camp->end_date->format('d/m/Y H:i') }}</p>
                        @if($camp->city)
                            <p>{{ $camp->city }}</p>
                        @endif
                        <p>{{ $camp->description }}</p>
                        @if($camp->price)
                            <p>{{ $camp->getFormattedPrice() }}</p>
                            {{-- TODO : Si 0 -> gratuit --}}
                        @endif
                    </article>
                </a>
            @empty
                <p>Aucune formation</p>
            @endforelse
        @endguest
    </div>

    <div>{{ $camps->links() }}</div>

    // Héro

    // Recherche | Filtres | Tri

    // Liste des camps (Date - Desc) + Pagination

    // Compositions + Texte

    // Galéries

</x-public.app>
