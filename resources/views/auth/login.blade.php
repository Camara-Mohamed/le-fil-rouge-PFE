<x-public.auth title="{{ __('auth.login.title') }}">

    <form method="POST"
          action="{{ route('login', ['locale' => app()->getLocale()]) }}"
          class="w-full flex flex-col gap-6">
        @csrf

        <h2 class="font-sans font-black text-2xl text-dark">{{ __('auth.login.title') }}</h2>

        <x-public.form.input
            type="email"
            name="email"
            :value="old('email')"
            :label="__('auth.login.email')"
            placeholder="{{ __('auth.login.email_placeholder') }}"
            :required="true"
        />

        <div x-data="{ show: false }" class="flex flex-col gap-2">
            <label for="password" class="font-sans font-bold text-base text-dark">
                {{ __('auth.login.password') }} <span class="text-red">*</span>
            </label>
            <div class="relative">
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    placeholder="{{ __('auth.login.password_placeholder') }}"
                    required
                    class="h-11 px-4 pr-12 w-full bg-white border border-bg-dark rounded-lg font-serif font-medium text-base text-dark placeholder:text-dark-mid transition duration-200"
                />
                <button type="button" @click="show = !show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-dark-mid hover:text-dark transition duration-200">
                    <x-icons.eye class="size-5" x-show="!show" />
                    <x-icons.eye-slash class="size-5" x-show="show" style="display:none" />
                </button>
            </div>
            @error('password')
                <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                    <p class="font-serif text-sm text-danger">{{ $message }}</p>
                </div>
            @enderror
        </div>

        <div class="flex justify-between items-center">
            <label class="flex items-center gap-2 font-sans text-sm text-dark cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-bg-dark" />
                {{ __('auth.login.remember_me') }}
            </label>
            <a href="{{ route('password.request', ['locale' => app()->getLocale()]) }}"
               class="font-sans text-sm text-red hover:text-red-mid underline transition duration-200">
                {{ __('auth.login.forgot_password') }}
            </a>
        </div>

        <button type="submit"
                class="w-full py-3 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
            {{ __('auth.login.submit') }}
        </button>

    </form>

    <div class="flex flex-col gap-4">
        <hr class="border-bg-dark" />

        <p class="font-sans text-sm text-dark-mid text-center">
            {{ __('auth.login.no_account') }}
            <a href="{{ route('public.volunteer', ['locale' => app()->getLocale()]) }}"
               class="text-red font-medium underline hover:text-red-mid transition duration-200">
                {{ __('auth.login.be_volunteer') }}
            </a>
        </p>
    </div>

</x-public.auth>
