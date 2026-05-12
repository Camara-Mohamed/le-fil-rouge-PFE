<x-public.app title="Erreur 404">

    <h2>Erreur 403</h2>

    <p>Vous n'êtes pas autoriser à aller sur cette page.</p>

    <a href="{{ route('admin.dashboard', ['locale' => app()->getLocale()]) }}">Revenir en arrière</a>

</x-public.app>
