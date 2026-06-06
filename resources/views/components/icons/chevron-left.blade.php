@props([
    'class' => 'size-5',
    'fill'  => 'fill-current',
])

<div {{ $attributes->merge(['class' => $class]) }}>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-full h-full {{ $fill }}">
        <path d="M165.66,202.34a8,8,0,0,1-11.32,11.32l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L91.31,128Z"/>
    </svg>
</div>
