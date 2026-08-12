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

    public function toDatabase(object $notifiable): array
    {
        $action = $this->published ? __('emails.published') : __('emails.refused');

        return [
            'message' => ucfirst($this->modelLabel).' '.$action.' : '.$this->model->title,
            'url' => $this->publicUrl($this->model),
        ];
    }
}
