<div class="flex flex-col gap-8 p-8" wire:poll.10s>

    @if(auth()->user()->isIncomplete())
        <div>
            <p>Votre dossier est incomplet.</p>
            <a href="{{ route('admin.profile', ['locale' => app()->getLocale()]) }}">Mon Profil</a>
        </div>
    @endif

    <section class="flex flex-col gap-4">
        <h2 class="sr-only">CTA</h2>
        <div class="flex flex-wrap gap-4">

            @can('manage-members')
                <a href="{{ route('admin.members.create', ['locale' => app()->getLocale()]) }}">Ajouter un membre</a>
                <a href="{{ route('admin.members.index', ['locale' => app()->getLocale()]) }}">Gérer les membres</a>
            @endcan

            @can('manage-messages')
                <a href="{{ route('admin.messages.index', ['locale' => app()->getLocale()]) }}">Voir les messages</a>
            @endcan

            @can('manage-training')
                <a href="{{ route('admin.trainings.create', ['locale' => app()->getLocale()]) }}">Créer une formation</a>
            @endcan

            @can('manage-camp')
                <a href="{{ route('admin.camps.create', ['locale' => app()->getLocale()]) }}">Créer un camp</a>
            @endcan

            @can('manage-announcement')
                <a href="{{ route('admin.announcements.create', ['locale' => app()->getLocale()]) }}">Ajouter une actualité</a>
            @endcan
        </div>
    </section>

    <section class="flex flex-col gap-4" wire:ignore>
        <h2>Mon Calendrier</h2>
        <div x-data="dashboardCalendar(@js($calendarEvents), '{{ app()->getLocale() }}')"></div>
    </section>

    @isset($pendingTrainingRegisters)
        <section class="flex flex-col gap-4">
            <h2>Inscriptions ({{ $pendingTrainingRegisters->count() }})</h2>

            @forelse($pendingTrainingRegisters as $register)
                <div wire:key="training-register-{{ $register->id }}">
                    <p>
                        <strong>{{ $register->user->fullName() }}</strong>
                        - {{ $register->training->title }}
                        ({{ $register->training->start_date->format('d/m/Y') }})
                    </p>
                    @if($register->notes)
                        <p>Notes : {{ $register->notes }}</p>
                    @endif
                    <div>
                        <button wire:click="acceptTrainingRegister({{ $register->id }})">Accepter</button>
                        <button wire:click="openConfirmRefuseModal({{ $register->id }}, 'training_register')">Refuser</button>
                    </div>
                </div>
            @empty
                <p>Aucune inscription en attente.</p>
            @endforelse
        </section>
    @endisset

    @isset($pendingCampRegisters)
        <section class="flex flex-col gap-4">
            <h2>Inscriptions ({{ $pendingCampRegisters->count() }})</h2>

            @forelse($pendingCampRegisters as $register)
                <div wire:key="camp-register-{{ $register->id }}">
                    <p>
                        <strong>{{ $register->user->fullName() }}</strong>
                        - {{ $register->camp->title }}
                        ({{ $register->camp->start_date->format('d/m/Y') }})
                    </p>
                    @if($register->notes)
                        <p>Notes : {{ $register->notes }}</p>
                    @endif
                    <div>
                        <button wire:click="acceptCampRegister({{ $register->id }})">Accepter</button>
                        <button wire:click="openConfirmRefuseModal({{ $register->id }}, 'camp_register')">Refuser</button>
                    </div>
                </div>
            @empty
                <p>Aucune inscription en attente.</p>
            @endforelse
        </section>
    @endisset

    @isset($pendingTrainings)
        <section class="flex flex-col gap-4">
            <h2>Formations ({{ $pendingTrainings->count() }})</h2>

            @forelse($pendingTrainings as $training)
                <div wire:key="training-{{ $training->id }}">
                    <p>
                        <strong>{{ $training->title }}</strong>
                        - par {{ $training->user->fullName() }}
                        ({{ $training->start_date->format('d/m/Y') }})
                    </p>
                    <div>
                        <a href="{{ route('admin.trainings.edit', ['locale' => app()->getLocale(), 'training' => $training]) }}">Voir</a>
                        <button wire:click="publishTraining({{ $training->id }})">Publier</button>
                        <button wire:click="openConfirmRefuseModal({{ $training->id }}, 'training')">Refuser</button>
                    </div>
                </div>
            @empty
                <p>Aucune formation en attente de validation.</p>
            @endforelse
        </section>
    @endisset

    @isset($pendingCamps)
        <section class="flex flex-col gap-4">
            <h2>Camps ({{ $pendingCamps->count() }})</h2>

            @forelse($pendingCamps as $camp)
                <div wire:key="camp-{{ $camp->id }}">
                    <p>
                        <strong>{{ $camp->title }}</strong>
                        - par {{ $camp->user->fullName() }}
                        ({{ $camp->start_date->format('d/m/Y') }})
                    </p>
                    <div>
                        <a href="{{ route('admin.camps.edit', ['locale' => app()->getLocale(), 'camp' => $camp]) }}">Voir</a>
                        <button wire:click="publishCamp({{ $camp->id }})">Publier</button>
                        <button wire:click="openConfirmRefuseModal({{ $camp->id }}, 'camp')">Refuser</button>
                    </div>
                </div>
            @empty
                <p>Aucun camp en attente de validation.</p>
            @endforelse
        </section>
    @endisset
</div>
