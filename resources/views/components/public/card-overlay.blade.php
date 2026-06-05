@props([
    'label'   => null,
    'variant' => 'danger',
])

@php
$variants = [
    'danger'  => 'bg-danger-bg text-danger',
    'warning' => 'bg-warning-bg text-warning',
    'success' => 'bg-success-bg text-success',
    'info'    => 'bg-info-bg text-info',
];
$classes = $variants[$variant] ?? $variants['danger'];
@endphp

<div class="absolute inset-0 bg-gray-900/40 flex flex-col justify-end items-end p-6">
    @if($label)
        <span class="px-4 py-0.5 {{ $classes }} rounded-2xl font-sans text-sm font-medium leading-6 capitalize">
            {{ $label }}
        </span>
    @endif
</div>
