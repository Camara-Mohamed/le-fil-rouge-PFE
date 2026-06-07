<x-public.app :title="__('errors.403_title')">

    <section aria-labelledby="error-heading" class="px-4 md:px-6 lg:px-8 py-24 md:py-32 flex flex-col items-center text-center gap-8">

        <p class="font-sans font-black text-[10rem] md:text-[14rem] leading-none text-red select-none" aria-hidden="true">
            403
        </p>

        <div class="flex flex-col gap-4 max-w-lg">
            <h2 id="error-heading" class="font-sans font-black text-3xl md:text-4xl text-dark">
                {{ __('errors.403_title') }}
            </h2>
            <p class="font-serif text-lg text-dark-mid leading-7">
                {{ __('errors.403_message') }}
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mt-4">
            <x-public.link
                href="{{ route('public.home', ['locale' => app()->getLocale()]) }}"
                class="px-8 py-3 bg-red text-white rounded-lg hover:opacity-90">
                {{ __('errors.back_home') }}
            </x-public.link>
            <x-public.link
                href="{{ route('public.contact', ['locale' => app()->getLocale()]) }}"
                class="px-8 py-3 border border-dark text-dark rounded-lg hover:bg-bg-mid">
                {{ __('errors.contact') }}
            </x-public.link>
        </div>

    </section>

</x-public.app>
