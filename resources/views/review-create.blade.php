<h2>⭐ Review Book: {{ $request->book->title }}</h2>

<form method="POST" action="{{ route('review.store', $request->id) }}">
    @csrf

    <label>Rating</label>
    <select name="rating" class="form-control" required>
        <option value="5">⭐⭐⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="2">⭐⭐</option>
        <option value="1">⭐</option>
    </select>

    <label class="mt-2">Comment</label>
    <textarea name="comment" class="form-control"></textarea>

    <button class="btn btn-primary mt-3">
        Submit Review
    </button>
</form>