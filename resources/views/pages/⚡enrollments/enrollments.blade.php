<div class="flex flex-col gap-8">

    <h2>Mes formations</h2>

    @forelse($trainingRegisters as $register)
        <div>
            <a href="{{ route('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $register->training]) }}">
                {{ $register->training->title }}
            </a>
            <span>{{ $register->training->start_date->format('d/m/Y') }} → {{ $register->training->end_date->format('d/m/Y') }}</span>
            <p>{{ $register->status->label() }}</p>
            @if($register->notes)
                <p>{{ $register->notes }}</p>
            @endif
        </div>
    @empty
        <p>Aucune inscription à une formation</p>
    @endforelse

    <h2>Mes camps</h2>

    @forelse($campRegisters as $register)
        <div>
            <a href="{{ route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $register->camp]) }}">
                {{ $register->camp->title }}
            </a>
            <span>{{ $register->camp->start_date->format('d/m/Y') }} → {{ $register->camp->end_date->format('d/m/Y') }}</span>
            <span>{{ $register->status->label() }}</span>
            @if($register->notes)
                <p>{{ $register->notes }}</p>
            @endif
        </div>
    @empty
        <p>Aucune inscription à un stage ou séjour</p>
    @endforelse

    // Liste des inscriptions actuelles

    // Liste des formations

    // Liste des camps

</div>
