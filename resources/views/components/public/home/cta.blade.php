<section aria-labelledby="section-cta"
         class="px-4 md:px-6 lg:px-8 py-16 md:py-20">

    <h2 id="section-cta" class="sr-only">{{ __('public/home.cta_section') }}</h2>

    <div class="flex flex-col lg:flex-row items-stretch gap-6">

        {{-- Card Formations : image en haut --}}
        <a href="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}"
           wire:navigate
           class="group flex-1 p-4 bg-white rounded-2xl shadow-[5px_5px_20px_0px_rgba(0,0,0,0.10)]
                  border-t-8 border-success flex flex-col justify-between gap-6">

            <img src="{{ asset('images/home/formations.webp') }}"
                 srcset="{{ asset('images/home/formations-640.webp') }} 640w, {{ asset('images/home/formations-1024.webp') }} 1024w, {{ asset('images/home/formations-1440.webp') }} 1440w"
                 sizes="(max-width: 1500px) 100vw, 50vw"
                 alt="{{ __('public/home.cta_trainings_title') }}"
                 class="w-full h-80 object-cover rounded-lg"
                 loading="lazy"
            />

            <div class="flex flex-col gap-4">
                <h3 class="font-sans font-black text-3xl text-dark">
                    {{ __('public/home.cta_trainings_title') }}
                </h3>
                <div class="flex flex-col items-end gap-4">
                    <x-public.content class="text-dark self-stretch">
                        {{ __('public/home.cta_trainings_desc') }}
                    </x-public.content>
                    <span class="font-sans text-sm font-medium text-red underline group-hover:text-red-mid transition duration-200">
                        {{ __('public/home.cta_trainings_link') }}
                    </span>
                </div>
            </div>

        </a>

        {{-- Card Camps : image en bas --}}
        <a href="{{ route('public.camps.index', ['locale' => app()->getLocale()]) }}"
           wire:navigate
           class="group flex-1 p-4 bg-white rounded-2xl shadow-[5px_5px_20px_0px_rgba(0,0,0,0.10)]
                  border-t-8 border-warning flex flex-col justify-between gap-6">

            <div class="flex flex-col gap-4">
                <h3 class="font-sans font-black text-3xl text-dark">
                    {{ __('public/home.cta_camps_title') }}
                </h3>
                <div class="flex flex-col items-end gap-4">
                    <x-public.content class="text-dark self-stretch">
                        {{ __('public/home.cta_camps_desc') }}
                    </x-public.content>
                    <span class="font-sans text-sm font-medium text-red underline group-hover:text-red-mid transition duration-200">
                        {{ __('public/home.cta_camps_link') }}
                    </span>
                </div>
            </div>

            <img src="{{ asset('images/home/camps.webp') }}"
                 srcset="{{ asset('images/home/camps-640.webp') }} 640w, {{ asset('images/home/camps-1024.webp') }} 1024w, {{ asset('images/home/camps-1440.webp') }} 1440w"
                 sizes="(max-width: 1500px) 100vw, 50vw"
                 alt="{{ __('public/home.cta_camps_title') }}"
                 class="w-full h-80 object-cover rounded-lg"
                 loading="lazy"
            />

        </a>

    </div>

</section>
