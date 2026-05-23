<x-public.auth title="{{ __('auth.forgot_password.title') }}">

    <a href="{{ route('login', ['locale'=>app()->getLocale()]) }}">Revenir à la page de connexion</a>

    <form method="POST" action="{{ route('password.email', ['locale'=>app()->getLocale()]) }}">
        @csrf

        <h2>{{ __('auth.forgot_password.title') }}</h2>

        <div>
            <label for="email">{{ __('auth.forgot_password.email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                placeholder="{{ __('auth.forgot_password.email_placeholder') }}"
                value="{{ old('email') }}"
                required
            >
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit">
            {{ __('auth.forgot_password.submit') }}
        </button>

    </form>
</x-public.auth>
