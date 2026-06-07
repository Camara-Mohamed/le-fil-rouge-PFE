<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body>

<header>
    <h1>Bienvenue chez Le Fil Rouge !</h1>
</header>

<main>
    <p>Salut <strong>{{ $user->fullName() }}</strong> !</p>

    <p>Ton compte a été créé. Voici tes identifiants pour te connecter :</p>

    <p>
        <strong>Email :</strong>
        {{ $user->email }}
    </p>

    <p>
        <strong>Mot de passe :</strong>
        {{ $password }}
    </p>

    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}">Se connecter</a>

    <small>Pense à changer ton mot de passe dès ta première connexion.</small>
</main>

<footer>
    <p>Le Fil Rouge</p>
</footer>

</body>
</html>
