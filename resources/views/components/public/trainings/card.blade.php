@props(['training'])

@php
    $isFull        = $training->participants && $training->acceptedRegisters->count() >= $training->participants;
    $statusVariant = match($training->status->value) {
        'published' => 'success',
        'confirmed' => 'info',
        'refused'   => 'danger',
        default     => 'warning',
    };
@endphp

<a href="{{ route('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $training->id]) }}"
   wire:navigate
   title="{{ __('public/trainings.card_title', ['title' => $training->title]) }}"
   class="group flex flex-col bg-bg rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] hover:shadow-[0px_16px_40px_0px_rgba(0,0,0,0.18)] border-b-4 border-success overflow-hidden h-[516px] transition-[transform,box-shadow] duration-300 ease-out hover:-translate-y-2 hover:scale-[1.02]">

    <div class="relative h-60 shrink-0 bg-dark-light">
        @if($training->banner)
            @php
                $variantName  = pathinfo(basename($training->banner), PATHINFO_FILENAME) . '.' . config('banners.image_type');
                $variantsBase = config('banners.paths.trainings.variants');
                $srcset       = collect(config('banners.sizes.banner'))
                    ->map(fn($w) => Storage::url("{$variantsBase}/{$w}/{$variantName}") . " {$w}w")
                    ->implode(', ');
            @endphp
            <img src="{{ Storage::url($training->banner) }}"
                 srcset="{{ $srcset }}"
                 sizes="(max-width: 768px) 100vw, 33vw"
                 alt="{{ $training->title }}"
                 class="absolute inset-0 w-full h-full object-cover"
                 loading="eager"
            />
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-dark-light to-dark-mid opacity-60"></div>
        @endif
        <div class="absolute inset-0 bg-gray-900/40 flex flex-col justify-end items-end p-3 gap-1.5">
            @if($training->type)
                <span class="px-3 py-0.5 bg-danger-bg text-danger rounded-2xl font-sans text-sm font-medium leading-6 capitalize">
                    {{ $training->type->label() }}
                </span>
            @endif
            @auth
                <x-public.badge :variant="$statusVariant">{{ $training->status->label() }}</x-public.badge>
            @endauth
        </div>
    </div>

    {{-- Contenu --}}
    <div class="flex-1 flex flex-col justify-between gap-2 pb-4">

        <div class="h-full px-6 flex flex-col gap-6 pt-4 justify-between">
            <div class="flex flex-col gap-2">
                <h3 class="font-sans font-black text-base text-dark">
                    {{ $training->title }}
                </h3>
                <x-public.content class="text-sm text-dark line-clamp-4">
                    {{ $training->description }}
                </x-public.content>
            </div>
            <p class="font-sans text-xs font-medium uppercase text-dark">
                {{ __('general.date_from', [
                    'start' => $training->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY'),
                    'end'   => $training->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY'),
                ]) }}
            </p>
        </div>

        <div class="px-6">
            <div class="pt-3 pb-1 border-t border-bg-dark flex justify-between items-center">
                @if($training->user)
                    <p class="font-sans text-sm text-dark">
                        {{ __('general.by') }}
                        <span class="font-bold">{{ $training->user->fullName() }}</span>
                    </p>
                @else
                    <span></span>
                @endif
                @if($training->participants)
                    <span @class([
                        'px-4 py-0.5 rounded-2xl font-sans text-sm font-bold leading-6',
                        'text-danger' => $isFull,
                        'text-success' => !$isFull,
                    ])>
                        {{ $isFull
                            ? __('general.full')
                            : __('general.participants', ['current' => $training->acceptedRegisters->count(), 'max' => $training->participants]) }}
                    </span>
                @endif
            </div>
        </div>

    </div>

</a>
