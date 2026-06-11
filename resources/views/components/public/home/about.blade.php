<section aria-labelledby="section-about"
         class="px-4 md:px-6 lg:px-8 py-16 md:py-20">

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- Image --}}
        <div class="w-full lg:w-1/2 shrink-0 self-stretch relative min-h-64">
            <img src="{{ asset('images/home/about.webp') }}"
                 srcset="{{ asset('images/home/about-640.webp') }} 640w, {{ asset('images/home/about-1024.webp') }} 1024w, {{ asset('images/home/about-1440.webp') }} 1440w"
                 sizes="(max-width: 1024px) 100vw, 50vw"
                 alt="{{ __('public/home.about_img_alt') }}"
                 class="absolute inset-0 w-full h-full object-cover rounded-lg"
                 loading="lazy"
            />
        </div>

        {{-- Texte --}}
        <div class="w-full lg:w-1/2 flex flex-col items-start lg:items-end justify-between gap-4">

            <div class="self-stretch flex flex-col gap-4">

                <span class="border-b border-red font-sans font-medium text-base text-dark pb-0.5 self-start">
                    {{ __('public/home.about_label') }}
                </span>

                <div class="flex flex-col gap-4">
                    <h2 id="section-about"
                        class="font-sans font-black text-3xl text-dark">
                        {{ __('public/home.about_title') }}
                    </h2>
                    <x-public.content class="text-dark">
                        {{ __('public/home.about_content_1') }}
                    </x-public.content>
                    <x-public.content class="text-dark">
                        {{ __('public/home.about_content_2') }}
                    </x-public.content>
                </div>

            </div>

            <x-public.link
                href="{{ route('public.about', ['locale' => app()->getLocale()]) }}"
                class="text-red text-sm font-medium underline hover:text-red-mid">
                {{ __('public/home.about_cta') }}
            </x-public.link>

        </div>

    </div>

</section>
