<x-public.auth title="{{ __('auth.reset.title') }}">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <h2>{{ __('auth.reset.title') }}</h2>

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email">{{ __('auth.reset.email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                placeholder="{{ __('auth.reset.email_placeholder') }}"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div x-data="{ show: false }">
            <label for="password">{{ __('auth.reset.password') }}</label>
            <input
                id="password"
                :type="show ? 'text' : 'password'"
                name="password"
                placeholder="{{ __('auth.reset.password_placeholder') }}"
                required
            >
            <button
                type="button"
                @click="show = !show"
            >
                <span x-show="!show">Afficher</span>
                <span x-show="show">Cacher</span>
            </button>
        </div>

        <div x-data="{ show: false }">
            <label for="password_confirmation">{{ __('auth.reset.password_confirmation') }}</label>
            <input
                id="password_confirmation"
                :type="show ? 'text' : 'password'"
                name="password_confirmation"
                placeholder="{{ __('auth.reset.password_placeholder') }}"
                required
            >
            <button
                type="button"
                @click="show = !show"
            >
                <span x-show="!show">Afficher</span>
                <span x-show="show">Cacher</span>
            </button>
        </div>

        <button type="submit">
            {{ __('auth.reset.submit') }}
        </button>

    </form>
</x-public.auth>
