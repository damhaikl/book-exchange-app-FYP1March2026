<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Rating & Reviews | UniKL BookHub</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --navy: #102f53;
            --navy-dark: #0b2542;
            --navy-mid: #245586;
            --sky: #dceafb;
            --ink: #14263d;
            --muted: #63758a;
            --line: #dce5ef;
            --page: #f4f7fb;
            --gold: #f5a623;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            background: var(--page);
            font-family: 'Instrument Sans', Arial, sans-serif;
        }

        /* Header */
        .site-header {
            position: relative;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(ellipse at 85% 20%, #2b5d8b 0, transparent 36%),
                linear-gradient(130deg, #0b2542, #173f6b);
        }

        .site-header::after {
            position: absolute;
            content: "";
            width: 380px;
            height: 380px;
            right: -145px;
            top: -245px;
            border: 1px solid #ffffff18;
            border-radius: 50%;
            box-shadow: 0 0 0 45px #ffffff08,
                        0 0 0 90px #ffffff05;
        }

        .header-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            max-width: 1250px;
            margin: auto;
            padding: 18px 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-weight: 800;
            letter-spacing: -.02em;
            text-decoration: none;
        }

        .brand-mark {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #ffffff1d;
            color: #fff;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .header-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 13px;
            border: 1px solid #ffffff70;
            border-radius: 9px;
            color: #fff;
            font-size: .84rem;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s, color .2s;
        }

        .header-link:hover {
            color: var(--navy);
            background: #fff;
        }

        /* Page Introduction */
        .page-intro {
            position: relative;
            z-index: 1;
            max-width: 1250px;
            margin: auto;
            padding: 28px 28px 48px;
        }

        .intro-row {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: #b8d5f5;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .page-intro h1 {
            margin: 0;
            color: #fff;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            letter-spacing: -.055em;
        }

        .page-intro p {
            max-width: 620px;
            margin: 9px 0 0;
            color: #d3e1f0;
            line-height: 1.65;
        }

        .review-count {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 13px;
            border: 1px solid #ffffff35;
            border-radius: 10px;
            color: #fff;
            background: #ffffff12;
            font-size: .85rem;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Main Content */
        .page-main {
            position: relative;
            z-index: 2;
            max-width: 1250px;
            margin: -20px auto 0;
            padding: 0 28px 56px;
        }

        /* Review Summary */
        .reviews-summary {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px 22px;
            margin-bottom: 20px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 10px 30px #173f6b08;
        }

        .summary-icon {
            display: grid;
            place-items: center;
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 12px;
            color: var(--navy-mid);
            background: var(--sky);
            font-size: 1.35rem;
        }

        .summary-label {
            display: block;
            margin-bottom: 4px;
            color: var(--muted);
            font-size: .8rem;
            font-weight: 600;
        }

        .summary-value {
            display: block;
            color: var(--navy);
            font-size: 1.65rem;
            font-weight: 800;
            line-height: 1.2;
        }

        /* Review Cards */
        .review-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .review-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 21px;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 10px 30px #173f6b08;
            transition: transform .2s, border-color .2s, box-shadow .2s;
        }

        .review-card:hover {
            transform: translateY(-3px);
            border-color: #b7cbe0;
            box-shadow: 0 18px 38px #173f6b15;
        }

        .review-top {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e8edf3;
        }

        .review-avatar {
            display: grid;
            place-items: center;
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            border-radius: 12px;
            color: var(--navy-mid);
            background: var(--sky);
            font-size: 1.1rem;
        }

        .review-author {
            min-width: 0;
        }

        .review-author h5 {
            margin: 0 0 4px;
            color: var(--navy);
            font-size: .95rem;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .review-author p {
            margin: 0;
            color: var(--muted);
            font-size: .77rem;
        }

        .review-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .review-stars {
            color: var(--gold);
            font-size: 1.15rem;
            letter-spacing: 2px;
        }

        .empty-star {
            color: #dce3eb;
        }

        .rating-number {
            color: var(--navy);
            font-size: .85rem;
            font-weight: 800;
        }

        .review-comment {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            flex: 1;
            padding: 14px;
            margin-bottom: 15px;
            border-radius: 10px;
            color: #52677e;
            background: #f4f7fb;
            font-size: .85rem;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        .comment-icon {
            margin-top: 3px;
            flex-shrink: 0;
            color: var(--navy-mid);
        }

        .review-book {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 12px;
            border: 1px solid #dce7f3;
            border-radius: 9px;
            color: var(--navy-mid);
            background: #f0f5fb;
            font-size: .8rem;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .review-book i {
            flex-shrink: 0;
        }

        /* Empty State */
        .empty-state {
            padding: 58px 24px;
            border: 1px dashed #b9cadd;
            border-radius: 18px;
            background: #fff;
            text-align: center;
        }

        .empty-icon {
            display: grid;
            place-items: center;
            width: 65px;
            height: 65px;
            margin: 0 auto 17px;
            border-radius: 18px;
            color: var(--navy-mid);
            background: var(--sky);
            font-size: 1.65rem;
        }

        .empty-state h2 {
            margin: 0 0 8px;
            color: var(--navy);
            font-size: 1.2rem;
            font-weight: 800;
        }

        .empty-state p {
            max-width: 420px;
            margin: 0 auto;
            color: var(--muted);
            line-height: 1.6;
        }

        /* Alerts */
        .alert {
            border: 0;
            border-radius: 12px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .review-list {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 620px) {
            .header-inner {
                padding: 14px 18px;
            }

            .page-intro {
                padding: 25px 20px 42px;
            }

            .intro-row {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-main {
                padding: 0 14px 36px;
            }

            .review-card {
                padding: 17px;
            }

            .header-link span {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="site-header">

        <div class="header-inner">

            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true">
                    <i class="bi bi-book-half"></i>
                </span>
                <span>UniKL BookHub</span>
            </a>

            <div class="header-actions">

                <a href="{{ route('homepage') }}" class="header-link">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <span>Browse books</span>
                </a>

                <a href="{{ route('dashboard') }}" class="header-link">
                    <i class="bi bi-arrow-left" aria-hidden="true"></i>
                    <span>Dashboard</span>
                </a>

            </div>

        </div>

        <!-- Page Introduction -->
        <div class="page-intro">

            <div class="intro-row">

                <div>
                    <p class="eyebrow">Your feedback</p>

                    <h1>Rating & Reviews</h1>

                    <p>
                        See what other students say about their book
                        exchange experience with you.
                    </p>
                </div>

                <span class="review-count">
                    <i class="bi bi-chat-square-text-fill" aria-hidden="true"></i>
                    {{ $reviews->count() }} reviews received
                </span>

            </div>

        </div>

    </header>

    <!-- Main Content -->
    <main class="page-main">

        @if(session('success'))
            <div class="alert alert-success mb-3" role="status">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-3" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Review Summary -->
        <div class="reviews-summary">

            <div class="summary-icon">
                <i class="bi bi-chat-square-heart"></i>
            </div>

            <div>
                <span class="summary-label">Total Reviews Received</span>

                <span class="summary-value">
                    {{ $reviews->count() }}
                </span>
            </div>

        </div>

        @if($reviews->isEmpty())

            <!-- Empty State -->
            <section class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-chat-square-heart"></i>
                </div>

                <h2>No reviews yet</h2>

                <p>
                    You haven't received any ratings or reviews yet.
                    Once another student reviews your book exchange,
                    their feedback will appear here.
                </p>

            </section>

        @else

            <!-- Review List -->
            <div class="review-list">

                @foreach($reviews as $review)

                    <article class="review-card">

                        <!-- Student Information -->
                        <div class="review-top">

                            <div class="review-avatar">
                                <i class="bi bi-person-fill"></i>
                            </div>

                            <div class="review-author">

                                <h5>
                                    {{ $review->user->name ?? 'Unknown' }}
                                </h5>

                                <p>
                                    <i class="bi bi-mortarboard me-1"></i>
                                    {{ $review->user->programme ?? 'Programme not specified' }}
                                </p>

                            </div>

                        </div>

                        <!-- Rating -->
                        <div class="review-rating">

                            <span class="review-stars"
                                aria-label="{{ $review->rating }} out of 5 stars">

                                @for($i = 1; $i <= 5; $i++)

                                    @if($i <= $review->rating)
                                        ★
                                    @else
                                        <span class="empty-star">★</span>
                                    @endif

                                @endfor

                            </span>

                            <span class="rating-number">
                                {{ $review->rating }}/5
                            </span>

                        </div>

                        <!-- Review Comment -->
                        <div class="review-comment">

                            <i class="bi bi-chat-left-text comment-icon"></i>

                            <span>
                                {{ $review->comment ?: 'No written comment provided.' }}
                            </span>

                        </div>

                        <!-- Reviewed Book -->
                        <div class="review-book">

                            <i class="bi bi-book"></i>

                            <span>
                                Book:
                                {{ $review->book->title ?? 'Book no longer available' }}
                            </span>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </main>

</body>
</html>