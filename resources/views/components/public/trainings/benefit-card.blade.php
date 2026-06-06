@props([
    'number',
    'title',
    'description',
])

<div class="w-full p-4 bg-bg rounded-lg shadow-[0px_5px_30px_0px_rgba(0,0,0,0.10)] outline outline-1 outline-offset-[-1px] outline-bg-dark flex flex-col gap-4">
    <span class="text-right font-sans font-black text-5xl text-red leading-none">
        {{ $number }}
    </span>
    <div class="flex flex-col gap-2">
        <p class="font-sans font-black text-base text-dark">{{ $title }}</p>
        <p class="font-serif text-sm text-dark leading-5">{{ $description }}</p>
    </div>
</div>
