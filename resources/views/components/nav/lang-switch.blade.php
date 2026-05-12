<ul class="flex gap-2">
    @foreach (config('app.locales') as $locale)
        <li class="hover:text-purple-500 hover:underline">
            @if (request()->route() && Route::currentRouteName())
                <a href="{{ route(Route::currentRouteName(), array_merge(request()->route()->parameters(), ['locale' => $locale])) }}">{{ $locale }}</a>
            @endif
        </li>
    @endforeach
</ul>
