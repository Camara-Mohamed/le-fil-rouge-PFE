<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;

class NewCommentNotification extends BaseNotification
{
    public function __construct(
        public Model $model,
        public User $author,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.new_comment_subject', ['title' => $this->model->title]))
            ->view('emails.notifications.new-comment', [
                'model' => $this->model,
                'author' => $this->author,
            ]);
    }
}
