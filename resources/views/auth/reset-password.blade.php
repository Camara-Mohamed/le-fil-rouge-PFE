<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <h2>Reset Password</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <input type="hidden" name="_token" value="{{ $request->route('token') }}">

    <button type="submit">Modifier le mot de passe</button>
</form>
