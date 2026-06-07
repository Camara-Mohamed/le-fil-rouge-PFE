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
        $action = $this->created ? 'créé' : 'modifié';

        return (new MailMessage)
            ->subject(ucfirst($this->modelLabel).' '.($this->created ? 'créé' : 'modifié').' : '.$this->model->title)
            ->line("{$this->author->fullName()} a {$action} {$this->modelLabel} **{$this->model->title}**.");
    }
}
