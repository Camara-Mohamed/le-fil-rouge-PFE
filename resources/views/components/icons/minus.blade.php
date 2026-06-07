@props([
    'class' => 'size-5',
    'fill'  => 'fill-current',
])

<span {{ $attributes->merge(['class' => $class . ' inline-block']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" class="w-full h-full {{ $fill }}">
        <path d="M228,128a12,12,0,0,1-12,12H40a12,12,0,0,1,0-24H216A12,12,0,0,1,228,128Z"/>
    </svg>
</span>
