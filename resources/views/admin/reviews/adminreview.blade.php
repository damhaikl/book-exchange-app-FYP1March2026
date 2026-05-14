<a href="{{ route('dashboard') }}" class="back-btn">
        ← Back
    </a>

<h2>Student Reviews</h2>

<table border="1" width="100%">
    <tr>
        <th>Student</th>
        <th>Book</th>
        <th>Rating</th>
        <th>Comment</th>
    </tr>

    @forelse($reviews as $review)
        <tr>
            <td>{{ $review->user->name ?? 'N/A' }}</td>
            <td>{{ $review->book->title ?? 'N/A' }}</td>
            <td>{{ $review->rating }}</td>
            <td>{{ $review->comment }}</td>
            <td>
                <form action="{{ route('admin.reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" style="background:red; color:white; border:none; padding:5px 10px; cursor:pointer;">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align:center; padding:15px; color:gray;">
                No reviews yet.
            </td>
        </tr>
    @endforelse
</table>