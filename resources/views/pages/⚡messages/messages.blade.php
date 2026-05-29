@php
    use App\Enums\VolunteerRequestStatus;
@endphp

<div>
    <livewire:widgets::breadcrumb :items="[
        ['label' => __('breadcrumbs.messages')],
    ]"/>

    <div>
        @forelse ($messages as $message)
            <div wire:key="{{ $message->type }}-{{ $message->id }}">
                <div>
                    <div>
                        <div>
                            <div>
                                <span>
                                    {{ $message->type === 'contact' ? 'Contact' : 'Bénévole' }}
                                </span>

                                @if ($message->status)
                                    <span>{{ $message->status->label() }}</span>
                                @endif

                                <p>{{ $message->created_at->diffForHumans() }}</p>
                            </div>

                            <p>{{ $message->name }}</p>
                            <p>{{ $message->email }}</p>

                            @if ($message->subject)
                                <p>{{ $message->subject }}</p>
                            @endif

                            <p>{{ $message->message }}</p>
                        </div>
                    </div>

                    <div>
                        @if (!$message->read_at)
                            <button wire:click="markAsRead({{ $message->id }}, '{{ $message->type }}')">
                                Marquer comme lu
                            </button>
                        @endif

                        @if ($message->type === 'contact')
                            <a href="mailto:{{ $message->email }}">Répondre</a>
                        @else
                            <a href="mailto:{{ $message->email }}">Contacter</a>
                        @endif

                        @if ($message->type === 'volunteer')

                            @if ($message->status !== VolunteerRequestStatus::REJECTED)
                                <button
                                    wire:click="rejectVolunteer({{ $message->id }})"
                                    wire:confirm="Refuser la demande ?"
                                >
                                    Refuser
                                </button>
                            @endif

                            @if ($message->status === VolunteerRequestStatus::PENDING)
                                <button wire:click="openCreateMember({{ $message->id }})">
                                    Créer un compte
                                </button>
                            @endif

                            @if ($message->status !== VolunteerRequestStatus::PENDING)
                                <button
                                    wire:click="resetToPending({{ $message->id }})"
                                    wire:confirm="Remettre la demande en attente ?"
                                >
                                    Remettre en attente
                                </button>
                            @endif

                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p>Aucun message.</p>
        @endforelse
    </div>
</div>
