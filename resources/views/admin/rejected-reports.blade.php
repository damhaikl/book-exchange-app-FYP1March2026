<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Rejected reports | UniKL BookHub</title>
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
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1260px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .back-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.86rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .back-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1260px;margin:auto;padding:28px 28px 48px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p { max-width:650px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .page-main { position:relative;z-index:2;max-width:1260px;margin:-20px auto 0;padding:0 28px 56px; }
        .search-panel { display:flex;align-items:flex-end;gap:12px;margin-bottom:16px;padding:16px;border:1px solid var(--line);border-radius:14px;background:#fff;box-shadow:0 10px 30px #173f6b08; }
        .search-field { flex:1; }
        .form-label { margin-bottom:6px;color:#29435f;font-size:.8rem;font-weight:700; }
        .form-control { min-height:42px;border:1px solid #d5dfeb;border-radius:9px;color:var(--ink);font-size:.88rem;box-shadow:none; }
        .form-control:focus { border-color:#6e9bc9;box-shadow:0 0 0 3px #dceafb; }
        .btn { border-radius:9px;font-weight:700; }
        .btn-primary { color:#fff;background:var(--navy);border-color:var(--navy); }
        .btn-primary:hover,.btn-primary:focus { color:#fff;background:var(--navy-dark);border-color:var(--navy-dark); }
        .btn-outline-secondary { color:#526b86;border-color:#c9d5e2; }
        .btn-outline-secondary:hover { color:var(--navy);border-color:#a9bed4;background:#eaf1f9; }
        .report-list { display:grid;gap:15px; }
        .report-card { overflow:hidden;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 10px 30px #173f6b08; }
        .report-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;padding:19px 21px 15px;border-bottom:1px solid #e8edf3; }
        .report-kicker { margin:0 0 5px;color:var(--navy-mid);font-size:.68rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase; }
        .report-header h2 { margin:0;color:var(--navy);font-size:1.12rem;font-weight:800;line-height:1.4;overflow-wrap:anywhere; }
        .report-subtitle { display:flex;flex-wrap:wrap;gap:8px 15px;margin:7px 0 0;color:var(--muted);font-size:.8rem; }
        .report-subtitle span { display:inline-flex;align-items:center;gap:6px; }
        .report-subtitle i { color:var(--navy-mid); }
        .status-rejected { display:inline-flex;align-items:center;gap:6px;padding:7px 10px;border-radius:8px;color:#a7333d;background:#fdebed;font-size:.74rem;font-weight:800;white-space:nowrap; }
        .report-body { display:flex;align-items:flex-start;justify-content:space-between;gap:24px;padding:19px 21px 21px; }
        .report-details { min-width:0;flex:1; }
        .detail-label { margin:0 0 5px;color:#71849a;font-size:.72rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase; }
        .detail-value { margin:0;color:#425a73;font-size:.9rem;line-height:1.65;white-space:pre-line;overflow-wrap:anywhere; }
        .report-description { margin-top:14px; }
        .report-actions { display:flex;flex-wrap:wrap;gap:8px;flex:0 0 auto; }
        .report-actions .btn { min-height:37px;font-size:.8rem; }
        .delete-button { color:#8b3038;border-color:#e8c3c7;background:#fff; }
        .delete-button:hover { color:#81252d;border-color:#ddaeb4;background:#fff0f1; }
        .empty-state { padding:58px 24px;border:1px dashed #b9cadd;border-radius:18px;background:#fff;text-align:center; }
        .empty-icon { display:grid;place-items:center;width:60px;height:60px;margin:0 auto 17px;border-radius:18px;color:var(--navy-mid);background:var(--sky);font-size:1.55rem; }
        .empty-state h2 { margin:0 0 8px;color:var(--navy);font-size:1.2rem;font-weight:800; }
        .empty-state p { max-width:440px;margin:0 auto;color:var(--muted);line-height:1.6; }
        @media(max-width:760px) { .report-body { flex-direction:column; } .report-actions { width:100%; } }
        @media(max-width:600px) { .header-inner { padding:14px 18px; } .page-intro { padding:25px 20px 42px; } .page-main { padding:0 14px 36px; } .search-panel { align-items:stretch;flex-direction:column;padding:14px; } .search-panel .btn { width:100%; } .report-header { padding:16px; } .report-body { gap:14px;padding:16px; } .report-actions .btn { flex:1; } .back-link span { display:none; } }
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
            <p class="eyebrow">Admin report history</p>
            <h1>Rejected reports</h1>
            <p>Review reports that were rejected and revisit their original listings.</p>
        </div>
    </header>

    <main class="page-main">
        <form method="GET" action="{{ url()->current() }}" class="search-panel">
            <div class="search-field">
                <label for="search" class="form-label">Search reports</label>
                <input id="search" type="text" name="search" class="form-control" placeholder="Search by student, book, or reason" value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1" aria-hidden="true"></i>Search</button>
            @if(request('search'))
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise me-1" aria-hidden="true"></i>Reset</a>
            @endif
        </form>

        @forelse($reports as $report)
            <div class="report-list mb-3">
                <article class="report-card">
                    <header class="report-header">
                        <div>
                            <p class="report-kicker">Submitted by {{ $report->user->name ?? 'N/A' }}</p>
                            <h2>{{ $report->book->title ?? 'Book unavailable' }}</h2>
                            <div class="report-subtitle">
                                <span><i class="bi bi-calendar3" aria-hidden="true"></i>Submitted {{ $report->created_at->format('d M Y, h:i A') }}</span>
                                <span><i class="bi bi-arrow-repeat" aria-hidden="true"></i>Updated {{ $report->updated_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                        <span class="status-rejected"><i class="bi bi-x-circle-fill" aria-hidden="true"></i>Rejected</span>
                    </header>
                    <div class="report-body">
                        <div class="report-details">
                            <p class="detail-label">Reason</p>
                            <p class="detail-value"><strong>{{ $report->reason }}</strong></p>
                            <div class="report-description">
                                <p class="detail-label">Description</p>
                                <p class="detail-value">{{ $report->description }}</p>
                            </div>
                            @if($report->admin_review)
                                <div class="report-description">
                                    <p class="detail-label">Admin review</p>
                                    <p class="detail-value">{{ $report->admin_review }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="report-actions">
                            <a href="{{ url('/book/' . $report->book_id) }}" class="btn btn-outline-secondary" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>View listing</a>
                            <form method="POST" action="{{ route('admin.reports.delete', $report->id) }}" onsubmit="return confirm('Delete this report?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn delete-button"><i class="bi bi-trash3 me-1" aria-hidden="true"></i>Delete report</button>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <section class="empty-state">
                <div class="empty-icon"><i class="bi bi-clipboard-x" aria-hidden="true"></i></div>
                <h2>No rejected reports found</h2>
                <p>There are no rejected reports matching this search.</p>
            </section>
        @endforelse
    </main>
</body>
</html>
