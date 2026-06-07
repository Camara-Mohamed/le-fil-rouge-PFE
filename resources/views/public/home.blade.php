<x-public.app title="{{ __('public/home.title') }}">

@push('schema')
<script type="application/ld+json">{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type' => 'Organization',
            '@id'   => config('app.url') . '#organization',
            'name'  => config('app.name'),
            'url'   => config('app.url'),
            'logo'  => asset('favicon.svg'),
        ],
        [
            '@type'     => 'WebSite',
            '@id'       => config('app.url') . '#website',
            'name'      => config('app.name'),
            'url'       => config('app.url'),
            'publisher' => ['@id' => config('app.url') . '#organization'],
        ],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

    {{-- Hero --}}
    <x-public.home.hero />

    {{-- Liste des actualités récentes --}}
    <x-public.home.announcements :announcements="$announcements" />

    {{-- À propos --}}
    <x-public.home.about />

    {{-- CTA (Formations et Camps) --}}
    <x-public.home.cta />

    {{-- Statistiques + CTA (Devenir Volontaire) --}}
    <x-public.home.volunteer />

</x-public.app>
