<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <h2>Reset Password</h2>

    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="********" required>
    <input type="password" name="password_confirmation" placeholder="********" required>

    <button type="submit">Modifier le mot de passe</button>
</form>
