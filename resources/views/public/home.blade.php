<x-public.app title="Page d'Accueil">

    <h2>Page d'Accueil</h2>

    <a href="{{ route('public.volunteer', ['locale' => app()->getLocale()]) }}">Devenir Volontaire</a>

    <div class="grid grid-cols-3 gap-8">
        @foreach($announcements as $announcement)
            <a href="{{ route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement->id]) }}">
                <article>
                    <h3>{{ $announcement->title }}</h3>
                    <p>{{ $announcement->description }}</p>
                    <p>{{ $announcement->details }}</p>
                </article>
            </a>
        @endforeach
    </div>

    // Héro

    // Liste des actualités récentes (limite 3)

    // Video + Texte + Quelques statistiques + CTA->About

    // CTA (Formations x Camps)

    // Statistiques + CTA (Devenir Volontaire)

</x-public.app>
