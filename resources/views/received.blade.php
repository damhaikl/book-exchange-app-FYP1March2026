<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Received reviews | UniKL BookHub</title>
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
        .header-actions { display:flex;align-items:center;gap:9px; }
        .header-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.84rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .header-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1000px;margin:auto;padding:28px 28px 48px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .intro-row { display:flex;align-items:flex-end;justify-content:space-between;gap:18px; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p { max-width:620px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .review-count { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff35;border-radius:10px;color:#fff;background:#ffffff12;font-size:.84rem;font-weight:700;white-space:nowrap; }
        .page-main { position:relative;z-index:2;max-width:1000px;margin:-20px auto 0;padding:0 28px 56px; }
        .review-list { display:grid;gap:14px; }
        .review-card { display:grid;grid-template-columns:54px minmax(0,1fr);align-items:start;gap:17px;padding:21px;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 10px 30px #173f6b08;transition:border-color .2s,box-shadow .2s; }
        .review-card:hover { border-color:#b7cbe0;box-shadow:0 14px 34px #173f6b11; }
        .review-icon { display:grid;place-items:center;width:54px;height:54px;border-radius:15px;color:var(--navy-mid);background:var(--sky);font-size:1.25rem; }
        .review-content { min-width:0; }
        .review-kicker { margin:0 0 4px;color:var(--navy-mid);font-size:.69rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase; }
        .review-author { margin:0;color:var(--navy);font-size:1.08rem;font-weight:800;line-height:1.4; }
        .review-programme { margin:4px 0 12px;color:var(--muted);font-size:.82rem; }
        .rating { display:flex;align-items:center;gap:8px;margin-bottom:11px;color:#d18a18;font-size:1.05rem;letter-spacing:.08em; }
        .rating-value { color:#536a82;font-size:.78rem;font-weight:800;letter-spacing:0; }
        .review-comment { display:flex;align-items:flex-start;gap:9px;margin:0 0 13px;padding:12px 13px;border-radius:10px;color:#425a73;background:#f4f7fb;font-size:.9rem;line-height:1.65;white-space:pre-line;overflow-wrap:anywhere; }
        .review-comment i { flex:0 0 auto;margin-top:3px;color:var(--navy-mid); }
        .review-comment.is-empty { color:#8292a4;font-style:italic; }
        .review-book { display:inline-flex;align-items:center;gap:8px;max-width:100%;padding:8px 11px;border:1px solid #dce8f4;border-radius:9px;color:var(--navy-mid);background:#f5f9fd;font-size:.82rem;font-weight:700;overflow-wrap:anywhere; }
        .empty-state { padding:58px 24px;border:1px dashed #b9cadd;border-radius:18px;background:#fff;text-align:center; }
        .empty-icon { display:grid;place-items:center;width:60px;height:60px;margin:0 auto 17px;border-radius:18px;color:var(--navy-mid);background:var(--sky);font-size:1.55rem; }
        .empty-state h2 { margin:0 0 8px;color:var(--navy);font-size:1.2rem;font-weight:800; }
        .empty-state p { max-width:460px;margin:0 auto;color:var(--muted);line-height:1.6; }
        @media(max-width:600px) { .header-inner { padding:14px 18px; } .page-intro { padding:25px 20px 42px; } .intro-row { align-items:flex-start;flex-direction:column; } .page-main { padding:0 14px 36px; } .review-card { grid-template-columns:44px minmax(0,1fr);gap:12px;padding:16px; } .review-icon { width:44px;height:44px;border-radius:13px;font-size:1.1rem; } .review-author { font-size:1rem; } .back-link span,.header-link span { display:none; } }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true"><i class="bi bi-book-half"></i></span>
                <span>UniKL BookHub</span>
            </a>
            <div class="header-actions">
                <a href="{{ route('homepage') }}" class="header-link"><i class="bi bi-search" aria-hidden="true"></i><span>Browse books</span></a>
                <a href="{{ route('dashboard') }}" class="header-link"><i class="bi bi-arrow-left" aria-hidden="true"></i><span>Dashboard</span></a>
            </div>
        </div>
        <div class="page-intro">
            <div class="intro-row">
                <div>
                    <p class="eyebrow">Your seller feedback</p>
                    <h1>Ratings &amp; reviews received</h1>
                    <p>See what students have shared after exchanging books with you.</p>
                </div>
                <span class="review-count"><i class="bi bi-chat-square-text" aria-hidden="true"></i>{{ $reviews->count() }} {{ \Illuminate\Support\Str::plural('review', $reviews->count()) }}</span>
            </div>
        </div>
    </header>

    <main class="page-main">
        @if(session('success'))
            <div class="alert alert-success mb-3" role="status">
                <i class="bi bi-check-circle me-2" aria-hidden="true"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-3" role="alert">
                <i class="bi bi-exclamation-circle me-2" aria-hidden="true"></i>{{ session('error') }}
            </div>
        @endif
        @if($reviews->isEmpty())
            <section class="empty-state">
                <div class="empty-icon"><i class="bi bi-chat-square-heart" aria-hidden="true"></i></div>
                <h2>No reviews yet</h2>
                <p>You haven’t received any ratings or reviews yet. Feedback will appear here after another student reviews a completed exchange.</p>
            </section>
        @else
            <div class="review-list">
                @foreach($reviews as $review)
                    <article class="review-card">
                        <div class="review-icon" aria-hidden="true"><i class="bi bi-person-heart"></i></div>
                        <div class="review-content">
                            <p class="review-kicker">Student feedback</p>
                            <h2 class="review-author">{{ $review->user->name ?? 'Unknown student' }}</h2>
                            <p class="review-programme">{{ $review->user->programme ?? 'Programme not specified' }}</p>
                            <div class="rating" aria-label="{{ $review->rating }} out of 5 stars">
                                <span aria-hidden="true">@for($i = 1; $i <= 5; $i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor</span>
                                <span class="rating-value">{{ $review->rating }}/5</span>
                            </div>
                            <p class="review-comment {{ $review->comment ? '' : 'is-empty' }}"><i class="bi bi-chat-left-text" aria-hidden="true"></i><span>{{ $review->comment ?: 'No written comment provided.' }}</span></p>
                            <div class="review-book"><i class="bi bi-book" aria-hidden="true"></i><span>{{ $review->book->title ?? 'Book no longer available' }}</span></div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
