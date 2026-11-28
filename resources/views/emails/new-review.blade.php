<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Rating & Review Received</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <h2>UniKL MIIT BookHub</h2>

    <p>Hi, {{ $studentName }}.</p>

    <p>
        You have received a new rating and review for your transaction on UniKL MIIT BookHub.
    </p>

    <h3>Review Details</h3>

    <ul>
        <li>
            <strong>Book Title:</strong>
            {{ $bookTitle }}
        </li>
        <li>
            <strong>Reviewer Name:</strong>
            {{ $reviewerName }}
        </li>
        <li>
            <strong>Rating:</strong>
            {{ $rating }}/5 stars ⭐
        </li>
        <li>
            <strong>Review Comment:</strong>
            {{ $reviewComment ?: 'No written comment provided.' }}
        </li>
    </ul>

    <p>
        Please log in to UniKL MIIT BookHub to view the full review
        and read the feedback submitted by the student.
    </p>

    <p>Thank you for using UniKL MIIT BookHub!</p>

</body>
</html>