<nav aria-label="{{ __('navigation.primary_nav') }}"
     class="flex justify-between items-center bg-bg py-4 px-8 border-b-2 border-b-red border-solid">
    <h3 class="sr-only">{{ __('navigation.primary_nav') }}</h3>

    <a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}"
       wire:navigate
       title="{{ __('navigation.home_title') }}"
       aria-label="{{ config('app.name') }}"
       aria-current="{{ request()->routeIs('public.home') ? 'page' : 'false' }}"
       class="text-red font-sans text-2xl font-black hover:text-red-mid">
        {{ __('navigation.home') }}
    </a>

    <ul role="list" class="flex gap-4 items-center">

        <x-nav.nav-link href="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}"
                        title="{{ __('navigation.trainings_title') }}" route="public.trainings.*">
            {{ __('navigation.trainings') }}
        </x-nav.nav-link>

        <x-nav.nav-link href="{{ route('public.camps.index', ['locale' => app()->getLocale()]) }}"
                        title="{{ __('navigation.camps_title') }}" route="public.camps.*">
            {{ __('navigation.camps') }}
        </x-nav.nav-link>

        <x-nav.nav-link href="{{ route('public.about', ['locale' => app()->getLocale()]) }}"
                        title="{{ __('navigation.about_title') }}" route="public.about">
            {{ __('navigation.about') }}
        </x-nav.nav-link>

        <x-nav.nav-link href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}"
                        title="{{ __('navigation.announcements_title') }}" route="public.announcements.*">
            {{ __('navigation.announcements') }}
        </x-nav.nav-link>

        @can('manage-members')
            <x-nav.nav-link href="{{ route('admin.members.index', ['locale' => app()->getLocale()]) }}"
                            title="{{ __('navigation.members_title') }}" route="admin.members.*">
                {{ __('navigation.members') }}
            </x-nav.nav-link>
        @endcan

        @can('manage-messages')
            <x-nav.nav-link href="{{ route('admin.messages.index', ['locale' => app()->getLocale()]) }}"
                            title="{{ __('navigation.messages_title') }}" route="admin.messages.*">
                {{ __('navigation.messages') }}
            </x-nav.nav-link>
        @endcan

        <x-nav.nav-link href="{{ route('public.contact', ['locale' => app()->getLocale()]) }}"
                        title="{{ __('navigation.contact_title') }}" route="public.contact">
            {{ __('navigation.contact') }}
        </x-nav.nav-link>

        @guest
            <li>
                <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"
                   wire:navigate
                   title="{{ __('navigation.login_title') }}"
                   class="px-6 py-2 inline-flex border-2 border-red rounded bg-red text-white font-sans font-medium
                          hover:bg-red-mid hover:border-red-mid transition-colors duration-200
                           focus:ring-red">
                    {{ __('navigation.login') }}
                </a>
            </li>
        @endguest

        @auth
            <x-nav.drop-menu />
        @endauth

    </ul>
</nav>
