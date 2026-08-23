<section aria-labelledby="section-volunteer-form"
         class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)]">

    <h2 id="section-volunteer-form" class="font-sans font-black text-3xl text-dark mb-8">
        {{ __('public/volunteer-request.form_title') }}
    </h2>

    @if(session('send'))
        <div class="mb-6 px-4 py-3 bg-success-bg border-l-[3px] border-success rounded">
            <p class="font-serif text-sm text-success">{{ session('send') }}</p>
        </div>
    @endif

    <form method="POST"
          action="{{ route('public.volunteer.store', ['locale' => app()->getLocale()]) }}"
          class="flex flex-col gap-6">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <x-public.form.input
                type="text"
                name="first_name"
                :value="old('first_name')"
                :label="__('public/volunteer-request.first_name')"
                placeholder="{{ __('public/volunteer-request.first_name_placeholder') }}"
                maxlength="255"
                :required="true"
            />
            <x-public.form.input
                type="text"
                name="last_name"
                :value="old('last_name')"
                :label="__('public/volunteer-request.last_name')"
                placeholder="{{ __('public/volunteer-request.last_name_placeholder') }}"
                maxlength="255"
                :required="true"
            />
        </div>

        <x-public.form.input
            type="email"
            name="email"
            :value="old('email')"
            :label="__('public/volunteer-request.email')"
            placeholder="{{ __('public/volunteer-request.email_placeholder') }}"
            maxlength="255"
            :required="true"
        />

        <x-public.form.input
            type="tel"
            name="phone"
            :value="old('phone')"
            :label="__('public/volunteer-request.phone')"
            placeholder="{{ __('public/volunteer-request.phone_placeholder') }}"
            maxlength="20"
            :required="true"
        />

        <x-public.form.textarea
            name="message"
            :label="__('public/volunteer-request.message')"
            placeholder="{{ __('public/volunteer-request.message_placeholder') }}"
            maxlength="5000"
            :required="true"
        >{{ old('message') }}</x-public.form.textarea>

        <button type="submit"
                class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200 capitalize">
            {{ __('public/volunteer-request.submit') }}
        </button>

    </form>
</section>
