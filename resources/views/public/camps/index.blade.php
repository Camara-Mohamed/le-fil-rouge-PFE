<x-public.app title="La liste des stages et séjours">

    <h2>La liste des stages et séjours</h2>

    <div class="grid grid-cols-3 gap-8">
        @foreach($camps as $camp)
            <a href="{{ route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $camp->id]) }}">
                <article>
                    <h3>{{ $camp->title }}</h3>
                    <p>{{ $camp->start_date }}</p>
                    <p>{{ $camp->city }}</p>
                </article>
            </a>
        @endforeach
    </div>

    <div>{{ $camps->links() }}</div>

    // Héro

    // Recherche | Filtres | Tri

    // Liste des camps (Date - Desc) + Pagination

    // Compositions + Texte

    // Galéries

</x-public.app>
