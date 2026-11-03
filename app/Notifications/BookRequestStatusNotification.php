<?php

namespace App\Notifications;

use App\Models\BookRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookRequestStatusNotification extends Notification
{
    use Queueable;

    public function __construct(private BookRequest $bookRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $this->bookRequest->loadMissing('book');
        $bookTitle = $this->bookRequest->book?->title ?? 'the book';
        $message = match ($this->bookRequest->status) {
            'approved' => sprintf('The seller approved your request for “%s”.', $bookTitle),
            'rejected' => sprintf('The seller declined your request for “%s”.', $bookTitle),
            'cancelled' => sprintf('Your request for “%s” was cancelled.', $bookTitle),
            'completed' => sprintf('Your request for “%s” was marked completed.', $bookTitle),
            default => sprintf('Your request for “%s” has a status update.', $bookTitle),
        };

        return [
            'type' => 'book_request_status',
            'book_request_id' => $this->bookRequest->id,
            'book_id' => $this->bookRequest->book_id,
            'book_title' => $bookTitle,
            'status' => $this->bookRequest->status,
            'message' => $message,
        ];
    }
}
