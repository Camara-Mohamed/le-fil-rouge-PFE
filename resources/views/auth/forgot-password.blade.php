<x-public.auth title="{{ __('auth.forgot_password.title') }}">

    @if(session('status'))
        <div class="w-full px-4 py-3 bg-success-bg border-l-[3px] border-success rounded-lg">
            <p class="font-serif text-sm text-success">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST"
          action="{{ route('password.email', ['locale' => app()->getLocale()]) }}"
          class="w-full flex flex-col gap-6">
        @csrf

        <h2 class="font-sans font-black text-2xl text-dark">{{ __('auth.forgot_password.title') }}</h2>

        <x-public.form.input
            type="email"
            name="email"
            :value="old('email')"
            :label="__('auth.forgot_password.email')"
            placeholder="{{ __('auth.forgot_password.email_placeholder') }}"
            autocomplete="email"
            :required="true"
        />

        <button type="submit"
                class="w-full py-3 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
            {{ __('auth.forgot_password.submit') }}
        </button>

    </form>

    <x-slot:more_cta>
        <p class="font-sans text-sm text-dark-mid text-center">
            <a href="{{ route('login', ['locale' => app()->getLocale()]) }}"
               class="text-red font-medium underline hover:text-red-mid transition duration-200">
                {{ __('auth.forgot_password.back') }}
            </a>
        </p>
    </x-slot:more_cta>

</x-public.auth>
