<a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}"
   wire:navigate
   title="{{ __('navigation.home_title') }}"
   aria-label="{{ config('app.name') }}"
   class="text-red font-sans text-2xl font-black hover:text-red-mid transition duration-200">
    {{ config('app.name') }}
</a>
