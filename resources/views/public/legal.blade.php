@push('schema')
<script type="application/ld+json">{!! json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'WebPage',
    'name'        => __('public/legal.title'),
    'url'         => route('public.legal', ['locale' => app()->getLocale()]),
    'description' => __('public/legal.cookies_text'),
    'publisher'   => [
        '@type' => 'Organization',
        'name'  => config('app.name'),
        'url'   => config('app.url'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-public.app title="{{ __('public/legal.title') }}">

    <x-public.hero title="{{ __('public/legal.title') }}" />

    <div class="px-4 md:px-6 lg:px-8 pt-8 pb-4">
        <livewire:widgets::breadcrumb :items="[
            ['label' => __('breadcrumbs.home'), 'url' => route('public.home', ['locale' => app()->getLocale()])],
            ['label' => __('public/legal.title')],
        ]" />
    </div>

    <section aria-labelledby="legal-heading" class="px-4 md:px-6 lg:px-8 py-16">
        <h2 id="legal-heading" class="sr-only">{{ __('public/legal.title') }}</h2>

        <div class="max-w-3xl flex flex-col gap-12">

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/legal.editor_title') }}</h3>
                <div class="font-sans text-base leading-7 text-dark-mid flex flex-col gap-1">
                    <p><strong>{{ __('public/legal.org_name') }}</strong> {{ config('app.name') }}</p>
                    <p>
                        <strong>{{ __('public/legal.contact') }}</strong>
                        <a href="{{ route('public.contact', ['locale' => app()->getLocale()]) }}"
                           class="underline hover:text-dark transition duration-200">
                            {{ __('public/legal.contact_link') }}
                        </a>
                    </p>
                </div>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/legal.hosting_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/legal.hosting_text') }}</p>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/legal.data_title') }}</h3>
                <div class="font-sans text-base leading-7 text-dark-mid flex flex-col gap-3">
                    <p>{{ __('public/legal.data_intro') }}</p>
                    <ul class="list-disc pl-6 flex flex-col gap-1">
                        <li>{{ __('public/legal.data_item_1') }}</li>
                        <li>{{ __('public/legal.data_item_2') }}</li>
                        <li>{{ __('public/legal.data_item_3') }}</li>
                    </ul>
                    <p>{{ __('public/legal.data_rights') }}</p>
                </div>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/legal.cookies_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/legal.cookies_text') }}</p>
            </div>

            <div>
                <h3 class="font-sans font-black text-2xl text-dark mb-4">{{ __('public/legal.ip_title') }}</h3>
                <p class="font-sans text-base leading-7 text-dark-mid">{{ __('public/legal.ip_text') }}</p>
            </div>

        </div>
    </section>

</x-public.app>
