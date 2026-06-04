@props(['href', 'title' => ''])

<li>
    <a href="{{ $href }}"
       wire:navigate
       title="{{ $title }}"
       class="block px-4 py-2 font-sans font-medium text-dark transition
              hover:text-white hover:bg-red
              focus:text-white focus:bg-red">
        {{ $slot }}
    </a>
</li>
