<style>
    body {
    background-color: #111827;
    }
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
        color: white;
    }

        .reviews-summary {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 22px;
        margin: 25px 0;
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

    .review-card {
        padding: 22px;
        margin-bottom: 17px;
        background: #ffffff;
        border: 1px solid #e8e5f0;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(45, 30, 90, 0.04);
        transition: 0.2s ease;
    }

    .review-card:hover {
        border-color: #d8c8ff;
        box-shadow: 0 7px 20px rgba(109, 40, 217, 0.08);
        transform: translateY(-2px);
    }

    .review-top {
        margin-bottom: 16px;
    }

    .review-author {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .review-author h5 {
        margin: 0 0 5px;
        color: #30205f;
        font-size: 15px;
        font-weight: 700;
    }

    .review-author p {
        margin: 0;
        color: #898399;
        font-size: 12px;
    }

    .review-rating {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .review-stars {
        color: #f5a623;
        font-size: 20px;
        letter-spacing: 2px;
    }

    .rating-number {
        color: #49386b;
        font-size: 14px;
        font-weight: 700;
    }

    .review-comment {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px;
        margin-bottom: 15px;
        background: #f8f7fc;
        border-radius: 9px;
        color: #55546a;
        font-size: 14px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .comment-icon {
        margin-top: 3px;
        color: #8b5cf6;
        flex-shrink: 0;
    }

    .review-book {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        max-width: 100%;
        padding: 9px 13px;
        background: #f3efff;
        border-radius: 8px;
        color: #6d28d9;
        font-size: 13px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .review-empty {
        padding: 45px 20px;
        text-align: center;
        background: #ffffff;
        border: 1px dashed #d8ccef;
        border-radius: 14px;
    }

    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 65px;
        height: 65px;
        margin: 0 auto 16px;
        background: #f3efff;
        color: #8b5cf6;
        border-radius: 50%;
        font-size: 28px;
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
        line-height: 1.7;
    }

    @media (max-width: 576px) {
        .reviews-summary {
            padding: 15px 17px;
        }

        .review-card {
            padding: 17px;
        }

        .review-stars {
            font-size: 17px;
        }
    }

  
</style>

<div class="page-container">

    <a href="{{ route('dashboard') }}" class="back-btn">
        ← Back
    </a>

    <h3>⭐ Rating & Review Received</h3>

    <div class="reviews-summary">
        <i class="bi bi-chat-square-text summary-icon"></i>
        <div>
            <span class="summary-label">Total Reviews Received</span>
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
                You haven't received any ratings or reviews yet.
                Once another student reviews your book exchange,
                their feedback will appear here.
            </p>
        </div>

    @else

        @foreach($reviews as $review)

            <div class="review-card">

                <div class="review-top">
                    <div class="review-author">

                        <div>
                            <h5>
                                {{ $review->user->name ?? 'Unknown' }}
                            </h5>

                            <p>
                                {{ $review->user->programme ?? 'Programme not specified' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="review-rating">
                    <span class="review-stars"
                        aria-label="{{ $review->rating }} out of 5 stars">
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
                </div>

                <div class="review-comment">
                    <i class="bi bi-chat-left-text comment-icon"></i>

                    <span>
                        {{ $review->comment ?: 'No written comment provided.' }}
                    </span>
                </div>

                <div class="review-book">
                    <i class="bi bi-book"></i>

                    <span>
                        Book: {{ $review->book->title ?? 'Book no longer available' }}
                    </span>
                </div>

            </div>

        @endforeach

    @endif
</div>