<div class="flex flex-col gap-8 px-4 py-8 md:px-8" wire:poll.10s>

    <x-public.missing-document/>

    {{-- CTA --}}
    @canany(['manage-members', 'manage-messages', 'manage-training', 'manage-camp', 'manage-announcement'])
        <div class="flex flex-col lg:flex-row flex-wrap gap-3">

                @can('manage-members')
                    <x-public.link
                        href="{{ route('admin.members.create', ['locale' => app()->getLocale()]) }}"
                        class="flex-1 justify-center py-4 rounded-lg bg-red text-white font-sans font-bold text-sm hover:bg-red-mid transition duration-200">
                        <x-icons.plus class="size-4" fill="fill-current" />
                        {{ __('pages/dashboard.add_member') }}
                    </x-public.link>
                    <x-public.link
                        href="{{ route('admin.members.index', ['locale' => app()->getLocale()]) }}"
                        class="flex-1 justify-center py-4 rounded-lg border-2 border-dark-light text-dark font-sans font-bold text-sm hover:border-dark transition duration-200">
                        {{ __('pages/dashboard.manage_members') }}
                    </x-public.link>
                @endcan

                @can('manage-messages')
                    <x-public.link
                        href="{{ route('admin.messages.index', ['locale' => app()->getLocale()]) }}"
                        class="flex-1 justify-center py-4 rounded-lg border-2 border-dark-light text-dark font-sans font-bold text-sm hover:border-dark transition duration-200">
                        {{ __('pages/dashboard.view_messages') }}
                    </x-public.link>
                @endcan

                @can('manage-training')
                    <x-public.link
                        href="{{ route('admin.trainings.create', ['locale' => app()->getLocale()]) }}"
                        class="flex-1 justify-center py-4 rounded-lg bg-red text-white font-sans font-bold text-sm hover:bg-red-mid transition duration-200">
                        <x-icons.plus class="size-4" fill="fill-current" />
                        {{ __('pages/dashboard.create_training') }}
                    </x-public.link>
                @endcan

                @can('manage-camp')
                    <x-public.link
                        href="{{ route('admin.camps.create', ['locale' => app()->getLocale()]) }}"
                        class="flex-1 justify-center py-4 rounded-lg bg-red text-white font-sans font-bold text-sm hover:bg-red-mid transition duration-200">
                        <x-icons.plus class="size-4" fill="fill-current" />
                        {{ __('pages/dashboard.create_camp') }}
                    </x-public.link>
                @endcan

                @can('manage-announcement')
                    <x-public.link
                        href="{{ route('admin.announcements.create', ['locale' => app()->getLocale()]) }}"
                        class="flex-1 justify-center py-4 rounded-lg border-2 border-dark-light text-dark font-sans font-bold text-sm hover:border-dark transition duration-200">
                        <x-icons.plus class="size-4" fill="fill-current" />
                        {{ __('pages/dashboard.add_announcement') }}
                    </x-public.link>
                @endcan

        </div>
    @endcanany

    @canany(['manage-training', 'manage-camp', 'manage-members'])
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_380px] gap-8 items-start">
    @else
    <div class="flex flex-col gap-8 max-w-4xl">
    @endcanany

        {{-- Calendrier --}}
        <section aria-label="{{ __('pages/dashboard.calendar_title') }}" wire:ignore>
            <div x-data="dashboardCalendar(@js($calendarEvents), '{{ app()->getLocale() }}')" class="flex flex-col gap-4">

                <div class="flex items-center justify-between flex-wrap gap-3">
                    <h2 class="font-sans font-bold text-xl text-dark">{{ __('pages/dashboard.calendar_title') }}</h2>
                    <div class="flex gap-1 bg-bg rounded-lg p-1">
                        <button type="button"
                            x-on:click="changeView('listMonth')"
                            :class="currentView === 'listMonth' ? 'bg-white text-dark shadow-sm' : 'text-dark-mid hover:text-dark'"
                            class="px-3 py-1.5 font-sans font-medium text-xs rounded-md transition">
                            {{ __('pages/dashboard.calendar_list') }}
                        </button>
                        <button type="button"
                            x-on:click="changeView('dayGridWeek')"
                            :class="currentView === 'dayGridWeek' ? 'bg-white text-dark shadow-sm' : 'text-dark-mid hover:text-dark'"
                            class="px-3 py-1.5 font-sans font-medium text-xs rounded-md transition">
                            {{ __('pages/dashboard.calendar_week') }}
                        </button>
                        <button type="button"
                            x-on:click="changeView('dayGridMonth')"
                            :class="currentView === 'dayGridMonth' ? 'bg-white text-dark shadow-sm' : 'text-dark-mid hover:text-dark'"
                            class="px-3 py-1.5 font-sans font-medium text-xs rounded-md transition">
                            {{ __('pages/dashboard.calendar_month') }}
                        </button>
                    </div>
                </div>

                <div x-ref="calendarEl"></div>

            </div>
        </section>

        @canany(['manage-training', 'manage-camp', 'manage-members'])
            <aside aria-labelledby="aside-pending-title" class="flex flex-col gap-6">
                <h2 id="aside-pending-title" class="sr-only">{{ __('pages/dashboard.pending_aside_title') }}</h2>

                {{-- Inscriptions en attente --}}
                @if(isset($pendingTrainingRegisters) || isset($pendingCampRegisters))
                    @php
                        $totalPendingRegisters = (isset($pendingTrainingRegisters) ? $pendingTrainingRegisters->count() : 0)
                                              + (isset($pendingCampRegisters) ? $pendingCampRegisters->count() : 0);
                    @endphp
                    <section aria-label="{{ __('pages/dashboard.pending_registers_title') }}" class="flex flex-col gap-4">

                        <div class="flex items-center gap-2">
                            <h2 class="font-sans font-bold text-base text-dark">{{ __('pages/dashboard.pending_registers_title') }}</h2>
                            @if($totalPendingRegisters > 0)
                                <x-public.badge variant="danger">{{ $totalPendingRegisters }}</x-public.badge>
                            @endif
                        </div>

                        <div class="flex flex-col gap-3">

                            @isset($pendingTrainingRegisters)
                                @forelse($pendingTrainingRegisters as $register)
                                    <div wire:key="training-register-{{ $register->id }}"
                                         class="bg-white rounded-xl px-4 py-3 shadow-[0px_2px_10px_0px_rgba(0,0,0,0.07)] flex flex-col gap-3">
                                        <div class="flex flex-col gap-0.5">
                                            <p class="font-sans font-bold text-sm text-dark">{{ $register->user->fullName() }}</p>
                                            <p class="font-serif text-sm text-dark-mid">{{ $register->training->title }}</p>
                                            <x-public.badge variant="success" class="self-start">{{ __('pages/dashboard.training_badge') }} · {{ $register->training->start_date->format('d/m/Y') }}</x-public.badge>
                                            @if($register->notes)
                                                <p class="font-serif text-xs text-dark-mid italic mt-1 whitespace-pre-line">{{ $register->notes }}</p>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            <x-forms.button wire:click="acceptTrainingRegister({{ $register->id }})" class="flex-1 bg-success text-white border-success">
                                                {{ __('pages/dashboard.accept') }}
                                            </x-forms.button>
                                            <x-forms.button wire:click="openConfirmRefuseModal({{ $register->id }}, 'training_register')" class="flex-1 text-danger border-danger hover:bg-danger hover:text-white">
                                                {{ __('pages/dashboard.refuse') }}
                                            </x-forms.button>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            @endisset

                            @isset($pendingCampRegisters)
                                @forelse($pendingCampRegisters as $register)
                                    <div wire:key="camp-register-{{ $register->id }}"
                                         class="bg-white rounded-xl px-4 py-3 shadow-[0px_2px_10px_0px_rgba(0,0,0,0.07)] flex flex-col gap-3">
                                        <div class="flex flex-col gap-0.5">
                                            <p class="font-sans font-bold text-sm text-dark">{{ $register->user->fullName() }}</p>
                                            <p class="font-serif text-sm text-dark-mid">{{ $register->camp->title }}</p>
                                            <x-public.badge variant="info" class="self-start">{{ __('pages/dashboard.camp_badge') }} · {{ $register->camp->start_date->format('d/m/Y') }}</x-public.badge>
                                            @if($register->notes)
                                                <p class="font-serif text-xs text-dark-mid italic mt-1 whitespace-pre-line">{{ $register->notes }}</p>
                                            @endif
                                        </div>
                                        <div class="flex gap-2">
                                            <x-forms.button wire:click="acceptCampRegister({{ $register->id }})" class="flex-1 bg-success text-white border-success">
                                                {{ __('pages/dashboard.accept') }}
                                            </x-forms.button>
                                            <x-forms.button wire:click="openConfirmRefuseModal({{ $register->id }}, 'camp_register')" class="flex-1 text-danger border-danger hover:bg-danger hover:text-white">
                                                {{ __('pages/dashboard.refuse') }}
                                            </x-forms.button>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            @endisset

                            @if($totalPendingRegisters === 0)
                                <p class="font-serif text-sm text-dark-mid">{{ __('pages/dashboard.no_pending_registers') }}</p>
                            @endif

                        </div>
                    </section>
                @endif

                {{-- Événements en attente --}}
                @if(isset($pendingTrainings) || isset($pendingCamps))
                    @php
                        $totalPendingEvents = (isset($pendingTrainings) ? $pendingTrainings->count() : 0)
                                           + (isset($pendingCamps) ? $pendingCamps->count() : 0);
                    @endphp
                    <section aria-label="{{ __('pages/dashboard.pending_events_title') }}" class="flex flex-col gap-4">

                        <div class="flex items-center gap-2">
                            <h2 class="font-sans font-bold text-base text-dark">{{ __('pages/dashboard.pending_events_title') }}</h2>
                            @if($totalPendingEvents > 0)
                                <x-public.badge variant="warning">{{ $totalPendingEvents }}</x-public.badge>
                            @endif
                        </div>

                        <div class="flex flex-col gap-3">

                            @isset($pendingTrainings)
                                @forelse($pendingTrainings as $training)
                                    <div wire:key="training-{{ $training->id }}"
                                         class="bg-white rounded-xl px-4 py-3 shadow-[0px_2px_10px_0px_rgba(0,0,0,0.07)] flex flex-col gap-3">
                                        <div class="flex flex-col gap-0.5">
                                            <p class="font-sans font-bold text-sm text-dark">{{ $training->title }}</p>
                                            <p class="font-serif text-sm text-dark-mid">{{ __('general.by') }} {{ $training->user->fullName() }}</p>
                                            <x-public.badge variant="success" class="self-start">{{ __('pages/dashboard.training_badge') }} · {{ $training->start_date->format('d/m/Y') }}</x-public.badge>
                                        </div>
                                        <div class="flex gap-2">
                                            <x-public.link
                                                href="{{ route('admin.trainings.edit', ['locale' => app()->getLocale(), 'training' => $training]) }}"
                                                class="flex-1 border-2 border-dark-light text-dark hover:border-dark justify-center">
                                                {{ __('pages/dashboard.view') }}
                                            </x-public.link>
                                            <x-forms.button wire:click="publishTraining({{ $training->id }})" class="flex-1 bg-success text-white border-success">
                                                {{ __('pages/dashboard.publish') }}
                                            </x-forms.button>
                                            <x-forms.button wire:click="openConfirmRefuseModal({{ $training->id }}, 'training')" class="flex-1 text-danger border-danger hover:bg-danger hover:text-white">
                                                {{ __('pages/dashboard.refuse') }}
                                            </x-forms.button>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            @endisset

                            @isset($pendingCamps)
                                @forelse($pendingCamps as $camp)
                                    <div wire:key="camp-{{ $camp->id }}"
                                         class="bg-white rounded-xl px-4 py-3 shadow-[0px_2px_10px_0px_rgba(0,0,0,0.07)] flex flex-col gap-3">
                                        <div class="flex flex-col gap-0.5">
                                            <p class="font-sans font-bold text-sm text-dark">{{ $camp->title }}</p>
                                            <p class="font-serif text-sm text-dark-mid">{{ __('general.by') }} {{ $camp->user->fullName() }}</p>
                                            <x-public.badge variant="info" class="self-start">{{ __('pages/dashboard.camp_badge') }} · {{ $camp->start_date->format('d/m/Y') }}</x-public.badge>
                                        </div>
                                        <div class="flex gap-2">
                                            <x-public.link
                                                href="{{ route('admin.camps.edit', ['locale' => app()->getLocale(), 'camp' => $camp]) }}"
                                                class="flex-1 border-2 border-dark-light text-dark hover:border-dark justify-center">
                                                {{ __('pages/dashboard.view') }}
                                            </x-public.link>
                                            <x-forms.button wire:click="publishCamp({{ $camp->id }})" class="flex-1 bg-success text-white border-success">
                                                {{ __('pages/dashboard.publish') }}
                                            </x-forms.button>
                                            <x-forms.button wire:click="openConfirmRefuseModal({{ $camp->id }}, 'camp')" class="flex-1 text-danger border-danger hover:bg-danger hover:text-white">
                                                {{ __('pages/dashboard.refuse') }}
                                            </x-forms.button>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            @endisset

                            @if($totalPendingEvents === 0)
                                <p class="font-serif text-sm text-dark-mid">{{ __('pages/dashboard.no_pending_events') }}</p>
                            @endif

                        </div>
                    </section>
                @endif

            </aside>
        @endcanany

    </div>

</div>
