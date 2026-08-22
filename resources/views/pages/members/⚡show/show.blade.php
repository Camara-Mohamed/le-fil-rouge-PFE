@php
    use Illuminate\Support\Facades\Storage;
    use App\Enums\UserStatus;
    use App\Enums\RegisterStatus;

    $initials = strtoupper($member->first_name[0] . $member->last_name[0]);
    $sizes    = config('avatar.sizes');

    $statusVariant = match($member->status) {
        UserStatus::COMPLETE   => 'success',
        UserStatus::PENDING    => 'warning',
        UserStatus::INCOMPLETE => 'danger',
        UserStatus::ARCHIVED   => 'danger',
    };
@endphp

<div>

    <x-public.hero :title="$member->fullName()" />

    <div class="flex flex-col gap-6 px-4 py-8 md:px-8">

        <div class="flex items-center justify-between gap-4 flex-wrap">
            <livewire:widgets::breadcrumb :items="[
                ['label' => __('breadcrumbs.members'), 'url' => route('admin.members.index', ['locale' => app()->getLocale()])],
                ['label' => $member->fullName()],
            ]" />

            <div class="flex items-center gap-3 shrink-0 flex-wrap">
                @if($member->isArchived())
                    @can('restore', $member)
                        <button type="button" wire:click="restore"
                                class="font-sans font-bold text-sm text-success underline hover:text-red transition duration-200">
                            {{ __('pages/members.show_restore') }}
                        </button>
                    @endcan
                    @can('forceDelete', $member)
                        <button type="button" wire:click="openConfirmForceDeleteModal"
                                class="font-sans font-bold text-sm text-danger underline hover:text-red transition duration-200">
                            {{ __('pages/members.show_force_delete') }}
                        </button>
                    @endcan
                @else
                    <a href="{{ route('admin.members.edit', ['locale' => app()->getLocale(), 'member' => $member]) }}"
                       wire:navigate
                       class="font-sans font-bold text-sm text-dark underline hover:text-red transition duration-200">
                        {{ __('pages/members.show_edit') }}
                    </a>
                    @can('delete', $member)
                        <button type="button" wire:click="openConfirmDeleteModal"
                                class="font-sans font-bold text-sm text-danger underline hover:text-red transition duration-200">
                            {{ __('pages/members.show_archive') }}
                        </button>
                    @endcan
                    @can('forceDelete', $member)
                        <button type="button" wire:click="openConfirmForceDeleteModal"
                                class="font-sans font-bold text-sm text-danger underline hover:text-red transition duration-200">
                            {{ __('pages/members.show_force_delete') }}
                        </button>
                    @endcan
                @endif
            </div>
        </div>

        <section aria-labelledby="member-heading"
                 class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col sm:flex-row items-start sm:items-center gap-6">

            @if($member->avatar_path)
                <a href="{{ Storage::url('avatars/originals/' . $member->avatar_path) }}" data-fancybox="avatar">
                    <img
                        src="{{ Storage::url('avatars/originals/' . $member->avatar_path) }}"
                        srcset="@foreach($sizes as $size){{ Storage::url(sprintf(config('avatar.variant_pattern'), $size['width'], $size['height']) . '/' . $member->avatar_path) }} {{ $size['width'] }}w,@endforeach"
                        alt="{{ __('pages/members.show_avatar_alt', ['name' => $member->fullName()]) }}"
                        class="size-24 rounded-full object-cover ring-4 ring-white shadow shrink-0 cursor-pointer"
                    >
                </a>
            @else
                <div class="size-24 rounded-full bg-bg-dark ring-4 ring-white shadow flex items-center justify-center font-sans font-black text-2xl text-dark shrink-0">
                    {{ $initials }}
                </div>
            @endif

            <div class="flex flex-col gap-2">
                <h2 id="member-heading" class="font-sans font-black text-3xl text-dark">{{ $member->fullName() }}</h2>
                <div class="flex flex-wrap gap-2">
                    <x-public.badge variant="info">{{ $member->role->label() }}</x-public.badge>
                    <x-public.badge :variant="$statusVariant">{{ $member->status->label() }}</x-public.badge>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Informations personnelles --}}
            <section aria-labelledby="info-heading"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h3 id="info-heading" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.show_section_personal_info') }}</h3>

                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-0.5">
                        <span class="font-sans font-semibold text-xs uppercase tracking-wider text-dark-mid">{{ __('pages/members.show_label_email') }}</span>
                        <a href="mailto:{{ $member->email }}"
                           class="font-serif text-base text-dark hover:text-red transition">{{ $member->email }}</a>
                    </div>

                    @if($member->phone)
                        <div class="flex flex-col gap-0.5">
                            <span class="font-sans font-semibold text-xs uppercase tracking-wider text-dark-mid">{{ __('pages/members.show_label_phone') }}</span>
                            <a href="tel:{{ $member->phone }}"
                               class="font-serif text-base text-dark hover:text-red transition">{{ $member->phone }}</a>
                        </div>
                    @endif

                    @if($member->birth_date)
                        <div class="flex flex-col gap-0.5">
                            <span class="font-sans font-semibold text-xs uppercase tracking-wider text-dark-mid">{{ __('pages/members.show_label_birth_date') }}</span>
                            <p class="font-serif text-base text-dark">
                                {{ $member->birth_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY') }}
                                <span class="text-dark-mid">({{ $member->getAge() }} {{ __('pages/members.show_age_suffix') }})</span>
                            </p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- Adresse --}}
            @if($member->address || $member->city)
                <section aria-labelledby="address-heading"
                         class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                    <h3 id="address-heading" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.show_section_address') }}</h3>

                    <div class="flex flex-col gap-4">
                        @if($member->address)
                            <div class="flex flex-col gap-0.5">
                                <span class="font-sans font-semibold text-xs uppercase tracking-wider text-dark-mid">{{ __('pages/members.show_label_street') }}</span>
                                <p class="font-serif text-base text-dark">{{ $member->address }} {{ $member->number }}</p>
                            </div>
                        @endif
                        @if($member->city)
                            <div class="flex flex-col gap-0.5">
                                <span class="font-sans font-semibold text-xs uppercase tracking-wider text-dark-mid">{{ __('pages/members.show_label_city') }}</span>
                                <p class="font-serif text-base text-dark">{{ $member->postal_code }} {{ $member->city }}</p>
                            </div>
                        @endif
                        @if($member->province)
                            <div class="flex flex-col gap-0.5">
                                <span class="font-sans font-semibold text-xs uppercase tracking-wider text-dark-mid">{{ __('pages/members.show_label_province') }}</span>
                                <p class="font-serif text-base text-dark">{{ $member->province->label() }}</p>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            {{-- Régime alimentaire --}}
            @if($member->diet)
                <section aria-labelledby="diet-heading"
                         class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                    <h3 id="diet-heading" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.show_section_diet') }}</h3>

                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col gap-0.5">
                            <span class="font-sans font-semibold text-xs uppercase tracking-wider text-dark-mid">{{ __('pages/members.show_label_diet') }}</span>
                            <p class="font-serif text-base text-dark">{{ $member->diet->label() }}</p>
                        </div>
                        @if($member->allergies)
                            <div class="flex flex-col gap-0.5">
                                <span class="font-sans font-semibold text-xs uppercase tracking-wider text-dark-mid">{{ __('pages/members.show_label_allergies') }}</span>
                                <p class="font-serif text-base text-dark">{{ $member->allergies }}</p>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            {{-- Documents --}}
            <section aria-labelledby="docs-heading"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h3 id="docs-heading" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.show_section_documents') }}</h3>

                @if($member->documents && $member->documents->isNotEmpty())
                    <div class="flex flex-col gap-3">
                        @foreach($member->documents as $document)
                            <div wire:key="document-{{ $document->id }}"
                                 class="px-4 py-3 bg-bg rounded-lg flex items-center justify-between gap-4">
                                <div class="flex flex-col gap-0.5 min-w-0">
                                    <p class="font-sans font-semibold text-sm text-dark truncate">{{ $document->name }}</p>
                                    <p class="font-serif text-xs text-dark-mid">{{ $document->type }}</p>
                                </div>
                                <a href="{{ route('admin.documents.download', ['locale' => app()->getLocale(), 'document' => $document]) }}"
                                   data-fancybox="member-document"
                                   data-type="iframe"
                                   data-width="1000"
                                   data-height="900"
                                   class="font-sans font-medium text-sm text-dark underline hover:text-red transition shrink-0">
                                    {{ __('pages/members.show_action_view_document') }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="font-serif text-dark-mid">{{ __('pages/members.show_empty_documents') }}</p>
                @endif
            </section>

        </div>

        {{-- Historique --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Formations --}}
            <section aria-labelledby="trainings-heading"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h3 id="trainings-heading" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.show_section_trainings') }}</h3>

                @forelse($trainingRegisters as $register)
                    <div wire:key="training-register-{{ $register->id }}"
                         class="flex flex-col gap-2 p-4 rounded-xl border border-bg-dark bg-bg">
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <a href="{{ route('public.trainings.show', ['locale' => app()->getLocale(), 'training' => $register->training]) }}"
                               wire:navigate
                               class="font-sans font-semibold text-dark hover:text-red transition">
                                {{ $register->training->title }}
                            </a>
                            <x-public.badge variant="{{ match($register->status) {
                                RegisterStatus::ACCEPTED => 'success',
                                RegisterStatus::REFUSED  => 'danger',
                                RegisterStatus::PENDING  => 'warning',
                            } }}">
                                {{ $register->status->label() }}
                            </x-public.badge>
                        </div>
                        <p class="font-serif text-sm text-dark-mid">
                            {{ __('pages/members.show_date_from') }} {{ $register->training->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                            {{ __('pages/members.show_date_to') }} {{ $register->training->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                        </p>
                        @if($register->notes)
                            <p class="font-serif text-sm text-dark-mid italic">{{ $register->notes }}</p>
                        @endif
                    </div>
                @empty
                    <p class="font-serif text-dark-mid">{{ __('pages/members.show_empty_trainings') }}</p>
                @endforelse
            </section>

            {{-- Camps --}}
            <section aria-labelledby="camps-heading"
                     class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-6">
                <h3 id="camps-heading" class="font-sans font-bold text-xl text-dark">{{ __('pages/members.show_section_camps') }}</h3>

                @forelse($campRegisters as $register)
                    <div wire:key="camp-register-{{ $register->id }}"
                         class="flex flex-col gap-2 p-4 rounded-xl border border-bg-dark bg-bg">
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <a href="{{ route('public.camps.show', ['locale' => app()->getLocale(), 'camp' => $register->camp]) }}"
                               wire:navigate
                               class="font-sans font-semibold text-dark hover:text-red transition">
                                {{ $register->camp->title }}
                            </a>
                            <x-public.badge variant="{{ match($register->status) {
                                RegisterStatus::ACCEPTED => 'success',
                                RegisterStatus::REFUSED  => 'danger',
                                RegisterStatus::PENDING  => 'warning',
                            } }}">
                                {{ $register->status->label() }}
                            </x-public.badge>
                        </div>
                        <p class="font-serif text-sm text-dark-mid">
                            {{ __('pages/members.show_date_from') }} {{ $register->camp->start_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                            {{ __('pages/members.show_date_to') }} {{ $register->camp->end_date->locale(app()->getLocale())->isoFormat('D MMMM YYYY [à] HH[h]mm') }}
                        </p>
                        @if($register->notes)
                            <p class="font-serif text-sm text-dark-mid italic">{{ $register->notes }}</p>
                        @endif
                    </div>
                @empty
                    <p class="font-serif text-dark-mid">{{ __('pages/members.show_empty_camps') }}</p>
                @endforelse
            </section>

        </div>

    </div>

</div>
