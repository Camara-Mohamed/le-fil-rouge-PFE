@push('schema')
<script type="application/ld+json">{!! json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'WebPage',
    'name'        => __('public/volunteer-request.title'),
    'url'         => route('public.volunteer', ['locale' => app()->getLocale()]),
    'description' => __('partials.meta.public.description'),
    'publisher'   => [
        '@type' => 'Organization',
        'name'  => config('app.name'),
        'url'   => config('app.url'),
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-public.app title="{{ __('public/volunteer-request.title') }}">

    {{-- Hero --}}
    <x-public.hero title="{{ __('public/volunteer-request.title') }}" />

    <div class="px-4 md:px-6 lg:px-8 py-16 md:py-20 grid grid-cols-1 md:grid-cols-3 gap-12">

        {{-- Informations --}}
        <div class="col-span-1">
            <x-public.volunteer.info />
        </div>

        {{-- Formualire --}}
        <div class="col-span-1 md:col-span-2 md:max-w-lg">
            <x-public.volunteer.form />
        </div>

    </div>

</x-public.app>
