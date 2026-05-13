<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Propose New Schedule</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f8f9fa;">

<div class="container mt-5">

    <div class="card p-4 shadow-sm mx-auto" style="max-width:600px;">

        <h3 class="mb-4">🔁 Propose New Schedule</h3>

        <p>
            You are requesting:
            <strong>{{ $book->title }}</strong>
        </p>

        <!-- Seller Original Schedule -->
        <div class="alert alert-info">

            <h5>📍 Seller Original Schedule</h5>

            <p><b>Location:</b> {{ $book->meeting_location }}</p>
            <p><b>Date:</b> {{ $book->meeting_date }}</p>
            <p><b>Time:</b> {{ $book->meeting_time }}</p>

        </div>

        <!-- Proposal Form -->
        <form method="POST"
              action="{{ route('book.proposeSchedule', $book->id) }}">

            @csrf

            <div class="mb-3">
                <label>📍 Proposed Location</label>
                <input type="text"
                       name="proposed_location"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>📅 Proposed Date</label>
                <input type="date"
                       name="proposed_date"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>⏰ Proposed Time</label>
                <input type="time"
                       name="proposed_time"
                       class="form-control"
                       required>
            </div>

            <button class="btn btn-primary w-100">
                🚀 Send Proposal
            </button>

        </form>

    </div>

</div>

</body>
</html>