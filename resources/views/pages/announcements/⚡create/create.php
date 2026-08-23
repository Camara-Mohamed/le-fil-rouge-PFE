<?php

use App\Enums\UserStatus;
use App\Livewire\Forms\AnnouncementForm;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public AnnouncementForm $form;

    public function save(): void
    {
        $this->authorize('create', Announcement::class);

        $announcement = $this->form->store(auth()->user());

        try {
            foreach (User::where('status', UserStatus::COMPLETE)->get() as $user) {
                $user->notify(new AnnouncementNotification($announcement));
            }
            Notification::route('mail', config('mail.notification_for_mails'))->notify(new AnnouncementNotification($announcement));
        } catch (Throwable) {
        }

        session()->flash('success', __('toast/announcements.created'));

        $this->redirectRoute('public.announcements.show', [
            'locale' => app()->getLocale(),
            'announcement' => $announcement,
        ]);
    }

    public function render()
    {
        return view('pages.announcements.⚡create.create')
            ->title(__('pages/announcements.create_page_title'));
    }
};
