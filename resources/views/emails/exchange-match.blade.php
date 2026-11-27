
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Exchange Match</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    
    <h2>📚 UniKL BookHub</h2>

    <p>Hi, {{ $studentName }}.</p>

    <p>
        Good news! UniKL MIIT BookHub has found a potential
        mutual book exchange match for you.
    </p>

    <h3>Exchange Match Details</h3>

    <p><strong>Your Exchange:</strong></p>

    <ul>
        <li>
            <strong>Your Offered Book:</strong>
            {{ $myBookTitle }}
        </li>
        <li>
            <strong>Your Wanted Book:</strong>
            {{ $matchedBookTitle }}
        </li>
    </ul>

    <p><strong>Other Student's Exchange:</strong></p>

    <ul>
        <li>
            <strong>Their Offered Book:</strong>
            {{ $matchedBookTitle }}
        </li>
        <li>
            <strong>Their Wanted Book:</strong>
            {{ $myBookTitle }}
        </li>
        <li>
            <strong>Student Name:</strong>
            {{ $matchedStudentName }}
        </li>
    </ul>

    <p>
        Both students are offering the books that the other student
        wants. This means you have a potential book exchange match!
    </p>

    <p>
        Please note that this is only a potential match.
        The exchange is not confirmed until both students agree
        to proceed with the exchange arrangements.
    </p>

    <p>Please log in to UniKL MIIT BookHub to view the details.</p>

</body>
</html>
