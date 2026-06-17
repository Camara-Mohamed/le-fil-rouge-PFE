<nav aria-label="{{ __('general.secondary_nav') }}" class="relative z-[110] flex items-center bg-dark py-3 px-4 md:px-6 lg:px-8">
    <h3 class="sr-only">{{ __('general.secondary_nav') }}</h3>

    @auth
        <a href="{{ route('admin.help', ['locale' => app()->getLocale()]) }}"
           wire:navigate
           class="font-sans text-sm text-dark-light hover:text-white transition duration-200">
            {{ __('pages/help.nav') }}
        </a>
    @endauth

    <x-nav.lang-switch></x-nav.lang-switch>
</nav>
