@props(['camp'])

@php
    $isFull = $camp->participants && $camp->acceptedRegisters->count() >= $camp->participants;
    $statusVariant = match($camp->status->value) {
        'published' => 'success',
        'confirmed' => 'info',
        'refused'   => 'danger',
        default     => 'warning',
    };
@endphp

<a href="{{ route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $camp->id]) }}"
   wire:navigate
   title="{{ __('public/camps.card_title', ['title' => $camp->title]) }}"
   class="group flex flex-col bg-bg rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] border-b-4 border-success overflow-hidden h-[516px]">

    <div class="relative h-60 shrink-0 bg-dark-light">
        @if($camp->banner)
            @php
                $variantName  = pathinfo(basename($camp->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
                $variantsBase = config('banners.paths.camps.variants');
                $srcset       = collect(config('banners.sizes.banner'))
                    ->map(fn($w) => Storage::url("{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                    ->implode(', ');
            @endphp
            <img src="{{ Storage::url($camp->banner) }}"
                 srcset="{{ $srcset }}"
                 sizes="(max-width: 768px) 100vw, 33vw"
                 alt="{{ $camp->title }}"
                 class="absolute inset-0 w-full h-full object-cover"
                 loading="lazy"
            />
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-dark-light to-dark-mid opacity-60"></div>
        @endif
        <div class="absolute inset-0 bg-gray-900/40 flex flex-col justify-end items-end p-3 gap-1.5">
            @if($camp->type)
                <span class="px-3 py-0.5 bg-danger-bg text-danger rounded-2xl font-sans text-sm font-medium leading-6 capitalize">
                    {{ $camp->type->label() }}
                </span>
            @endif
            @auth
                <x-public.badge :variant="$statusVariant">{{ $camp->status->label() }}</x-public.badge>
            @endauth
        </div>
    </div>

    <div class="flex-1 flex flex-col justify-between gap-2 pb-4">

        <div class="h-full px-6 flex flex-col gap-6 pt-4 justify-between">
            <div class="flex flex-col gap-2">
                <h3 class="font-sans font-black text-base text-dark">
                    {{ $camp->title }}
                </h3>
                <x-public.content class="text-sm text-dark">
                    {{ $camp->description }}
                </x-public.content>
            </div>
            <p class="font-sans text-xs font-medium uppercase text-dark">
                {{ __('general.date_from', [
                    'start' => $camp->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY'),
                    'end'   => $camp->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY'),
                ]) }}
            </p>
        </div>

        <div class="px-6">
            <div class="pt-3 pb-1 border-t border-bg-dark flex justify-between items-center">
                @if($camp->user)
                    <p class="font-sans text-sm text-dark">
                        {{ __('general.by') }}
                        <span class="font-bold">{{ $camp->user->fullName() }}</span>
                    </p>
                @else
                    <span></span>
                @endif
                @if($camp->participants)
                    <span @class([
                        'px-4 py-0.5 rounded-2xl font-sans text-sm font-bold leading-6',
                        'text-danger' => $isFull,
                        'text-success' => !$isFull,
                    ])>
                        {{ $isFull
                            ? __('general.full')
                            : __('general.participants', ['current' => $camp->acceptedRegisters->count(), 'max' => $camp->participants]) }}
                    </span>
                @endif
            </div>
        </div>

    </div>

</a>
