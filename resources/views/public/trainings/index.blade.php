<x-public.app title="{{ __('public/trainings.title') }}">

    {{-- Héro --}}

@can('create', App\Models\Training::class)
        <a href="{{ route('admin.trainings.create', ['locale' => app()->getLocale()]) }}">Ajouter une formation</a>
    @endcan

    {{-- Liste des formations --}}
    <div class="px-4 md:px-6 lg:px-8 py-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($trainings as $training)
            <x-public.trainings.card :training="$training" />
        @empty
            <p class="font-serif text-dark-mid col-span-3">Aucune formation disponible.</p>
        @endforelse
    </div>

    <div class="px-4 md:px-6 lg:px-8">{{ $trainings->links() }}</div>

    {{-- Recherche | Filtres | Tri --}}

    {{-- Liste des formations (Date - Desc) + Pagination --}}

    {{-- Image + Texte Descriptifs --}}

    {{-- Galéries --}}

</x-public.app>
