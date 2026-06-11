@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.new_comment') }}</h1>

    <p>
        <strong>{{ $author->fullName() }}</strong>
        {{ __('emails.left_comment_on') }} <strong>{{ $model->title }}</strong>.
    </p>
@endsection
