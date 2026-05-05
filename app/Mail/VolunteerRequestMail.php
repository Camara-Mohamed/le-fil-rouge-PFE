<?php

namespace App\Mail;

use AllowDynamicProperties;
use App\Models\VolunteerRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

#[AllowDynamicProperties]
class VolunteerRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public VolunteerRequest $volunteerRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle Demande de Volontaire — '.$this->volunteerRequest->fullName(),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.volunteer-request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
