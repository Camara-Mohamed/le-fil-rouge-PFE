@props([
    'label'       => null,
    'name'        => null,
    'options'     => [],
    'placeholder' => null,
    'required'    => false,
    'error'       => null,
])

<div class="flex flex-col gap-2">
    @if($label)
        <label @if($name) for="{{ $name }}" @endif
               class="font-sans font-bold text-base text-dark">
            {{ $label }}@if($required)<abbr title="{{ __('general.required') }}" class="text-red"> *</abbr>@endif
        </label>
    @endif

    <div class="relative">
        <select
            @if($name) id="{{ $name }}" name="{{ $name }}" @endif
            {{ $attributes->merge(['class' =>
                'w-full h-11 px-4 pr-10 bg-bg rounded-lg appearance-none cursor-pointer ' .
                'font-serif font-medium text-base text-dark ' .
                'focus:outline-red transition duration-200'
            ]) }}
        >
            @if($placeholder)
                <option value="">{{ $placeholder }}</option>
            @endif
            @foreach($options as $option)
                @if(is_array($option))
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @else
                    <option value="{{ $option->value }}">{{ $option->label() }}</option>
                @endif
            @endforeach
        </select>

        <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-dark-mid">
            <x-icons.chevron-down />
        </div>
    </div>

    @error($name)
        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
            <p class="text-danger text-sm font-serif">{{ $message }}</p>
        </div>
    @enderror
</div>
