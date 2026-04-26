<form method="POST" action="{{ route('login') }}">
    @csrf
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="********" required>

    <button type="submit">Se connecter</button>

    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
</form>
