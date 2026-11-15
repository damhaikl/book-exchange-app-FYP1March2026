<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportReviewedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reportId;
    protected $status;
    protected $reviewerName;
    protected $adminReview;
    protected $audience;

    public function __construct(
        $reportId,
        $status,
        $reviewerName,
        $adminReview,
        $audience
    ) {
        $this->reportId = $reportId;
        $this->status = $status;
        $this->reviewerName = $reviewerName;
        $this->adminReview = $adminReview;
        $this->audience = $audience;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusText = ucfirst($this->status);

        if ($this->audience === 'admin') {
            $message = "Admin {$this->reviewerName} reviewed Report #{$this->reportId}. Status: {$statusText}.";
        } else {
            $message = "Your Report #{$this->reportId} has been reviewed. Status: {$statusText}.";
        }

        return (new MailMessage)
            ->subject("UniKL MIIT BookHub - Report {$statusText}")
            ->greeting("Hello {$notifiable->name},")
            ->line($message)
            ->line('Admin Review:')
            ->line($this->adminReview ?: 'No additional comments provided.')
            ->line('Thank you for using UniKL MIIT BookHub.')
            ->salutation('Regards, UniKL MIIT BookHub Team');
    }

    public function toArray(object $notifiable): array
    {
        $statusText = ucfirst($this->status);

        if ($this->audience === 'admin') {
            $message = "Admin {$this->reviewerName} reviewed Report #{$this->reportId}. Status: {$statusText}.";
        } else {
            $message = "Your Report #{$this->reportId} has been reviewed. Status: {$statusText}.";
        }

        return [
            'type' => 'report_reviewed',
            'report_id' => $this->reportId,
            'status' => $this->status,
            'reviewer_name' => $this->reviewerName,
            'admin_review' => $this->adminReview,
            'audience' => $this->audience,
            'message' => $message,
        ];
    }
}
