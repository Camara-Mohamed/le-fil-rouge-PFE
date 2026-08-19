<div wire:poll.20s>

{{-- Inscrits --}}
@can('update', $model)

    <div {{ $attributes->class(['flex flex-col gap-6 pt-6 border-t border-bg-dark']) }}>
        <h3 class="font-sans font-black text-3xl text-dark">
            {{ __('livewire/enrollment.inscrits_title', ['count' => $accepted->count() + $pending->count() + $refused->count()]) }}
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Acceptés --}}
            <div class="flex flex-col gap-4">
                <h4 class="font-sans font-black text-base text-dark border-b border-success pb-2">
                    {{ __('livewire/enrollment.accepted_title', ['count' => $accepted->count()]) }}
                </h4>
                @forelse($accepted as $registrant)
                    <div wire:key="accepted-{{ $registrant->id }}"
                         class="p-4 bg-bg rounded-lg border border-bg-dark flex flex-col gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <a href="{{ route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $registrant->user->id]) }}"
                               wire:navigate
                               class="shrink-0 hover:opacity-80 transition duration-200">
                                @if($registrant->user->avatar_path)
                                    <img src="{{ Storage::url('avatars/originals/' . $registrant->user->avatar_path) }}"
                                         alt="{{ $registrant->user->fullName() }}"
                                         class="size-8 rounded-full object-cover">
                                @else
                                    <div class="size-8 rounded-full bg-bg-dark flex items-center justify-center font-sans font-bold text-xs text-dark-mid uppercase">
                                        {{ strtoupper($registrant->user->first_name[0] . $registrant->user->last_name[0]) }}
                                    </div>
                                @endif
                            </a>
                            <div class="min-w-0">
                                <a href="{{ route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $registrant->user->id]) }}"
                                   wire:navigate
                                   class="font-sans font-bold text-sm text-dark hover:text-red transition duration-200 block truncate">
                                    {{ $registrant->user->fullName() }}
                                </a>
                                <span class="font-sans text-xs text-dark-mid">{{ $registrant->user->role->label() }}</span>
                            </div>
                        </div>
                        @if($registrant->notes)
                            <p class="font-serif text-xs text-dark-mid italic border-l-2 border-bg-dark pl-2 whitespace-pre-line">{!! $registrant->notes !!}</p>
                        @endif
                        <div class="flex gap-4 self-end">
                            <button type="button" wire:click="refuse({{ $registrant->id }})"
                                    class="font-sans text-xs font-bold text-danger underline hover:opacity-70 transition duration-200">
                                {{ __('livewire/enrollment.action_refuse') }}
                            </button>
                            <button type="button" wire:click="pending({{ $registrant->id }})"
                                    class="font-sans text-xs font-bold text-warning underline hover:opacity-70 transition duration-200">
                                {{ __('livewire/enrollment.action_pending') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="font-serif text-sm text-dark-mid">{{ __('livewire/enrollment.empty_accepted') }}</p>
                @endforelse
            </div>

            {{-- En attente --}}
            <div class="flex flex-col gap-4">
                <h4 class="font-sans font-black text-base text-dark border-b border-warning pb-2">
                    {{ __('livewire/enrollment.pending_title', ['count' => $pending->count()]) }}
                </h4>
                @forelse($pending as $registrant)
                    <div wire:key="pending-{{ $registrant->id }}"
                         class="p-4 bg-bg rounded-lg border border-bg-dark flex flex-col gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <a href="{{ route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $registrant->user->id]) }}"
                               wire:navigate
                               class="shrink-0 hover:opacity-80 transition duration-200">
                                @if($registrant->user->avatar_path)
                                    <img src="{{ Storage::url('avatars/originals/' . $registrant->user->avatar_path) }}"
                                         alt="{{ $registrant->user->fullName() }}"
                                         class="size-8 rounded-full object-cover">
                                @else
                                    <div class="size-8 rounded-full bg-bg-dark flex items-center justify-center font-sans font-bold text-xs text-dark-mid uppercase">
                                        {{ strtoupper($registrant->user->first_name[0] . $registrant->user->last_name[0]) }}
                                    </div>
                                @endif
                            </a>
                            <div class="min-w-0">
                                <a href="{{ route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $registrant->user->id]) }}"
                                   wire:navigate
                                   class="font-sans font-bold text-sm text-dark hover:text-red transition duration-200 block truncate">
                                    {{ $registrant->user->fullName() }}
                                </a>
                                <span class="font-sans text-xs text-dark-mid">{{ $registrant->user->role->label() }}</span>
                            </div>
                        </div>
                        @if($registrant->notes)
                            <p class="font-serif text-xs text-dark-mid italic border-l-2 border-bg-dark pl-2 whitespace-pre-line">{!! $registrant->notes !!}</p>
                        @endif
                        <div class="flex gap-4 self-end">
                            <button type="button" wire:click="accept({{ $registrant->id }})"
                                    class="font-sans text-xs font-bold text-success underline hover:opacity-70 transition duration-200">
                                {{ __('livewire/enrollment.action_accept') }}
                            </button>
                            <button type="button" wire:click="refuse({{ $registrant->id }})"
                                    class="font-sans text-xs font-bold text-danger underline hover:opacity-70 transition duration-200">
                                {{ __('livewire/enrollment.action_refuse') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="font-serif text-sm text-dark-mid">{{ __('livewire/enrollment.empty_pending') }}</p>
                @endforelse
            </div>

            {{-- Refusés --}}
            <div class="flex flex-col gap-4">
                <h4 class="font-sans font-black text-base text-dark border-b border-danger pb-2">
                    {{ __('livewire/enrollment.refused_title', ['count' => $refused->count()]) }}
                </h4>
                @forelse($refused as $registrant)
                    <div wire:key="refused-{{ $registrant->id }}"
                         class="p-4 bg-bg rounded-lg border border-bg-dark flex flex-col gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            <a href="{{ route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $registrant->user->id]) }}"
                               wire:navigate
                               class="shrink-0 hover:opacity-80 transition duration-200">
                                @if($registrant->user->avatar_path)
                                    <img src="{{ Storage::url('avatars/originals/' . $registrant->user->avatar_path) }}"
                                         alt="{{ $registrant->user->fullName() }}"
                                         class="size-8 rounded-full object-cover">
                                @else
                                    <div class="size-8 rounded-full bg-bg-dark flex items-center justify-center font-sans font-bold text-xs text-dark-mid uppercase">
                                        {{ strtoupper($registrant->user->first_name[0] . $registrant->user->last_name[0]) }}
                                    </div>
                                @endif
                            </a>
                            <div class="min-w-0">
                                <a href="{{ route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $registrant->user->id]) }}"
                                   wire:navigate
                                   class="font-sans font-bold text-sm text-dark hover:text-red transition duration-200 block truncate">
                                    {{ $registrant->user->fullName() }}
                                </a>
                                <span class="font-sans text-xs text-dark-mid">{{ $registrant->user->role->label() }}</span>
                            </div>
                        </div>
                        <div class="flex gap-4 self-end">
                            <button type="button" wire:click="accept({{ $registrant->id }})"
                                    class="font-sans text-xs font-bold text-success underline hover:opacity-70 transition duration-200">
                                {{ __('livewire/enrollment.action_accept') }}
                            </button>
                            <button type="button" wire:click="pending({{ $registrant->id }})"
                                    class="font-sans text-xs font-bold text-warning underline hover:opacity-70 transition duration-200">
                                {{ __('livewire/enrollment.action_pending') }}
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="font-serif text-sm text-dark-mid">{{ __('livewire/enrollment.empty_refused') }}</p>
                @endforelse
            </div>

        </div>
    </div>

@else

    @if($accepted->count())
        <div class="flex flex-col gap-4 pt-6 border-t border-bg-dark">
            <h3 class="font-sans font-black text-3xl text-dark">
                {{ __('livewire/enrollment.inscrits_title', ['count' => $accepted->count()]) }}
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($accepted as $registrant)
                    <div wire:key="user-accepted-{{ $registrant->id }}"
                         class="p-4 bg-bg rounded-lg border border-bg-dark flex items-center gap-3">
                        @if($registrant->user->avatar_path)
                            <img src="{{ Storage::url('avatars/originals/' . $registrant->user->avatar_path) }}"
                                 alt="{{ $registrant->user->fullName() }}"
                                 class="size-9 rounded-full object-cover shrink-0">
                        @else
                            <div class="size-9 rounded-full bg-bg-dark shrink-0 flex items-center justify-center font-sans font-bold text-xs text-dark-mid uppercase">
                                {{ strtoupper($registrant->user->first_name[0] . $registrant->user->last_name[0]) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="font-sans font-bold text-sm text-dark truncate">{{ $registrant->user->fullName() }}</p>
                            <span class="font-sans text-xs text-dark-mid">{{ $registrant->user->role->label() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endcan
</div>
