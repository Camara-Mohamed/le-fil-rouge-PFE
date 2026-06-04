@props([
    'href',
    'title' => '',
    'route' => ''
])

<li role="none">
    <a href="{{ $href }}"
       wire:navigate
       title="{{ $title }}"
       aria-current="{{ request()->routeIs($route) ? 'page' : 'false' }}"
       {{ $attributes->merge(['class' => 'block px-4 py-2 font-sans font-medium text-dark transition
              hover:text-white hover:bg-red
              focus:text-white focus:bg-red']) }}>
        {{ $slot }}
    </a>
</li>
