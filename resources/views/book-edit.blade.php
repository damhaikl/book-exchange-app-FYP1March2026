<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .top-bar {
            max-width: 600px;
            margin-top: 40px;
            margin-left: 120px;
        }
    </style>
</head>

<body>

<div class="top-bar">
    <a href="{{ route('book.myListings') }}" class="btn btn-outline-secondary">
        ⬅️ Back
    </a>
</div>

<div class="container mt-5">

    <h3>Edit Book</h3>

    <form method="POST" action="{{ route('book.update', $book->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 📖 BOOK INFO -->
        <input type="text" name="booktitle" class="form-control mb-2" value="{{ $book->title }}" required>

        <textarea name="bookdescription" class="form-control mb-2" required>{{ $book->description }}</textarea>

        <div class="mb-3">
            <label>Price (RM)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $book->price }}" required>
        </div>

        <select name="condition" class="form-control mb-2">
            <option value="New" {{ $book->condition == 'New' ? 'selected' : '' }}>New</option>
            <option value="Like New" {{ $book->condition == 'Like New' ? 'selected' : '' }}>Like New</option>
            <option value="Used" {{ $book->condition == 'Used' ? 'selected' : '' }}>Used</option>
        </select>

        <input type="text" name="subject_id" class="form-control mb-2" value="{{ $book->subject_id }}">

        <input type="file" name="image" class="form-control mb-3">

        <hr>

        <!-- 📍 SMART MEETING SECTION -->
        <h5>📍 Meeting Details</h5>

        <div class="mb-2">
            <label>Location</label>
            <input type="text" name="meeting_location" class="form-control"
                   value="{{ $book->meeting_location }}">
        </div>

        <div class="mb-2">
            <label>Date</label>
            <input type="date" name="meeting_date" class="form-control"
                   value="{{ $book->meeting_date }}">
        </div>

        <div class="mb-3">
            <label>Time</label>
            <input type="time" name="meeting_time" class="form-control"
                   value="{{ $book->meeting_time }}">
        </div>

        <button class="btn btn-primary w-100">Update Book</button>
    </form>

</div>

</body>
</html>