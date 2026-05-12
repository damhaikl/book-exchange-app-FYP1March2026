<h2>⭐ Review & Rating Book: {{ $request->book->title }}</h2>

<form method="POST" action="{{ route('review.store', $request->id) }}">
    @csrf

    <label>Rating</label>
    <select name="rating" class="form-control" required>
        <option value="">-- Select Rating --</option>
        <option value="5">⭐⭐⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="2">⭐⭐</option>
        <option value="1">⭐</option>
    </select>

    <label class="mt-2">Review</label>
    <textarea name="comment" class="form-control" required></textarea>

    <button class="btn btn-primary mt-3">
        Submit Review
    </button>
</form>