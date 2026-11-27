<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExchangeMatchNotification extends Notification
{
    use Queueable;

    public function __construct(
        private int $myBookId,
        private int $matchedBookId,
        private string $myBookTitle,
        private string $matchedBookTitle,
        private string $matchedStudentName,
        private string $matchKey
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'exchange_match',
            'my_book_id' => $this->myBookId,
            'matched_book_id' => $this->matchedBookId,
            'my_book_title' => $this->myBookTitle,
            'matched_book_title' => $this->matchedBookTitle,
            'matched_student_name' => $this->matchedStudentName,
            'match_key' => $this->matchKey,
            'message' => sprintf(
                'A mutual exchange match was found between your book “%s” and “%s”.',
                $this->myBookTitle,
                $this->matchedBookTitle
            ),
        ];
    }
}
