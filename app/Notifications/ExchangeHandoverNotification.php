<?php

namespace App\Notifications;

use App\Models\BookRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExchangeHandoverNotification extends Notification
{
    use Queueable;

    public function __construct(
        private BookRequest $bookRequest,
        private string $notificationType,
        private string $message
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $this->bookRequest->loadMissing('book');

        $bookTitle = $this->bookRequest->book?->title ?? 'the book';

        return [
            'type' => $this->notificationType,
            'book_request_id' => $this->bookRequest->id,
            'book_id' => $this->bookRequest->book_id,
            'book_title' => $bookTitle,
            'status' => $this->bookRequest->status,
            'message' => $this->message,
        ];
    }
}
