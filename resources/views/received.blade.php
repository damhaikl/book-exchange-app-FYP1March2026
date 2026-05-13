<style>
    .page-container {
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 15px;
        padding: 8px 15px;
        background-color: #6b7280;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        transition: 0.2s;
    }

    .back-btn:hover {
        background-color: #4b5563;
    }

    h3 {
        font-size: 22px;
        margin-bottom: 20px;
        color: #7c3aed;
    }

    .review-card {
        border: 1px solid #e5e7eb;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        transition: 0.2s;
    }

    .review-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .rating {
        font-size: 16px;
        font-weight: bold;
        color: #f59e0b;
        margin-bottom: 8px;
    }

    .comment {
        margin-bottom: 10px;
        font-size: 15px;
        color: #374151;
    }

    .book-title {
        font-size: 12px;
        color: #6b7280;
    }
</style>

<div class="page-container">

    <a href="{{ route('dashboard') }}" class="back-btn">
        ← Back
    </a>

    <h3>⭐ Rating & Review Received</h3>

    @if($reviews->isEmpty())
        <p style="margin-top:20px; margin-left: 10px;">
            No reviews found.
        </p>
    @else
        @foreach($reviews as $review)
            <div class="review-card">

                <div class="rating">
                    ⭐ Rating: {{ $review->rating }}/5
                </div>

                <div class="comment">
                    💬 {{ $review->comment }}
                </div>

                <div class="book-title">
                    📚 Book: {{ $review->book->title }}
                </div>

            </div>
        @endforeach
    @endif
</div>