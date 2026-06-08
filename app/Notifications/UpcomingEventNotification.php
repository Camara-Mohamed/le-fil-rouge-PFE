<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpcomingEventNotification extends Notification
{
    use Queueable;

    public function __construct(public Model $model) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.upcoming_event_subject', ['title' => $this->model->title]))
            ->view('emails.notifications.upcoming-event', ['model' => $this->model]);
    }
}
