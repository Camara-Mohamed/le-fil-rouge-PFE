@php
    use App\Models\Announcement;
@endphp

<x-public.app title="Liste des actualités">

    <h2>Liste des actualités</h2>

    @can('create', Announcement::class)
        <a href="{{ route('admin.announcements.create', ['locale' => app()->getLocale()]) }}">Ajouter une actualité</a>
    @endcan

    <div class="grid grid-cols-3 gap-8">
        @forelse($announcements as $announcement)
            <a href="{{ route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement->id]) }}">
                <article>
                    @if($announcement->banner)
                        <img src="{{ asset('storage/' . $announcement->banner) }}" alt="{{ $announcement->title }}">
                    @endif
                    <h3>{{ $announcement->title }}</h3>
                    <p>{{ $announcement->description }}</p>
                    @if($announcement->published_at)
                        <p>{{ $announcement->published_at->format('d/m/Y H:i') }}</p>
                    @endif
                    @auth
                        <span>{{ $announcement->published_at }}</span>
                    @endauth
                </article>
            </a>
        @empty
            <p>Aucune actualité</p>
        @endforelse
    </div>

    <div>{{ $announcements->links() }}</div>

    // Héro

    // Rechercher | Tri (Date)

    // Liste des actualités + Pagination

    // Liens utiles

</x-public.app>
