@props([
    'type'  => 'button',
    'title' => '',
])

<button
    type="{{ $type }}"
    title="{{ $title }}"
    {{ $attributes->merge(['class' => 'cursor-pointer inline-flex items-center justify-center gap-2 px-6 py-2 rounded border-2 font-sans font-medium transition duration-200']) }}
>
    {{ $slot }}
</button>
