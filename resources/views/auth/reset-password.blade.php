<x-public.auth title="{{ __('auth.reset.title') }}" :back="false">

    <form method="POST"
          action="{{ route('password.update', ['locale' => app()->getLocale()]) }}"
          class="w-full flex flex-col gap-6">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <h2 class="font-sans font-black text-2xl text-dark">{{ __('auth.reset.title') }}</h2>

        <x-public.form.input
            type="email"
            name="email"
            :value="old('email')"
            :label="__('auth.reset.email')"
            placeholder="{{ __('auth.reset.email_placeholder') }}"
            :required="true"
        />

        <div x-data="{ show: false }" class="flex flex-col gap-2">
            <label for="password" class="font-sans font-bold text-base text-dark">
                {{ __('auth.reset.password') }} <span class="text-red">*</span>
            </label>
            <div class="relative">
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    placeholder="{{ __('auth.reset.password_placeholder') }}"
                    required
                    class="h-11 px-4 pr-12 w-full bg-white border border-bg-dark rounded-lg font-serif font-medium text-base text-dark placeholder:text-dark-mid placeholder:font-normal transition duration-200"
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

        <div x-data="{ show: false }" class="flex flex-col gap-2">
            <label for="password_confirmation" class="font-sans font-bold text-base text-dark">
                {{ __('auth.reset.password_confirmation') }} <span class="text-red">*</span>
            </label>
            <div class="relative">
                <input
                    id="password_confirmation"
                    :type="show ? 'text' : 'password'"
                    name="password_confirmation"
                    placeholder="{{ __('auth.reset.password_placeholder') }}"
                    required
                    class="h-11 px-4 pr-12 w-full bg-white border border-bg-dark rounded-lg font-serif font-medium text-base text-dark placeholder:text-dark-mid placeholder:font-normal transition duration-200"
                />
                <button type="button" @click="show = !show"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-dark-mid hover:text-dark transition duration-200">
                    <x-icons.eye class="size-5" x-show="!show" />
                    <x-icons.eye-slash class="size-5" x-show="show" style="display:none" />
                </button>
            </div>
            @error('password_confirmation')
                <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                    <p class="font-serif text-sm text-danger">{{ $message }}</p>
                </div>
            @enderror
        </div>

        <button type="submit"
                class="w-full py-3 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
            {{ __('auth.reset.submit') }}
        </button>

    </form>

</x-public.auth>
