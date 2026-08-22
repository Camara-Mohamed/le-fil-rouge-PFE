@props([
    'label'     => null,
    'name'      => null,
    'required'  => false,
    'rows'      => 6,
    'maxlength' => null,
])

<div class="flex flex-col gap-2">
    @if($label)
        <label @if($name) for="{{ $name }}" @endif
               class="font-sans font-bold text-base text-dark">
            {{ $label }}@if($required)<abbr title="{{ __('general.required') }}" class="text-red"> *</abbr>@endif
        </label>
    @endif

    <textarea
        @if($name) id="{{ $name }}" name="{{ $name }}" @endif
        rows="{{ $rows }}"
        @if($maxlength) maxlength="{{ $maxlength }}" @endif
        {{ $attributes->merge(['class' =>
            'px-4 py-3 w-full bg-white border border-bg-dark rounded-lg resize-none ' .
            'font-serif font-medium text-base text-dark placeholder:text-dark-mid placeholder:font-normal ' .
            'transition duration-200'
        ]) }}
    >{{ $slot }}</textarea>

    @if($maxlength)
        <p class="font-serif text-xs text-dark-mid">{{ $maxlength }} caractères max</p>
    @endif

    @error($name)
        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
            <p class="font-serif text-sm text-danger">{{ $message }}</p>
        </div>
    @enderror
</div>
