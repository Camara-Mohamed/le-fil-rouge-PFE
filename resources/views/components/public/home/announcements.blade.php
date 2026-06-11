@props(['announcements'])

<section aria-labelledby="section-announcements"
         class="px-4 md:px-6 lg:px-8 py-16 md:py-20">

    <div class="flex flex-col gap-6">

        {{-- Titre --}}
        <h2 id="section-announcements"
            class="font-sans font-black text-4xl md:text-5xl text-dark capitalize">
            {{ __('public/home.announcements_title') }}
        </h2>

        <div class="flex flex-col items-end gap-6">

            <x-public.link
                href="{{ route('public.announcements.index', ['locale' => app()->getLocale()]) }}"
                class="text-red text-sm font-medium underline uppercase hover:text-red-mid">
                {{ __('public/home.announcements_see_all') }}
            </x-public.link>

            {{-- Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 self-stretch ">
                @foreach($announcements as $announcement)
                    <a wire:key="announcement-{{ $announcement->id }}" href="{{ route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement->id]) }}"
                       wire:navigate
                       class="h-[420px] bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col">

                        {{-- Image --}}
                        @if($announcement->banner)
                            @php
                                $variantName  = pathinfo(basename($announcement->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
                                $variantsBase = config('banners.paths.announcements.variants');
                                $srcset       = collect(config('banners.sizes.banner'))
                                    ->map(fn($w) => Storage::url("{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                                    ->implode(', ');
                            @endphp
                            <img src="{{ Storage::url("{$variantsBase}/640/{$variantName}") }}"
                                 srcset="{{ $srcset }}"
                                 sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
                                 alt="{{ $announcement->title }}"
                                 class="w-full h-52 object-cover rounded-tl-2xl rounded-tr-2xl"
                                 loading="lazy"
                            />
                        @else
                            <div class="w-full h-52 bg-dark-light rounded-tl-2xl rounded-tr-2xl"></div>
                        @endif

                        {{-- Contenu --}}
                        <div class="p-4 flex flex-col justify-between flex-1">
                            <div class="flex flex-col gap-2">
                                <h3 class="font-sans font-black text-xl text-dark">
                                    {{ $announcement->title }}
                                </h3>
                                <x-public.content class="text-sm text-dark">
                                    {{ $announcement->description }}
                                </x-public.content>
                            </div>
                            <p class="font-sans text-x uppercase text-dark">
                                {{ __('public/home.announcements_published', [
                                    'date' => $announcement->published_at
                                        ?->locale(app()->getLocale())
                                        ->isoFormat('D MMMM YYYY')
                                ]) }}
                            </p>
                        </div>

                    </a>
                @endforeach
            </div>

        </div>
    </div>

</section>
