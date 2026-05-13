<!DOCTYPE html>
<html>
<head>
    <title>Book Status Update</title>
</head>
<body style="font-family: Arial; padding: 20px;">

    <h2>📚 Book Request Update</h2>

    <p>Hello,</p>

    <p>Your book request status has been updated.</p>

    <p><strong>Book Name:</strong> {{ $bookRequest->book->title ?? 'Unknown Book' }}</p>

    <p><strong>Status:</strong> {{ strtoupper($status) }}</p>
    @if($status == 'pending')
        <p style="color: orange;">
            📚 Someone has requested your book.
        </p>
    @elseif($status == 'approved')
        <p style="color: green;">✅ Your request has been approved.</p>
    @elseif($status == 'rejected')
        <p style="color: red;">❌ Your request has been rejected.</p>
    @elseif($status == 'completed')
        <p style="color: blue;">📦 Transaction completed.</p>
    @elseif($status == 'cancelled')
        <p>The request for your book has been cancelled.</p>

        <p><strong>Book:</strong> {{ $bookRequest->book->title }}</p>
        <p><strong>By:</strong> {{ $bookRequest->requester->name }}</p>
    @endif

</body>
</html>