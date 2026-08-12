<?php

namespace App\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;

class ModelStatusNotification extends BaseNotification
{
    public function __construct(
        public Model $model,
        public string $modelLabel,
        public bool $published = true,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $action = $this->published ? __('emails.published') : __('emails.refused');

        return (new MailMessage)
            ->subject(ucfirst($this->modelLabel).' '.$action.' : '.$this->model->title)
            ->view('emails.notifications.model-status', [
                'model' => $this->model,
                'modelLabel' => $this->modelLabel,
                'published' => $this->published,
            ]);
    }
}
