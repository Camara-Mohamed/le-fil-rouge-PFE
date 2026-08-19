<footer class="bg-dark">
    <h2 class="sr-only">Footer</h2>

    <div class="px-4 md:px-8 lg:px-8 py-6 flex items-center justify-between gap-6 flex-wrap">

        <span class="font-sans font-black text-2xl text-red-mid">{{ config('app.name') }}</span>

        <nav aria-labelledby="footer-nav-heading" class="flex flex-wrap items-center gap-4">
            <h3 id="footer-nav-heading" class="sr-only">{{ __('partials.footer.nav_label') }}</h3>
            <x-public.link
                href="{{ route('public.trainings.index', ['locale' => app()->getLocale()]) }}"
                :title="__('navigation.trainings_title')"
                class="text-base text-white hover:text-red">
                {{ __('navigation.trainings') }}
            </x-public.link>
            <x-public.link
                href="{{ route('public.camps.index', ['locale' => app()->getLocale()]) }}"
                :title="__('navigation.camps_title')"
                class="text-base text-white hover:text-red">
                {{ __('navigation.camps') }}
            </x-public.link>
            <x-public.link
                href="{{ route('public.about', ['locale' => app()->getLocale()]) }}"
                :title="__('navigation.about_title')"
                class="text-base text-white hover:text-red">
                {{ __('navigation.about') }}
            </x-public.link>
            <x-public.link
                href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}"
                :title="__('navigation.announcements_title')"
                class="text-base text-white hover:text-red">
                {{ __('navigation.announcements') }}
            </x-public.link>
            <x-public.link
                href="{{ route('public.contact', ['locale' => app()->getLocale()]) }}"
                :title="__('navigation.contact_title')"
                class="text-base text-white hover:text-red">
                {{ __('navigation.contact') }}
            </x-public.link>
        </nav>

    </div>

    <div class="px-4 md:px-8 lg:px-8 py-3 border-t border-dark-mid flex items-center justify-between gap-4 flex-wrap">

        <div class="flex items-center gap-3">
            <a href="https://mohamed-camara.com/"
               target="_blank"
               rel="noopener noreferrer"
               class="font-serif font-bold text-sm text-white underline hover:text-red transition duration-200">
                {{ __('partials.footer.made_by') }}
            </a>
            <span class="text-white/40 text-sm">|</span>
            <x-public.link
                href="{{ route('public.legal', ['locale' => app()->getLocale()]) }}"
                class="text-sm text-white/60 hover:text-white">
                {{ __('navigation.legal') }}
            </x-public.link>
        </div>

        <p class="font-sans font-medium text-sm text-white">
            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('partials.footer.rights') }}
        </p>

    </div>

</footer>
