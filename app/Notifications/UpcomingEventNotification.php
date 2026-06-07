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
            ->subject(__('notifications.upcoming_event.subject', ['title' => $this->model->title]))
            ->line(__('notifications.upcoming_event.line1', ['title' => $this->model->title]))
            ->line(__('notifications.upcoming_event.line2', ['date' => $this->model->start_date->translatedFormat('d MMMM Y')]));
    }
}
