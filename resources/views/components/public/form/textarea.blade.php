@props([
    'label'    => null,
    'name'     => null,
    'required' => false,
    'error'    => null,
    'rows'     => 6,
])

<div class="flex flex-col gap-2">
    @if($label)
        <label @if($name) for="{{ $name }}" @endif
               class="font-sans font-bold text-base text-dark">
            {{ $label }}@if($required)<span class="text-red"> *</span>@endif
        </label>
    @endif

    <textarea
        @if($name) id="{{ $name }}" name="{{ $name }}" @endif
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' =>
            'px-4 py-3 w-full bg-white border border-bg-dark rounded-lg' .
            'font-serif font-medium text-base text-dark placeholder:text-dark-mid ' .
            'transition duration-200'
        ]) }}
    >{{ $slot }}</textarea>

    @if($error)
        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
            <p class="text-danger text-sm font-serif">{{ $error }}</p>
        </div>
    @endif
</div>
