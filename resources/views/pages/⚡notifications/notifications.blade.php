<div>

    <x-public.hero title="{{ __('general.notifications') }}" />

    <div class="flex flex-col gap-8 px-4 py-8 md:px-8 max-w-full">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="font-serif text-sm text-dark-mid">
                @if($unread > 0)
                    {{ $unread }} {{ __('general.unread') }}
                @endif
            </p>

            @if($unread > 0)
                <button type="button" wire:click="markAllRead"
                        class="self-start px-4 py-2 rounded-lg border-2 border-dark-light text-dark font-sans font-medium text-xs hover:border-dark transition">
                    {{ __('general.mark_all_read') }}
                </button>
            @endif
        </div>

        {{-- Filtres --}}
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="search"
                   wire:model.live.debounce.300ms="search"
                   placeholder="{{ __('pages/notifications.search_placeholder') }}"
                   aria-label="{{ __('pages/notifications.search_aria') }}"
                   class="flex-1 px-4 py-2 rounded-lg border border-bg-dark bg-white font-serif text-sm text-dark
                          placeholder:text-dark-light focus:outline-none focus:border-red transition">

            <select wire:model.live="filter"
                    aria-label="{{ __('pages/notifications.filter_aria') }}"
                    class="px-3 py-2 rounded-lg border border-bg-dark bg-white font-sans text-sm text-dark
                           focus:outline-none focus:border-red transition cursor-pointer">
                <option value="all">{{ __('pages/notifications.filter_all') }}</option>
                <option value="unread">{{ __('pages/notifications.filter_unread') }}</option>
                <option value="read">{{ __('pages/notifications.filter_read') }}</option>
            </select>

            <button type="button" wire:click="$set('sort', sort === 'desc' ? 'asc' : 'desc')"
                    x-data
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-bg-dark bg-white
                           font-sans text-sm text-dark hover:border-red transition whitespace-nowrap">
                {{ $sort === 'desc' ? __('pages/notifications.sort_newest') : __('pages/notifications.sort_oldest') }}
            </button>
        </div>

        {{-- Liste --}}
        <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex flex-col gap-4">

            @if($notifications->isEmpty())
                <p class="font-serif text-sm text-dark-mid text-center py-8">{{ __('general.no_notifications') }}</p>
            @else
                <ul class="flex flex-col divide-y divide-bg-dark">
                    @foreach($notifications as $notif)
                        @php
                            $isUnread = is_null($notif->read_at);
                            $url = $notif->data['url'] ?? null;
                        @endphp
                        <li wire:key="notif-{{ $notif->id }}"
                            class="py-4 flex items-start gap-3 {{ $isUnread ? 'bg-red-light/20' : '' }}">

                            <span class="mt-1.5 shrink-0 size-2 rounded-full {{ $isUnread ? 'bg-red' : 'bg-dark-light/40' }}" aria-hidden="true"></span>

                            <div class="flex-1 min-w-0">
                                <p class="font-serif text-sm text-dark leading-relaxed">
                                    @if($url)
                                        <a href="{{ $url }}" wire:navigate
                                           wire:click="markRead('{{ $notif->id }}')"
                                           class="hover:underline hover:text-red transition-colors">
                                            {{ $notif->data['message'] ?? __('general.new_notification') }}
                                        </a>
                                    @else
                                        {{ $notif->data['message'] ?? __('general.new_notification') }}
                                    @endif
                                </p>
                                <p class="font-sans text-xs text-dark-mid mt-1">
                                    {{ $notif->created_at->diffForHumans() }}
                                </p>
                            </div>

                            <div class="flex items-center gap-1 shrink-0">
                                @if($isUnread)
                                    <button type="button" wire:click="markRead('{{ $notif->id }}')"
                                            title="{{ __('pages/notifications.mark_read') }}"
                                            class="p-2 rounded-lg text-dark-light hover:text-dark hover:bg-bg-mid transition">
                                        <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                @endif
                                <button type="button" wire:click="deleteNotification('{{ $notif->id }}')"
                                        title="{{ __('pages/notifications.delete') }}"
                                        class="p-2 rounded-lg text-dark-light hover:text-danger hover:bg-danger-bg transition">
                                    <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="pt-2">
                    {{ $notifications->links() }}
                </div>
            @endif
        </section>

        {{-- Préférence --}}
        <section class="p-6 bg-white rounded-2xl shadow-[0px_5px_20px_0px_rgba(0,0,0,0.10)] flex items-center justify-between gap-4">
            <div>
                <h2 class="font-sans font-bold text-base text-dark">{{ __('pages/notifications.prefs_title') }}</h2>
                <p class="font-serif text-sm text-dark-mid mt-1">{{ __('pages/notifications.prefs_desc') }}</p>
            </div>
            <button type="button" wire:click="toggleEmailNotifications"
                    role="switch"
                    aria-checked="{{ auth()->user()->email_notifications ? 'true' : 'false' }}"
                    aria-label="{{ __('pages/notifications.prefs_title') }}"
                    class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent
                           transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red focus-visible:ring-offset-2
                           {{ auth()->user()->email_notifications ? 'bg-red' : 'bg-dark-light/40' }}">
                <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-sm
                             transition duration-200
                             {{ auth()->user()->email_notifications ? 'translate-x-5' : 'translate-x-0' }}"
                      aria-hidden="true"></span>
            </button>
        </section>

    </div>
</div>
