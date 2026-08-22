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
    class="fixed inset-x-0 bottom-0 z-50 w-full px-4 pb-4 md:px-6 md:pb-6"
    role="dialog"
    aria-modal="false"
    aria-labelledby="cookie-banner-heading"
    aria-describedby="cookie-banner-desc"
>
    <div class="max-w-7xl mx-auto bg-white border border-bg-dark rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] p-6 flex flex-col md:flex-row md:items-center gap-4 md:gap-8">
        <div class="flex flex-col gap-2 md:flex-1">
            <h2 id="cookie-banner-heading" class="font-sans font-black text-xl text-dark">
                {{ __('partials.cookie_banner.title') }}
            </h2>
            <p id="cookie-banner-desc" class="font-serif text-base text-dark-mid">
                {{ __('partials.cookie_banner.description') }}
            </p>
        </div>

        <div class="flex items-center gap-3 flex-wrap shrink-0">
            <button type="button" @click="choose('essential')"
                class="px-6 py-3 rounded-lg border-2 border-dark-light text-dark font-sans font-bold text-sm hover:border-dark transition duration-200">
                {{ __('partials.cookie_banner.essential_only') }}
            </button>
            <button type="button" @click="choose('all')"
                class="px-6 py-3 rounded-lg bg-red text-white font-sans font-bold text-sm hover:bg-red-mid transition duration-200">
                {{ __('partials.cookie_banner.accept_all') }}
            </button>
        </div>
    </div>
</div>
