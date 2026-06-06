<section aria-labelledby="section-valeurs" class="px-4 md:px-6 lg:px-8 py-16 md:py-20">
    <h2 id="section-valeurs" class="sr-only">{{ __('public/about.valeurs_title') }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach([
            ['number' => '01', 'title' => __('public/about.valeurs_1_title'), 'desc' => __('public/about.valeurs_1_desc')],
            ['number' => '02', 'title' => __('public/about.valeurs_2_title'), 'desc' => __('public/about.valeurs_2_desc')],
            ['number' => '03', 'title' => __('public/about.valeurs_3_title'), 'desc' => __('public/about.valeurs_3_desc')],
            ['number' => '04', 'title' => __('public/about.valeurs_4_title'), 'desc' => __('public/about.valeurs_4_desc')],
            ['number' => '05', 'title' => __('public/about.valeurs_5_title'), 'desc' => __('public/about.valeurs_5_desc')],
        ] as $item)
            <div class="flex items-start gap-6">
                <div class="size-20 bg-red rounded-full flex items-center justify-center shrink-0">
                    <span class="font-sans font-black text-3xl text-white leading-none">{{ $item['number'] }}</span>
                </div>
                <div class="flex flex-col gap-2 pt-2">
                    <h3 class="font-sans font-black text-2xl text-dark">{{ $item['title'] }}</h3>
                    <p class="font-serif text-base text-dark leading-5">{{ $item['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
