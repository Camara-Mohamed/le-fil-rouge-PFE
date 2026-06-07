<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body>

<header>
    <h1>Salut {{ $volunteerRequest->fullName() }} !</h1>
</header>

<main>
    <p>
        On a bien reçu ta demande pour rejoindre le Fil Rouge. On te recontacte rapidement pour la suite !
    </p>
</main>

<footer>
    <p>
        L'équipe du Fil Rouge
    </p>
</footer>

</body>
</html>
