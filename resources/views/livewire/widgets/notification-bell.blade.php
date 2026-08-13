<div class="relative"
     x-data="{
         init() {
             if (window.Echo) {
                 Echo.private('notifications.{{ auth()->id() }}')
                     .listen('.notification.received', () => {
                         $wire.dispatch('notification-received');
                     });
             }
         }
     }"
     @click.outside="$wire.set('open', false)">

    {{-- Bouton cloche --}}
    <button type="button"
            wire:click="toggle"
            class="relative p-2 rounded-lg text-dark hover:text-red hover:bg-bg-mid transition duration-200
                   focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red"
            :aria-label="'{{ __('general.notifications') }}' + ($wire.unread ? ' ({{ $unread }} {{ __("general.unread") }})' : '')"
            aria-expanded="{{ $open ? 'true' : 'false' }}"
            aria-haspopup="true">

        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if($unread > 0)
            <span class="absolute top-1 right-1 flex items-center justify-center
                         min-w-[1.1rem] h-[1.1rem] px-0.5 rounded-full
                         bg-red text-white font-sans font-bold text-[0.6rem] leading-none
                         pointer-events-none"
                  aria-hidden="true">
                {{ $unread > 9 ? '9+' : $unread }}
            </span>
        @endif
    </button>

    {{-- Notifications --}}
    <div x-show="$wire.open"
         class="absolute right-0 mt-2 w-80 bg-white border border-bg-dark rounded-2xl shadow-xl z-50 origin-top-right overflow-hidden"
         role="dialog"
         aria-label="{{ __('general.notifications') }}"
         aria-live="polite"
         style="display:none;">

        <div class="flex items-center justify-between px-4 py-3 border-b border-bg-dark bg-bg">
            <span class="font-sans font-bold text-sm text-dark">{{ __('general.notifications') }}</span>
            @if($unread > 0)
                <button wire:click="markAllRead"
                        class="font-sans text-xs text-dark-mid hover:text-red transition duration-200">
                    {{ __('general.mark_all_read') }}
                </button>
            @endif
        </div>

        <ul class="divide-y divide-bg-mid max-h-80 overflow-y-auto" role="list">
            @forelse($notifications as $notif)
                @php
                    $isUnread = is_null($notif->read_at);
                    $url = $notif->data['url'] ?? null;
                @endphp
                <li wire:key="notif-{{ $notif->id }}"
                    @class([
                        'px-4 py-3 flex items-start gap-3 transition-colors duration-150',
                        'bg-red-light/30 hover:bg-red-light/50' => $isUnread,
                        'hover:bg-bg' => !$isUnread,
                        'cursor-pointer' => (bool) $url,
                    ])
                    @if($url)
                        x-data
                        @click="$wire.markRead('{{ $notif->id }}'); $nextTick(() => window.location.href = '{{ $url }}')"
                    @else
                        wire:click="markRead('{{ $notif->id }}')"
                    @endif>

                    <span class="mt-1.5 shrink-0 size-2 rounded-full {{ $isUnread ? 'bg-red' : 'bg-dark-light/40' }}" aria-hidden="true"></span>

                    <div class="flex-1 min-w-0">
                        <p class="font-serif text-xs text-dark leading-relaxed">
                            {{ $notif->data['message'] ?? __('general.new_notification') }}
                        </p>
                        <p class="font-sans text-[0.65rem] text-dark-mid mt-0.5">
                            {{ $notif->created_at->diffForHumans() }}
                        </p>
                    </div>
                </li>
            @empty
                <li class="px-4 py-10 text-center">
                    <p class="font-serif text-sm text-dark-mid">{{ __('general.no_notifications') }}</p>
                </li>
            @endforelse
        </ul>

    </div>
</div>
