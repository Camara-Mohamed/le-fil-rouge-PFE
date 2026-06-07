@php
    use App\Enums\RegisterStatus;

    @endphp

<div class="flex flex-col gap-8 px-4 py-8 md:px-8">

    <h2 class="font-sans font-black text-3xl text-dark">Mon historique</h2>

    {{-- Formations --}}
    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
        <h3 class="font-sans font-bold text-xl text-dark">Mes formations</h3>

        @forelse($trainingRegisters as $register)
            <div class="flex flex-col gap-2 p-4 rounded-xl border border-bg-dark bg-bg">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <a href="{{ route('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $register->training]) }}"
                       class="font-sans font-semibold text-dark hover:text-red transition">
                        {{ $register->training->title }}
                    </a>
                    <x-public.badge variant="{{ match($register->status) {
                        RegisterStatus::ACCEPTED => 'success',
                        RegisterStatus::REFUSED  => 'danger',
                        RegisterStatus::PENDING                             => 'warning',
                    } }}">
                        {{ $register->status->label() }}
                    </x-public.badge>
                </div>

                <p class="font-serif text-sm text-dark-mid">
                    Du {{ $register->training->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                    au {{ $register->training->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                </p>

                @if($register->notes)
                    <p class="font-serif text-sm text-dark-mid italic">{{ $register->notes }}</p>
                @endif
            </div>
        @empty
            <p class="font-serif text-dark-mid">Aucune inscription à une formation.</p>
        @endforelse
    </section>

    {{-- Camps --}}
    <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
        <h3 class="font-sans font-bold text-xl text-dark">Mes camps & séjours</h3>

        @forelse($campRegisters as $register)
            <div class="flex flex-col gap-2 p-4 rounded-xl border border-bg-dark bg-bg">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <a href="{{ route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $register->camp]) }}"
                       class="font-sans font-semibold text-dark hover:text-red transition">
                        {{ $register->camp->title }}
                    </a>
                    <x-public.badge variant="{{ match($register->status) {
                        RegisterStatus::ACCEPTED => 'success',
                        RegisterStatus::REFUSED  => 'danger',
                        RegisterStatus::PENDING             => 'warning',
                    } }}">
                        {{ $register->status->label() }}
                    </x-public.badge>
                </div>

                <p class="font-serif text-sm text-dark-mid">
                    Du {{ $register->camp->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                    au {{ $register->camp->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                </p>

                @if($register->notes)
                    <p class="font-serif text-sm text-dark-mid italic">{{ $register->notes }}</p>
                @endif
            </div>
        @empty
            <p class="font-serif text-dark-mid">Aucune inscription à un camp ou séjour.</p>
        @endforelse
    </section>

</div>
