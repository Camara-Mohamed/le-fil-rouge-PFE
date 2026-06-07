<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberChangedNotification extends Notification
{
    use Queueable;

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
        $mail = (new MailMessage)->subject('Modification de votre compte');

        if ($this->newRole) {
            $mail->line("Votre rôle a été mis à jour : **{$this->newRole}**.");
        }

        if ($this->newStatus) {
            $mail->line("Votre statut a été mis à jour : **{$this->newStatus}**.");
        }

        return $mail;
    }
}
