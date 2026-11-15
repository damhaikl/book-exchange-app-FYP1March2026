<style>
    body {
        background-color: #111827;
    }

    .page-container {
        max-width: 1100px;
        margin: auto;
        padding: 20px;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
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
        color: white;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 22px;
        color: white;
        font-weight: 700;
    }

    .reviews-summary {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 22px;
        margin-bottom: 25px;
        background: linear-gradient(135deg, #f5f0ff, #faf8ff);
        border: 1px solid #e9ddff;
        border-radius: 14px;
    }

    .summary-icon {
        font-size: 27px;
        color: #7c3aed;
    }

    .summary-label {
        display: block;
        margin-bottom: 5px;
        color: #77718d;
        font-size: 13px;
    }

    .summary-value {
        display: block;
        color: #30205f;
        font-size: 23px;
        font-weight: 700;
    }

    .table-container {
        background: white;
        padding: 20px;
        border-radius: 14px;
        border: 1px solid #e8e5f0;
        box-shadow: 0 3px 12px rgba(45, 30, 90, 0.04);
        overflow-x: auto;
    }

    .reviews-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .reviews-table th {
        background: #f3efff;
        color: #49306f;
        padding: 15px;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        border-bottom: 2px solid #e5dcf7;
    }

    .reviews-table td {
        padding: 15px;
        color: #55546a;
        font-size: 14px;
        border-bottom: 1px solid #eeeaf5;
        vertical-align: middle;
    }

    .reviews-table tbody tr {
        transition: 0.2s ease;
    }

    .reviews-table tbody tr:hover {
        background-color: #faf8ff;
    }

    .student-name {
        color: #30205f;
        font-weight: 700;
    }

    .book-title {
        color: #6d28d9;
        font-weight: 600;
    }

    .rating-stars {
        color: #f5a623;
        font-size: 17px;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .rating-number {
        color: #49386b;
        font-size: 13px;
        font-weight: 700;
        margin-left: 5px;
    }

    .comment-text {
        max-width: 280px;
        overflow-wrap: anywhere;
        line-height: 1.6;
    }

    .delete-btn {
        background: #dc2626;
        color: white;
        border: none;
        padding: 7px 13px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .delete-btn:hover {
        background: #b91c1c;
    }

    .review-empty {
        padding: 45px 20px;
        text-align: center;
        background: #ffffff;
        border: 1px dashed #d8ccef;
        border-radius: 14px;
    }

    .empty-icon {
        font-size: 35px;
        color: #8b5cf6;
        margin-bottom: 12px;
    }

    .review-empty h5 {
        margin-bottom: 8px;
        color: #30205f;
        font-size: 17px;
        font-weight: 700;
    }

    .review-empty p {
        margin: 0;
        color: #858197;
        font-size: 14px;
    }

    @media (max-width: 576px) {
        .table-container {
            padding: 12px;
        }

        h2 {
            font-size: 21px;
        }
    }
</style>

<div class="page-container">

    <a href="{{ route('dashboard') }}" class="back-btn">
        ← Back
    </a>

    <h2>⭐ Student Reviews</h2>

    <div class="reviews-summary">
        <i class="bi bi-chat-square-text summary-icon"></i>

        <div>
            <span class="summary-label">Total Student Reviews</span>
            <span class="summary-value">{{ $reviews->count() }}</span>
        </div>
    </div>

    @if($reviews->isEmpty())

        <div class="review-empty">
            <div class="empty-icon">
                <i class="bi bi-chat-square-heart"></i>
            </div>

            <h5>No reviews yet</h5>

            <p>
                There are currently no student reviews in the system.
            </p>
        </div>

    @else

        <div class="table-container">

            <table class="reviews-table">

                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Book</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($reviews as $review)

                        <tr>
                            <td>
                                <span class="student-name">
                                    {{ $review->user->name ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <span class="book-title">
                                    {{ $review->book->title ?? 'N/A' }}
                                </span>
                            </td>

                            <td>
                                <span class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ★
                                        @else
                                            <span style="color: #d1d5db;">★</span>
                                        @endif
                                    @endfor
                                </span>

                                <span class="rating-number">
                                    {{ $review->rating }}/5
                                </span>
                            </td>

                            <td>
                                <div class="comment-text">
                                    {{ $review->comment ?: 'No comment provided.' }}
                                </div>
                            </td>

                            <td>
                                <form action="{{ route('admin.reviews.delete', $review->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this review?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="delete-btn">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>

                                </form>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>
```