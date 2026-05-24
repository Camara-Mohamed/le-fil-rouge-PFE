<x-public.app title="Liste des formations">

    <h2>Liste des formations</h2>

    @can('create', App\Models\Training::class)
        <a href="{{ route('admin.trainings.create', ['locale' => app()->getLocale()]) }}">Ajouter une formation</a>
    @endcan

    <div class="grid grid-cols-3 gap-8">
        @forelse($trainings as $training)
            <a href="{{ route('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $training->id]) }}">
                <article>
                    @if($training->banner)
                        <img src="{{ asset('storage/' . $training->banner) }}" alt="{{ $training->title }}">
                    @endif
                    <h3>{{ $training->title }}</h3>
                    <p>{{ $training->start_date->format('d/m/Y H:i') }} — {{ $training->end_date->format('d/m/Y H:i')
                     }}</p>
                    @if($training->city)
                        <p>{{ $training->city }}</p>
                    @endif
                    <p>{{ $training->description }}</p>
                    @if($training->price)
                        <p>{{ $training->getFormattedPrice() }}</p>
                    @endif
                    @auth
                        <span>{{ $training->status->label() }}</span>
                    @endauth
                </article>
            </a>
        @empty
            <p>Aucune formation</p>
        @endforelse
    </div>

    <div>{{ $trainings->links() }}</div>

    // Héro

    // Recherche | Filtres | Tri

    // Liste des formations (Date - Desc) + Pagination

    // Image + Texte Descriptifs

    // Galéries

</x-public.app>
