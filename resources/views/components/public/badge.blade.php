@props(['variant' => 'danger'])

@php
$variants = [
    'danger'  => 'bg-danger-bg text-danger border-danger',
    'warning' => 'bg-warning-bg text-warning border-warning',
    'success' => 'bg-success-bg text-success border-success',
    'info'    => 'bg-info-bg text-info border-info',
];
$classes = $variants[$variant] ?? $variants['danger'];
@endphp

<span {{ $attributes->merge(['class' => "px-3 py-0.5 rounded-2xl border font-serif text-sm font-medium leading-6 {$classes}"]) }}>
    {{ $slot }}
</span>
