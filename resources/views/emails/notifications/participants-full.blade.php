@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.participants_full') }}</h1>

    <p>
        {{ ucfirst($modelLabel) }} <strong>{{ $model->title }}</strong>
        {{ __('emails.participants_full_line') }}
    </p>
    <p>{{ __('emails.participants_full_action') }}</p>
@endsection
