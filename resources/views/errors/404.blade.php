<x-public.app :title="__('errors.404_title')">

    <h2>{{ __('errors.404_title') }}</h2>

    <p>{{ __('errors.404_message') }}</p>

    <a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}">{{ __('errors.back_home') }}</a>

</x-public.app>
