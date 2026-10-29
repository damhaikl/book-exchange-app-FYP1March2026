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

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <p>
            You are requesting:
            <strong>{{ $book->title }}</strong>
        </p>

        <!-- Seller Original Schedule -->
        <div class="alert alert-info">

            <h5>📍 Seller Original Schedule</h5>

            <p><b>Location:</b> {{ $book->meeting_location }}</p>
            <p><b>Date:</b> {{ $book->meeting_date }}</p>
            <p><b>Time:</b>
                {{ $book->meeting_time ? \Carbon\Carbon::parse($book->meeting_time)->format('g:i A') : 'Not set' }}
                @if($book->meeting_end_time)
                    – {{ \Carbon\Carbon::parse($book->meeting_end_time)->format('g:i A') }}
                @endif
            </p>

        </div>

        <!-- Proposal Form -->
        <form method="POST"
              action="{{ $proposal ? route('book.proposeSchedule.update', $book->id) : route('book.proposeSchedule', $book->id) }}">
            @csrf
            <input type="hidden" name="return_to" value="{{ $returnTo }}">
            @if($proposal)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label>📍 Proposed Location</label>
                <input type="text"
                       name="proposed_location"
                       class="form-control"
                       value="{{ old('proposed_location', $proposal?->proposed_location) }}"
                       required>
                @error('proposed_location')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label>📅 Proposed Date</label>
                <input type="date"
                       name="proposed_date"
                       class="form-control"
                       value="{{ old('proposed_date', $proposal?->proposed_date) }}"
                       required>
                @error('proposed_date')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label>⏰ Proposed start time</label>
                <input type="time"
                       name="proposed_time"
                       class="form-control"
                       value="{{ substr((string) old('proposed_time', $proposal?->proposed_time), 0, 5) }}"
                       required>
                @error('proposed_time')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label>⏰ Proposed end time</label>
                <input type="time"
                       name="proposed_end_time"
                       class="form-control"
                       value="{{ substr((string) old('proposed_end_time', $proposal?->proposed_end_time), 0, 5) }}"
                       required>
                @error('proposed_end_time')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            <button class="btn btn-primary w-100">
                {{ $proposal ? 'Save Updated Proposal' : 'Send Proposal' }}
            </button>

        </form>

    </div>

</div>

</body>
</html>
