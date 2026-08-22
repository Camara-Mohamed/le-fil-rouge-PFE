@extends('pdf.layout')

@section('content')

    <div class="pdf-title">
        <h1>{{ __('pdf.camp_contract.title') }}</h1>
        <p>{{ $camp->title }}</p>
    </div>

    {{-- Le camp --}}
    <div class="pdf-section">
        <div class="pdf-section-title">{{ __('pdf.camp_contract.section_camp') }}</div>

        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.camp_contract.label_dates') }}</span>
            <span class="pdf-info-value">
                {{ __('pdf.camp_contract.date_from') }} {{ $camp->start_date->format('d/m/Y') }}
                {{ __('pdf.camp_contract.date_to') }} {{ $camp->end_date->format('d/m/Y') }}
            </span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.camp_contract.label_type') }}</span>
            <span class="pdf-info-value">{{ $camp->type->label() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.camp_contract.label_location') }}</span>
            <span class="pdf-info-value">
                {{ $camp->address }} {{ $camp->number }},
                {{ $camp->postal_code }} {{ $camp->city }}
            </span>
        </div>
    </div>

    {{-- Le participant --}}
    <div class="pdf-section">
        <div class="pdf-section-title">{{ __('pdf.camp_contract.section_participant') }}</div>

        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.camp_contract.label_name') }}</span>
            <span class="pdf-info-value">{{ $register->user->fullName() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.camp_contract.label_email') }}</span>
            <span class="pdf-info-value">{{ $register->user->email }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.camp_contract.label_phone') }}</span>
            <span class="pdf-info-value">{{ $register->user->phone }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.camp_contract.label_birth_date') }}</span>
            <span class="pdf-info-value">{{ $register->user->birth_date?->format('d/m/Y') }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.camp_contract.label_role') }}</span>
            <span class="pdf-info-value">{{ $register->user->role->label() }}</span>
        </div>
        @if($register->user->address)
            <div class="pdf-info-row">
                <span class="pdf-info-label">{{ __('pdf.camp_contract.label_address') }}</span>
                <span class="pdf-info-value">
                    {{ $register->user->address }} {{ $register->user->number }},
                    {{ $register->user->postal_code }} {{ $register->user->city }}
                </span>
            </div>
        @endif
        @if($register->user->diet)
            <div class="pdf-info-row">
                <span class="pdf-info-label">{{ __('pdf.camp_contract.label_diet') }}</span>
                <span class="pdf-info-value">{{ $register->user->diet->label() }}</span>
            </div>
        @endif
        @if($register->user->allergies)
            <div class="pdf-info-row">
                <span class="pdf-info-label">{{ __('pdf.camp_contract.label_allergies') }}</span>
                <span class="pdf-info-value">{{ $register->user->allergies }}</span>
            </div>
        @endif
        @if($register->notes)
            <div class="pdf-info-row">
                <span class="pdf-info-label">{{ __('pdf.camp_contract.label_notes') }}</span>
                <span class="pdf-info-value">{{ $register->notes }}</span>
            </div>
        @endif
    </div>

    {{-- Signature --}}
    <div class="pdf-section" style="margin-top: 40px;">
        <div class="pdf-section-title">{{ __('pdf.camp_contract.section_signatures') }}</div>
        <div style="display: flex; gap: 40px; margin-top: 16px;">
            <div style="flex: 1;">
                <p style="font-size: 10px; color: #6A6A88; margin-bottom: 40px;">{{ __('pdf.camp_contract.signature_participant') }}</p>
                <div style="border-top: 1px solid #C8A89A; padding-top: 6px; font-size: 10px; color: #1A1A2E;">
                    {{ $register->user->fullName() }}
                </div>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 10px; color: #6A6A88; margin-bottom: 40px;">{{ __('pdf.camp_contract.signature_org') }}</p>
                <div style="border-top: 1px solid #C8A89A; padding-top: 6px; font-size: 10px; color: #6A6A88;">
                    {{ __('pdf.camp_contract.signature_stamp') }}
                </div>
            </div>
        </div>
    </div>

@endsection
