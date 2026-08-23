@php
    use App\Enums\UserRoles;
    use App\Enums\UserStatus;
    use App\Models\User;
@endphp

<div class="flex flex-col gap-8 px-4 py-8 md:px-8">

    <div class="flex items-center justify-between gap-4 flex-wrap">
        <h2 class="font-sans font-black text-3xl text-dark">{{ __('pages/members.index_title') }}</h2>

        @can('create', User::class)
            <a href="{{ route('admin.members.create', ['locale' => app()->getLocale()]) }}"
               class="flex items-center gap-2 px-6 py-2 rounded-lg bg-red text-white font-sans font-medium hover:bg-red-mid transition">
                <x-icons.plus class="size-4" fill="fill-current" />
                {{ __('pages/members.index_add_member') }}
            </a>
        @endcan
    </div>

    {{-- Filtre --}}
    <div class="flex flex-wrap gap-3">
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="{{ __('pages/members.index_search_placeholder') }}"
            aria-label="{{ __('pages/members.index_search_aria') }}"
            class="flex-1 min-w-48 px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark placeholder:text-dark-mid focus:outline-none focus:border-dark"
        />

        <select wire:model.live="role" aria-label="{{ __('pages/members.index_filter_role_aria') }}" class="px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark focus:outline-none focus:border-dark">
            <option value="">{{ __('pages/members.index_all_roles') }}</option>
            @foreach(UserRoles::registrable() as $role)
                <option value="{{ $role->value }}">{{ $role->label() }}</option>
            @endforeach
        </select>

        @if(!$archived)
            <select wire:model.live="status" aria-label="{{ __('pages/members.index_filter_status_aria') }}" class="px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark focus:outline-none focus:border-dark">
                <option value="">{{ __('pages/members.index_all_statuses') }}</option>
                @foreach(UserStatus::cases() as $statut)
                    @if($statut !== UserStatus::ARCHIVED)
                        <option value="{{ $statut->value }}">{{ $statut->label() }}</option>
                    @endif
                @endforeach
            </select>
        @endif

        <button
            type="button"
            wire:click="$toggle('archived')"
            class="px-4 py-2 rounded-lg border-2 font-sans font-medium text-sm transition
                   {{ $archived ? 'border-dark bg-dark text-white' : 'border-dark-light text-dark hover:border-dark' }}">
            {{ $archived ? __('pages/members.index_view_active') : __('pages/members.index_view_archived') }}
        </button>

        @if($search || $role || $status)
            <button type="button" wire:click="resetFilters" class="px-4 py-2 rounded-lg border border-bg-dark text-dark-mid font-serif text-sm hover:border-dark hover:text-dark transition">
                {{ __('pages/members.index_reset_filters') }}
            </button>
        @endif
    </div>

    {{-- Tableau --}}
    <div class="bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-bg-dark">
                    <th class="px-6 py-4 text-left font-sans font-semibold text-sm text-dark-mid">{{ __('pages/members.index_col_avatar') }}</th>
                    <th class="px-6 py-4 text-left font-sans font-semibold text-sm text-dark-mid">{{ __('pages/members.index_col_name') }}</th>
                    <th class="px-6 py-4 text-left font-sans font-semibold text-sm text-dark-mid">{{ __('pages/members.index_col_email') }}</th>
                    <th class="px-6 py-4 text-left font-sans font-semibold text-sm text-dark-mid">{{ __('pages/members.index_col_role') }}</th>
                    <th class="px-6 py-4 text-left font-sans font-semibold text-sm text-dark-mid">{{ __('pages/members.index_col_status') }}</th>
                    <th class="px-6 py-4 text-right font-sans font-semibold text-sm text-dark-mid">{{ __('pages/members.index_col_actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-bg-dark">
                @forelse($members as $member)
                    @php $initials = strtoupper($member->first_name[0] . $member->last_name[0]); @endphp
                    <tr wire:key="member-{{ $member->id }}" class="hover:bg-bg transition">
                        <td class="px-6 py-4">
                            @if($member->avatar_path)
                                <a href="{{ Storage::url('avatars/originals/' . $member->avatar_path) }}" data-fancybox="members">
                                    <img src="{{ Storage::url('avatars/originals/' . $member->avatar_path) }}"
                                         alt="{{ $member->fullName() }}"
                                         class="w-10 h-10 rounded-full object-cover">
                                </a>
                            @else
                                <div class="w-10 h-10 rounded-full bg-bg-dark flex items-center justify-center font-sans font-bold text-sm text-dark-mid">
                                    {{ $initials }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-sans font-semibold text-dark">{{ $member->fullName() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-serif text-sm text-dark-mid">{{ $member->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-serif text-sm text-dark">{{ $member->role->label() }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <x-public.badge variant="{{ match($member->status) {
                                UserStatus::COMPLETE   => 'success',
                                UserStatus::PENDING    => 'warning',
                                UserStatus::INCOMPLETE => 'danger',
                                UserStatus::ARCHIVED   => 'danger',
                            } }}">{{ $member->status->label() }}</x-public.badge>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.members.show', ['locale' => app()->getLocale(), 'member' => $member]) }}"
                                   class="px-3 py-1.5 rounded-lg border-2 border-dark-light text-dark text-sm font-sans font-medium hover:border-dark transition">
                                    {{ __('pages/members.index_action_view') }}
                                </a>
                                @if(!$member->isArchived())
                                    <a href="{{ route('admin.members.edit', ['locale' => app()->getLocale(), 'member' => $member]) }}"
                                       class="px-3 py-1.5 rounded-lg bg-dark text-white text-sm font-sans font-medium hover:bg-dark-mid transition">
                                        {{ __('pages/members.index_action_edit') }}
                                    </a>
                                    @can('delete', $member)
                                        <button type="button"
                                                wire:click="openDeleteModal({{ $member->id }})"
                                                class="px-3 py-1.5 rounded-lg border-2 border-red text-red text-sm font-sans font-medium hover:bg-red-light transition">
                                            {{ __('pages/members.index_action_delete') }}
                                        </button>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center font-serif text-dark-mid">
                            {{ __('pages/members.index_empty') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($members->hasPages())
        <div class="flex justify-center">{{ $members->links() }}</div>
    @endif

</div>
