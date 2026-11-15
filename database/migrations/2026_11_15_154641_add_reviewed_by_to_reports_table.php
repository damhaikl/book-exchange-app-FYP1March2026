
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReportReviewedNotification extends Notification
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
        return ['database'];
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
