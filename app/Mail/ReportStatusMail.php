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

    public function __construct($report, $status)
    {
        $this->report = $report;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Report Notification')
                    ->view('emails.report_status');
    }
}