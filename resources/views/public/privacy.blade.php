@push('schema')
<script type="application/ld+json">{!! json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'WebPage',
    'name'        => __('public/privacy.title'),
    'url'         => route('public.privacy', ['locale' => app()->getLocale()]),
    'description' => __('public/privacy.intro'),
    'publisher'   => [
        '@type' => 'Organization',
        'name'  => config('app.name'),
        'url'   => config('app.url'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-public.app title="{{ __('public/privacy.title') }}">

    <x-public.hero title="{{ __('public/privacy.title') }}" />

    <section aria-labelledby="privacy-heading" class="px-4 md:px-6 lg:px-8 py-16">
        <h2 id="privacy-heading" class="sr-only">{{ __('public/privacy.title') }}</h2>

        <div class="max-w-3xl flex flex-col gap-12">

            <p class="font-serif text-base leading-7 text-dark-mid">{{ __('public/privacy.intro') }}</p>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.controller_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/privacy.controller_text') }}</p>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.data_title') }}</h3>
                <div class="font-sans text-base leading-7 text-dark-mid flex flex-col gap-3">
                    <p>{{ __('public/privacy.data_intro') }}</p>
                    <ul class="list-disc pl-6 flex flex-col gap-1">
                        <li>{{ __('public/privacy.data_item_1') }}</li>
                        <li>{{ __('public/privacy.data_item_2') }}</li>
                        <li>{{ __('public/privacy.data_item_3') }}</li>
                        <li>{{ __('public/privacy.data_item_4') }}</li>
                        <li>{{ __('public/privacy.data_item_5') }}</li>
                    </ul>
                </div>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.purpose_title') }}</h3>
                <div class="font-sans text-base leading-7 text-dark-mid flex flex-col gap-3">
                    <p>{{ __('public/privacy.purpose_intro') }}</p>
                    <ul class="list-disc pl-6 flex flex-col gap-1">
                        <li>{{ __('public/privacy.purpose_item_1') }}</li>
                        <li>{{ __('public/privacy.purpose_item_2') }}</li>
                        <li>{{ __('public/privacy.purpose_item_3') }}</li>
                        <li>{{ __('public/privacy.purpose_item_4') }}</li>
                    </ul>
                    <p>{{ __('public/privacy.legal_basis') }}</p>
                </div>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.recipients_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/privacy.recipients_text') }}</p>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.retention_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/privacy.retention_text') }}</p>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.security_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/privacy.security_text') }}</p>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.rights_title') }}</h3>
                <div class="font-sans text-base leading-7 text-dark-mid flex flex-col gap-3">
                    <p>{{ __('public/privacy.rights_intro') }}</p>
                    <ul class="list-disc pl-6 flex flex-col gap-1">
                        <li>{{ __('public/privacy.rights_item_1') }}</li>
                        <li>{{ __('public/privacy.rights_item_2') }}</li>
                        <li>{{ __('public/privacy.rights_item_3') }}</li>
                        <li>{{ __('public/privacy.rights_item_4') }}</li>
                        <li>{{ __('public/privacy.rights_item_5') }}</li>
                    </ul>
                    <p>
                        {{ __('public/privacy.rights_how') }}
                        <a href="{{ route('public.contact', ['locale' => app()->getLocale()]) }}"
                           class="underline hover:text-dark transition duration-200">
                            {{ __('public/privacy.rights_how_link') }}
                        </a>.
                    </p>
                    <p>{{ __('public/privacy.rights_complaint') }}</p>
                </div>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.cookies_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/privacy.cookies_text') }}</p>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/privacy.updates_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/privacy.updates_text') }}</p>
                <p class="font-sans text-sm text-dark-mid mt-2">{{ __('public/privacy.last_updated') }} {{ now()->translatedFormat('j F Y') }}</p>
            </div>

        </div>
    </section>

</x-public.app>
