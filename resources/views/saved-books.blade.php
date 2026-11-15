<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Saved books | UniKL BookHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --navy:#102f53; --navy-dark:#0b2542; --navy-mid:#245586; --sky:#dceafb; --ink:#14263d; --muted:#63758a; --line:#dce5ef; --page:#f4f7fb; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; color:var(--ink); background:var(--page); font-family:'Instrument Sans',Arial,sans-serif; }
        .site-header { position:relative;overflow:hidden;color:#fff;background:radial-gradient(ellipse at 85% 20%,#2b5d8b 0,transparent 36%),linear-gradient(130deg,#0b2542,#173f6b); }
        .site-header::after { position:absolute;content:"";width:380px;height:380px;right:-145px;top:-245px;border:1px solid #ffffff18;border-radius:50%;box-shadow:0 0 0 45px #ffffff08,0 0 0 90px #ffffff05; }
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1250px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .header-actions { display:flex;align-items:center;gap:9px; }
        .header-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.84rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .header-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1250px;margin:auto;padding:28px 28px 48px; }
        .intro-row { display:flex;align-items:flex-end;justify-content:space-between;gap:24px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p { max-width:620px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .saved-count { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff35;border-radius:10px;color:#fff;background:#ffffff12;font-size:.85rem;font-weight:700;white-space:nowrap; }
        .page-main { position:relative;z-index:2;max-width:1250px;margin:-20px auto 0;padding:0 28px 56px; }
        .saved-grid { display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px; }
        .saved-card { display:flex;height:100%;flex-direction:column;overflow:hidden;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 10px 30px #173f6b08;transition:transform .2s,border-color .2s,box-shadow .2s; }
        .saved-card:hover { transform:translateY(-3px);border-color:#b7cbe0;box-shadow:0 18px 38px #173f6b15; }
        .saved-cover { display:block;width:100%;height:220px;object-fit:cover;background:#eaf1f9; }
        .saved-card-body { display:flex;flex:1;flex-direction:column;padding:17px; }
        .card-topline { display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:8px;color:var(--navy-mid);font-size:.72rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase; }
        .card-topline i { font-size:.9rem; }
        .saved-title { display:-webkit-box;min-height:2.7em;margin:0 0 7px;overflow:hidden;color:var(--navy);font-size:1.08rem;font-weight:800;line-height:1.35;-webkit-line-clamp:2;-webkit-box-orient:vertical; }
        .saved-description { min-height:3.9em;margin:0 0 13px;color:var(--muted);font-size:.84rem;line-height:1.55; }
        .saved-meta { display:flex;flex-wrap:wrap;gap:7px;margin-bottom:12px; }
        .meta-chip { display:inline-flex;align-items:center;gap:6px;padding:5px 8px;border-radius:7px;color:#4b647f;background:#f1f5f9;font-size:.73rem;font-weight:600; }
        .saved-category { min-height:2.5em;margin:0 0 12px;color:#60758b;font-size:.8rem;line-height:1.5; }
        .saved-actions { display:flex;gap:8px;margin-top:auto;padding-top:13px;border-top:1px solid #e8edf3; }
        .saved-actions .btn { min-height:38px;border-radius:9px;font-size:.82rem;font-weight:700; }
        .detail-button { color:#fff;background:var(--navy);border-color:var(--navy); }
        .detail-button:hover { color:#fff;background:var(--navy-dark);border-color:var(--navy-dark); }
        .unsave-button { color:var(--navy-mid);border-color:#c9d5e2;background:#fff; }
        .unsave-button:hover { color:#8b2029;border-color:#e7aeb4;background:#fff0f1; }
        .empty-state { padding:58px 24px;border:1px dashed #b9cadd;border-radius:18px;background:#fff;text-align:center; }
        .empty-icon { display:grid;place-items:center;width:60px;height:60px;margin:0 auto 17px;border-radius:18px;color:var(--navy-mid);background:var(--sky);font-size:1.55rem; }
        .empty-state h2 { margin:0 0 8px;color:var(--navy);font-size:1.2rem;font-weight:800; }
        .empty-state p { max-width:420px;margin:0 auto 20px;color:var(--muted);line-height:1.6; }
        .primary-button { display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:11px 15px;border-radius:9px;color:#fff;background:var(--navy);font-weight:800;text-decoration:none; }
        .primary-button:hover { color:#fff;background:var(--navy-dark); }
        .alert { border:0;border-radius:12px; }
        @media(max-width:1000px) { .saved-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media(max-width:620px) { .header-inner { padding:14px 18px; } .page-intro { padding:25px 20px 42px; } .intro-row { align-items:flex-start;flex-direction:column; } .page-main { padding:0 14px 36px; } .saved-grid { grid-template-columns:1fr;gap:14px; } .header-link span { display:none; } }
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
                    <p class="eyebrow">Your collection</p>
                    <h1>Saved books</h1>
                    <p>Keep the books you want to revisit close at hand.</p>
                </div>
                <span class="saved-count"><i class="bi bi-heart-fill" aria-hidden="true"></i>{{ $saved->count() }} saved</span>
            </div>
        </div>
    </header>

    <main class="page-main">
        @if(session('success'))
            <div class="alert alert-success mb-3" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-3" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
        @endif

        <div class="saved-grid">
            @forelse($saved as $item)
                @if($item->book)
                    <article class="saved-card">
                        <img src="{{ asset('storage/' . $item->book->image) }}" class="saved-cover" alt="Cover of {{ $item->book->title }}">
                        <div class="saved-card-body">
                            <div class="card-topline"><span>Saved for later</span><i class="bi bi-bookmark-heart" aria-hidden="true"></i></div>
                            <h2 class="saved-title">{{ $item->book->title }}</h2>
                            <p class="saved-description">{{ \Illuminate\Support\Str::limit($item->book->description, 150) }}</p>
                            <div class="saved-meta">
                                <span class="meta-chip"><i class="bi bi-bookmark" aria-hidden="true"></i>{{ $item->book->condition }}</span>
                                <span class="meta-chip"><i class="bi bi-cash-coin" aria-hidden="true"></i>{{ $item->book->price ? 'RM ' . number_format($item->book->price, 2) : 'Free / Not set' }}</span>
                            </div>
                            <p class="saved-category"><i class="bi bi-tag me-1" aria-hidden="true"></i>{{ $item->book->subject_category ?? 'Category not set' }}</p>
                            <div class="saved-actions">
                                <a href="{{ url('/book/' . $item->book->id) }}" class="btn detail-button flex-grow-1"><i class="bi bi-eye me-1" aria-hidden="true"></i>View details</a>
                                <form method="POST" action="{{ route('book.unsave', $item->book->id) }}" onsubmit="return confirm('Remove this book from your saved list?')">
                                    @csrf
                                    <button type="submit" class="btn unsave-button" aria-label="Unsave {{ $item->book->title }}" title="Unsave book"><i class="bi bi-bookmark-x" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endif
            @empty
                <section class="empty-state" style="grid-column:1/-1">
                    <div class="empty-icon"><i class="bi bi-bookmark-heart" aria-hidden="true"></i></div>
                    <h2>No saved books yet</h2>
                    <p>Browse the catalogue and save books you’d like to revisit later.</p>
                    <a href="{{ route('homepage') }}" class="primary-button"><i class="bi bi-compass" aria-hidden="true"></i>Browse books</a>
                </section>
            @endforelse
        </div>
    </main>
</body>
</html>
