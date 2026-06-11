@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.upcoming_event') }}</h1>

    <p>{{ __('emails.upcoming_event_line1', ['title' => $model->title]) }}</p>
    <p>{{ __('emails.upcoming_event_line2', ['date' => $model->start_date->translatedFormat('d MMMM Y')]) }}</p>
@endsection
