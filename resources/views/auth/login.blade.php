<x-public.auth title="{{ __('auth.login.title') }}">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2>{{ __('auth.login.title') }}</h2>

        <div>
            <label for="email">{{ __('auth.login.email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                placeholder="{{ __('auth.login.email_placeholder') }}"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div>
            <label for="password">{{ __('auth.login.password') }}</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="{{ __('auth.login.password_placeholder') }}"
                required
            >
        </div>

        <button type="submit">
            {{ __('auth.login.submit') }}
        </button>

        <a href="{{ route('password.request') }}">
            {{ __('auth.login.forgot_password') }}
        </a>

    </form>
</x-public.auth>
