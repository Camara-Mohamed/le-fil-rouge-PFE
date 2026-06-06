<x-public.app title="{{ $announcement->title }}">

    {{-- Bannière --}}
    @if($announcement->banner)
        @php
            $variantName  = pathinfo(basename($announcement->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
            $variantsBase = config('banners.paths.announcements.variants');
            $srcset       = collect(config('banners.sizes.banner'))
                ->map(fn($w) => asset("storage/{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                ->implode(', ');
        @endphp
        <div class="px-4 md:px-6 lg:px-8 pb-10">
            <div class="relative">
                <img src="{{ asset('storage/' . $announcement->banner) }}"
                     srcset="{{ $srcset }}"
                     sizes="100vw"
                     alt="{{ $announcement->title }}"
                     class="w-full h-64 md:h-[480px] object-cover rounded-2xl"
                     loading="eager" />
                <div class="absolute inset-0 bg-dark/30 rounded-2xl"></div>
                @if($announcement->user)
                    <div class="absolute bottom-6 right-6 px-4 py-1.5 bg-bg rounded-2xl border border-bg-dark">
                        <p class="font-sans text-sm text-dark leading-6">
                            Par <span class="font-bold">{{ $announcement->user->fullName() }}</span>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @endif

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
                    Modifier
                </a>
                <button
                    x-data
                    @click="Livewire.dispatch('open_modal', { payload: { form: 'modals::announcements.confirm-delete', model_id: '{{ $announcement->id }}', model_type: 'announcement' } })"
                    class="font-sans font-bold text-sm text-danger underline hover:text-red transition duration-200">
                    Supprimer
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

            {{-- Descriptio --}}
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
            <h2 id="galerie-heading" class="font-sans font-black text-3xl text-dark mb-6">Galerie</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($announcement->galeries as $galerie)
                    <a href="{{ asset('storage/' . $galerie->path) }}" data-fancybox="galerie-announcement">
                        <img src="{{ asset('storage/' . $galerie->path) }}"
                             alt="{{ $announcement->title }}"
                             class="w-full h-48 object-cover rounded-2xl" />
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Commentaires --}}
    @auth
        <section class="px-4 md:px-6 lg:px-8 pb-16">
            <livewire:comments :model="$announcement" />
        </section>
    @endauth

    <livewire:widgets::modal />

</x-public.app>
