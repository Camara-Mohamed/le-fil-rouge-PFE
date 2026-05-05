<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body>

<header>
    <h1>Nouveau message de contact</h1>
</header>

<main>
    <p>
        <strong>De :</strong>
        {{ $contactMessage->full_name }} ({{ $contactMessage->email }})
    </p>

    <p>
        <strong>Sujet :</strong>
        {{ $contactMessage->sujet }}
    </p>

    <p>
        <strong>Message :</strong>
    </p>

    <p>
        {{ $contactMessage->message }}
    </p>
</main>

</body>
</html>
