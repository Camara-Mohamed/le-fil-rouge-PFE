<section aria-labelledby="section-volunteer"
         class="px-4 md:px-6 lg:px-8 py-16 md:py-20">

    <div class="flex flex-col md:flex-row items-stretch gap-4">

        {{-- Stats --}}
        @foreach([
            ['value' => __('public/home.stat_1_value'), 'label' => __('public/home.stat_1_label')],
            ['value' => __('public/home.stat_2_value'), 'label' => __('public/home.stat_2_label')],
            ['value' => __('public/home.stat_3_value'), 'label' => __('public/home.stat_3_label')],
        ] as $stat)
            <div class="p-3 bg-bg rounded-lg shadow-[0px_5px_30px_0px_rgba(0,0,0,0.10)]
                        flex flex-col items-center justify-center gap-1 min-w-[120px]">
                <p class="font-sans font-black text-3xl text-red">
                    {{ $stat['value'] }}
                </p>
                <p class="font-serif font-semibold text-sm text-dark text-center leading-snug">
                    {{ $stat['label'] }}
                </p>
            </div>
        @endforeach

        {{-- CTA --}}
        <div class="flex-1 flex flex-col items-start justify-center gap-6 md:pl-4">

            <div class="flex flex-col gap-3">
                <h2 id="section-volunteer"
                    class="font-sans font-black text-3xl text-dark">
                    {{ __('public/home.volunteer_title') }}
                </h2>
                <x-public.content class="text-dark">
                    {{ __('public/home.volunteer_desc') }}
                </x-public.content>
            </div>

            <x-public.link
                href="{{ route('public.volunteer', ['locale' => app()->getLocale()]) }}"
                class="px-8 py-4 rounded-lg bg-red text-white
                       hover:bg-red-mid capitalize">
                {{ __('public/home.volunteer_cta') }}
            </x-public.link>

        </div>

    </div>

</section>
