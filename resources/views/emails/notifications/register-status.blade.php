@extends('emails.layout')

@section('content')
    @if($accepted)
        <h1>{{ __('emails.registration_accepted') }}</h1>
        <p>{{ __('emails.registration_accepted_line', ['title' => $model->title]) }}</p>
    @else
        <h1>{{ __('emails.registration_refused') }}</h1>
        <p>{{ __('emails.registration_refused_line', ['title' => $model->title]) }}</p>
    @endif
@endsection
