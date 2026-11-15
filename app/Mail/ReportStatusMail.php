<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $status;
    public $audience;
    public $reviewerName;

    public function __construct($report, $status, $audience = 'admin', $reviewerName = null)
    {
        $this->report = $report;
        $this->status = $status;
        $this->audience = $audience;
        $this->reviewerName = $reviewerName;
    }

    public function build()
    {
        return $this->subject('UniKL MIIT BookHub - Report ' . ucfirst($this->status))
                    ->view('emails.report_status');
    }
}
