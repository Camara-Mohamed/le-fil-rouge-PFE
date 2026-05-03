<x-public.app title="Erreur 404">

    <h2>Erreur 404</h2>

    <p>Page introuvable.</p>

    <a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}">Accueil</a>

</x-public.app>
