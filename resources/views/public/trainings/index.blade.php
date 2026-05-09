<x-public.app title="Liste des Formations">

    <h2>Liste des Formations</h2>

    <div class="grid grid-cols-3 gap-8">
        @foreach($trainings as $training)
            <a href="{{ route('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $training->id]) }}">
                <article>
                    <h3>{{ $training->title }}</h3>
                    <p>{{ $training->start_date }}</p>
                    <p>{{ $training->city }}</p>
                </article>
            </a>
        @endforeach
    </div>

    <div>{{ $trainings->links() }}</div>

    <a href="{{route('admin.trainings.create', ['locale' => app()->getLocale()])}}">Create</a>

</x-public.app>
