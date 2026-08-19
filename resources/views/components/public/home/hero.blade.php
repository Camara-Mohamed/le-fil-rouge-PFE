<section aria-labelledby="section-hero"
         class="relative overflow-hidden min-h-[500px] lg:min-h-[742px] flex items-center
                px-4 md:px-6 lg:px-8 py-20 lg:py-44">

    {{-- Image --}}
    <img src="{{ asset('images/home/hero-1440.webp') }}"
         srcset="{{ asset('images/home/hero-640.webp') }} 640w, {{ asset('images/home/hero-1024.webp') }} 1024w, {{ asset('images/home/hero-1440.webp') }} 1440w"
         sizes="100vw"
         alt="{{ __('public/home.hero_img_alt') }}"
         width="1440"
         height="742"
         loading="eager"
         fetchpriority="high"
         class="absolute inset-0 w-full h-full object-cover"
    />

    {{-- Dégradé --}}
    <div class="absolute inset-0 bg-linear-to-r from-dark to-gray-900/10"></div>

    {{-- Contenu --}}
    <div class="relative w-full max-w-[545px] flex flex-col gap-4">

        <h2 id="section-hero"
            class="font-sans font-black text-4xl md:text-5xl text-white capitalize leading-tight">
            {{ __('public/home.hero_title') }}
        </h2>

        <div class="flex flex-col gap-12">

            <x-public.content class="text-white leading-6">
                {{ __('public/home.hero_content') }}
            </x-public.content>

            <div class="flex flex-wrap gap-4">
                <x-public.link
                    href="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}"
                    title="{{ __('public/home.hero_cta_trainings') }}"
                    class="px-8 py-4 rounded-lg bg-red text-white hover:bg-red-mid">
                    {{ __('public/home.hero_cta_trainings') }}
                </x-public.link>

                <x-public.link
                    href="{{ route('public.volunteer', ['locale' => app()->getLocale()]) }}"
                    title="{{ __('public/home.hero_cta_volunteer') }}"
                    class="px-8 py-4 rounded-lg bg-white text-red hover:bg-red-light">
                    {{ __('public/home.hero_cta_volunteer') }}
                </x-public.link>
            </div>

        </div>
    </div>

</section>
