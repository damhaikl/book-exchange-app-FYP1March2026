<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Sent requests | UniKL BookHub</title>
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
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1120px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .back-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.86rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .back-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1120px;margin:auto;padding:28px 28px 48px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p { max-width:620px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .page-main { position:relative;z-index:2;max-width:1120px;margin:-20px auto 0;padding:0 28px 56px; }
        .request-list { display:grid;gap:16px; }
        .request-card { overflow:hidden;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 10px 30px #173f6b08; }
        .request-card-header { display:flex;align-items:flex-start;justify-content:space-between;gap:16px;padding:20px 22px 16px;border-bottom:1px solid #e8edf3; }
        .book-kicker { margin:0 0 5px;color:var(--navy-mid);font-size:.7rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase; }
        .request-card h2 { margin:0;color:var(--navy);font-size:1.2rem;font-weight:800;letter-spacing:-.02em; }
        .owner-line { display:flex;align-items:center;gap:7px;margin:8px 0 0;color:var(--muted);font-size:.87rem; }
        .owner-line i { color:var(--navy-mid); }
        .status-badge { display:inline-flex;align-items:center;gap:6px;padding:7px 10px;border-radius:8px;color:#825711;background:#fff2d7;font-size:.74rem;font-weight:800;white-space:nowrap; }
        .status-badge.approved { color:#23744a;background:#e4f4eb; }
        .status-badge.rejected { color:#aa3038;background:#fde8e9; }
        .status-badge.completed { color:#245586;background:#e6f1fb; }
        .status-badge.cancelled { color:#526579;background:#e9eef4; }
        .request-card-body { padding:18px 22px 21px; }
        .status-actions { display:flex;align-items:center;flex-wrap:wrap;gap:9px;margin-bottom:17px; }
        .status-actions .btn { min-height:37px;border-radius:9px;font-size:.82rem;font-weight:800; }
        .status-label { margin-right:3px;color:#536a82;font-size:.84rem;font-weight:700; }
        .cancel-button { color:#8b3038;border-color:#e8c3c7;background:#fff; }
        .cancel-button:hover { color:#81252d;border-color:#ddaeb4;background:#fff0f1; }
        .complete-button { color:#fff;background:var(--navy);border-color:var(--navy); }
        .complete-button:hover { color:#fff;background:var(--navy-dark);border-color:var(--navy-dark); }
        .review-button { color:var(--navy);border-color:#c9d5e2;background:#fff; }
        .review-button:hover { color:var(--navy);border-color:#a9bed4;background:#eaf1f9; }
        .reviewed-label { display:inline-flex;align-items:center;gap:6px;padding:8px 10px;border-radius:8px;color:#526579;background:#e9eef4;font-size:.78rem;font-weight:700; }
        .schedule-grid { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px; }
        .schedule-box { padding:15px;border:1px solid #dfe8f1;border-radius:12px;background:#f7f9fc; }
        .schedule-box.proposed { border-color:#c8dcef;background:#f1f7fd; }
        .schedule-title { display:flex;align-items:center;gap:8px;margin:0 0 12px;color:var(--navy);font-size:.86rem;font-weight:800; }
        .schedule-box.proposed .schedule-title { color:#245586; }
        .schedule-detail { display:flex;gap:8px;margin:7px 0 0;color:#52677d;font-size:.84rem;line-height:1.5; }
        .schedule-detail i { flex:0 0 16px;margin-top:2px;color:#7188a0; }
        .schedule-detail strong { color:#29435f; }
        .proposal-manage { display:flex;justify-content:flex-end;margin-top:12px; }
        .manage-button { display:inline-flex;align-items:center;gap:7px;padding:9px 12px;border:1px solid #c8dcef;border-radius:9px;color:var(--navy);background:#fff;font-size:.82rem;font-weight:800; }
        .manage-button:hover { border-color:#a9c5e3;background:#eaf3fc; }
        .empty-state { padding:58px 24px;border:1px dashed #b9cadd;border-radius:18px;background:#fff;text-align:center; }
        .empty-icon { display:grid;place-items:center;width:60px;height:60px;margin:0 auto 17px;border-radius:18px;color:var(--navy-mid);background:var(--sky);font-size:1.55rem; }
        .empty-state h2 { margin:0 0 8px;color:var(--navy);font-size:1.2rem;font-weight:800; }
        .empty-state p { max-width:420px;margin:0 auto;color:var(--muted);line-height:1.6; }
        .modal-content { overflow:hidden;border:1px solid var(--line);border-radius:16px;box-shadow:0 20px 60px #0b25422b; }
        .modal-header { padding:18px 20px;color:#fff;background:var(--navy); }
        .modal-header .modal-title { font-size:1rem;font-weight:800; }
        .modal-header .btn-close { filter:brightness(0) invert(1); }
        .modal-body { padding:20px;color:#52677d;line-height:1.65; }
        .modal-footer { gap:8px;padding:14px 20px;border-top:1px solid #e8edf3; }
        .modal-footer .btn { border-radius:9px;font-weight:700; }
        .modal-edit-button { color:#fff;background:var(--navy);border-color:var(--navy); }
        .modal-edit-button:hover { color:#fff;background:var(--navy-dark);border-color:var(--navy-dark); }
        .alert { border:0;border-radius:12px; }
        @media(max-width:650px) { .header-inner { padding:14px 18px; } .page-intro { padding:25px 20px 42px; } .page-main { padding:0 14px 36px; } .request-card-header { padding:17px; } .request-card-body { padding:15px 17px 18px; } .schedule-grid { grid-template-columns:1fr; } .back-link span { display:none; } .proposal-manage { justify-content:stretch; } .manage-button { justify-content:center;width:100%; } }
        @media(max-width:430px) { .status-actions { align-items:stretch; } .status-actions .btn { flex:1 1 100%; } }
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
            <p class="eyebrow">Buyer activity</p>
            <h1>Sent book requests</h1>
            <p>Track requests you have sent and review the meeting details for each book.</p>
        </div>
    </header>

    <main class="page-main">
        @if(session('success'))
            <div class="alert alert-success mb-3" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-3" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
        @endif

        @forelse($requests as $req)
            @php
                $hasReview = \App\Models\Review::where('book_id', $req->book_id)
                    ->where('user_id', auth()->id())
                    ->exists();
                $displayStatus = ($req->status == 'completed' || $req->is_taken) ? 'completed' : $req->status;
            @endphp
            <div class="request-list mb-3">
                <article class="request-card">
                    <header class="request-card-header">
                        <div>
                            <p class="book-kicker">Your book request</p>
                            <h2>{{ $req->book->title }}</h2>
                            <p class="owner-line"><i class="bi bi-person-circle" aria-hidden="true"></i>Book owner <strong>{{ $req->owner->name }}</strong></p>
                        </div>
                        <span class="status-badge {{ in_array($displayStatus, ['approved', 'rejected', 'completed', 'cancelled'], true) ? $displayStatus : '' }}"><i class="bi bi-circle-fill" style="font-size:.42rem" aria-hidden="true"></i>{{ ucfirst($displayStatus) }}</span>
                    </header>

                    <div class="request-card-body">
                        @if($req->status == 'pending' || ($req->status == 'approved' && !$req->is_taken) || $req->status == 'completed' || $req->is_taken)
                            <div class="status-actions">
                                <span class="status-label">Request actions</span>
                                @if($req->status == 'pending')
                                    <form method="POST" action="{{ route('request.cancel', $req->id) }}">
                                        @csrf
                                        <button type="submit" class="btn cancel-button"><i class="bi bi-x-circle me-1" aria-hidden="true"></i>Cancel request</button>
                                    </form>
                                @elseif($req->status == 'approved' && !$req->is_taken)
                                    <form method="POST" action="{{ route('request.take', $req->id) }}">
                                        @csrf
                                        <button type="submit" class="btn complete-button"><i class="bi bi-check-circle me-1" aria-hidden="true"></i>Mark as received</button>
                                    </form>
                                    <form method="POST" action="{{ route('request.cancel', $req->id) }}">
                                        @csrf
                                        <button type="submit" class="btn cancel-button"><i class="bi bi-x-circle me-1" aria-hidden="true"></i>Cancel request</button>
                                    </form>
                                @elseif($req->status == 'completed' || $req->is_taken)
                                    @if(!$hasReview)
                                        <a href="{{ route('review.create', $req->id) }}" class="btn review-button"><i class="bi bi-star me-1" aria-hidden="true"></i>Write a review</a>
                                    @else
                                        <span class="reviewed-label"><i class="bi bi-check-circle" aria-hidden="true"></i>Already reviewed</span>
                                    @endif
                                @endif
                            </div>
                        @endif

                        <div class="schedule-grid">
                            <section class="schedule-box">
                                <h3 class="schedule-title"><i class="bi bi-calendar2-check" aria-hidden="true"></i>Seller’s meeting schedule</h3>
                                <p class="schedule-detail"><i class="bi bi-geo-alt" aria-hidden="true"></i><span><strong>Location</strong><br>{{ $req->book->meeting_location ?? 'Not set' }}</span></p>
                                <p class="schedule-detail"><i class="bi bi-calendar3" aria-hidden="true"></i><span><strong>Date</strong><br>{{ $req->book->meeting_date ?? 'Not set' }}</span></p>
                                <p class="schedule-detail"><i class="bi bi-clock" aria-hidden="true"></i><span><strong>Time</strong><br>{{ $req->book->meeting_time ? \Carbon\Carbon::parse($req->book->meeting_time)->format('g:i A') : 'Not set' }}@if($req->book->meeting_end_time) – {{ \Carbon\Carbon::parse($req->book->meeting_end_time)->format('g:i A') }}@endif</span></p>
                            </section>

                            @if($req->status === 'negotiation')
                                <section class="schedule-box proposed">
                                    <h3 class="schedule-title"><i class="bi bi-arrow-left-right" aria-hidden="true"></i>Your proposed schedule</h3>
                                    <p class="schedule-detail"><i class="bi bi-geo-alt" aria-hidden="true"></i><span><strong>Location</strong><br>{{ $req->proposed_location }}</span></p>
                                    <p class="schedule-detail"><i class="bi bi-calendar3" aria-hidden="true"></i><span><strong>Date</strong><br>{{ $req->proposed_date }}</span></p>
                                    <p class="schedule-detail"><i class="bi bi-clock" aria-hidden="true"></i><span><strong>Time</strong><br>{{ $req->proposed_time ? \Carbon\Carbon::parse($req->proposed_time)->format('g:i A') : 'Not set' }}@if($req->proposed_end_time) – {{ \Carbon\Carbon::parse($req->proposed_end_time)->format('g:i A') }}@endif</span></p>
                                    <div class="proposal-manage">
                                        <button type="button" class="manage-button" data-bs-toggle="modal" data-bs-target="#proposalModal-{{ $req->id }}"><i class="bi bi-pencil-square" aria-hidden="true"></i>Manage proposed schedule</button>
                                    </div>
                                </section>

                                <div class="modal fade" id="proposalModal-{{ $req->id }}" tabindex="-1" aria-labelledby="proposalModalTitle-{{ $req->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="proposalModalTitle-{{ $req->id }}">Schedule proposal already sent</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>You already proposed a new meeting schedule. Would you like to change it?</p>
                                                <p class="mb-0">Deleting the proposal keeps your book request active and returns it to the seller’s original meeting schedule.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Keep proposal</button>
                                                <form method="POST" action="{{ route('book.proposeSchedule.delete', $req->book_id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="return_to" value="sent-requests">
                                                    <button type="submit" class="btn btn-outline-danger">Delete proposal</button>
                                                </form>
                                                <a href="{{ route('book.proposeScheduleForm', $req->book_id) }}?return_to=sent-requests" class="btn modal-edit-button">Edit proposal</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <section class="empty-state">
                <div class="empty-icon"><i class="bi bi-send" aria-hidden="true"></i></div>
                <h2>No requests sent yet</h2>
                <p>When you request a book from the catalogue, you can follow its status and meeting details here.</p>
            </section>
        @endforelse
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
