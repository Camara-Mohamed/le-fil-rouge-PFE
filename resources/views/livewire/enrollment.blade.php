<div wire:poll.20s>

    {{-- Utilisateur stade d'inscription --}}
    @if($register === null && $canEnroll)
        <div>
            <label>Notes (optionnel)</label>
            <textarea wire:model="notes"></textarea>
        </div>
        <button wire:click="enroll">S'inscrire</button>

    @elseif($register?->isPending())
        <p>Inscription en attente</p>
        @if($register->notes)
            <p>Notes : {{ $register->notes }}</p>
        @endif
        @if($canCancel)
            <button wire:click="openCancelModal('pending')">
                Ne plus s'inscrire
            </button>
        @endif

    @elseif($register?->isAccepted())
        <p>Inscription acceptée</p>
        @if($register->notes)
            <p>Notes : {{ $register->notes }}</p>
        @endif
        @if($canCancel)
            <button wire:click="openCancelModal('accepted')">
                Se désinscrire
            </button>
        @endif

    @elseif($register?->isRefused())
        <p>Inscription refusée</p>
        @if($register->notes)
            <p>Notes : {{ $register->notes }}</p>
        @endif

    @elseif($model->isConfirmed() && $register === null)
        <p>Les inscriptions sont finies</p>
    @endif


    {{-- Admin et créateur listes des inscriptions --}}
    @can('update', $model)

        <h3>En attente ({{ $pending->count() }})</h3>
        @forelse($pending as $registrant)

            <table wire:key="pending-{{ $registrant->id }}">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{ $registrant->user->fullName() }}</td>
                    <td>{{ $registrant->user->email }}</td>
                    <td>{{ $registrant->user->role->label() }}</td>
                    <td>{{ $registrant->user->status->label() }}</td>

                    <td>
                        @if($registrant->notes)
                            {{ $registrant->notes }}
                        @endif
                    </td>

                    <td>
                        <button wire:click="accept({{ $registrant->id }})">
                            Accepter
                        </button>

                        <button wire:click="pending({{ $registrant->id }})">
                            Mettre en attente
                        </button>

                        <button
                            wire:click="refuse({{ $registrant->id }})"
                            wire:confirm="Refuser ?"
                        >
                            Refuser
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

        @empty
            <p>Aucune inscription en attente</p>
        @endforelse


        <h3>Acceptés ({{ $accepted->count() }})</h3>
        @forelse($accepted as $registrant)

            <table wire:key="accepted-{{ $registrant->id }}">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{ $registrant->user->fullName() }}</td>
                    <td>{{ $registrant->user->email }}</td>
                    <td>{{ $registrant->user->role->label() }}</td>
                    <td>{{ $registrant->user->status->label() }}</td>

                    <td>
                        @if($registrant->notes)
                            {{ $registrant->notes }}
                        @endif
                    </td>

                    <td>
                        <button wire:click="refuse({{ $registrant->id }})">
                            Refuser
                        </button>

                        <button wire:click="pending({{ $registrant->id }})">
                            Mettre en attente
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

        @empty
            <p>Aucune inscription acceptée</p>
        @endforelse


        <h3>Refusés ({{ $refused->count() }})</h3>
        @forelse($refused as $registrant)

            <table wire:key="refused-{{ $registrant->id }}">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{ $registrant->user->fullName() }}</td>
                    <td>{{ $registrant->user->email }}</td>
                    <td>{{ $registrant->user->role->label() }}</td>
                    <td>{{ $registrant->user->status->label() }}</td>

                    <td>
                        @if($registrant->notes)
                            {{ $registrant->notes }}
                        @endif
                    </td>

                    <td>
                        <button wire:click="accept({{ $registrant->id }})">
                            Accepter
                        </button>

                        <button wire:click="pending({{ $registrant->id }})">
                            Mettre en attente
                        </button>

                        <button
                            wire:click="refuse({{ $registrant->id }})"
                            wire:confirm="Refuser ?"
                        >
                            Refuser
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

        @empty
            <p>Aucune inscription refusée</p>
        @endforelse

    @else

        {{-- User : liste des inscrits --}}
        <h3>Participants ({{ $accepted->count() }})</h3>

        @forelse($accepted as $registrant)

            <table wire:key="participant-{{ $registrant->id }}">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Rôle</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>{{ $registrant->user->fullName() }}</td>
                    <td>{{ $registrant->user->role->label() }}</td>
                </tr>
                </tbody>
            </table>

        @empty
            <p>Aucun inscrit</p>
        @endforelse

    @endcan

</div>
