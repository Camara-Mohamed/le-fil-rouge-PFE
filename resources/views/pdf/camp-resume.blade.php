@extends('pdf.layout')

@section('content')

    <div class="pdf-title">
        <h1>{{ $camp->title }}</h1>
        <p>{{ __('pdf.resume.subtitle_camp') }}</p>
    </div>

    {{-- Informations --}}
    <div class="pdf-section">
        <div class="pdf-section-title">{{ __('pdf.resume.section_general') }}</div>

        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.resume.label_dates') }}</span>
            <span class="pdf-info-value">
                {{ __('pdf.resume.date_from') }} {{ $camp->start_date->format('d/m/Y H:i') }}
                {{ __('pdf.resume.date_to') }} {{ $camp->end_date->format('d/m/Y H:i') }}
            </span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.resume.label_type') }}</span>
            <span class="pdf-info-value">{{ $camp->type->label() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.resume.label_creator') }}</span>
            <span class="pdf-info-value">{{ $camp->user->fullName() }}</span>
        </div>
        @if($camp->city)
            <div class="pdf-info-row">
                <span class="pdf-info-label">{{ __('pdf.resume.label_location') }}</span>
                <span class="pdf-info-value">
                    {{ $camp->address }} {{ $camp->number }},
                    {{ $camp->postal_code }} {{ $camp->city }}
                </span>
            </div>
        @endif
    </div>

    {{-- Stats --}}
    <div class="pdf-section">
        <div class="pdf-section-title">{{ __('pdf.resume.section_stats') }}</div>
        <div class="pdf-stats">
            <div class="pdf-stat accepted">
                <div class="pdf-stat-value">{{ $camp->acceptedRegisters->count() }}</div>
                <div class="pdf-stat-label">{{ __('pdf.resume.stat_accepted') }}</div>
            </div>
            <div class="pdf-stat pending">
                <div class="pdf-stat-value">{{ $camp->pendingRegisters->count() }}</div>
                <div class="pdf-stat-label">{{ __('pdf.resume.stat_pending') }}</div>
            </div>
            <div class="pdf-stat refused">
                <div class="pdf-stat-value">{{ $camp->refusedRegisters->count() }}</div>
                <div class="pdf-stat-label">{{ __('pdf.resume.stat_refused') }}</div>
            </div>
        </div>
    </div>

    {{-- Liste inscrits --}}
    <div class="pdf-section">
        <div class="pdf-section-title">{{ __('pdf.resume.section_registered', ['count' => $camp->acceptedRegisters->count()]) }}</div>
        <table>
            <thead>
                <tr>
                    <th>{{ __('pdf.resume.col_name') }}</th>
                    <th>{{ __('pdf.resume.col_email') }}</th>
                    <th>{{ __('pdf.resume.col_role') }}</th>
                    <th>{{ __('pdf.resume.col_notes') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($camp->acceptedRegisters as $register)
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
