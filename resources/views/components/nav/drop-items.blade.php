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

<form method="POST" action="{{ route('logout', ['locale' => app()->getLocale()]) }}">
    @csrf
    <button type="submit"
            title="{{ __('navigation.logout_title') }}"
            class="w-full border-none bg-transparent hover:text-white focus:text-white
                                    rounded-none
                                    px-4 py-2 hover:bg-red focus:bg-red  font-medium text-red">
        {{ __('navigation.logout') }}
    </button>
</form>
