<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Review $review)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase(object $notifiable): array
    {
        $this->review->loadMissing(['user', 'book']);

        $reviewerName = $this->review->user?->name ?? 'Another student';
        $bookTitle = $this->review->book?->title ?? 'the book';

        return [
            'type' => 'new_review',
            'review_id' => $this->review->id,
            'book_request_id' => $this->review->book_request_id,
            'book_id' => $this->review->book_id,
            'book_title' => $bookTitle,
            'reviewer_id' => $this->review->user_id,
            'rating' => $this->review->rating,
            'message' => sprintf(
                '%s has submitted a rating and review for you. Check your profile to view the feedback.',
                $reviewerName
            ),
        ];
    }

    public function toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
    {
        $this->review->loadMissing(['user', 'book']);

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('New Rating & Review Received - UniKL MIIT BookHub')
            ->view('emails.new-review', [
                'studentName' => $notifiable->name,
                'reviewerName' => $this->review->user?->name ?? 'Another student',
                'bookTitle' => $this->review->book?->title ?? 'the book',
                'rating' => $this->review->rating,
                'reviewComment' => $this->review->comment,
            ]);
    }
}