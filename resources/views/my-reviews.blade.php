<!DOCTYPE html>
<html>
<head>
    <title>My Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

<a href="/dashboard" class="btn btn-secondary mb-3">⬅ Back</a>

<h2>⭐ My Rating & Reviews</h2>

@forelse($reviews as $review)

<div class="card p-3 mb-3">

    <h5>📚 {{ $review->book->title }}</h5>

    <p class="text-muted">
        🕒 Reviewed on: {{ $review->created_at->format('d M Y, h:i A') }}
    </p>

    <p>
        Rating:
        {{ str_repeat('⭐', $review->rating) }}
    </p>

    <p>
        💬 Comment:
        {{ $review->comment ?? 'No comment' }}
    </p>

    <form method="POST" action="{{ route('review.delete', $review->id) }}">
        @csrf
        @method('DELETE')

        <button class="btn btn-danger btn-sm mt-2"
                onclick="return confirm('Delete this review?')">
            🗑 Delete
        </button>
    </form>

</div>

@empty
<p>No reviews yet...</p>
@endforelse

</body>
</html>