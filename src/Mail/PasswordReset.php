<?php

namespace Partymeister\Core\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    protected string $hash;

    /**
     * Create a new message instance.
     */
    public function __construct(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('partymeister-core-visitor-registration.password_reset_from_email'), config('partymeister-core-visitor-registration.password_reset_from_name')),
            subject: config('partymeister-core-visitor-registration.password_reset_subject_prefix') . 'PartyMeister password reset',
        );

    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text: 'partymeister-core::emails.visitors.password-forgotten',
            with: [
                'demoparty' => config('motor-cms-frontend.name'),
                'link' => url('/password-forgotten?t='.$this->hash),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
