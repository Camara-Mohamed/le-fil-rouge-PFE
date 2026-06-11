@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.document_subject', ['name' => $member->fullName()]) }}</h1>

    <p>
        <strong>{{ $member->fullName() }}</strong>
        {{ __('emails.document_sent') }}
    </p>
@endsection
