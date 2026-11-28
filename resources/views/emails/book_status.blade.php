<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UniKL MIIT BookHub Notification</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 20px; color: #333;">

    <h2>📚 UniKL MIIT BookHub</h2>

    @if($status === 'pending')

    <p>Hi,</p>
    <p>{{ $bookRequest->owner->name ?? 'Student' }},</p>

    @if(($bookRequest->book->listing_type ?? '') === 'exchange')

        <p>
            You have received a new Exchange request for your listed book.
        </p>

        <ul>
            <li>
                <strong>Your Book:</strong>
                {{ $bookRequest->book->title ?? 'Unknown Book' }}
            </li>
            <li>
                <strong>Offered Book:</strong>
                {{ $bookRequest->exchangeOffer->title ?? 'Unknown Book' }}
            </li>
            <li>
                <strong>Requested By:</strong>
                {{ $bookRequest->requester->name ?? 'Unknown Student' }}
            </li>
            <li>
                <strong>Status:</strong>
                {{ ucfirst($bookRequest->status) }}
            </li>
        </ul>
        @if($bookRequest->status === 'negotiation')
            <p>
                The requester has suggested a different meeting schedule.
            </p>
        @endif

    @else

        <p>
            You have received a new Sell request for your listed book.
        </p>

        <ul>
            <li>
                <strong>Your Book:</strong>
                {{ $bookRequest->book->title ?? 'Unknown Book' }}
            </li>
            <li>
                <strong>Requested By:</strong>
                {{ $bookRequest->requester->name ?? 'Unknown Student' }}
            </li>
            <li>
                <strong>Status:</strong>
                {{ ucfirst($bookRequest->status) }}
            </li>
        </ul>

        @if($bookRequest->status === 'negotiation')
            <p>
                The requester has suggested a different meeting schedule.
            </p>
        @endif

    @endif

    <p>
        Please log in to UniKL MIIT BookHub to review and respond to this request.
    </p>

    @elseif($status === 'approved')

        <p>Hi, {{ $bookRequest->requester->name ?? 'Student' }}.</p>

        @if($bookRequest->book->listing_type === 'sell')

            <p style="color: green;">
                ✅ Good news! Your Request for the following book has been approved by the book owner.
            </p>

            <p><strong>Request Details</strong></p>

            <ul>
                <li>
                    <strong>Book:</strong>
                    {{ $bookRequest->book->title ?? 'Unknown Book' }}
                </li>
                <li>
                    <strong>Approved By:</strong>
                    {{ $bookRequest->owner->name ?? 'Book Owner' }}
                </li>
                <li><strong>Status:</strong> Approved</li>
            </ul>

            <p><strong>Final Agreed Schedule</strong></p>

            <ul>
                <li>
                    <strong>Location:</strong>
                    {{ $bookRequest->book->meeting_location ?? 'Not specified' }}
                </li>
                <li>
                    <strong>Date:</strong>
                    {{ $bookRequest->book->meeting_date ?? 'Not specified' }}
                </li>
                <li>
                    <strong>Time:</strong>
                    {{ $bookRequest->book->meeting_time ?? 'Not specified' }}
                    –
                    {{ $bookRequest->book->meeting_end_time ?? 'Not specified' }}
                </li>
            </ul>

            <p>
                Your request has been successfully approved. Please attend the agreed meeting to collect your book.
            </p>

        @else

            <p style="color: green;">
                ✅ Good news! Your Exchange request has been accepted by the book owner.
            </p>

            <p><strong>Exchange Details</strong></p>

            <ul>
                <li>
                    <strong>Your Book:</strong>
                    {{ $bookRequest->exchangeOffer->title ?? 'Unknown Book' }}
                </li>
                <li>
                    <strong>Offered Book:</strong>
                    {{ $bookRequest->book->title ?? 'Unknown Book' }}
                </li>
                <li>
                    <strong>Accepted By:</strong>
                    {{ $bookRequest->owner->name ?? 'Book Owner' }}
                </li>
                <li><strong>Status:</strong> Approved</li>
            </ul>

            <p><strong>Final Agreed Schedule</strong></p>

            <ul>
                <li>
                    <strong>Location:</strong>
                    {{ $bookRequest->proposed_location ?? 'Not specified' }}
                </li>
                <li>
                    <strong>Date:</strong>
                    {{ $bookRequest->proposed_date ?? 'Not specified' }}
                </li>
                <li>
                    <strong>Time:</strong>
                    {{ $bookRequest->proposed_time ?? 'Not specified' }}
                    –
                    {{ $bookRequest->proposed_end_time ?? 'Not specified' }}
                </li>
            </ul>

            <p>
                Your Exchange arrangement has been successfully confirmed.
                Please bring your offered book to the agreed meeting to complete the exchange.
            </p>

        @endif

        <p>
            Please log in to UniKL MIIT BookHub to view your request details.
        </p>

    @elseif($status === 'rejected')

        <p>Hi, {{ $bookRequest->requester->name ?? 'Student' }}.</p>

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

        <p>Hi,</p>

        <p style="color: red;">
            @if(($bookRequest->book->listing_type ?? '') === 'exchange')
                ❌ Your Exchange request has been cancelled.
            @else
                ❌ Your Sell request has been cancelled.
            @endif
        </p>

        <ul>
            @if(($bookRequest->book->listing_type ?? '') === 'exchange')

                <li>
                    <strong>Your Book:</strong>
                    {{ $bookRequest->book->title ?? 'Unknown Book' }}
                </li>

                <li>
                    <strong>Offered Book:</strong>
                    {{ $bookRequest->exchangeOffer->title ?? 'Unknown Book' }}
                </li>

            @else

                <li>
                    <strong>Book:</strong>
                    {{ $bookRequest->book->title ?? 'Unknown Book' }}
                </li>

            @endif

            <li>
                <strong>Cancelled By:</strong>
                {{ $cancelledBy ?? 'Unknown Student' }}
            </li>
        </ul>

        <p>
            Please log in to UniKL MIIT BookHub to view the updated request status.
        </p>

    @elseif($status === 'sell_schedule_proposed')

    <p>
        Hi
        {{ $bookRequest->schedule_type === 'seller'
            ? ($bookRequest->requester->name ?? 'Student')
            : ($bookRequest->owner->name ?? 'Student') }},
    </p>

    <p style="color: #1d4ed8;">
        📅 A new Sell meeting schedule has been proposed.
    </p>

    @if($bookRequest->schedule_type === 'seller')
        <p>
            The book owner has proposed a different meeting schedule
            for your Sell request.
        </p>
    @else
        <p>
            The requester has proposed a different meeting schedule
            for the Sell request.
        </p>
    @endif

    <p><strong>Sell Request Details</strong></p>

    <ul>
        <li>
            <strong>Book:</strong>
            {{ $bookRequest->book->title ?? 'Unknown Book' }}
        </li>
        <li>
            <strong>Proposed By:</strong>
            {{ $bookRequest->schedule_type === 'seller'
                ? ($bookRequest->owner->name ?? 'Unknown Student')
                : ($bookRequest->requester->name ?? 'Unknown Student') }}
        </li>
        <li>
            <strong>Status:</strong>
            Negotiation
        </li>
    </ul>

    <p><strong>New Proposed Schedule</strong></p>

    <ul>
        <li>
            <strong>Location:</strong>
            {{ $bookRequest->proposed_location ?? 'Not specified' }}
        </li>
        <li>
            <strong>Date:</strong>
            {{ $bookRequest->proposed_date ?? 'Not specified' }}
        </li>
        <li>
            <strong>Time:</strong>
            {{ $bookRequest->proposed_time ?? 'Not specified' }}
            –
            {{ $bookRequest->proposed_end_time ?? 'Not specified' }}
        </li>
    </ul>

    <p>
        Please log in to UniKL MIIT BookHub to review the proposed schedule.
        You can accept the schedule or propose another schedule.
    </p>

   

    @elseif($status === 'exchange_schedule_proposed')

        <p>
            Hi
            {{ $bookRequest->schedule_type === 'owner'
                ? ($bookRequest->requester->name ?? 'Student')
                : ($bookRequest->owner->name ?? 'Student') }},
        </p>

        <p style="color: #1d4ed8;">
            📅 A new Exchange meeting schedule has been proposed.
        </p>

        @if($bookRequest->schedule_type === 'owner')
            <p>
                The book owner has proposed a different meeting schedule
                for your Exchange request.
            </p>
        @else
            <p>
                The requester has proposed a different meeting schedule
                for the Exchange request.
            </p>
        @endif

        <p><strong>Exchange Details</strong></p>

        <ul>
            <li>
                <strong>Your Book:</strong>
                {{ $bookRequest->exchangeOffer->title ?? 'Unknown Book' }}
            </li>
            <li>
                <strong>Requested Book:</strong>
                {{ $bookRequest->book->title ?? 'Unknown Book' }}
            </li>
            <li>
                <strong>Proposed By:</strong>
                {{ $bookRequest->schedule_type === 'owner'
                    ? ($bookRequest->owner->name ?? 'Unknown Student')
                    : ($bookRequest->requester->name ?? 'Unknown Student') }}
            </li>
            <li>
                <strong>Status:</strong>
                {{ ucfirst($bookRequest->status) }}
            </li>
        </ul>

        <p><strong>New Proposed Schedule</strong></p>

        <ul>
            <li>
                <strong>Location:</strong>
                {{ $bookRequest->proposed_location ?? 'Not specified' }}
            </li>
            <li>
                <strong>Date:</strong>
                {{ $bookRequest->proposed_date ?? 'Not specified' }}
            </li>
            <li>
                <strong>Time:</strong>
                {{ $bookRequest->proposed_time ?? 'Not specified' }}
                –
                {{ $bookRequest->proposed_end_time ?? 'Not specified' }}
            </li>
        </ul>

        <p>
            Please log in to UniKL MIIT BookHub to review the proposed
            schedule. You can accept it or propose another schedule.
        </p>

    @elseif($status === 'exchange_schedule_accepted')

        <p>Hi, {{ $bookRequest->owner->name ?? 'Student' }}.</p>

        <p style="color: green;">
            ✅ Good News! The requester has accepted your proposed Exchange meeting schedule.
        </p>

        <p><strong>Exchange Details</strong></p>

        <ul>
            <li>
                <strong>Your Book:</strong>
                {{ $bookRequest->book->title ?? 'Unknown Book' }}
            </li>
            <li>
                <strong>Offered Book:</strong>
                {{ $bookRequest->exchangeOffer->title ?? 'Unknown Book' }}
            </li>
            <li>
                <strong>Accepted By:</strong>
                {{ $bookRequest->requester->name ?? 'Unknown Student' }}
            </li>
            <li>
                <strong>Status:</strong>
                Approved
            </li>
        </ul>

        <p><strong>Final Agreed Schedule</strong></p>

        <ul>
            <li>
                <strong>Location:</strong>
                {{ $bookRequest->proposed_location ?? 'Not specified' }}
            </li>
            <li>
                <strong>Date:</strong>
                {{ $bookRequest->proposed_date ?? 'Not specified' }}
            </li>
            <li>
                <strong>Time:</strong>
                {{ $bookRequest->proposed_time ?? 'Not specified' }}
                –
                {{ $bookRequest->proposed_end_time ?? 'Not specified' }}
            </li>
        </ul>

        <p>
            The Exchange meeting schedule has been confirmed.
            Please attend the agreed meeting to complete the exchange.
        </p>

        <p>
            Please log in to UniKL MIIT BookHub to view your Exchange details.
        </p>

    @elseif($status === 'exchange_accepted')

        <p>Hi, {{ $bookRequest->requester->name ?? 'Student' }}.</p>

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

        <p>Hi, {{ $bookRequest->requester->name ?? 'Student' }}.</p>

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

        Hi, {{ $recipientName }}.</p>

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

        Hi, {{ $recipientName }}.</p>

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
