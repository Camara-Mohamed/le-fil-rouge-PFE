@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.volunteer_confirmation_title') }}</h1>

    <p>{{ __('emails.volunteer_confirmation_hello', ['name' => $volunteerRequest->fullName()]) }}</p>
    <p>{{ __('emails.volunteer_confirmation_body') }}</p>

    <hr class="divider">

    <p><strong>{{ __('emails.volunteer_confirmation_sign') }}</strong></p>
@endsection
