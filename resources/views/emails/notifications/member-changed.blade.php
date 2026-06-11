@extends('emails.layout')

@section('content')
    <h1>{{ __('emails.member_changed_subject') }}</h1>

    @if($newRole)
        <p>{{ __('emails.member_changed_role') }} <strong>{{ $newRole }}</strong></p>
    @endif

    @if($newStatus)
        <p>{{ __('emails.member_changed_status') }} <strong>{{ $newStatus }}</strong></p>
    @endif
@endsection
