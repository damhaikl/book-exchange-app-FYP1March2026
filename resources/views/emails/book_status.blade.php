<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UniKL BookHub Notification</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px; color: #333;">

    <h2>📚 UniKL BookHub</h2>

    @if($status === 'pending')

        <p>Hello {{ $bookRequest->owner->name ?? 'Student' }},</p>

        <p>
            You have received a new request for your listed book.
        </p>

        <ul>
            <li>
                <strong>Book:</strong>
                {{ $bookRequest->book->title ?? 'Unknown Book' }}
            </li>
            <li>
                <strong>Requested By:</strong>
                {{ $bookRequest->requester->name ?? 'Unknown Student' }}
            </li>
            <li>
                <strong>Status:</strong>
                Pending
            </li>
        </ul>

        <p>
            Please log in to UniKL MIIT BookHub to review and respond to this request.
        </p>

    @elseif($status === 'approved')

        <p>Hello {{ $bookRequest->requester->name ?? 'Student' }},</p>

        <p style="color: green;">
            ✅ Your {{ ucfirst($bookRequest->book->listing_type ?? 'book') }} request has been approved.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to view your request.
        </p>

    @elseif($status === 'rejected')

        <p>Hello {{ $bookRequest->requester->name ?? 'Student' }},</p>

        <p style="color: red;">
            ❌ Your {{ ucfirst($bookRequest->book->listing_type ?? 'book') }} request has been rejected.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to view your request.
        </p>

    @elseif($status === 'cancelled')

        <p>Hello,</p>

        <p style="color: orange;">
            Your book request has been cancelled.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to view the updated request status.
        </p>

    @elseif($status === 'sell_schedule_proposed')

        <p>Hello,</p>

        <p style="color: #1d4ed8;">
            📅 A new Sell meeting schedule has been proposed.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to review the proposed schedule.
        </p>

    @elseif($status === 'exchange_schedule_proposed')

        <p>Hello,</p>

        <p style="color: #1d4ed8;">
            📅 A new Exchange meeting schedule has been proposed.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to review the proposed schedule.
        </p>

    @elseif($status === 'exchange_accepted')

        <p>Hello {{ $bookRequest->requester->name ?? 'Student' }},</p>

        <p style="color: green;">
            ✅ Your Exchange request has been accepted.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to view the Exchange details.
        </p>

    @elseif($status === 'exchange_rejected')

        <p>Hello {{ $bookRequest->requester->name ?? 'Student' }},</p>

        <p style="color: red;">
            ❌ Your Exchange request has been rejected.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to view your request.
        </p>

    @elseif($status === 'handover_confirmed')

        <p>Hello,</p>

        <p style="color: green;">
            📦 The other student has confirmed the physical book handover.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to confirm your handover.
        </p>

    @elseif($status === 'completed' && $isCompleted)

        <p>Hello,</p>

        <p style="color: blue;">
            🎉 Both students have confirmed the physical handover.
        </p>

        <p>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </p>

        <p>
            This transaction has been successfully completed on UniKL MIIT BookHub.
        </p>

    @endif

    <hr style="border: none; border-top: 1px solid #ddd; margin-top: 25px;">

    <p style="font-size: 12px; color: #777;">
        This is an automated notification from UniKL MIIT BookHub.
        Please do not reply to this email.
    </p>

</body>
</html>
