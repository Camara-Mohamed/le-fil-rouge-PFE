<li class="relative" x-data="{ open: false }">
    <details :open="open" @click.outside="open = false">

        <summary
            class="list-none cursor-pointer px-6 py-2 inline-flex items-center gap-2 border-2 border-red rounded bg-red
                   text-white font-sans font-medium hover:bg-red-mid transition duration-200"
            title="{{ __('navigation.profile_title') }}"
            @click.prevent="open = !open"
            @keydown.escape="open = false">
            {{ __('navigation.profile') }}
        </summary>

        <ul class="absolute right-0 mt-4 min-w-48 bg-white border border-bg-dark rounded shadow-lg z-50">

            <x-nav.drop-item href="{{ route('admin.dashboard', ['locale' => app()->getLocale()]) }}"
                             title="{{ __('navigation.dashboard_title') }}">
                {{ __('navigation.dashboard') }}
            </x-nav.drop-item>

            <x-nav.drop-item href="{{ route('admin.profile', ['locale' => app()->getLocale()]) }}"
                             title="{{ __('navigation.account_title') }}">
                {{ __('navigation.account') }}
            </x-nav.drop-item>

            <x-nav.drop-item href="{{ route('admin.enrollments', ['locale' => app()->getLocale()]) }}"
                             title="{{ __('navigation.history_title') }}">
                {{ __('navigation.history') }}
            </x-nav.drop-item>

            <li class="border-t border-t-red bg-red-light">
                <form method="POST" action="{{ route('logout', ['locale' => app()->getLocale()]) }}">
                    @csrf
                    <x-forms.button type="submit"
                                    title="{{ __('navigation.logout_title') }}"
                                    class="w-full border-none bg-transparent hover:text-white focus:text-white
                                    rounded-none
                                    px-4 py-2 hover:bg-red focus:bg-red  font-medium text-red">
                        {{ __('navigation.logout') }}
                    </x-forms.button>
                </form>
            </li>

        </ul>
    </details>
</li>
