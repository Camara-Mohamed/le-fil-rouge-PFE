<div
    x-data="{
        show: false,
        init() {
            this.show = ! localStorage.getItem('cookie_consent');
        },
        choose(value) {
            localStorage.setItem('cookie_consent', value);
            this.show = false;
        },
    }"
    x-show="show"
    x-cloak
    x-transition
    class="fixed bottom-4 left-4 right-4 md:right-auto md:max-w-md z-50"
    role="dialog"
    aria-modal="false"
    aria-labelledby="cookie-banner-heading"
    aria-describedby="cookie-banner-desc"
>
    <div class="bg-bg border border-bg-dark rounded-3xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] p-6 flex flex-col gap-4">
        <h2 id="cookie-banner-heading" class="font-sans font-black text-2xl text-dark">
            {{ __('partials.cookie_banner.title') }}
        </h2>

        <p id="cookie-banner-desc" class="font-serif text-base text-dark-mid">
            {{ __('partials.cookie_banner.description') }}
        </p>

        <div class="flex items-center gap-3 flex-wrap">
            <button type="button" @click="choose('all')"
                class="px-6 py-3 rounded-full bg-dark text-white font-sans font-bold text-sm hover:bg-dark-mid transition duration-200">
                {{ __('partials.cookie_banner.accept_all') }}
            </button>
            <button type="button" @click="choose('essential')"
                class="px-6 py-3 rounded-full border-2 border-dark text-dark font-sans font-bold text-sm hover:bg-bg-mid transition duration-200">
                {{ __('partials.cookie_banner.essential_only') }}
            </button>
        </div>
    </div>
</div>
