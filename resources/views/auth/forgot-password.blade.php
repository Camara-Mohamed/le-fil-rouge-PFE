<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <h2>Reset Password</h2>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Réinitialiser</button>
</form>
