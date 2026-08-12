<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentUploadedNotification extends BaseNotification
{
    public function __construct(public User $member) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.document_subject', ['name' => $this->member->fullName()]))
            ->view('emails.notifications.document-uploaded', ['member' => $this->member]);
    }
}
