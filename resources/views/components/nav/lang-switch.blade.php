<ul class="flex gap-1.5">
    @foreach (config('app.locales') as $locale)
        <li class="font-serif text-white text font-normal hover:text-red-mid focus:text-red-mid hover:underline
        focus:underline
        capitalize">
            @if (request()->route() && Route::currentRouteName())
                <a href="{{ route(Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale'
                => $locale])) }}" title="Changer de langue">{{ $locale }}</a>
            @endif
        </li>
    @endforeach
</ul>
