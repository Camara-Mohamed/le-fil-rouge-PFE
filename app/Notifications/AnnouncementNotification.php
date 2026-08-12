<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Notifications\Messages\MailMessage;

class AnnouncementNotification extends BaseNotification
{
    public function __construct(public Announcement $announcement) {}

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.announcement_subject', ['title' => $this->announcement->title]))
            ->view('emails.notifications.announcement', ['announcement' => $this->announcement]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => __('emails.announcement_subject', ['title' => $this->announcement->title]),
            'url' => $this->publicUrl($this->announcement),
        ];
    }
}
