<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

class MemberChangedNotification extends BaseNotification
{
    public function __construct(
        public ?string $newRole = null,
        public ?string $newStatus = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.member_changed_subject'))
            ->view('emails.notifications.member-changed', [
                'newRole' => $this->newRole,
                'newStatus' => $this->newStatus,
            ]);
    }
}
