<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModelChangedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Model $model,
        public string $modelLabel,
        public User $author,
        public bool $created = true,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $action = $this->created ? __('emails.created') : __('emails.modified');

        return (new MailMessage)
            ->subject(ucfirst($this->modelLabel).' '.$action.' : '.$this->model->title)
            ->view('emails.notifications.model-changed', [
                'model'      => $this->model,
                'modelLabel' => $this->modelLabel,
                'author'     => $this->author,
                'created'    => $this->created,
            ]);
    }
}
