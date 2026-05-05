<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body>

<header>
    <h1>Nouvelle demande de volontaire</h1>
</header>

<main>
    <p>
        <strong>Nom :</strong>
        {{ $volunteerRequest->fullName() }}
    </p>

    <p>
        <strong>Email :</strong>
        {{ $volunteerRequest->email }}
    </p>

    <p>
        <strong>Téléphone :</strong>
        {{ $volunteerRequest->phone }}
    </p>

    <p>
        <strong>Message :</strong>
    </p>

    <p>
        {{ $volunteerRequest->message }}
    </p>
</main>

</body>
</html>
