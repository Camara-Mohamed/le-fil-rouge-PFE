@extends('pdf.layout')

@section('content')

    <div class="pdf-title">
        <h1>{{ $training->title }}</h1>
        <p>{{ __('pdf.resume.subtitle_training') }}</p>
    </div>

    {{-- Informations --}}
    <div class="pdf-section">
        <div class="pdf-section-title">{{ __('pdf.resume.section_general') }}</div>

        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.resume.label_dates') }}</span>
            <span class="pdf-info-value">
                {{ __('pdf.resume.date_from') }} {{ $training->start_date->format('d/m/Y H:i') }}
                {{ __('pdf.resume.date_to') }} {{ $training->end_date->format('d/m/Y H:i') }}
            </span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.resume.label_type') }}</span>
            <span class="pdf-info-value">{{ $training->type->label() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.resume.label_price') }}</span>
            <span class="pdf-info-value">{{ $training->getFormattedPrice() }}</span>
        </div>
        <div class="pdf-info-row">
            <span class="pdf-info-label">{{ __('pdf.resume.label_creator') }}</span>
            <span class="pdf-info-value">{{ $training->user->fullName() }}</span>
        </div>
        @if($training->city)
            <div class="pdf-info-row">
                <span class="pdf-info-label">{{ __('pdf.resume.label_location') }}</span>
                <span class="pdf-info-value">
                    {{ $training->address }} {{ $training->number }},
                    {{ $training->postal_code }} {{ $training->city }}
                </span>
            </div>
        @endif
    </div>

    {{-- Stats --}}
    <div class="pdf-section">
        <div class="pdf-section-title">{{ __('pdf.resume.section_stats') }}</div>
        <div class="pdf-stats">
            <div class="pdf-stat accepted">
                <div class="pdf-stat-value">{{ $training->acceptedRegisters->count() }}</div>
                <div class="pdf-stat-label">{{ __('pdf.resume.stat_accepted') }}</div>
            </div>
            <div class="pdf-stat pending">
                <div class="pdf-stat-value">{{ $training->pendingRegisters->count() }}</div>
                <div class="pdf-stat-label">{{ __('pdf.resume.stat_pending') }}</div>
            </div>
            <div class="pdf-stat refused">
                <div class="pdf-stat-value">{{ $training->refusedRegisters->count() }}</div>
                <div class="pdf-stat-label">{{ __('pdf.resume.stat_refused') }}</div>
            </div>
        </div>
    </div>

    {{-- Liste inscrits --}}
    <div class="pdf-section">
        <div class="pdf-section-title">{{ __('pdf.resume.section_registered', ['count' => $training->acceptedRegisters->count()]) }}</div>
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
