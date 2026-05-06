<ul class="flex gap-2">
    @foreach (config('app.locales') as $locale)
        <li class="hover:text-purple-500 hover:underline"><a href="{{ route(
        Route::currentRouteName(),
        array_merge(request()->route()->parameters(),
            ['locale' => $locale])) }}">
            {{ $locale }}
        </a></li>
    @endforeach
</ul>
