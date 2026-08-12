<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;

class ModelChangedNotification extends BaseNotification
{
    public function __construct(
        public Model $model,
        public string $modelLabel,
        public User $author,
        public bool $created = true,
    ) {}

    public function toMail(object $notifiable): MailMessage
    {
        $action = $this->created ? __('emails.created') : __('emails.modified');

        return (new MailMessage)
            ->subject(ucfirst($this->modelLabel).' '.$action.' : '.$this->model->title)
            ->view('emails.notifications.model-changed', [
                'model' => $this->model,
                'modelLabel' => $this->modelLabel,
                'author' => $this->author,
                'created' => $this->created,
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        $action = $this->created ? __('emails.created') : __('emails.modified');

        return [
            'message' => ucfirst($this->modelLabel).' '.$action.' : '.$this->model->title,
            'url' => $this->publicUrl($this->model),
        ];
    }
}
