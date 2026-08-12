<?php

namespace App\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;

class NewRegisterNotification extends BaseNotification
{
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
            ->subject(__('emails.new_register_subject', ['title' => $this->model->title]))
            ->view('emails.notifications.new-register', [
                'model' => $this->model,
                'modelLabel' => $this->modelLabel,
                'participantName' => $this->participantName,
            ]);
    }
}
