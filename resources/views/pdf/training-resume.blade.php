<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
</head>
<body>

<h1>{{ $training->title }}</h1>

<p>
    Du {{ $training->start_date->format('d/m/Y H:i') }}
    au {{ $training->end_date->format('d/m/Y H:i') }}
</p>
<p>Type : {{ $training->type->label() }}</p>
<p>Prix : {{ $training->getFormattedPrice() }}</p>
<p>Créateur : {{ $training->user->fullName() }}</p>
@if($training->city)
    <p>Lieu : {{ $training->address }} {{ $training->number }}, {{ $training->postal_code }} {{ $training->city }}</p>
@endif

<h2>Statistiques</h2>
<p>Acceptés : {{ $training->acceptedRegisters->count() }}</p>
<p>En attente : {{ $training->pendingRegisters->count() }}</p>
<p>Refusés : {{ $training->refusedRegisters->count() }}</p>

<h2>Inscrits ({{ $training->acceptedRegisters->count() }})</h2>
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
    @foreach($training->acceptedRegisters as $register)
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
