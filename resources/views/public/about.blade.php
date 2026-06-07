<x-public.app title="{{ __('public/about.title') }}">

@push('schema')
<script type="application/ld+json">{!! json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'AboutPage',
    'name'        => __('public/about.title'),
    'url'         => route('public.about', ['locale' => app()->getLocale()]),
    'description' => __('partials.meta.public.description'),
    'mainEntity'  => [
        '@type' => 'Organization',
        'name'  => config('app.name'),
        'url'   => config('app.url'),
        'logo'  => asset('favicon.svg'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

    {{-- Hero --}}
    <x-public.hero title="{{ __('public/about.title') }}" />

    {{-- Histoire + CTA(Volontaire) --}}
    <x-public.about.histoire />

    {{-- Valeurs --}}
    <x-public.about.valeurs />

    {{-- Statistiques --}}
    <x-public.about.stats :stats="$stats" />

    {{-- FAQ --}}
    <x-public.about.faq />

</x-public.app>
