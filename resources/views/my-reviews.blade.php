<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>My reviews | UniKL BookHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --navy:#102f53; --navy-dark:#0b2542; --navy-mid:#245586; --sky:#dceafb; --ink:#14263d; --muted:#63758a; --line:#dce5ef; --page:#f4f7fb; }
        * { box-sizing:border-box; }
        body { margin:0;min-height:100vh;color:var(--ink);background:var(--page);font-family:'Instrument Sans',Arial,sans-serif; }
        .site-header { position:relative;overflow:hidden;color:#fff;background:radial-gradient(ellipse at 85% 20%,#2b5d8b 0,transparent 36%),linear-gradient(130deg,#0b2542,#173f6b); }
        .site-header::after { position:absolute;content:"";width:380px;height:380px;right:-145px;top:-245px;border:1px solid #ffffff18;border-radius:50%;box-shadow:0 0 0 45px #ffffff08,0 0 0 90px #ffffff05; }
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1000px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .back-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.86rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .back-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1000px;margin:auto;padding:28px 28px 48px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p { max-width:620px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .page-main { position:relative;z-index:2;max-width:1000px;margin:-20px auto 0;padding:0 28px 56px; }
        .review-list { display:grid;gap:14px; }
        .review-card { display:grid;grid-template-columns:54px minmax(0,1fr) auto;align-items:start;gap:17px;padding:21px;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 10px 30px #173f6b08;transition:border-color .2s,box-shadow .2s; }
        .review-card:hover { border-color:#b7cbe0;box-shadow:0 14px 34px #173f6b11; }
        .review-icon { display:grid;place-items:center;width:54px;height:54px;border-radius:15px;color:var(--navy-mid);background:var(--sky);font-size:1.25rem; }
        .review-content { min-width:0; }
        .review-kicker { margin:0 0 4px;color:var(--navy-mid);font-size:.69rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase; }
        .review-title { margin:0;color:var(--navy);font-size:1.1rem;font-weight:800;line-height:1.4; }
        .review-date { display:flex;align-items:center;gap:6px;margin:7px 0 12px;color:var(--muted);font-size:.8rem; }
        .rating { display:flex;align-items:center;gap:8px;margin-bottom:10px;color:#d18a18;font-size:1rem;letter-spacing:.08em; }
        .rating-value { color:#536a82;font-size:.78rem;font-weight:800;letter-spacing:0; }
        .review-comment { margin:0;color:#425a73;font-size:.9rem;line-height:1.65;white-space:pre-line;overflow-wrap:anywhere; }
        .review-comment.is-empty { color:#8292a4;font-style:italic; }
        .delete-button { display:inline-flex;align-items:center;gap:7px;padding:8px 11px;border:1px solid #e8c3c7;border-radius:9px;color:#8b3038;background:#fff;font-size:.8rem;font-weight:700;transition:background .15s,border-color .15s; }
        .delete-button:hover { border-color:#ddaeb4;background:#fff0f1; }
        .empty-state { padding:58px 24px;border:1px dashed #b9cadd;border-radius:18px;background:#fff;text-align:center; }
        .empty-icon { display:grid;place-items:center;width:60px;height:60px;margin:0 auto 17px;border-radius:18px;color:var(--navy-mid);background:var(--sky);font-size:1.55rem; }
        .empty-state h2 { margin:0 0 8px;color:var(--navy);font-size:1.2rem;font-weight:800; }
        .empty-state p { max-width:420px;margin:0 auto;color:var(--muted);line-height:1.6; }
        @media(max-width:600px) { .header-inner { padding:14px 18px; } .page-intro { padding:25px 20px 42px; } .page-main { padding:0 14px 36px; } .review-card { grid-template-columns:44px minmax(0,1fr);gap:12px;padding:16px; } .review-icon { width:44px;height:44px;border-radius:13px;font-size:1.1rem; } .review-title { font-size:1rem; } .delete-button { grid-column:2;justify-self:start; } .back-link span { display:none; } }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true"><i class="bi bi-book-half"></i></span>
                <span>UniKL BookHub</span>
            </a>
            <a href="{{ route('dashboard') }}" class="back-link"><i class="bi bi-arrow-left" aria-hidden="true"></i><span>Back to dashboard</span></a>
        </div>
        <div class="page-intro">
            <p class="eyebrow">Your feedback</p>
            <h1>My ratings &amp; reviews</h1>
            <p>See the feedback you have shared about books you received.</p>
        </div>
    </header>

    <main class="page-main">
        @forelse($reviews as $review)
            <div class="review-list mb-3">
                <article class="review-card">
                    <div class="review-icon" aria-hidden="true"><i class="bi bi-chat-square-quote"></i></div>
                    <div class="review-content">
                        <p class="review-kicker">Book review</p>
                        <h2 class="review-title">{{ $review->book->title }}</h2>
                        <p class="review-date"><i class="bi bi-clock" aria-hidden="true"></i>Reviewed on {{ $review->created_at->format('d M Y, h:i A') }}</p>
                        <div class="rating" aria-label="{{ $review->rating }} out of 5 stars">
                            <span aria-hidden="true">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', max(0, 5 - $review->rating)) }}</span>
                            <span class="rating-value">{{ $review->rating }}/5</span>
                        </div>
                        <p class="review-comment {{ $review->comment ? '' : 'is-empty' }}">{{ $review->comment ?? 'No comment was added.' }}</p>
                    </div>
                    <form method="POST" action="{{ route('review.delete', $review->id) }}" onsubmit="return confirm('Delete this review?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button"><i class="bi bi-trash3" aria-hidden="true"></i><span>Delete</span></button>
                    </form>
                </article>
            </div>
        @empty
            <section class="empty-state">
                <div class="empty-icon"><i class="bi bi-star" aria-hidden="true"></i></div>
                <h2>No reviews yet</h2>
                <p>After you complete a book exchange, you can leave a rating and review for the seller.</p>
            </section>
        @endforelse
    </main>
</body>
</html>
