<?php

namespace App\Livewire\Widgets;

use Livewire\Attributes\On;
use Livewire\Component;

class NotificationBell extends Component
{
    public bool $open = false;

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    public function markAllRead(): void
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        $this->open = false;
    }

    public function markRead(string $notifId): void
    {
        auth()->user()->notifications()->find($notifId)?->markAsRead();
    }

    #[On('notification-received')]
    public function refresh(): void {}

    public function render()
    {
        $notifications = auth()->user()->notifications()->latest()->limit(10)->get();

        return view('livewire.widgets.notification-bell', [
            'notifications' => $notifications,
            'unread' => $notifications->whereNull('read_at')->count(),
        ]);
    }
}
