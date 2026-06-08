@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.volunteer_request_title') }}</h1>

    <p><strong>{{ __('emails.volunteer_request_name') }} :</strong> {{ $volunteerRequest->fullName() }}</p>
    <p><strong>{{ __('emails.volunteer_request_email') }} :</strong> {{ $volunteerRequest->email }}</p>
    <p><strong>{{ __('emails.volunteer_request_phone') }} :</strong> {{ $volunteerRequest->phone }}</p>

    <hr class="divider">

    <p><strong>{{ __('emails.volunteer_request_message') }} :</strong></p>
    <p>{{ $volunteerRequest->message }}</p>
@endsection
