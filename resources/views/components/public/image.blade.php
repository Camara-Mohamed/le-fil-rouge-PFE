@props([
    'src'    => '',
    'srcset' => '',
    'sizes'  => '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 600px',
    'alt'    => '',
])

<figure {{ $attributes->merge(['class' => '']) }}>
    <img
        src="{{ $src }}"
        @if($srcset) srcset="{{ $srcset }}" @endif
        sizes="{{ $sizes }}"
        alt="{{ $alt }}"
        loading="eager"
        class="w-full h-auto object-cover rounded-2xl shadow-lg"
    />
</figure>
