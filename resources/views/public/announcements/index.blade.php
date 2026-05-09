<x-public.app title="Liste des actualités">

    <h2>Liste des actualités</h2>

    <div class="grid grid-cols-3 gap-8">
        @foreach($announcements as $announcement)
            <a href="{{ route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement->id]) }}">
                <article>
                    <h3>{{ $announcement->title }}</h3>
                    <p>{{ $announcement->description }}</p>
                    <p>{{ $announcement->details }}</p>
                    <p>{{ $announcement->published_at }}</p>
                </article>
            </a>
        @endforeach
    </div>

    <div>{{ $announcements->links() }}</div>

</x-public.app>
