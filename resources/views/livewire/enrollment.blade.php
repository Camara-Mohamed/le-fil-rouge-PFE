<div wire:poll.20s class="flex flex-col gap-8">

    {{-- Inscription --}}
    @if($register === null && $canEnroll)
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <label for="enrollment-notes" class="font-sans font-bold text-base text-dark">
                    {{ __('livewire/enrollment.notes') }}
                    <span class="font-serif font-normal text-sm text-dark-mid">{{ __('livewire/enrollment.notes_optional') }}</span>
                </label>
                <textarea id="enrollment-notes"
                          wire:model="notes"
                          rows="4"
                          placeholder="{{ __('livewire/enrollment.notes_placeholder') }}"
                          class="w-full p-4 bg-white rounded-lg border-2 border-bg-mid font-serif text-base text-dark placeholder:text-dark-light resize-none focus:outline-none focus:border-red transition duration-200"></textarea>
            </div>
            <button type="button" wire:click="enroll"
                    class="self-start px-8 py-3 bg-red border-2 border-red rounded-lg font-sans font-bold text-sm text-white hover:bg-red-mid hover:border-red-mid transition duration-200">
                {{ __('livewire/enrollment.enroll') }}
            </button>
        </div>

    @elseif($register?->isPending())
        <div class="flex flex-col gap-4">
            <div class="px-4 py-3 bg-warning-bg border border-warning rounded-lg">
                <span class="font-sans text-sm font-medium text-warning">{{ __('livewire/enrollment.status_pending') }}</span>
            </div>
            @if($register->notes)
                <div class="flex flex-col gap-2">
                    <span class="font-sans font-bold text-base text-dark">{{ __('livewire/enrollment.notes') }}</span>
                    <div class="p-4 bg-white rounded-lg border-2 border-bg-mid font-serif text-base text-dark whitespace-pre-line">{!! $register->notes !!}</div>
                </div>
            @endif
            @if($canCancel)
                <button type="button" wire:click="openCancelModal('pending')"
                        class="self-start px-8 py-3 bg-red-light border-2 border-red rounded-lg font-sans font-bold text-sm text-red hover:bg-red hover:text-white transition duration-200">
                    {{ __('livewire/enrollment.cancel_pending') }}
                </button>
            @endif
        </div>

    @elseif($register?->isAccepted())
        <div class="flex flex-col gap-4">

            @if(isset($model->price) && $model->price > 0)
                {{-- Payante --}}
                <div class="flex flex-col gap-3 p-4 bg-success-bg border border-success rounded-lg">
                    <span class="font-sans font-black text-sm text-danger">{{ __('admin.payment.title') }}</span>
                    <p class="font-serif text-sm text-dark">
                        {{ __('admin.payment.content', [
                            'amount'   => $model->getFormattedPrice(),
                            'deadline' => $model->end_date->translatedFormat('j F Y'),
                        ]) }}
                    </p>
                    <ul class="flex flex-col gap-1">
                        <li class="font-sans text-sm text-dark">
                            <span class="font-bold">{{ __('admin.account_label') }} :</span> {{ __('admin.iban') }}
                        </li>
                        <li class="font-sans text-sm text-dark">
                            <span class="font-bold">{{ __('admin.communication_label') }} :</span> {{ $model->title }} – {{ auth()->user()->fullName() }}
                        </li>
                    </ul>
                </div>
            @else
                {{-- Gratuit --}}
                <div class="px-4 py-3 bg-success-bg border border-success rounded-lg">
                    <span class="font-sans text-sm font-medium text-success">{{ __('livewire/enrollment.status_accepted') }}</span>
                </div>
            @endif

            @if($register->notes)
                <div class="flex flex-col gap-2">
                    <span class="font-sans font-bold text-base text-dark">{{ __('livewire/enrollment.notes') }}</span>
                    <div class="p-4 bg-white rounded-lg border-2 border-bg-mid font-serif text-base text-dark whitespace-pre-line">{!! $register->notes !!}</div>
                </div>
            @endif
            @if($canCancel)
                <button type="button" wire:click="openCancelModal('accepted')"
                        class="self-start px-8 py-3 bg-red border-2 border-red rounded-lg font-sans font-bold text-sm text-white hover:bg-red-mid hover:border-red-mid transition duration-200">
                    {{ __('livewire/enrollment.deregister') }}
                </button>
            @endif
        </div>

    @elseif($register?->isRefused())
        <div class="flex flex-col gap-4">
            <div class="px-4 py-3 bg-danger-bg border border-danger rounded-lg">
                <span class="font-sans text-sm font-medium text-danger">{{ __('livewire/enrollment.status_refused') }}</span>
            </div>
            @if($register->notes)
                <div class="flex flex-col gap-2">
                    <span class="font-sans font-bold text-base text-dark">{{ __('livewire/enrollment.notes') }}</span>
                    <div class="p-4 bg-white rounded-lg border-2 border-bg-mid font-serif text-base text-dark whitespace-pre-line">{!! $register->notes !!}</div>
                </div>
            @endif
        </div>

    @elseif(! $model->isPublished() && $register === null)
        <div class="px-4 py-3 bg-bg-mid border border-bg-dark rounded-lg">
            <span class="font-sans text-sm font-medium text-dark-mid">{{ __('livewire/enrollment.not_open') }}</span>
        </div>
    @endif

</div>
