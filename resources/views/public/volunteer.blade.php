<x-public.app title="Devenir Volontaire">

    <h2>Devenir Volontaire</h2>

    @if (session('send'))
        <p>{{ session('send') }}</p>
    @endif

    <form method="POST" action="{{ route('public.volunteer.store', ['locale' => app()->getLocale()]) }}">
        @csrf

        <div>
            <label for="first_name">{{ __('/public/volunteer-request.first_name') }}</label>
            <input
                id="first_name"
                type="text"
                name="first_name"
                value="{{ old('first_name') }}"
                required
            >
            @error('first_name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="last_name">{{ __('/public/volunteer-request.last_name') }}</label>
            <input
                id="last_name"
                type="text"
                name="last_name"
                value="{{ old('last_name') }}"
                required
            >
            @error('last_name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">{{ __('/public/volunteer-request.email') }}</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
            @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="phone">{{ __('/public/volunteer-request.phone') }}</label>
            <input
                id="phone"
                type="tel"
                name="phone"
                value="{{ old('phone') }}"
                required
            >
            @error('phone')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="message">{{ __('/public/volunteer-request.message') }}</label>
            <textarea
                id="message"
                name="message"
                required
            >{{ old('message') }}</textarea>
            @error('message')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">{{ __('/public/volunteer-request.submit') }}</button>

    </form>

    // Héro

    // Texte + Image + CTA (Encre Nommé)

    // Formulaire

</x-public.app>
