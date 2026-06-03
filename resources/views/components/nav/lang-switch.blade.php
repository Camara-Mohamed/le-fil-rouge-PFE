<ul class="flex items-center gap-1.5">
    @foreach (config('app.locales') as $locale)
        <li class="font-serif text-sm text-white underline font-normal hover:text-red-mid focus:text-red-mid">
            @if (request()->route() && Route::currentRouteName())
                <a href="{{ route(Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale'
                => $locale])) }}" lang="{{ $locale }}" hreflang="{{ $locale }}"
                   title="{{ __('general.switch_language', ['language' => __('general.locales.' . $locale)]) }}">
                    {{ $locale }}
                </a>
            @endif
        </li>
    @endforeach
</ul>
