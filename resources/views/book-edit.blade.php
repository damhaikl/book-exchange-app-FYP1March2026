<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h3>Edit Book</h3>

    <form method="POST" action="{{ route('book.update', $book->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input type="text" name="booktitle" class="form-control mb-2" value="{{ $book->title }}" required>

        <textarea name="bookdescription" class="form-control mb-2" required>{{ $book->description }}</textarea>

        <select name="condition" class="form-control mb-2">
            <option value="New" {{ $book->condition == 'New' ? 'selected' : '' }}>New</option>
            <option value="Like New" {{ $book->condition == 'Like New' ? 'selected' : '' }}>Like New</option>
            <option value="Used" {{ $book->condition == 'Used' ? 'selected' : '' }}>Used</option>
        </select>

        <input type="text" name="subject_id" class="form-control mb-2" value="{{ $book->subject_id }}">

        <input type="file" name="image" class="form-control mb-3">

        <button class="btn btn-primary">Update Book</button>
    </form>

</div>

</body>
</html>