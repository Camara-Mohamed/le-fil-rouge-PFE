@props([
    'href',
    'title' => '',
    'route' => '',
    'class' => '',
])

@php
    $active = request()->routeIs($route);
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    <a href="{{ $href }}"
       wire:navigate
       title="{{ $title }}"
       aria-current="{{ $active ? 'page' : 'false' }}"
       class="relative inline-block font-sans font-medium text-dark hover:text-red transition duration-200 focus:text-red focus:after:scale-x-100
              after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-red after:rounded-full
              after:transition-transform after:duration-300 after:origin-left
              after:scale-x-0 hover:after:scale-x-100
              aria-[current=page]:text-red aria-[current=page]:after:scale-x-100">
        {{ $slot }}
    </a>
</li>
