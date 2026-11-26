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
    public $cancelledBy;

    /**
     * Create a new message instance.
     */
    public function __construct($bookRequest, $status, $isCompleted = false, $cancelledBy = null)
    {
        $this->bookRequest = $bookRequest;
        $this->status = $status;
        $this->isCompleted = $isCompleted;
        $this->cancelledBy = $cancelledBy;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $bookTitle = $this->bookRequest->book->title ?? 'Book';

        $subject = match ($this->status) {
            'sell_schedule_proposed' =>
                "New Meeting Schedule Proposed – {$bookTitle}",

            'exchange_schedule_proposed' =>
                "New Exchange Meeting Schedule Proposed – {$bookTitle}",

            'exchange_schedule_accepted' =>
                "Exchange Approved – {$bookTitle}",

            'approved' =>
                "Request Approved – {$bookTitle}",

            'rejected' =>
                "Request Rejected – {$bookTitle}",

            'cancelled' =>
                "Request Cancelled – {$bookTitle}",

            'completed' =>
                "Transaction Completed – {$bookTitle}",

            default =>
                "New Request Received – {$bookTitle}",
        };

        return new Envelope(subject: $subject);
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