<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $bookRequest;
    public $status;
    public $isCompleted;

    /**
     * Create a new message instance.
     */
    public function __construct($bookRequest, $status, $isCompleted = false)
    {
        $this->bookRequest = $bookRequest;
        $this->status = $status;
        $this->isCompleted = $isCompleted;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Book Request Status Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.book_status',
        );
    }

    /**
     * Get attachments (not used)
     */
    public function attachments(): array
    {
        return [];
    }
}