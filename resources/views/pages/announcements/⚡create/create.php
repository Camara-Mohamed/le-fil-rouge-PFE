<?php

use App\Livewire\Forms\AnnouncementForm;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Title('Ajouter une actualité')] class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public AnnouncementForm $form;

    public function save(): void
    {
        $this->authorize('create', Announcement::class);

        $announcement = $this->form->store(auth()->user());

        try {
            foreach (User::all() as $user) {
                $user->notify(new AnnouncementNotification($announcement));
            }
            Notification::route('mail', config('mail.reply_to.address'))->notify(new AnnouncementNotification($announcement));
        } catch (\Throwable) {}

        session()->flash('success', __('toast/announcements.created'));

        $this->redirectRoute('admin.announcements.edit', [
            'locale' => app()->getLocale(),
            'announcement' => $announcement,
        ]);
    }

    public function render()
    {
        return view('pages.announcements.⚡create.create');
    }
};
