<?php

namespace App\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;

class UpcomingEventNotification extends BaseNotification
{
    public function __construct(public Model $model) {}

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.upcoming_event_subject', ['title' => $this->model->title]))
            ->view('emails.notifications.upcoming-event', ['model' => $this->model]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => __('emails.upcoming_event_subject', ['title' => $this->model->title]),
            'url' => $this->publicUrl($this->model),
        ];
    }
}
