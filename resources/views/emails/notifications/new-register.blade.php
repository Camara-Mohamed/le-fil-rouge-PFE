@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.new_registration') }}</h1>

    <p>
        <strong>{{ $participantName }}</strong>
        {{ __('emails.registered_to') }} {{ $modelLabel }} <strong>{{ $model->title }}</strong>.
    </p>
@endsection
