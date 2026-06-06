<section aria-labelledby="section-faq" class="px-4 md:px-6 lg:px-8 py-16 md:py-20">

    <h2 id="section-faq" class="font-sans font-black text-4xl text-dark mb-8">
        {{ __('public/about.faq_title') }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach([
            ['q' => __('public/about.faq_1_q'), 'a' => __('public/about.faq_1_a')],
            ['q' => __('public/about.faq_2_q'), 'a' => __('public/about.faq_2_a')],
            ['q' => __('public/about.faq_3_q'), 'a' => __('public/about.faq_3_a')],
            ['q' => __('public/about.faq_4_q'), 'a' => __('public/about.faq_4_a')],
            ['q' => __('public/about.faq_5_q'), 'a' => __('public/about.faq_5_a')],
            ['q' => __('public/about.faq_6_q'), 'a' => __('public/about.faq_6_a')],
        ] as $item)
            <x-public.accordion
                :summary="$item['q']"
                class="px-6 py-4 bg-bg-mid rounded-lg border-l-[6px] border-red">
                <p class="font-serif text-sm text-dark leading-5">{{ $item['a'] }}</p>
            </x-public.accordion>
        @endforeach
    </div>

</section>
