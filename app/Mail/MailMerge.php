<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

//https://dev.to/capsulescodes/craft-emails-with-laravel-vue-and-tailwind-using-inertia-mailable-3m7?context=digest
class MailMerge extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct() {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Votre fiche');
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.welcome');
    }

    public function attachments(): array
    {
        return [];
    }
}
