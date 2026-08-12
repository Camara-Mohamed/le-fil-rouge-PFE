<?php

namespace App\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;

class ParticipantsFullNotification extends BaseNotification
{
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
            ->subject(__('emails.participants_full_subject', ['title' => $this->model->title]))
            ->view('emails.notifications.participants-full', [
                'model' => $this->model,
                'modelLabel' => $this->modelLabel,
            ]);
    }
}
