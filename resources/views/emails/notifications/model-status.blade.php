@extends('emails.layout')

@section('content')
    <h1>{{ ucfirst($modelLabel) }} {{ $published ? __('emails.published') : __('emails.refused') }}</h1>

    <p>
        {{ __('emails.model_status_line', [
            'modelLabel' => $modelLabel,
            'title'      => $model->title,
            'action'     => $published ? __('emails.published') : __('emails.refused'),
        ]) }}
    </p>
@endsection
