@php use App\Enums\TrainingStatus; @endphp
<x-public.auth title="{{ __('auth.login.title') }}">

    <a href="{{ route('public.home', ['locale' => app()->getLocale()]) }}">Revenir à la page d'accueil</a>

    <form method="POST" action="{{ route('login', ['locale'=>app()->getLocale()]) }}">
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

        <div x-data="{ show: false }">
            <label for="password">{{ __('auth.login.password') }}</label>

            <input
                id="password"
                :type="show ? 'text' : 'password'"
                name="password"
                placeholder="{{ __('auth.login.password_placeholder') }}"
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
            {{ __('auth.login.submit') }}
        </button>

        <a href="{{ route('password.request', ['locale'=>app()->getLocale()]) }}">
            {{ __('auth.login.forgot_password') }}
        </a>

        <p>Vous n'êtes pas encore membre ? <a href="{{ route('public.volunteer', ['locale' => app()->getLocale()])
        }}">Devenez volontaire</a></p>

    </form>

    // Retour

    // Présentation

    // Formulaire + CTA (Volontaire)


</x-public.auth>
