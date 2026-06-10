@php
    use App\Enums\UserRoles;
    use App\Enums\UserStatus;
@endphp

<div>

    <x-public.hero :title="__('breadcrumbs.create_member')" />

    <div class="flex flex-col gap-6 px-4 py-8 md:px-8">

        <livewire:widgets::breadcrumb :items="[
            ['label' => __('breadcrumbs.members'), 'url' => route('admin.members.index', ['locale' => app()->getLocale()])],
            ['label' => __('breadcrumbs.create_member')],
        ]" />

        <form wire:submit="save" class="flex flex-col gap-6">

            {{-- Identité --}}
            <section aria-labelledby="section-identity"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 id="section-identity" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.create_section_identity') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-public.form.input :label="__('pages/members.create_label_first_name')" name="first_name" wire:model.live="first_name" required />
                    <x-public.form.input :label="__('pages/members.create_label_last_name')" name="last_name" wire:model.live="last_name" required />
                </div>
            </section>

            {{-- Accès --}}
            <section aria-labelledby="section-access"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 id="section-access" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.create_section_access') }}</h2>

                <x-public.form.input :label="__('pages/members.create_label_email')" name="email" wire:model.live="email" type="email" required />

                <div class="flex flex-col gap-2">
                    <label for="password" class="font-sans font-bold text-base text-dark">{{ __('pages/members.create_label_password') }}</label>
                    <div class="relative" x-data="{ show: false }">
                        <input id="password" name="password"
                               :type="show ? 'text' : 'password'"
                               wire:model.live="password"
                               class="h-11 px-4 pr-12 w-full bg-white border border-bg-dark rounded-lg font-serif font-medium text-base text-dark transition duration-200">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-dark-mid hover:text-dark transition">
                            <x-icons.eye x-show="!show" class="size-5" fill="fill-current" />
                            <x-icons.eye-slash x-show="show" class="size-5" fill="fill-current" />
                        </button>
                    </div>
                    @error('password')
                        <div class="px-4 py-1 bg-danger-bg border-l-[3px] border-danger">
                            <p class="font-serif text-sm text-danger">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </section>

            {{-- Rôle & Statut --}}
            <section aria-labelledby="section-role"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 id="section-role" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.create_section_role_status') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <x-public.form.select
                        :label="__('pages/members.create_label_role')"
                        name="role"
                        :options="UserRoles::cases()"
                        wire:model.live="role"
                    />

                    @if($role === UserRoles::ARRIVANT->value)
                        <div class="flex flex-col gap-2">
                            <span class="font-sans font-bold text-base text-dark">{{ __('pages/members.create_label_status') }}</span>
                            <div class="h-11 px-4 flex items-center bg-bg rounded-lg border border-bg-dark">
                                <span class="font-serif text-base text-dark-mid">{{ __('pages/members.create_status_arrivant_note') }}</span>
                            </div>
                        </div>
                    @else
                        <x-public.form.select
                            :label="__('pages/members.create_label_status')"
                            name="status"
                            :options="UserStatus::cases()"
                            wire:model.live="status"
                        />
                    @endif

                </div>
            </section>

            {{-- Email de bienvenue --}}
            <section aria-labelledby="section-notify"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-4">
                <h2 id="section-notify" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.create_section_notification') }}</h2>
                <x-public.form.input
                    :label="__('pages/members.create_label_send_to')"
                    name="send_to"
                    wire:model.live="send_to"
                    type="email"
                    placeholder="adresse@exemple.com"
                />
                <p class="font-serif text-sm text-dark-mid">{{ __('pages/members.create_send_to_hint') }}</p>
            </section>

            <div class="flex items-center gap-4">
                <button type="submit"
                        class="flex-1 py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                    {{ __('pages/members.create_btn_submit') }}
                </button>
                <a href="{{ route('admin.members.index', ['locale' => app()->getLocale()]) }}"
                   class="flex-1 py-4 text-center bg-bg text-dark font-sans font-bold text-base rounded-lg hover:bg-bg-mid transition duration-200">
                    {{ __('pages/members.create_btn_cancel') }}
                </a>
            </div>

        </form>
    </div>
</div>
