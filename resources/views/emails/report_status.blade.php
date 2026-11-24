
<!DOCTYPE html>
<html>
<head>
    <title>Report Notification</title>
</head>
<body style="font-family: Arial; padding: 20px;">

    @if($status == 'pending')

        <h2>New Report Submitted</h2>

        <p>A new report has been submitted and requires your review.</p>

    @elseif($status == 'resolved')

        <h2>Report Resolved</h2>

        @if($audience == 'admin')
            <p>
                Admin {{ $reviewerName }} has reviewed Report #{{ $report->id }}
                and marked it as resolved.
            </p>
        @else
            <p>Your submitted report has been reviewed and resolved by an administrator.</p>
        @endif

    @elseif($status == 'rejected')

        <h2>Report Rejected</h2>

        @if($audience == 'admin')
            <p>
                Admin {{ $reviewerName }} has reviewed Report #{{ $report->id }}
                and marked it as rejected.
            </p>
        @else
            <p>Your submitted report has been reviewed and rejected by an administrator.</p>
        @endif

    @endif

    <hr>

    <p><strong>Report ID:</strong> {{ $report->id }}</p>
    <p><strong>Status:</strong> {{ strtoupper($status) }}</p>
    <p><strong>Reporting Student:</strong> {{ $report->user->name }}</p>
    <p><strong>Book:</strong> {{ $report->book->title }}</p>
    <p><strong>Reason:</strong> {{ $report->reason }}</p>

    @if($status == 'resolved' || $status == 'rejected')
        <p><strong>Admin Review:</strong></p>
        <p>{{ $report->admin_review ?: 'No additional comments provided.' }}</p>
    @endif

    @if($status == 'pending')
        <p>Please review the report in the admin panel.</p>
    @elseif($audience == 'student')
        <p>You can view your report status in the student panel.</p>
    @else
        <p>Please review the report in the admin panel.</p>
    @endif

    <hr>

    <p>Regards,<br>UniKL MIIT BookHub Team</p>

</body>
</html>
