<x-public.auth title="{{ __('auth.password.title') }}">
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <h2>{{ __('auth.password.title') }}</h2>

        <div>
            <label for="email">{{ __('auth.password.email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                placeholder="{{ __('auth.password.email_placeholder') }}"
                value="{{ old('email') }}"
                required
            >
        </div>

        <button type="submit">
            {{ __('auth.password.submit') }}
        </button>

    </form>
</x-public.auth>
