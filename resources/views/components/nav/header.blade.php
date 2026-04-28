<nav>
    <a href="{{ route('public.home', app()->getLocale()) }}">Home</a>

    <ul>
        <li><a href="{{ route('public.courses.index', app()->getLocale()) }}">Formations</a></li>
        <li><a href="{{ route('public.camps.index', app()->getLocale()) }}">Stages et Séjours</a></li>
        <li><a href="{{ route('public.about', app()->getLocale()) }}">Qui sommes-nous</a></li>
        <li><a href="{{ route('public.news.index', app()->getLocale()) }}">Actualités</a></li>
        <li><a href="{{ route('public.contact', app()->getLocale()) }}">Nous Contacter</a></li>

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
