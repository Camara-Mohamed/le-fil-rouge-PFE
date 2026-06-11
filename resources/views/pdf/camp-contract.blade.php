@extends('pdf.layout')

@section('content')

    <div class="pdf-title">
        <h1>Contrat de participation</h1>
        <p>{{ $camp->title }}</p>
    </div>

    {{-- Le camp --}}
    <div class="pdf-section">
        <div class="pdf-section-title">Le camp</div>

        <div class="pdf-info-row">
            <span class="pdf-info-label">Dates</span>
            <span class="pdf-info-value">
                Du {{ $camp->start_date->format('d/m/Y') }}
                au {{ $camp->end_date->format('d/m/Y') }}
            </span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Type</span>
            <span class="pdf-info-value">{{ $camp->type->label() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Lieu</span>
            <span class="pdf-info-value">
                {{ $camp->address }} {{ $camp->number }},
                {{ $camp->postal_code }} {{ $camp->city }}
            </span>
        </div>
    </div>

    {{-- Le participant --}}
    <div class="pdf-section">
        <div class="pdf-section-title">Le participant</div>

        <div class="pdf-info-row">
            <span class="pdf-info-label">Nom</span>
            <span class="pdf-info-value">{{ $register->user->fullName() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Email</span>
            <span class="pdf-info-value">{{ $register->user->email }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Téléphone</span>
            <span class="pdf-info-value">{{ $register->user->phone }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Date de naissance</span>
            <span class="pdf-info-value">{{ $register->user->birth_date?->format('d/m/Y') }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">Rôle</span>
            <span class="pdf-info-value">{{ $register->user->role->label() }}</span>
        </div>
        @if($register->user->address)
            <div class="pdf-info-row">
                <span class="pdf-info-label">Adresse</span>
                <span class="pdf-info-value">
                    {{ $register->user->address }} {{ $register->user->number }},
                    {{ $register->user->postal_code }} {{ $register->user->city }}
                </span>
            </div>
        @endif
        @if($register->user->diet)
            <div class="pdf-info-row">
                <span class="pdf-info-label">Régime alimentaire</span>
                <span class="pdf-info-value">{{ $register->user->diet->label() }}</span>
            </div>
        @endif
        @if($register->user->allergies)
            <div class="pdf-info-row">
                <span class="pdf-info-label">Allergies</span>
                <span class="pdf-info-value">{{ $register->user->allergies }}</span>
            </div>
        @endif
        @if($register->notes)
            <div class="pdf-info-row">
                <span class="pdf-info-label">Notes</span>
                <span class="pdf-info-value">{{ $register->notes }}</span>
            </div>
        @endif
    </div>

    {{-- Signature --}}
    <div class="pdf-section" style="margin-top: 40px;">
        <div class="pdf-section-title">Signatures</div>
        <div style="display: flex; gap: 40px; margin-top: 16px;">
            <div style="flex: 1;">
                <p style="font-size: 10px; color: #6A6A88; margin-bottom: 40px;">Le participant</p>
                <div style="border-top: 1px solid #C8A89A; padding-top: 6px; font-size: 10px; color: #1A1A2E;">
                    {{ $register->user->fullName() }}
                </div>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 10px; color: #6A6A88; margin-bottom: 40px;">Le Fil Rouge</p>
                <div style="border-top: 1px solid #C8A89A; padding-top: 6px; font-size: 10px; color: #6A6A88;">
                    Cachet et signature
                </div>
            </div>
        </div>
    </div>

@endsection
