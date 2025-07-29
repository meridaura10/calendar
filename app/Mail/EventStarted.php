<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventStarted extends Mailable
{
    use Queueable, SerializesModels;

    public Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Розпочинається подія',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.event_started',
            with: ['title' => $this->event->title]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
