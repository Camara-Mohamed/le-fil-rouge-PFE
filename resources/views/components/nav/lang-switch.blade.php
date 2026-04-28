<ul>
    @foreach (config('app.locales') as $locale)
        <li><a href="{{ route(
        Route::currentRouteName(),
        array_merge(request()->route()->parameters(),
            ['locale' => $locale])) }}">
            {{ $locale }}
        </a></li>
    @endforeach
</ul>
