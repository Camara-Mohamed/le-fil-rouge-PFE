<?php

namespace App\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;

class RegisterStatusNotification extends BaseNotification
{
    public function __construct(
        public Model $model,
        public string $status,
    ) {}

    public function toMail(object $notifiable): MailMessage
    {
        $accepted = $this->status === 'accepted';

        return (new MailMessage)
            ->subject(($accepted ? __('emails.registration_accepted') : __('emails.registration_refused')).' : '.$this->model->title)
            ->view('emails.notifications.register-status', [
                'model' => $this->model,
                'accepted' => $accepted,
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        $accepted = $this->status === 'accepted';

        return [
            'message' => ($accepted ? __('emails.registration_accepted') : __('emails.registration_refused')).' : '.$this->model->title,
            'url' => $this->publicUrl($this->model),
        ];
    }
}
