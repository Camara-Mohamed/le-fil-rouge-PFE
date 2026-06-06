<section aria-labelledby="section-camps-feature" class="px-4 md:px-6 lg:px-8 py-16 md:py-20">
    <div class="flex flex-col lg:flex-row gap-10 lg:gap-16">

        <div class="flex flex-col gap-8 lg:w-1/2">
            @foreach([
                ['label' => __('public/camps.feature_1_label'), 'title' => __('public/camps.feature_1_title'), 'desc' => __('public/camps.feature_1_desc')],
                ['label' => __('public/camps.feature_2_label'), 'title' => __('public/camps.feature_2_title'), 'desc' => __('public/camps.feature_2_desc')],
                ['label' => __('public/camps.feature_3_label'), 'title' => __('public/camps.feature_3_title'), 'desc' => __('public/camps.feature_3_desc')],
            ] as $item)
                <div class="flex flex-col gap-3">
                    <span class="font-sans font-black text-xl text-red">{{ $item['label'] }}</span>
                    <div class="p-4 bg-bg rounded-lg shadow-[0px_5px_30px_0px_rgba(0,0,0,0.10)] border border-bg-dark flex flex-col gap-2">
                        <p class="font-sans font-black text-base text-dark">{{ $item['title'] }}</p>
                        <p class="font-serif text-sm text-dark leading-5">{{ $item['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col gap-6 lg:w-1/2">
            <h2 id="section-camps-feature" class="font-sans font-black text-4xl text-dark capitalize">
                {{ __('public/camps.feature_section_title') }}
            </h2>
            <div class="relative flex-1 min-h-64 rounded-lg overflow-hidden">
                <x-public.image
                    src="{{ asset('images/camps/holiday_1.webp') }}"
                    srcset="{{ asset('images/camps/holiday_1-640.webp') }} 640w,
                            {{ asset('images/camps/holiday_1-1024.webp') }} 1024w,
                            {{ asset('images/camps/holiday_1-1440.webp') }} 1440w"
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    alt="{{ __('public/camps.hero_alt') }}"
                    class="w-full h-full object-cover"
                    loading="lazy"
                />
            </div>
        </div>

    </div>
</section>
