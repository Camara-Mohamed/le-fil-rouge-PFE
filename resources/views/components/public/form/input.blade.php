@props([
    'label'    => null,
    'name'     => null,
    'required' => false,
])

<div class="flex flex-col gap-2">
    @if($label)
        <label @if($name) for="{{ $name }}" @endif
               class="font-sans font-bold text-base text-dark">
            {{ $label }}@if($required)<span class="text-red"> *</span>@endif
        </label>
    @endif

    <input
        @if($name) id="{{ $name }}" name="{{ $name }}" @endif
        {{ $attributes->merge(['class' =>
            'h-11 px-4 w-full bg-white border border-bg-dark rounded-lg ' .
            'font-serif font-medium text-base text-dark placeholder:text-dark-mid ' .
            'transition duration-200'
        ]) }}
    />

    @error($name)
        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
            <p class="font-serif text-sm text-danger">{{ $message }}</p>
        </div>
    @enderror
</div>
