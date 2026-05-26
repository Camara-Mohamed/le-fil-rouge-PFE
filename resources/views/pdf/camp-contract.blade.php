<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
</head>
<body>

<h1>Contrat - {{ $camp->title }}</h1>

<h2>Le camp</h2>
<p><strong>Dates :</strong> {{ $camp->start_date->format('d/m/Y') }} au {{ $camp->end_date->format('d/m/Y') }}</p>
<p><strong>Type :</strong> {{ $camp->type->label() }}</p>
<p><strong>Lieu :</strong> {{ $camp->address }} {{ $camp->number }}, {{ $camp->postal_code }} {{ $camp->city
 }}</p>

<h2>Le participant</h2>
<div><strong>Nom :</strong> {{ $register->user->fullName() }}</div>
<div><strong>Email :</strong> {{ $register->user->email }}</div>
<div><strong>Téléphone :</strong> {{ $register->user->phone }}</div>
<div><strong>Date de naissance :</strong> {{ $register->user->birth_date?->format('d/m/Y') }}</div>
<div><strong>Rôle :</strong> {{ $register->user->role->label() }}</div>
@if($register->user->address)
    <div><strong>Adresse :</strong> {{ $register->user->address }} {{ $register->user->number }}, {{
    $register->user->postal_code }} {{ $register->user->city }}</div>
@endif
@if($register->user->diet)
    <div><strong>Régime :</strong> {{ $register->user->diet->label() }}</div>
@endif
@if($register->user->allergies)
    <div><strong>Allergies :</strong> {{ $register->user->allergies }}</div>
@endif
@if($register->notes)
    <div><strong>Notes :</strong> {{ $register->notes }}</div>
@endif

</body>
</html>
