@props([
    'src'     => '',
    'srcset'  => '',
    'sizes'   => '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 600px',
    'alt'     => '',
    'loading' => 'eager',
])

<img
    src="{{ $src }}"
    @if($srcset) srcset="{{ $srcset }}" @endif
    sizes="{{ $sizes }}"
    alt="{{ $alt }}"
    loading="{{ $loading }}"
    {{ $attributes->merge(['class' => 'w-full object-cover rounded-2xl']) }}
/>
