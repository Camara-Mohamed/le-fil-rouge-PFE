@extends('pdf.layout')

@section('content')

    <div class="pdf-title">
        <h1>{{ $training->title }}</h1>
        <p>Résumé de la formation</p>
    </div>

    {{-- Informations --}}
    <div class="pdf-section">
        <div class="pdf-section-title">Informations générales</div>

        <div class="pdf-info-row">
            <span class="pdf-info-label">Dates</span>
            <span class="pdf-info-value">
                Du {{ $training->start_date->format('d/m/Y H:i') }}
                au {{ $training->end_date->format('d/m/Y H:i') }}
            </span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Type</span>
            <span class="pdf-info-value">{{ $training->type->label() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Prix</span>
            <span class="pdf-info-value">{{ $training->getFormattedPrice() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Créateur</span>
            <span class="pdf-info-value">{{ $training->user->fullName() }}</span>
        </div>
        @if($training->city)
            <div class="pdf-info-row">
                <span class="pdf-info-label">Lieu</span>
                <span class="pdf-info-value">
                    {{ $training->address }} {{ $training->number }},
                    {{ $training->postal_code }} {{ $training->city }}
                </span>
            </div>
        @endif
    </div>

    {{-- Stats --}}
    <div class="pdf-section">
        <div class="pdf-section-title">Statistiques</div>
        <div class="pdf-stats">
            <div class="pdf-stat accepted">
                <div class="pdf-stat-value">{{ $training->acceptedRegisters->count() }}</div>
                <div class="pdf-stat-label">Acceptés</div>
            </div>
            <div class="pdf-stat pending">
                <div class="pdf-stat-value">{{ $training->pendingRegisters->count() }}</div>
                <div class="pdf-stat-label">En attente</div>
            </div>
            <div class="pdf-stat refused">
                <div class="pdf-stat-value">{{ $training->refusedRegisters->count() }}</div>
                <div class="pdf-stat-label">Refusés</div>
            </div>
        </div>
    </div>

    {{-- Liste inscrits --}}
    <div class="pdf-section">
        <div class="pdf-section-title">Inscrits acceptés ({{ $training->acceptedRegisters->count() }})</div>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($training->acceptedRegisters as $register)
                    <tr>
                        <td>{{ $register->user->fullName() }}</td>
                        <td>{{ $register->user->email }}</td>
                        <td>{{ $register->user->role->label() }}</td>
                        <td>{{ $register->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
