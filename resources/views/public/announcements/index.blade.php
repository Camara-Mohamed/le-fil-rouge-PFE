<x-public.app title="Liste des actualités">

    <h2>Liste des actualités</h2>

    <a href="{{ route('admin.announcements.create', ['locale' => app()->getLocale()]) }}">Ajouter une actualité</a>

    <div class="grid grid-cols-3 gap-8">
        @foreach($announcements as $announcement)
            <a href="{{ route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement->id]) }}">
                <article>
                    @if($announcement->banner)
                        <img src="{{ asset('storage/' . $announcement->banner) }}" alt="{{ $announcement->title }}">
                    @endif
                    <h3>{{ $announcement->title }}</h3>
                    <p>{{ $announcement->description }}</p>
                    <p>{{ $announcement->details }}</p>
                    <p>{{ $announcement->published_at->format('d/m/Y H:i') }}</p>
                </article>
            </a>
        @endforeach
    </div>

    <div>{{ $announcements->links() }}</div>

    // Héro

    // Rechercher | Tri (Date)

    // Liste des actualités + Pagination

    // Liens utiles

</x-public.app>
