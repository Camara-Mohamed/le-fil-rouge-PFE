<nav>
    <a href="{{ route('public.home') }}">Home</a>

    <ul>
        <li><a href="{{ route('public.courses.index') }}">Formations</a></li>
        <li><a href="{{ route('public.camps.index') }}">Stages et Séjours</a></li>
        <li><a href="{{ route('public.about') }}">Qui sommes-nous</a></li>
        <li><a href="{{ route('public.news.index') }}">Actualités</a></li>
        <li><a href="{{ route('public.contact') }}">Nous Contacter</a></li>

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
