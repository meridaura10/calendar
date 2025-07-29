<?php

namespace App\Mail;

use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReminderStarted extends Mailable
{
    use Queueable, SerializesModels;

    public Reminder $reminder;

    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Нагадування',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reminder_started',
            with: ['title' => $this->reminder->title]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
