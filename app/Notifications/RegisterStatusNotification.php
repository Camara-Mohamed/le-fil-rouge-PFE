<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Model $model,
        public string $status,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $accepted = $this->status === 'accepted';

        return (new MailMessage)
            ->subject(($accepted ? 'Inscription acceptée' : 'Inscription refusée').' : '.$this->model->title)
            ->line($accepted
                ? "Votre inscription à **{$this->model->title}** a été acceptée."
                : "Votre inscription à **{$this->model->title}** a été refusée."
            );
    }
}
