<!DOCTYPE html>
<html>
<head>
    <title>Edit Schedule</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:#f8f9fa;">

<div class="container mt-5">

    <div class="card p-4 shadow-sm mx-auto" style="max-width:500px;">

        <h3 class="mb-3">📅 Edit Meeting Schedule</h3>

        <form method="POST"
              action="{{ route('book.schedule.update', $book->id) }}">

            @csrf

            <div class="mb-3">
                <label>📍 Location</label>
                <input type="text"
                       name="meeting_location"
                       class="form-control"
                       value="{{ $book->meeting_location }}"
                       required>
            </div>

            <div class="mb-3">
                <label>📅 Date</label>
                <input type="date"
                       name="meeting_date"
                       class="form-control"
                       value="{{ $book->meeting_date }}"
                       required>
            </div>

            <div class="mb-3">
                <label>⏰ Time</label>
                <input type="time"
                       name="meeting_time"
                       class="form-control"
                       value="{{ $book->meeting_time }}"
                       required>
            </div>

            <button class="btn btn-primary w-100">
                💾 Save Changes
            </button>

        </form>

    </div>

</div>

</body>
</html>