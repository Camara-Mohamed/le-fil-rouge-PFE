@extends('emails.layout')

@section('content')
    <h1>{{ ucfirst($modelLabel) }} {{ $created ? __('emails.created') : __('emails.modified') }}</h1>

    <p>
        <strong>{{ $author->fullName() }}</strong>
        {{ $created ? __('emails.has_created') : __('emails.has_modified') }}
        {{ $modelLabel }} <strong>{{ $model->title }}</strong>.
    </p>
@endsection
