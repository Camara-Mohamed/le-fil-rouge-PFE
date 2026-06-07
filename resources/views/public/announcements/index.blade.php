<x-public.app title="{{ __('public/announcements.title') }}">

@push('schema')
<script type="application/ld+json">{!! json_encode([
    '@context'  => 'https://schema.org',
    '@type'     => 'CollectionPage',
    'name'      => __('public/announcements.title'),
    'url'       => route('public.announcements.index', ['locale' => app()->getLocale()]),
    'publisher' => [
        '@type' => 'Organization',
        'name'  => config('app.name'),
        'url'   => config('app.url'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

    {{-- Hero --}}
    <x-public.hero title="{{ __('public/announcements.title') }}" />

    <div class="px-4 md:px-6 lg:px-8 py-12">
        <livewire:public.announcements-index />
    </div>

</x-public.app>
