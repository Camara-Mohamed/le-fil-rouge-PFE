@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.announcement_subject', ['title' => $announcement->title]) }}</h1>

    <p>{{ $announcement->description }}</p>
@endsection
