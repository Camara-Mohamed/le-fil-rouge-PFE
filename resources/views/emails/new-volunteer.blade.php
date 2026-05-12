<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body>

<header>
    <h1>Nouveau Membre</h1>
</header>

<main>
    <p>Bienvenue <strong>{{ $user->fullName() }}</strong> !</p>

    <p>Ton compte à été crée. Voici tes identifiants :</p>

    <p>
        <strong>Téléphone :</strong>
        {{ $user->email }}
    </p>

    <p>
        <strong>Message :</strong>
        {{ $password }}
    </p>

    <a href="{{ route('login') }}">Se connecter</a>

    <small>Oublie pas de changer de mdp.</small>
</main>

</body>
</html>
