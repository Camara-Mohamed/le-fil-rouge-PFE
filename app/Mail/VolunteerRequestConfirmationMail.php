<?php

namespace App\Mail;

use App\Models\VolunteerRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VolunteerRequestConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public VolunteerRequest $volunteerRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre demande de volontaire sera bientôt traité',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.volunteer-request-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
