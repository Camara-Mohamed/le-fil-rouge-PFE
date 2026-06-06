<section aria-labelledby="section-contact-form"
         class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)]">

    <h2 id="section-contact-form" class="font-sans font-black text-3xl text-dark mb-8">
        {{ __('public/contact.form_title') }}
    </h2>

    @if(session('send'))
        <div class="mb-6 px-4 py-3 bg-success-bg border-l-[3px] border-success rounded">
            <p class="font-serif text-sm text-success">{{ session('send') }}</p>
        </div>
    @endif

    <form method="POST"
          action="{{ route('public.contact.store', ['locale' => app()->getLocale()]) }}"
          class="flex flex-col gap-6">
        @csrf

        <x-public.form.input
            type="text"
            name="full_name"
            :value="old('full_name')"
            :label="__('public/contact.full_name')"
            placeholder="Dylan Piquin"
            :required="true"
        />

        <x-public.form.input
            type="email"
            name="email"
            :value="old('email')"
            :label="__('public/contact.email')"
            placeholder="dylan.piquin@lefilrouge.be"
            :required="true"
        />

        <x-public.form.input
            type="text"
            name="sujet"
            :value="old('sujet')"
            :label="__('public/contact.sujet')"
            placeholder="Demande d'inscription, question générale…"
            :required="true"
        />

        <x-public.form.textarea
            name="message"
            :label="__('public/contact.message')"
            placeholder="Écris ton message ici…"
            :required="true"
        >{{ old('message') }}</x-public.form.textarea>

        <button type="submit"
                class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200 capitalize">
            {{ __('public/contact.submit') }}
        </button>

    </form>
</section>
