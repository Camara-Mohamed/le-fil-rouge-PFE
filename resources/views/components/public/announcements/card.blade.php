@props(['announcement', 'large' => false])

<a href="{{ route('public.announcements.show', ['locale' => app()->getLocale(), 'announcement' => $announcement->id]) }}"
   wire:navigate
   title="{{ __('public/announcements.card_title', ['title' => $announcement->title]) }}"
   class="group flex flex-col bg-bg rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] overflow-hidden h-full">

    {{-- Banner --}}
    <div @class([
        'relative shrink-0 bg-dark-light',
        'h-72' => $large,
        'h-48' => !$large,
    ])>
        @if($announcement->banner)
            @php
                $variantName  = pathinfo(basename($announcement->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
                $variantsBase = config('banners.paths.announcements.variants');
                $srcset       = collect(config('banners.sizes.banner'))
                    ->map(fn($w) => Storage::url("{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                    ->implode(', ');
            @endphp
            <img src="{{ Storage::url($announcement->banner) }}"
                 srcset="{{ $srcset }}"
                 sizes="{{ $large ? '66vw' : '33vw' }}"
                 alt="{{ $announcement->title }}"
                 class="absolute inset-0 w-full h-full object-cover"
                 loading="{{ $large ? 'eager' : 'lazy' }}"
            />
        @endif
        <div class="absolute inset-0 bg-dark/40 rounded-t-2xl"></div>

        @if($announcement->user)
            <div class="absolute bottom-4 right-4 px-4 py-1.5 bg-bg rounded-2xl border border-bg-dark">
                <p class="font-sans text-sm text-dark leading-6">
                    {{ __('public/announcements.by') }}
                    <span class="font-bold">{{ $announcement->user->fullName() }}</span>
                </p>
            </div>
        @endif
    </div>

    {{-- Contenu --}}
    <div class="flex flex-col justify-between gap-4 p-6 flex-1">
        <div class="flex flex-col gap-3">
            <h3 @class([
                'font-sans font-black text-dark',
                'text-2xl' => $large,
                'text-lg'  => !$large,
            ])>
                {{ $announcement->title }}
            </h3>
            @if($large && $announcement->description)
                <x-public.content class="text-base text-dark">
                    {{ $announcement->description }}
                </x-public.content>
            @endif
        </div>

        <div class="flex justify-between items-center">
            @if($announcement->published_at)
                <p class="font-sans text-sm uppercase text-dark-mid">
                    {{ __('public/announcements.published_on', [
                        'date' => $announcement->published_at->locale(app()->getLocale())->isoFormat('D MMMM YYYY')
                    ]) }}
                </p>
            @else
                <span></span>
            @endif
            <span class="font-sans text-sm font-medium text-red underline group-hover:text-red-mid transition duration-200">
                {{ __('public/announcements.read_more') }}
            </span>
        </div>
    </div>

</a>
