@props(['register'])

<div class="p-6 bg-bg rounded-lg shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex justify-between items-center gap-3">

    <div class="flex items-center gap-3 min-w-0">
        <div class="size-10 bg-info-bg rounded-full shrink-0 flex items-center justify-center">
            <span class="font-sans font-black text-sm text-info uppercase">
                {{ strtoupper($register->user->first_name[0] . $register->user->last_name[0]) }}
            </span>
        </div>
        <div class="flex flex-col gap-0.5 min-w-0">
            <p class="font-sans font-black text-base text-dark truncate">{{ $register->user->fullName() }}</p>
            <p class="font-serif text-sm text-dark-mid truncate">{{ $register->user->email }}</p>
        </div>
    </div>

    <span class="shrink-0 px-4 py-0.5 bg-warning-bg border border-warning rounded-2xl font-sans text-sm font-medium leading-6 text-red">
        {{ $register->user->role->label() }}
    </span>

</div>
