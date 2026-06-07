<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ParticipantsFullNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Model $model,
        public string $modelLabel,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Complet : {$this->model->title}")
            ->line("{$this->modelLabel} **{$this->model->title}** a atteint le nombre maximum de participants.")
            ->line('Vous pouvez passer son statut à **Confirmé**.');
    }
}
