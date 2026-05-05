<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body>

<header>
    <h1>Bonjour {{ $volunteerRequest->fullName() }},</h1>
</header>

<main>
    <p>
        Nous avons reçu votre demande.
    </p>
</main>

<footer>
    <p>
        Le Fil Rouge
    </p>
</footer>

</body>
</html>
