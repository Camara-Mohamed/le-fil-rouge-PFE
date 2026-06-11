@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.contact_title') }}</h1>

    <p><strong>{{ __('emails.contact_from') }} :</strong> {{ $contactMessage->full_name }} ({{ $contactMessage->email }})</p>
    <p><strong>{{ __('emails.contact_subject') }} :</strong> {{ $contactMessage->sujet }}</p>

    <hr class="divider">

    <p><strong>{{ __('emails.contact_message') }} :</strong></p>
    <p>{{ $contactMessage->message }}</p>
@endsection
