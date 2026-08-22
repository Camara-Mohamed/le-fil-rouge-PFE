<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Notifications\Messages\MailMessage;

class NewContactMessageNotification extends BaseNotification
{
    public function __construct(public ContactMessage $contactMessage) {}

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau Message - '.$this->contactMessage->sujet)
            ->view('emails.contact-message', [
                'contactMessage' => $this->contactMessage,
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Nouveau message de contact : '.$this->contactMessage->full_name,
            'url' => route('admin.messages.index', ['locale' => app()->getLocale()]),
        ];
    }
}
