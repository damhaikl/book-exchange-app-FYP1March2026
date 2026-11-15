<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>{{ $proposal ? 'Edit' : 'Propose' }} meeting schedule | UniKL BookHub</title>
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
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1040px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .back-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.86rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .back-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1040px;margin:auto;padding:27px 28px 47px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,2.8rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p { max-width:620px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .page-main { position:relative;z-index:2;max-width:900px;margin:-20px auto 0;padding:0 24px 52px; }
        .form-card { padding:clamp(22px,4vw,38px);border:1px solid var(--line);border-radius:18px;background:#fff;box-shadow:0 20px 55px #102f5312; }
        .book-reference { display:flex;align-items:flex-start;gap:13px;margin-bottom:20px;padding:15px;border:1px solid #dce8f4;border-radius:12px;background:#f4f8fc; }
        .book-reference-icon { display:grid;flex:0 0 40px;place-items:center;width:40px;height:40px;border-radius:12px;color:var(--navy-mid);background:var(--sky); }
        .book-reference-label { margin:0 0 3px;color:var(--navy-mid);font-size:.7rem;font-weight:800;letter-spacing:.09em;text-transform:uppercase; }
        .book-reference-title { margin:0;color:var(--navy);font-size:1rem;font-weight:800;line-height:1.4; }
        .section-heading { display:flex;align-items:center;gap:10px;margin:21px 0 13px;color:var(--navy);font-size:.95rem;font-weight:800; }
        .section-heading i { color:var(--navy-mid); }
        .seller-schedule { margin-bottom:23px;padding:17px;border:1px solid #c8dcef;border-radius:12px;background:#f1f7fd; }
        .seller-schedule-title { display:flex;align-items:center;gap:8px;margin:0 0 13px;color:var(--navy);font-size:.87rem;font-weight:800; }
        .schedule-grid { display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px; }
        .schedule-label { margin-bottom:4px;color:#71849a;font-size:.75rem; }
        .schedule-value { margin:0;color:#29435f;font-size:.87rem;font-weight:700;line-height:1.5;overflow-wrap:anywhere; }
        .form-label { margin-bottom:7px;color:#29435f;font-size:.86rem;font-weight:700; }
        .form-control { min-height:46px;border:1px solid #d5dfeb;border-radius:10px;color:var(--ink);background:#fff;font-size:.92rem;box-shadow:none; }
        .form-control:focus { border-color:#6e9bc9;box-shadow:0 0 0 3px #dceafb; }
        .field-error { display:block;margin-top:6px;color:#b42336;font-size:.82rem; }
        .submit-button { min-height:49px;margin-top:7px;border:0;border-radius:10px;color:#fff;background:var(--navy);font-weight:800;box-shadow:0 8px 18px #102f5324;transition:transform .2s,background .2s,box-shadow .2s; }
        .submit-button:hover,.submit-button:focus { color:#fff;background:var(--navy-dark);transform:translateY(-1px);box-shadow:0 12px 24px #102f5330; }
        .alert { border:0;border-radius:12px; }
        @media(max-width:620px) { .header-inner { padding:14px 18px; } .page-intro { padding:24px 20px 42px; } .page-main { padding:0 14px 36px; } .back-link span { display:none; } .schedule-grid { grid-template-columns:1fr;gap:9px; } .schedule-grid > div { display:flex;align-items:flex-start;gap:8px; } .schedule-grid .schedule-label { flex:0 0 72px;margin:2px 0 0; } }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true"><i class="bi bi-book-half"></i></span>
                <span>UniKL BookHub</span>
            </a>
            <a href="{{ $returnTo === 'sent-requests' ? route('sent.requests') : url('/book/' . $book->id) }}" class="back-link">
                <i class="bi bi-arrow-left" aria-hidden="true"></i><span>{{ $returnTo === 'sent-requests' ? 'Back to sent requests' : 'Back to book details' }}</span>
            </a>
        </div>
        <div class="page-intro">
            <p class="eyebrow">Meeting arrangements</p>
            <h1>{{ $proposal ? 'Edit your schedule proposal' : 'Propose a new schedule' }}</h1>
            <p>Suggest a location and time that works for you and the seller.</p>
        </div>
    </header>

    <main class="page-main">
        @if(session('error'))
            <div class="alert alert-danger mb-3" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
        @endif

        <section class="form-card" aria-label="Meeting schedule proposal">
            <div class="book-reference">
                <span class="book-reference-icon" aria-hidden="true"><i class="bi bi-book"></i></span>
                <div><p class="book-reference-label">Book request</p><p class="book-reference-title">{{ $book->title }}</p></div>
            </div>

            <h2 class="section-heading"><i class="bi bi-calendar2-check" aria-hidden="true"></i>Seller’s original schedule</h2>
            <section class="seller-schedule">
                <h3 class="seller-schedule-title"><i class="bi bi-info-circle" aria-hidden="true"></i>Current meeting details</h3>
                <div class="schedule-grid">
                    <div><div class="schedule-label">Location</div><p class="schedule-value">{{ $book->meeting_location ?? 'Not set' }}</p></div>
                    <div><div class="schedule-label">Date</div><p class="schedule-value">{{ $book->meeting_date ?? 'Not set' }}</p></div>
                    <div><div class="schedule-label">Time</div><p class="schedule-value">{{ $book->meeting_time ? \Carbon\Carbon::parse($book->meeting_time)->format('g:i A') : 'Not set' }}@if($book->meeting_end_time) – {{ \Carbon\Carbon::parse($book->meeting_end_time)->format('g:i A') }}@endif</p></div>
                </div>
            </section>

            <h2 class="section-heading"><i class="bi bi-arrow-left-right" aria-hidden="true"></i>Your proposed schedule</h2>
            <form method="POST" action="{{ $proposal ? route('book.proposeSchedule.update', $book->id) : route('book.proposeSchedule', $book->id) }}">
                @csrf
                <input type="hidden" name="return_to" value="{{ $returnTo }}">
                @if($proposal)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <div class="col-12">
                        <label for="proposed_location" class="form-label">Proposed location</label>
                        <input id="proposed_location" type="text" name="proposed_location" class="form-control" value="{{ old('proposed_location', $proposal?->proposed_location) }}" placeholder="e.g. UniKL MIIT Library Entrance" required>
                        @error('proposed_location')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="proposed_date" class="form-label">Proposed date</label>
                        <input id="proposed_date" type="date" name="proposed_date" class="form-control" value="{{ old('proposed_date', $proposal?->proposed_date) }}" required>
                        @error('proposed_date')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="proposed_time" class="form-label">Start time</label>
                        <input id="proposed_time" type="time" name="proposed_time" class="form-control" value="{{ substr((string) old('proposed_time', $proposal?->proposed_time), 0, 5) }}" required>
                        @error('proposed_time')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="proposed_end_time" class="form-label">End time</label>
                        <input id="proposed_end_time" type="time" name="proposed_end_time" class="form-control" value="{{ substr((string) old('proposed_end_time', $proposal?->proposed_end_time), 0, 5) }}" required>
                        @error('proposed_end_time')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                </div>

                <button type="submit" class="btn submit-button w-100">{{ $proposal ? 'Save updated proposal' : 'Send schedule proposal' }} <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i></button>
            </form>
        </section>
    </main>
</body>
</html>
