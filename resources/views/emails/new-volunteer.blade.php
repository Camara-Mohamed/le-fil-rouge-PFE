@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.new_volunteer_title') }}</h1>

    <p>{{ __('emails.new_volunteer_hello', ['name' => $user->fullName()]) }}</p>
    <p>{{ __('emails.new_volunteer_created') }}</p>

    <hr class="divider">

    <p><strong>{{ __('emails.new_volunteer_email') }} :</strong> {{ $user->email }}</p>
    <p><strong>{{ __('emails.new_volunteer_password') }} :</strong> {{ $password }}</p>

    <hr class="divider">

    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="btn">
        {{ __('emails.new_volunteer_cta') }}
    </a>

    <p class="note">{{ __('emails.new_volunteer_note') }}</p>
@endsection
