<?php

namespace App\Notifications;

use App\Models\VolunteerRequest;
use Illuminate\Notifications\Messages\MailMessage;

class NewVolunteerRequestNotification extends BaseNotification
{
    public function __construct(public VolunteerRequest $volunteerRequest) {}

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle Demande de Volontaire — '.$this->volunteerRequest->fullName())
            ->view('emails.volunteer-request', [
                'volunteerRequest' => $this->volunteerRequest,
            ]);
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Nouvelle demande de bénévolat : '.$this->volunteerRequest->fullName(),
            'url' => route('admin.messages.index', ['locale' => app()->getLocale()]),
        ];
    }
}
