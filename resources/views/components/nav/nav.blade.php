<nav aria-label="{{ __('navigation.primary_nav') }}"
     class="relative z-50 flex flex-wrap justify-between items-center bg-bg py-4 px-4 md:px-6 lg:px-8 border-b-2 border-b-red">

    <h3 class="sr-only">{{ __('navigation.primary_nav') }}</h3>

    {{-- Burger Checkbox --}}
    <input type="checkbox" id="nav-toggle" class="sr-only" />

    {{-- Logo --}}
    <x-nav.logo />

    {{-- Burger icon --}}
    <label id="nav-burger" for="nav-toggle"
           class="lg:hidden cursor-pointer text-dark hover:text-red-mid transition-colors"
           tabindex="0">
        <span class="sr-only">{{ __('navigation.open_menu') }}</span>
        <x-icons.burger fill="fill-dark" />
    </label>

    {{-- Liens --}}
    <ul id="main-nav-links"
        class="hidden lg:flex lg:items-center lg:gap-4">

        <li class="lg:hidden flex justify-between items-center pb-4 border-b border-bg-dark">
            <a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}"
               wire:navigate
               title="{{ __('navigation.home_title') }}"
               aria-current="{{ request()->routeIs('public.home') ? 'page' : 'false' }}"
               class="text-red font-sans text-xl font-black hover:text-red-mid transition duration-200">
                {{ __('navigation.home') }}
            </a>
            <label for="nav-toggle"
                   tabindex="0"
                   class="cursor-pointer text-dark hover:text-red-mid transition-colors">
                <span class="sr-only">{{ __('navigation.close_menu') }}</span>
                <x-icons.close />
            </label>
        </li>

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
                   class="px-6 py-2 inline-flex border-2 border-red rounded-lg bg-red text-white font-sans font-medium
                          hover:bg-red-mid hover:border-red-mid transition duration-200">
                    {{ __('navigation.login') }}
                </a>
            </li>
        @endguest

        @auth
            {{-- Desktop --}}
            <x-nav.drop-menu class="hidden lg:block" />

            {{-- Mobile --}}
            <li class="lg:hidden pt-6 border-t border-bg-dark">
                <span class="font-sans font-semibold text-dark-mid text-sm uppercase tracking-wider">
                    {{ __('navigation.profile') }}
                </span>
            </li>

            <x-nav.nav-link href="{{ route('admin.dashboard', ['locale' => app()->getLocale()]) }}"
                            title="{{ __('navigation.dashboard_title') }}"
                            route="admin.dashboard"
                            class="lg:hidden">
                {{ __('navigation.dashboard') }}
            </x-nav.nav-link>

            <x-nav.nav-link href="{{ route('admin.profile', ['locale' => app()->getLocale()]) }}"
                            title="{{ __('navigation.account_title') }}"
                            route="admin.profile"
                            class="lg:hidden">
                {{ __('navigation.account') }}
            </x-nav.nav-link>

            @unless(auth()->user()?->isAdmin())
            <x-nav.nav-link href="{{ route('admin.enrollments', ['locale' => app()->getLocale()]) }}"
                            title="{{ __('navigation.history_title') }}"
                            route="admin.enrollments"
                            class="lg:hidden">
                {{ __('navigation.history') }}
            </x-nav.nav-link>
            @endunless

            <li class="flex lg:hidden pt-8 border-t border-red
            justify-center">
                <form method="POST" action="{{ route('logout', ['locale' => app()->getLocale()]) }}">
                    @csrf
                    <button type="submit"
                            title="{{ __('navigation.logout_title') }}"
                            class="font-sans font-medium text-red py-4 px-6
                             bg-bg-mid hover:bg-red hover:text-white focus:bg-red focus:text-white
                            border-red rounded-lg">
                        {{ __('navigation.logout') }}
                    </button>
                </form>
            </li>
        @endauth

    </ul>
</nav>
