<?php

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filter = 'all';

    public string $sort = 'desc';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
    }

    public function markRead(string $id): void
    {
        auth()->user()->notifications()->find($id)?->markAsRead();
    }

    public function markAllRead(): void
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        $this->dispatch('toast', message: __('pages/notifications.marked_all_read'), type: 'success');
    }

    public function deleteNotification(string $id): void
    {
        auth()->user()->notifications()->where('id', $id)->delete();
    }

    public function toggleEmailNotifications(): void
    {
        $user = auth()->user();
        $user->update(['email_notifications' => ! $user->email_notifications]);
        $this->dispatch('toast', message: __('pages/notifications.prefs_saved'), type: 'success');
    }

    public function render()
    {
        $query = auth()->user()
            ->notifications()
            ->when($this->search !== '', fn ($q) => $q->where('data', 'LIKE', "%{$this->search}%"))
            ->when($this->filter === 'unread', fn ($q) => $q->whereNull('read_at'))
            ->when($this->filter === 'read', fn ($q) => $q->whereNotNull('read_at'))
            ->orderBy('created_at', $this->sort);

        $unread = auth()->user()->unreadNotifications()->count();
        $notifications = $query->paginate(15);

        return view('pages.⚡notifications.notifications', compact('notifications', 'unread'))
            ->title(__('navigation.notifications'));
    }
};
