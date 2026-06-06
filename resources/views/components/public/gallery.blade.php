@props([
    'images'  => [],
    'base'    => '',
    'title'   => '',
    'group'   => 'gallery',
    'alt'     => '',
])

<section class="px-4 md:px-6 lg:px-8 pb-16 md:pb-20">
    @if($title)
        <h2 class="font-sans font-black text-3xl text-dark mb-6">{{ $title }}</h2>
    @endif
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        @foreach($images as $name)
            @php
                $src    = asset("{$base}/{$name}.webp");
                $srcset = asset("{$base}/{$name}-640.webp")  . ' 640w, '
                        . asset("{$base}/{$name}-1024.webp") . ' 1024w, '
                        . asset("{$base}/{$name}-1440.webp") . ' 1440w';
            @endphp
            <a href="{{ $src }}" data-fancybox="{{ $group }}">
                <x-public.image
                    :src="$src"
                    :srcset="$srcset"
                    sizes="(max-width: 768px) 50vw, 33vw"
                    :alt="$alt"
                    class="w-full h-48"
                    loading="eager"
                />
            </a>
        @endforeach
    </div>
</section>
