@php
    use App\Enums\UserRoles;
    use App\Enums\UserStatus;
@endphp

<div>

    <x-public.hero :title="$member->fullName()" />

    <div class="flex flex-col gap-6 px-4 py-8 md:px-8">

        <livewire:widgets::breadcrumb :items="[
            ['label' => __('breadcrumbs.members'), 'url' => route('admin.members.index', ['locale' => app()->getLocale()])],
            ['label' => $member->fullName(), 'url' => route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $member])],
            ['label' => __('breadcrumbs.edit')],
        ]" />

        <form wire:submit="save" class="flex flex-col gap-6">

            {{-- Identité --}}
            <section aria-labelledby="section-identity"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 id="section-identity" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.edit_section_identity') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-public.form.input :label="__('pages/members.edit_label_first_name')" name="first_name" wire:model.live="first_name" required minlength="2" maxlength="255" />
                    <x-public.form.input :label="__('pages/members.edit_label_last_name')" name="last_name" wire:model.live="last_name" required minlength="2" maxlength="255" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-public.form.input :label="__('pages/members.edit_label_phone')" name="phone" wire:model.live="phone" type="tel" />
                    <x-public.form.input :label="__('pages/members.edit_label_birth_date')" name="birth_date" wire:model.live="birth_date" type="date" />
                </div>
            </section>

            {{-- Accès --}}
            <section aria-labelledby="section-access"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 id="section-access" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.edit_section_access') }}</h2>
                <x-public.form.input :label="__('pages/members.edit_label_email')" name="email" wire:model.live="email" type="email" required />
            </section>

            {{-- Rôle & Statut --}}
            @canany(['changeRole', 'changeStatus'], $member)
            <section aria-labelledby="section-role"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h2 id="section-role" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.edit_section_role_status') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    @can('changeRole', $member)
                        <x-public.form.select
                            :label="__('pages/members.edit_label_role')"
                            name="role"
                            :options="UserRoles::cases()"
                            wire:model.live="role"
                            required
                        />
                    @endcan

                    @can('changeStatus', $member)
                        @if($role === UserRoles::ARRIVANT->value)
                            <div class="flex flex-col gap-2">
                                <span class="font-sans font-bold text-base text-dark">{{ __('pages/members.edit_label_status') }}</span>
                                <div class="h-11 px-4 flex items-center bg-bg rounded-lg border border-bg-dark">
                                    <span class="font-serif text-base text-dark-mid">{{ __('pages/members.edit_status_arrivant_note') }}</span>
                                </div>
                            </div>
                        @else
                            <x-public.form.select
                                :label="__('pages/members.edit_label_status')"
                                name="status"
                                :options="UserStatus::cases()"
                                wire:model.live="status"
                                required
                            />
                        @endif
                    @endcan

                </div>
            </section>
            @endcanany

            <button type="submit"
                    class="w-full py-4 bg-red text-white font-sans font-bold text-base rounded-lg hover:bg-red-mid transition duration-200">
                {{ __('pages/members.edit_btn_submit') }}
            </button>

        </form>
    </div>
</div>
