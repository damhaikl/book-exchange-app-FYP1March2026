@php
use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Listings</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 40px;
        }

        img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<div class="container">

    <h3 class="mb-4">📚 My Book Listings</h3>

    <!-- Button to create new book -->
    <a href="{{ route('book.create') }}" class="btn btn-primary mb-3">
        ➕ Sell New Book
    </a>

    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Condition</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @forelse($books as $book)
            <tr>

                <!-- Image -->
                <td>
                    <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image">
                </td>

                <!-- Title (FIXED) -->
                <td>{{ $book->title }}</td>

                <!-- Condition -->
                <td>{{ $book->condition }}</td>

                <!-- Description (FIXED) -->
                <td>{{ Str::limit($book->description, 50) }}</td>

                <!-- Actions -->
                <td>
                    <!-- Edit -->
                    <a href="{{ route('book.edit', $book->id) }}" class="btn btn-sm btn-warning">
                        ✏️ Edit
                    </a>

                    <!-- Delete -->
                    <form action="{{ route('book.destroy', $book->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this book?')">
                            ❌ Delete
                        </button>
                    </form>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">
                    No books found 😢
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

</div>

</body>
</html>