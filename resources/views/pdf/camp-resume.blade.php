<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
</head>
<body>

<h1>{{ $camp->title }}</h1>

<p>
    Du {{ $camp->start_date->format('d/m/Y H:i') }}
    au {{ $camp->end_date->format('d/m/Y H:i') }}
</p>
<p>Type : {{ $camp->type->label() }}</p>
<p>Créateur : {{ $camp->user->fullName() }}</p>
@if($camp->city)
    <p>Lieu : {{ $camp->address }} {{ $camp->number }}, {{ $camp->postal_code }} {{ $camp->city }}</p>
@endif

<h2>Statistiques</h2>
<p>Acceptés : {{ $camp->acceptedRegisters->count() }}</p>
<p>En attente : {{ $camp->pendingRegisters->count() }}</p>
<p>Refusés : {{ $camp->refusedRegisters->count() }}</p>

<h2>Inscrits ({{ $camp->acceptedRegisters->count() }})</h2>
<table>
    <thead>
    <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>Rôle</th>
        <th>Notes</th>
    </tr>
    </thead>
    <tbody>
    @foreach($camp->acceptedRegisters as $register)
        <tr>
            <td>{{ $register->user->fullName() }}</td>
            <td>{{ $register->user->email }}</td>
            <td>{{ $register->user->role->label() }}</td>
            <td>{{ $register->notes }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
