<x-public.app title="{{ __('public/contact.title') }}">

@push('schema')
<script type="application/ld+json">{!! json_encode([
    '@context'  => 'https://schema.org',
    '@type'     => 'ContactPage',
    'name'      => __('public/contact.title'),
    'url'       => route('public.contact', ['locale' => app()->getLocale()]),
    'publisher' => [
        '@type' => 'Organization',
        'name'  => config('app.name'),
        'url'   => config('app.url'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

    {{-- Hero --}}
    <x-public.hero title="{{ __('public/contact.title') }}" />

    <div class="px-4 md:px-6 lg:px-8 py-16 md:py-20 grid grid-cols-1 md:grid-cols-3 gap-12">

        {{-- Coordonnées --}}
        <div class="col-span-1">
            <x-public.contact.coordonnees />
        </div>


        {{-- Formualire --}}
        <div class="col-span-1 md:col-span-2 md:max-w-lg">
            <x-public.contact.form />
        </div>

    </div>

</x-public.app>
