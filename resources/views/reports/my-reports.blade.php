<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>My reports | UniKL BookHub</title>
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
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1100px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .back-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.86rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .back-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1100px;margin:auto;padding:28px 28px 48px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p { max-width:620px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .page-main { position:relative;z-index:2;max-width:1100px;margin:-20px auto 0;padding:0 28px 56px; }
        .report-list { display:grid;gap:14px; }
        .report-card { display:grid;grid-template-columns:54px minmax(0,1fr) auto;align-items:start;gap:17px;padding:21px;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 10px 30px #173f6b08;transition:border-color .2s,box-shadow .2s; }
        .report-card:hover { border-color:#b7cbe0;box-shadow:0 14px 34px #173f6b11; }
        .report-icon { display:grid;place-items:center;width:54px;height:54px;border-radius:15px;color:var(--navy-mid);background:var(--sky);font-size:1.25rem; }
        .report-content { min-width:0; }
        .report-kicker { margin:0 0 4px;color:var(--navy-mid);font-size:.69rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase; }
        .report-book { margin:0;color:var(--navy);font-size:1.1rem;font-weight:800;line-height:1.4;overflow-wrap:anywhere; }
        .report-meta { display:flex;flex-wrap:wrap;gap:9px 15px;margin:8px 0 13px;color:var(--muted);font-size:.8rem; }
        .report-meta span { display:inline-flex;align-items:center;gap:6px; }
        .report-meta i { color:var(--navy-mid); }
        .reason-label { margin:0 0 4px;color:#29435f;font-size:.8rem;font-weight:800; }
        .report-reason { margin:0 0 5px;color:#425a73;font-size:.9rem;font-weight:600; }
        .report-description { margin:0;color:#63758a;font-size:.88rem;line-height:1.65;white-space:pre-line;overflow-wrap:anywhere; }
        .status-badge { display:inline-flex;align-items:center;gap:6px;padding:7px 10px;border-radius:8px;color:#825711;background:#fff2d7;font-size:.74rem;font-weight:800;white-space:nowrap; }
        .status-badge.resolved { color:#23744a;background:#e4f4eb; }
        .status-badge.rejected { color:#aa3038;background:#fde8e9; }
        .delete-button { display:inline-flex;align-items:center;gap:7px;margin-top:14px;padding:8px 11px;border:1px solid #e8c3c7;border-radius:9px;color:#8b3038;background:#fff;font-size:.8rem;font-weight:700;transition:background .15s,border-color .15s; }
        .delete-button:hover { border-color:#ddaeb4;background:#fff0f1; }
        .empty-state { padding:58px 24px;border:1px dashed #b9cadd;border-radius:18px;background:#fff;text-align:center; }
        .empty-icon { display:grid;place-items:center;width:60px;height:60px;margin:0 auto 17px;border-radius:18px;color:var(--navy-mid);background:var(--sky);font-size:1.55rem; }
        .empty-state h2 { margin:0 0 8px;color:var(--navy);font-size:1.2rem;font-weight:800; }
        .empty-state p { max-width:450px;margin:0 auto;color:var(--muted);line-height:1.6; }
        @media(max-width:600px) { .header-inner { padding:14px 18px; } .page-intro { padding:25px 20px 42px; } .page-main { padding:0 14px 36px; } .report-card { grid-template-columns:44px minmax(0,1fr);gap:12px;padding:16px; } .report-icon { width:44px;height:44px;border-radius:13px;font-size:1.1rem; } .report-book { font-size:1rem; } .status-badge { grid-column:2;justify-self:start;grid-row:2; } .delete-button { margin-top:12px; } .back-link span { display:none; } }
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
            <p class="eyebrow">Your support activity</p>
            <h1>My reports</h1>
            <p>Review the reports you have submitted and check their current status.</p>
        </div>
    </header>

    <main class="page-main">
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
        @endif

        @forelse($reports as $report)
            @php($statusClass = in_array($report->status, ['pending', 'resolved', 'rejected'], true) ? $report->status : 'pending')
            <div class="report-list mb-3">
                <article class="report-card">
                    <div class="report-icon" aria-hidden="true"><i class="bi bi-flag"></i></div>
                    <div class="report-content">
                        <p class="report-kicker">Submitted report</p>
                        <h2 class="report-book">{{ $report->book->title ?? 'Book unavailable' }}</h2>
                        <div class="report-meta">
                            <span><i class="bi bi-calendar3" aria-hidden="true"></i>{{ $report->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <p class="reason-label">Reason</p>
                        <p class="report-reason">{{ $report->reason }}</p>
                        <p class="report-description">{{ $report->description }}</p>
                        <form method="POST" action="{{ route('report.delete', $report->id) }}" onsubmit="return confirm('Are you sure you want to delete this report?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button"><i class="bi bi-trash3" aria-hidden="true"></i>Delete report</button>
                        </form>
                    </div>
                    <span class="status-badge {{ $statusClass }}"><i class="bi bi-circle-fill" style="font-size:.42rem" aria-hidden="true"></i>{{ ucfirst($report->status) }}</span>
                </article>
            </div>
        @empty
            <section class="empty-state">
                <div class="empty-icon"><i class="bi bi-flag" aria-hidden="true"></i></div>
                <h2>No reports found</h2>
                <p>Reports you submit about a book or listing will appear here so you can follow their status.</p>
            </section>
        @endforelse
    </main>
</body>
</html>
