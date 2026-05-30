<nav class="flex justify-between items-center bg-bg py-3 px-8 border-b-2 border-b-bg-dark border-solid ">
    <h3 class="sr-only">Navigation principale</h3>
<livewire.tests></livewire.tests>

    <a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}" wire:navigate>Accueil</a>

    <ul class="flex gap-4">
        <li class="text-sans text-dark text hover:text-red-mid font-medium"><a
                href="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}" wire:navigate>Les
                Formations</a></li>
        <li class="text-sans text-dark text hover:text-red-mid font-medium"><a
                href="{{ route('public.camps.index', ['locale' => app()->getLocale()]) }}" wire:navigate>Les
                Camps</a></li>
        <li class="text-sans text-dark text hover:text-red-mid font-medium"><a
                href="{{ route('public.about', ['locale' => app()->getLocale()]) }}" wire:navigate>Qui
                sommes-nous</a></li>
        <li class="text-sans text-dark text hover:text-red-mid font-medium"><a
                href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}" wire:navigate>Les
                Actualités</a></li>

        @can('manage-members')
            <li class="text-sans text-dark text hover:text-red-mid font-medium"><a
                    href="{{ route('admin.members.index', ['locale' => app()->getLocale()]) }}" wire:navigate>Les
                    Membres</a></li>
        @endcan

        @can('manage-messages')
            <li class="text-sans text-dark text hover:text-red-mid font-medium"><a
                    href="{{ route('admin.messages.index', ['locale' => app()->getLocale()]) }}" wire:navigate>Les
                    Messages</a></li>
        @endcan

        <li class="text-sans text-dark text hover:text-red-mid font-medium"><a
                href="{{ route('public.contact', ['locale' => app()->getLocale()]) }}" wire:navigate>Nous
                Contacter</a></li>

        @guest
            <a href="{{ route('login', ['locale'=>app()->getLocale()]) }}" class="text-green-500 hover:underline"
               wire:navigate>Login</a>
        @endguest

        @auth
            <li class="group relative">
                <button type="button" class="hover:text-blue-500 hover:underline">
                    Mon Profil
                </button>
                <ul>
                    <li class="text-sans text-dark text hover:text-red-mid"><a
                            href="{{ route('admin.dashboard', ['locale' => app()->getLocale()]) }}" wire:navigate>Mon
                            Dashboard</a></li>
                    <li class="text-sans text-dark text hover:text-red-mid"><a
                            href="{{ route('admin.profile', ['locale' => app()->getLocale()]) }}" wire:navigate>Mon
                            Compte</a></li>
                    <li class="text-sans text-dark text hover:text-red-mid"><a
                            href="{{ route('admin.enrollments', ['locale' => app()->getLocale()]) }}" wire:navigate>Mon
                            Historique</a></li>

                    <form method="POST"
                          action="{{ route('logout', ['locale'=>app()->getLocale()], ['locale'=>app()->getLocale()]) }}">
                        <button type="submit" class="hover:text-red-500 hover:underline">Logout</button>
                    </form>
                </ul>
            </li>
        @endauth
    </ul>
</nav>
