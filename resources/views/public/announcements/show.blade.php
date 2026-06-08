@php
    $articleSchema = [
        '@context'  => 'https://schema.org',
        '@type'     => 'NewsArticle',
        'headline'  => $announcement->title,
        'url'       => route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement]),
        'publisher' => [
            '@type' => 'Organization',
            'name'  => config('app.name'),
            'url'   => config('app.url'),
        ],
    ];
    if ($announcement->description) {
        $articleSchema['description'] = $announcement->description;
    }
    if ($announcement->published_at) {
        $articleSchema['datePublished'] = $announcement->published_at->toIso8601String();
    }
    if ($announcement->banner) {
        $articleSchema['image'] = Storage::url($announcement->banner);
    }
    if ($announcement->user) {
        $articleSchema['author'] = ['@type' => 'Person', 'name' => $announcement->user->fullName()];
    }
@endphp
@push('schema')
<script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

<x-public.app title="{{ $announcement->title }}">

    @php
        $srcset = null;
        if ($announcement->banner) {
            $variantName  = pathinfo(basename($announcement->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
            $variantsBase = config('banners.paths.announcements.variants');
            $srcset       = collect(config('banners.sizes.banner'))
                ->map(fn($w) => Storage::url("{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                ->implode(', ');
        }
    @endphp

    {{-- Hero --}}
    <x-public.hero
        title="{{ $announcement->title }}"
        :banner="$announcement->banner ? Storage::url($announcement->banner) : null"
        :srcset="$srcset"
    />

    <div class="px-4 md:px-6 lg:px-8 pt-8 pb-4 flex items-center justify-between gap-6 flex-wrap">
        <livewire:widgets::breadcrumb :items="[
            ['label' => __('breadcrumbs.home'), 'url' => route('public.home', ['locale' => app()->getLocale()])],
            ['label' => __('breadcrumbs.announcements'), 'url' => route('public.announcements.index', ['locale' => app()->getLocale()])],
            ['label' => $announcement->title],
        ]" />

        @can('update', $announcement)
            <div class="flex items-center gap-6 shrink-0">
                <a href="{{ route('admin.announcements.edit', ['locale' => app()->getLocale(), 'announcement' => $announcement]) }}"
                   wire:navigate
                   class="font-sans font-bold text-sm text-dark underline hover:text-red transition duration-200">
                    {{ __('general.edit') }}
                </a>
                <button
                    x-data
                    @click="Livewire.dispatch('open_modal', { payload: { form: 'modals::announcements.confirm-delete', model_id: '{{ $announcement->id }}', model_type: 'announcement' } })"
                    class="font-sans font-bold text-sm text-danger underline hover:text-red transition duration-200">
                    {{ __('general.delete') }}
                </button>
            </div>
        @endcan
    </div>

    {{-- Contenu article --}}
    <section aria-labelledby="announcement-heading" class="px-4 md:px-6 lg:px-8 pb-16">

        <div class="max-w-3xl">

            <div class="flex items-center gap-4 mb-6">
                @if($announcement->published_at)
                    <span class="font-sans text-sm uppercase text-dark-mid">
                        {{ $announcement->published_at->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}
                    </span>
                @endif
            </div>

            {{-- Titre --}}
            <h2 id="announcement-heading" class="font-sans font-black text-3xl md:text-4xl text-dark mb-8 leading-tight">
                {{ $announcement->title }}
            </h2>

            {{-- Description --}}
            @if($announcement->description)
                <x-public.content class="text-lg text-dark-mid mb-8 leading-7">
                    {{ $announcement->description }}
                </x-public.content>
            @endif

            {{-- Content --}}
            @if($announcement->content)
                <div class="font-serif text-base leading-7 text-dark prose-sm max-w-none">
                    {!! $announcement->content !!}
                </div>
            @elseif($announcement->details)
                <x-public.content class="text-base leading-7">{{ $announcement->details }}</x-public.content>
            @endif

        </div>

    </section>

    {{-- Galerie --}}
    @if($announcement->galeries->count())
        <section aria-labelledby="galerie-heading" class="px-4 md:px-6 lg:px-8 pb-16">
            <h2 id="galerie-heading" class="font-sans font-black text-3xl text-dark mb-6">{{ __('public/announcements.gallery_title') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($announcement->galeries as $galerie)
                    <a href="{{ Storage::url($galerie->path) }}" data-fancybox="galerie-announcement">
                        <img src="{{ Storage::url($galerie->path) }}"
                             alt="Photo {{ $loop->iteration }} — {{ $announcement->title }}"
                             class="w-full h-48 object-cover rounded-2xl" />
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Commentaires --}}
    @auth
        <section aria-labelledby="section-commentaires" class="px-4 md:px-6 lg:px-8 pb-16">
            <livewire:comments :model="$announcement" />
        </section>
    @endauth

    <livewire:widgets::modal />

</x-public.app>
