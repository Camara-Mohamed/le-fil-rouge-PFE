<x-public.app title="Nous Contacter">

    <h2>Nous Contacter</h2>


    @if (session('send'))
        <p>{{ session('send') }}</p>
    @endif

    <form method="POST" action="{{ route('public.contact.store', ['locale' => app()->getLocale()]) }}">
        @csrf

        <div>
            <label for="full_name">{{ __('/public/contact.full_name') }}</label>
            <input
                id="full_name"
                type="text"
                name="full_name"
                value="{{ old('full_name') }}"
                required
            >
            @error('full_name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="email">{{ __('/public/contact.email') }}</label>
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
            <label for="sujet">{{ __('/public/contact.sujet') }}</label>
            <input
                id="sujet"
                type="text"
                name="sujet"
                value="{{ old('sujet') }}"
                required
            >
            @error('sujet')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="message">{{ __('/public/contact.message') }}</label>
            <textarea
                id="message"
                name="message"
                required
            >{{ old('message') }}</textarea>
            @error('message')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">{{ __('/public/contact.submit') }}</button>

    </form>

    // Héro

    // Coordonnées | Formulaire de contact

    // Liste des partenaires

</x-public.app>
