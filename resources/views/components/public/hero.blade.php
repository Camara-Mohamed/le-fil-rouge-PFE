@props([
    'title'    => null,
    'subtitle' => null,
    'banner'   => null,
    'srcset'   => null,
])

@if($banner)
    <div class="relative h-64">
        <img
            src="{{ $banner }}"
            @if($srcset) srcset="{{ $srcset }}" sizes="100vw" @endif
            alt="{{ $title }}"
            class="w-full h-full object-cover"
            loading="eager"
        />
        <div class="absolute inset-0 bg-linear-to-r from-dark to-gray-900/10"></div>
        <div class="absolute inset-0 flex flex-col justify-end px-4 md:px-8 pb-8 gap-2">
            @if($title)
                <h1 class="font-sans font-black text-3xl md:text-5xl text-white [text-shadow:0_2px_8px_rgba(0,0,0,0.4)]">
                    {{ $title }}
                </h1>
            @endif
            @if($subtitle)
                <p class="font-serif text-base md:text-lg text-white/80">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
@else
    <div class="px-4 md:px-8 py-24 bg-bg border-b border-bg-dark">
        @if($title)
            <h1 class="font-sans font-black text-4xl md:text-5xl text-dark">{{ $title }}</h1>
        @endif
        @if($subtitle)
            <p class="font-serif text-lg text-dark-mid mt-2">{{ $subtitle }}</p>
        @endif
    </div>
@endif
