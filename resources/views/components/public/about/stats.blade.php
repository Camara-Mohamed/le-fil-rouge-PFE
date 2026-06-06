@props(['stats' => []])

<section aria-labelledby="section-stats" class="px-4 md:px-6 lg:px-8 py-16 md:py-20">
    <div class="flex flex-col gap-8">

        <h2 id="section-stats" class="font-sans font-black text-5xl text-dark capitalize">
            {{ __('public/about.stats_title') }}
        </h2>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($stats as $stat)
                <div class="p-4 bg-bg rounded-lg shadow-[0px_5px_30px_0px_rgba(0,0,0,0.10)] border border-bg-dark flex flex-col items-center gap-4">
                    <span class="font-sans font-black text-4xl text-red">{{ $stat['value'] }}</span>
                    <p class="font-serif text-sm font-semibold text-dark text-center">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>

    </div>
</section>
