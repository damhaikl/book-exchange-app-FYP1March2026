<!DOCTYPE html>
<html>
<head>
    <title>Report Notification</title>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2>🚨 New Report Submitted</h2>

    @if($status == 'pending')

    <p>A new report has been submitted.</p>

    <p><strong>Status:</strong> {{ strtoupper($status) }}</p>

    <p><strong>User:</strong> {{ $report->user->name }}</p>

    <p><strong>Book:</strong> {{ $report->book->title }}</p>

    <p><strong>Reason:</strong> {{ $report->reason }}</p>

    <p>Please review the report in the admin panel.</p>
    @elseif($status == 'resolved')
        <p>
            <strong>Status:</strong>
            {{ strtoupper($status) }}
        </p>
                <p>
        Please review the report in the student panel.
        </p>
    @elseif($status == 'rejected')
        <p>
            <strong>Status:</strong>
            {{ strtoupper($status) }}
        </p>
        <p>
        Please review the report in the student panel.
        </p>
    @endif

</body>
</html>