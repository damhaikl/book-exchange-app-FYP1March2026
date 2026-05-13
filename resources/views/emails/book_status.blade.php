<!DOCTYPE html>
<html>
<head>
    <title>Book Status Update</title>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2>📚 Book Request Update</h2>

    <p>Hello,</p>

    <p>Book request status has been updated.</p>

    <p><strong>Book Name:</strong> {{ $bookRequest->book->title ?? 'Unknown Book' }}</p>

    <p><strong>Status:</strong> {{ strtoupper($status) }}</p>
    @if($status == 'completed' && $isCompleted)

    <p style="color: blue;">
        <p><strong>Book:</strong> {{ $bookRequest->book->title }}</p>
        📦 This transaction has been successfully completed.
    </p>
    @elseif($status == 'pending')
        <p style="color: orange;">
            📚 Someone has requested your book.
        </p>
        <p><strong>Book:</strong> {{ $bookRequest->book->title }}</p>
        <p><strong>Request By:</strong> {{ $bookRequest->requester->name }}</p>
    @elseif($status == 'approved')
        <p style="color: green;">✅ Your request has been approved.</p>
    @elseif($status == 'rejected')
        <p style="color: red;">❌ Your request has been rejected.</p>
    @elseif($status == 'cancelled')
        <p>The request for your book has been cancelled.</p>
    @endif

</body>
</html>