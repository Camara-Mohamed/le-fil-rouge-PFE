<section aria-labelledby="section-volunteer-info">
    <h2 id="section-volunteer-info" class="font-sans font-black text-3xl text-dark mb-8">
        {{ __('public/volunteer-request.info_title') }}
    </h2>

    <div class="flex flex-col gap-3">
        @foreach([
            ['q' => __('public/volunteer-request.info_1_q'), 'a' => __('public/volunteer-request.info_1_a')],
            ['q' => __('public/volunteer-request.info_2_q'), 'a' => __('public/volunteer-request.info_2_a')],
            ['q' => __('public/volunteer-request.info_3_q'), 'a' => __('public/volunteer-request.info_3_a')],
            ['q' => __('public/volunteer-request.info_4_q'), 'a' => __('public/volunteer-request.info_4_a')],
        ] as $item)
            <x-public.accordion
                :summary="$item['q']"
                class="px-6 py-4 bg-bg-mid rounded-tr-lg rounded-br-lg border-l-[6px] border-red">
                <p class="font-serif text-sm text-dark leading-5">{{ $item['a'] }}</p>
            </x-public.accordion>
        @endforeach
    </div>
</section>
