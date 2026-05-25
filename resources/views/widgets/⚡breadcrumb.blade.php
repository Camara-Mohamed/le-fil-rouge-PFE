<?php

use Livewire\Component;

new class extends Component {
    public array $items = [];
};
?>

<nav>
    @foreach ($items as $item)
        @if (! $loop->last)
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a> /
        @else
            <span>{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>
