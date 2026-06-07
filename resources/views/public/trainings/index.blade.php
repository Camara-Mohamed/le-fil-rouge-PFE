<x-public.app title="{{ __('public/trainings.title') }}">

@push('schema')
<script type="application/ld+json">{!! json_encode([
    '@context'  => 'https://schema.org',
    '@type'     => 'CollectionPage',
    'name'      => __('public/trainings.title'),
    'url'       => route('public.trainings.index', ['locale' => app()->getLocale()]),
    'publisher' => [
        '@type' => 'Organization',
        'name'  => config('app.name'),
        'url'   => config('app.url'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

    {{-- Hero --}}
    <x-public.hero title="{{ __('public/trainings.title') }}" />

    <div class="px-4 md:px-6 lg:px-8 py-12">
        <livewire:public.trainings-index />
    </div>

    {{-- Les avantages --}}
    <x-public.trainings.benefits />

    {{-- Galerie --}}
    <x-public.gallery
        :images="['fun', 'fun_1', 'fun_2', 'fun_3', 'fun_4', 'fun_5']"
        base="images/trainings"
        title="{{ __('public/trainings.gallery_title') }}"
        alt="{{ __('public/trainings.hero_alt') }}"
        group="gallery-trainings"
    />

</x-public.app>
