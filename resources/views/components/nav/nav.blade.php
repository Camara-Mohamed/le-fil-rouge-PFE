<nav>
    <h3 class="sr-only">Navigation principale</h3>

    <a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}">Accueil</a>

    <ul>
        <li><a href="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}">Les Formations</a></li>
        <li><a href="{{ route('public.camps.index', ['locale' => app()->getLocale()]) }}">Les Camps</a></li>
        <li><a href="{{ route('public.about', ['locale' => app()->getLocale()]) }}">Qui sommes-nous</a></li>
        <li><a href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}">Les Actualités</a>
        </li>
        <li><a href="{{ route('public.contact', ['locale' => app()->getLocale()]) }}">Nous Contacter</a></li>

        @guest
            <a href="{{ route('login') }}">Login</a>
        @endguest

        @auth
            <form method="POST" action="{{ route('logout') }}">
                <button type="submit">Logout</button>
            </form>
        @endauth
    </ul>
</nav>
