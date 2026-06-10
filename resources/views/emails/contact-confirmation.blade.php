@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.contact_confirmation_title') }}</h1>

    <p>{{ __('emails.contact_confirmation_hello', ['name' => $contactMessage->full_name]) }}</p>
    <p>{{ __('emails.contact_confirmation_body') }}</p>

    <hr class="divider">

    <p><strong>{{ __('emails.contact_confirmation_sign') }}</strong></p>
@endsection
