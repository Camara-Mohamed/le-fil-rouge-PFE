@props([
    'href'  => '#',
    'title' => '',
])

<a href="{{ $href }}"
   wire:navigate
   title="{{ $title }}"
   {{ $attributes->merge(['class' => 'flex items-center justify-center gap-2 font-sans font-semibold transition duration-200']) }}>
    {{ $slot }}
</a>
