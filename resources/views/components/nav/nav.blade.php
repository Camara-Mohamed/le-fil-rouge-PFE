<nav class="flex gap-2 justify-between">
    <h3 class="sr-only">Navigation principale</h3>

    <a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}">Accueil</a>

    <ul class="flex gap-2">
        <li class="hover:underline hover:text-blue-500"><a href="{{ route('public.trainings.index', ['locale' => app()
        ->getLocale()]) }}">Les Formations</a></li>
        <li class="hover:underline hover:text-blue-500"><a href="{{ route('public.camps.index', ['locale' => app()
        ->getLocale()]) }}">Les Camps</a></li>
        <li class="hover:underline hover:text-blue-500"><a href="{{ route('public.about', ['locale' => app()->getLocale
        ()]) }}">Qui sommes-nous</a></li>
        <li class="hover:underline hover:text-blue-500"><a href="{{ route('public.announcements.index', ['locale' => app
        ()->getLocale()]) }}">Les Actualités</a>
        </li>

        @can('manage-members')
            <li class="hover:underline hover:text-blue-500"><a href="{{ route('admin.members.index', ['locale' => app()->getLocale
        ()]) }}">Les Membres</a></li>
        @endcan

        @can('manage-messages')
            <li class="hover:underline hover:text-blue-500"><a href="{{ route('admin.messages.index', ['locale' => app()->getLocale
        ()]) }}">Les Messages</a></li>
        @endcan

        <li class="hover:underline hover:text-blue-500"><a href="{{ route('public.contact', ['locale' => app()
        ->getLocale()]) }}">Nous Contacter</a></li>

        @guest
            <a href="{{ route('login', ['locale'=>app()->getLocale()]) }}" class="text-green-500 hover:underline">Login</a>
        @endguest

        @auth
            <li class="group relative">
                <button type="button" class="hover:text-blue-500 hover:underline">
                    Mon Profil
                </button>
                <ul>
                    <li class="hover:underline hover:text-blue-500"><a href="{{ route('admin.dashboard', ['locale' =>
                    app()->getLocale()]) }}">Mon Dashboard</a></li>
                    <li class="hover:underline hover:text-blue-500"><a href="{{ route('admin.profile', ['locale' =>
                    app()->getLocale()]) }}">Mon Compte</a></li>
                    <li class="hover:underline hover:text-blue-500"><a href="{{ route('admin.enrollments', ['locale' => app()->getLocale()]) }}">Mon Historique</a></li>

                    <form method="POST" action="{{ route('logout', ['locale'=>app()->getLocale()], ['locale'=>app()->getLocale()]) }}">
                        <button type="submit" class="hover:text-red-500 hover:underline">Logout</button>
                    </form>
                </ul>
            </li>
        @endauth
    </ul>
</nav>
