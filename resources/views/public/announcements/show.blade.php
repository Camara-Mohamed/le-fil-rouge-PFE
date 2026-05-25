<x-public.app title="{{ $announcement->title }}">

    <a href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}">Retour</a>

    @if($announcement->banner)
        <img src="{{ asset('storage/' . $announcement->banner) }}" alt="{{ $announcement->title }}">
    @endif

    <h1>{{ $announcement->title }}</h1>
    <p>{{ $announcement->published_at->format('d/m/Y H:i') }}</p>
    <p>{{ $announcement->description }}</p>

    @if($announcement->details)
        <p>{{ $announcement->details }}</p>
    @endif

    @if($announcement->content)
        <div>{!! $announcement->content !!}</div>
    @endif

    @if($announcement->galeries->count())
        <div class="grid grid-cols-6 gap-4">
            @foreach($announcement->galeries as $galerie)
                <img src="{{ asset('storage/' . $galerie->path) }}">
            @endforeach
        </div>
    @endif

    @can('update', $announcement)
        <a href="{{ route('admin.announcements.edit', ['locale' => app()->getLocale(), 'announcement' => $announcement]) }}">Modifier</a>
    @endcan

    @auth
        <livewire:comments :model="$announcement" />
    @endauth

    // Héro + Retour

    // Details | Description
</x-public.app>
