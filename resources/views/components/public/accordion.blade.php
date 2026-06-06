@props(['summary'])

<details {{ $attributes->merge(['class' => 'group']) }}>

    <summary class="flex justify-between items-center gap-4 cursor-pointer list-none">
        <span class="font-sans font-black text-base text-dark">{{ $summary }}</span>
        <span class="shrink-0 size-7 bg-red rounded-full flex items-center justify-center text-white select-none">
            <x-icons.plus class="size-3.5 group-open:hidden" fill="fill-white" />
            <x-icons.minus class="size-3.5 hidden group-open:block" fill="fill-white" />
        </span>
    </summary>

    <div class="mt-3">
        {{ $slot }}
    </div>

</details>
