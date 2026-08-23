<?php

use Livewire\Component;

new class extends Component {
    public array $items = [];
};
?>

<nav aria-label="{{ __('breadcrumbs.nav_label') }}" class="flex items-center flex-wrap gap-1">
    @foreach ($items as $item)
        @if (! $loop->last)
            <a href="{{ $item['url'] }}"
               class="font-sans text-sm text-dark-mid hover:text-dark transition duration-200">
                {{ $item['label'] }}
            </a>
            <x-icons.chevron-right class="size-3 shrink-0 text-dark-light" fill="fill-current" />
        @else
            <span class="font-sans text-sm text-dark font-medium" aria-current="page">
                {{ $item['label'] }}
            </span>
        @endif
    @endforeach
</nav>
