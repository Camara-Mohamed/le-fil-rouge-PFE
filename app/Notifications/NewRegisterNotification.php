<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRegisterNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Model $model,
        public string $modelLabel,
        public string $participantName,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Nouvelle inscription : {$this->model->title}")
            ->line("{$this->participantName} vient de s'inscrire à {$this->modelLabel} **{$this->model->title}**.");
    }
}
