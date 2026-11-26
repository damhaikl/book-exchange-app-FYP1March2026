
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
        :root {
            --navy:#102f53;
            --navy-dark:#0b2542;
            --navy-mid:#245586;
            --sky:#dceafb;
            --ink:#14263d;
            --muted:#63758a;
            --line:#dce5ef;
            --page:#f4f7fb;
        }

        * { box-sizing:border-box; }

        body {
            margin:0;
            min-height:100vh;
            color:var(--ink);
            background:var(--page);
            font-family:'Instrument Sans',Arial,sans-serif;
        }

        .site-header {
            position:relative;
            overflow:hidden;
            color:#fff;
            background:radial-gradient(ellipse at 85% 20%,#2b5d8b 0,transparent 36%),linear-gradient(130deg,#0b2542,#173f6b);
        }

        .site-header::after {
            position:absolute;
            content:"";
            width:380px;
            height:380px;
            right:-145px;
            top:-245px;
            border:1px solid #ffffff18;
            border-radius:50%;
            box-shadow:0 0 0 45px #ffffff08,0 0 0 90px #ffffff05;
        }

        .header-inner {
            position:relative;
            z-index:1;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            max-width:1120px;
            margin:auto;
            padding:18px 28px;
        }

        .brand {
            display:flex;
            align-items:center;
            gap:10px;
            color:#fff;
            font-weight:800;
            letter-spacing:-.02em;
            text-decoration:none;
        }

        .brand-mark {
            display:grid;
            place-items:center;
            width:38px;
            height:38px;
            border-radius:12px;
            background:#ffffff1d;
            color:#fff;
        }

        .back-link {
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:9px 13px;
            border:1px solid #ffffff70;
            border-radius:9px;
            color:#fff;
            font-size:.86rem;
            font-weight:700;
            text-decoration:none;
            transition:background .2s,color .2s;
        }

        .back-link:hover {
            color:var(--navy);
            background:#fff;
        }

        .page-intro {
            position:relative;
            z-index:1;
            max-width:1120px;
            margin:auto;
            padding:28px 28px 48px;
        }

        .eyebrow {
            margin:0 0 8px;
            color:#b8d5f5;
            font-size:.75rem;
            font-weight:800;
            letter-spacing:.12em;
            text-transform:uppercase;
        }

        .page-intro h1 {
            margin:0;
            color:#fff;
            font-size:clamp(2rem,4vw,3rem);
            font-weight:800;
            letter-spacing:-.055em;
        }

        .page-intro p {
            max-width:620px;
            margin:9px 0 0;
            color:#d3e1f0;
            line-height:1.65;
        }

        .page-main {
            position:relative;
            z-index:2;
            max-width:1120px;
            margin:-20px auto 0;
            padding:0 28px 56px;
        }

        .request-list {
            display:grid;
            gap:16px;
        }

        .request-card {
            overflow:hidden;
            border:1px solid var(--line);
            border-radius:16px;
            background:#fff;
            box-shadow:0 10px 30px #173f6b08;
        }

        .request-card-header {
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:16px;
            padding:20px 22px 16px;
            border-bottom:1px solid #e8edf3;
        }

        .book-kicker {
            margin:0 0 5px;
            color:var(--navy-mid);
            font-size:.7rem;
            font-weight:800;
            letter-spacing:.1em;
            text-transform:uppercase;
        }

        .request-card h2 {
            margin:0;
            color:var(--navy);
            font-size:1.2rem;
            font-weight:800;
            letter-spacing:-.02em;
        }

        .owner-line {
            display:flex;
            align-items:center;
            gap:7px;
            margin:8px 0 0;
            color:var(--muted);
            font-size:.87rem;
        }

        .owner-line i { color:var(--navy-mid); }

        .status-badge {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:7px 10px;
            border-radius:8px;
            font-size:.74rem;
            font-weight:800;
            white-space:nowrap;
        }

        .status-badge.approved {
            color:#23744a;
            background:#e4f4eb;
        }

        .status-badge.rejected {
            color:#aa3038;
            background:#fde8e9;
        }

        .status-badge.completed {
            color:#245586;
            background:#e6f1fb;
        }

        .status-badge.cancelled {
            color:#526579;
            background:#e9eef4;
        }

        .status-badge.pending,
        .status-badge.negotiation {
            color: #825711;
            background: #FFF2D7;
        }

        .request-card-body { padding:18px 22px 21px; }

        .status-actions {
            display:flex;
            align-items:center;
            flex-wrap:wrap;
            gap:9px;
            margin-bottom:17px;
        }

        .status-actions .btn {
            min-height:37px;
            border-radius:9px;
            font-size:.82rem;
            font-weight:800;
        }

        .status-label {
            margin-right:3px;
            color:#536a82;
            font-size:.84rem;
            font-weight:700;
        }

        .cancel-button {
            color:#8b3038;
            border-color:#e8c3c7;
            background:#fff;
        }

        .cancel-button:hover {
            color:#81252d;
            border-color:#ddaeb4;
            background:#fff0f1;
        }

        .complete-button {
            color:#fff;
            background:var(--navy);
            border-color:var(--navy);
        }

        .complete-button:hover {
            color:#fff;
            background:var(--navy-dark);
            border-color:var(--navy-dark);
        }

        .review-button {
            color:var(--navy);
            border-color:#c9d5e2;
            background:#fff;
        }

        .review-button:hover {
            color:var(--navy);
            border-color:#a9bed4;
            background:#eaf1f9;
        }

        .reviewed-label {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:8px 10px;
            border-radius:8px;
            color:#526579;
            background:#e9eef4;
            font-size:.78rem;
            font-weight:700;
        }

        .schedule-grid {
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:12px;
        }

        .schedule-box {
            padding:15px;
            border:1px solid #dfe8f1;
            border-radius:12px;
            background:#f7f9fc;
        }

        .schedule-box.proposed {
            border-color:#c8dcef;
            background:#f1f7fd;
        }

        .schedule-box.final {
            border-color:#c5e6d2;
            background:#f0f9f3;
        }

        .schedule-box.final .schedule-title {
            color:#23744a;
        }

        .schedule-title {
            display:flex;
            align-items:center;
            gap:8px;
            margin:0 0 12px;
            color:var(--navy);
            font-size:.86rem;
            font-weight:800;
        }

        .schedule-box.proposed .schedule-title { color:#245586; }

        .schedule-detail {
            display:flex;
            gap:8px;
            margin:7px 0 0;
            color:#52677d;
            font-size:.84rem;
            line-height:1.5;
        }

        .schedule-detail i {
            flex:0 0 16px;
            margin-top:2px;
            color:#7188a0;
        }

        .schedule-detail strong { color:#29435f; }

        .proposal-manage {
            display:flex;
            justify-content:flex-end;
            margin-top:12px;
        }

        .manage-button {
            display:inline-flex;
            align-items:center;
            gap:7px;
            padding:9px 12px;
            border:1px solid #c8dcef;
            border-radius:9px;
            color:var(--navy);
            background:#fff;
            font-size:.82rem;
            font-weight:800;
        }

        .manage-button:hover {
            border-color:#a9c5e3;
            background:#eaf3fc;
        }

        .empty-state {
            padding:58px 24px;
            border:1px dashed #b9cadd;
            border-radius:18px;
            background:#fff;
            text-align:center;
        }

        .empty-icon {
            display:grid;
            place-items:center;
            width:60px;
            height:60px;
            margin:0 auto 17px;
            border-radius:18px;
            color:var(--navy-mid);
            background:var(--sky);
            font-size:1.55rem;
        }

        .empty-state h2 {
            margin:0 0 8px;
            color:var(--navy);
            font-size:1.2rem;
            font-weight:800;
        }

        .empty-state p {
            max-width:420px;
            margin:0 auto;
            color:var(--muted);
            line-height:1.6;
        }

        .modal-content {
            overflow:hidden;
            border:1px solid var(--line);
            border-radius:16px;
            box-shadow:0 20px 60px #0b25422b;
        }

        .modal-header {
            padding:18px 20px;
            color:#fff;
            background:var(--navy);
        }

        .modal-header .modal-title {
            font-size:1rem;
            font-weight:800;
        }

        .modal-header .btn-close {
            filter:brightness(0) invert(1);
        }

        .modal-body {
            padding:20px;
            color:#52677d;
            line-height:1.65;
        }

        .modal-footer {
            gap:8px;
            padding:14px 20px;
            border-top:1px solid #e8edf3;
        }

        .modal-footer .btn {
            border-radius:9px;
            font-weight:700;
        }

        .modal-edit-button {
            color:#fff;
            background:var(--navy);
            border-color:var(--navy);
        }

        .modal-edit-button:hover {
            color:#fff;
            background:var(--navy-dark);
            border-color:var(--navy-dark);
        }

        .alert { border:0; border-radius:12px; }

        .request-filters {
            display:flex;
            flex-wrap:wrap;
            gap:9px;
        }

        .request-filters .btn {
            padding:9px 18px;
            border:1px solid #cbd8e6;
            border-radius:9px;
            color:var(--navy);
            background:#fff;
            font-weight:700;
        }

        .request-filters .btn.active {
            color:#fff;
            background:var(--navy);
            border-color:var(--navy);
        }

        @media(max-width:650px) {
            .header-inner { padding:14px 18px; }
            .page-intro { padding:25px 20px 42px; }
            .page-main { padding:0 14px 36px; }
            .request-card-header { padding:17px; }
            .request-card-body { padding:15px 17px 18px; }
            .schedule-grid { grid-template-columns:1fr; }
            .back-link span { display:none; }
            .proposal-manage { justify-content:stretch; }
            .manage-button { justify-content:center; width:100%; }
        }

        @media(max-width:430px) {
            .status-actions { align-items:stretch; }
            .status-actions .btn { flex:1 1 100%; }
        }

        .handover-progress {
            margin-top:15px;
            padding:14px;
            border:1px solid #dce5ef;
            border-radius:12px;
            background:#f7f9fc;
        }

        .handover-progress p {
            margin:7px 0 0;
            color:#52677d;
            font-size:.85rem;
        }

        .handover-progress i {
            margin-right:6px;
        }

        .request-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 15px;
        }

        .request-actions form {
            margin: 0;
        }

        .sell-approved-actions {
            margin-top: 12px;
        }

        .exchange-status-actions {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true">
                    <i class="bi bi-book-half"></i>
                </span>
                <span>UniKL BookHub</span>
            </a>

            <a href="{{ route('dashboard') }}" class="back-link">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                <span>Back to Dashboard</span>
            </a>
        </div>

        <div class="page-intro">
            <p class="eyebrow">Buyer activity</p>
            <h1>Sent book requests</h1>
            <p>Track requests you have sent and review the meeting details for each book.</p>
        </div>
    </header>

    <main class="page-main">

        @if(session('success'))
            <div class="alert alert-success mb-3" role="status">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-3" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="request-filters mb-4">
            <button type="button" class="btn active" data-filter="all">All</button>
            <button type="button" class="btn" data-filter="sell">Sell</button>
            <button type="button" class="btn" data-filter="exchange">Exchange</button>
        </div>

        <p id="filter-empty" class="text-muted text-center d-none">
            No requests found in this category.
        </p>

        @forelse($requests as $req)
            @php
                $hasReview = \App\Models\Review::where('book_request_id', $req->id)
                    ->where('user_id', auth()->id())
                    ->exists();

                $isExchange = $req->book && $req->book->listing_type === 'exchange';

                $displayStatus = $isExchange
                    ? (
                        $req->status === 'pending' && $req->schedule_type === 'requester'
                            ? 'negotiation'
                            : $req->status
                    )
                    : $req->status;
            @endphp

            <div class="request-list mb-3">

                <article class="request-card request-item"
                         data-request-type="{{ $isExchange ? 'exchange' : 'sell' }}">

                    <header class="request-card-header">
                        <div>
                            <p class="book-kicker">
                                Your {{ $isExchange ? 'exchange' : 'sell' }} request
                            </p>

                            <h2>{{ $req->book->title }}</h2>

                            <div class="mb-2">
                                @if($isExchange)
                                    <span class="badge text-bg-primary">Exchange</span>
                                @else
                                    <span class="badge text-bg-secondary">Sell</span>
                                @endif
                            </div>

                            <p class="owner-line">
                                <i class="bi bi-person-circle" aria-hidden="true"></i>
                                Book owner <strong>{{ $req->owner->name }}</strong>
                            </p>
                        </div>

                        <span class="status-badge {{ in_array($displayStatus, ['approved', 'rejected', 'completed', 'cancelled', 'pending', 'negotiation'], true) ? $displayStatus : '' }}">
                            <i class="bi bi-circle-fill" style="font-size:.42rem" aria-hidden="true"></i>
                            {{ ucfirst($displayStatus) }}
                        </span>
                    </header>

                    <div class="request-card-body">

                        {{-- SELL BOOK DETAILS --}}
                        @if(!$isExchange)

                            <section class="schedule-box mb-3">

                                <div class="d-flex align-items-start gap-3">

                                    {{-- BOOK COVER --}}
                                    @if($req->book->image)
                                        <img
                                            src="{{ asset('storage/' . $req->book->image) }}"
                                            alt="{{ $req->book->title }}"
                                            style="width:100px;height:135px;object-fit:cover;border-radius:9px;"
                                        >
                                    @else
                                        <div style="width:100px;height:135px;border-radius:9px;background:#e9eef4;display:grid;place-items:center;color:#7188a0;">
                                            <i class="bi bi-book" style="font-size:2rem;"></i>
                                        </div>
                                    @endif

                                    {{-- BOOK INFORMATION --}}
                                    <div>

                                        <h3 class="schedule-title mb-3">
                                            <i class="bi bi-book"></i>
                                            Book Details
                                        </h3>

                                        <p class="schedule-detail">
                                            <span>
                                                <strong>Subject Code:</strong>
                                                {{ $req->book->subject_id ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <span>
                                                <strong>Condition:</strong>
                                                {{ $req->book->condition ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <span>
                                                <strong>Price:</strong>
                                                RM {{ number_format((float) $req->book->price, 2) }}
                                            </span>
                                        </p>

                                    </div>

                                </div>

                            </section>

                        @endif

                        {{-- EXCHANGE OFFERED BOOK --}}
                        @if($isExchange && $req->exchangeOffer)
                            <section class="schedule-box proposed mb-3">
                                <h3 class="schedule-title">
                                    <i class="bi bi-arrow-left-right"></i>
                                    Your offered book
                                </h3>

                                <div class="d-flex align-items-center gap-3">
                                    @if($req->exchangeOffer->image)
                                        <img
                                            src="{{ asset('storage/' . $req->exchangeOffer->image) }}"
                                            alt="{{ $req->exchangeOffer->title }}"
                                            style="width:75px;height:100px;object-fit:cover;border-radius:9px;"
                                        >
                                    @endif

                                    <div>
                                        <strong>{{ $req->exchangeOffer->title }}</strong>

                                        <p class="schedule-detail">
                                            <span>
                                                <strong>Subject:</strong>
                                                {{ $req->exchangeOffer->subject_id }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <span>
                                                <strong>Condition:</strong>
                                                {{ $req->exchangeOffer->condition }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </section>
                        @endif

                        {{-- SELL: STUDENT A RESPONDS TO SELLER'S PROPOSED SCHEDULE --}}
                        @if(
                            !$isExchange &&
                            $req->status === 'negotiation' &&
                            $req->schedule_type === 'seller'
                        )

                            <div class="status-actions {{ $req->status === 'approved' ? 'sell-approved-actions' : '' }}">
                                {{-- -Action 
                                <span class="status-label">Review Proposed Schedule</span>
                                --}}

                                {{-- Accept Student B's proposed schedule --}}
                                <form method="POST"
                                    action="{{ route('request.accept-schedule', $req->id) }}">
                                    @csrf

                                    <button type="submit" class="btn complete-button">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Accept Proposed Schedule
                                    </button>
                                </form>

                                {{-- Propose another schedule --}}
                                <button type="button"
                                        class="btn review-button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#sellCounterSchedule-{{ $req->id }}">
                                    <i class="bi bi-calendar-plus me-1"></i>
                                    Propose Another Schedule
                                </button>

                                {{-- Cancel request --}}
                                <form method="POST"
                                    action="{{ route('request.cancel', $req->id) }}"
                                    onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                    @csrf

                                    <button type="submit" class="btn cancel-button">
                                        <i class="bi bi-x-circle me-1"></i>
                                        Cancel Request
                                    </button>
                                </form>

                            </div>

                            {{-- Student A's new schedule form --}}
                            <div class="collapse mb-3"
                                id="sellCounterSchedule-{{ $req->id }}">

                                <section class="schedule-box proposed">

                                    <h3 class="schedule-title">
                                        <i class="bi bi-calendar-plus"></i>
                                        Propose Another Meeting Schedule
                                    </h3>

                                    <form method="POST"
                                        action="{{ route('request.counter-schedule-buyer', $req->id) }}">

                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label">Meeting location</label>
                                            <input type="text"
                                                name="proposed_location"
                                                class="form-control"
                                                required
                                                maxlength="255"
                                                placeholder="Enter meeting location">
                                        </div>

                                        <div class="row">

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Meeting date</label>
                                                <input type="date"
                                                    name="proposed_date"
                                                    class="form-control"
                                                    min="{{ date('Y-m-d') }}"
                                                    required>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Start time</label>
                                                <input type="time"
                                                    name="proposed_time"
                                                    class="form-control"
                                                    required>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">End time</label>
                                                <input type="time"
                                                    name="proposed_end_time"
                                                    class="form-control"
                                                    required>
                                            </div>

                                        </div>

                                        <button type="submit" class="btn complete-button">
                                            <i class="bi bi-send me-1"></i>
                                            Proposed New Schedule
                                        </button>

                                    </form>

                                </section>

                            </div>

                        @endif

                        {{-- SCHEDULE DETAILS --}}       

                        <div class="schedule-grid">

                            @if($isExchange)

                                {{-- STUDENT B'S LATEST PROPOSED SCHEDULE --}}
                                @if($req->schedule_type === 'owner')

                                    <section class="schedule-box proposed">

                                        <h3 class="schedule-title">
                                            <i class="bi bi-calendar2-check"></i>

                                            @if($req->status === 'approved')
                                                Final Agreed Schedule
                                            @else
                                                Owner's Proposed Schedule
                                            @endif
                                        </h3>

                                        <p class="schedule-detail">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>
                                                <strong>Location</strong><br>
                                                {{ $req->proposed_location ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-calendar3"></i>
                                            <span>
                                                <strong>Date</strong><br>
                                                {{ $req->proposed_date
                                                    ? \Carbon\Carbon::parse($req->proposed_date)->format('d M Y')
                                                    : 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-clock"></i>
                                            <span>
                                                <strong>Time</strong><br>

                                                {{ $req->proposed_time
                                                    ? \Carbon\Carbon::parse($req->proposed_time)->format('g:i A')
                                                    : 'Not set' }}

                                                @if($req->proposed_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->proposed_end_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </p>

                                    </section>

                                {{-- STUDENT A'S OWN PROPOSED SCHEDULE --}}
                                @elseif($req->schedule_type === 'requester')

                                    {{-- STUDENT B'S ORIGINAL SCHEDULE --}}
                                    <section class="schedule-box">

                                        <h3 class="schedule-title">
                                            <i class="bi bi-calendar2-check"></i>
                                            Owner's Original Schedule
                                        </h3>

                                        <p class="schedule-detail">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>
                                                <strong>Location</strong><br>
                                                {{ $req->book->meeting_location ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-calendar3"></i>
                                            <span>
                                                <strong>Date</strong><br>
                                                {{ $req->book->meeting_date
                                                    ? \Carbon\Carbon::parse($req->book->meeting_date)->format('d M Y')
                                                    : 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-clock"></i>
                                            <span>
                                                <strong>Time</strong><br>

                                                {{ $req->book->meeting_time
                                                    ? \Carbon\Carbon::parse($req->book->meeting_time)->format('g:i A')
                                                    : 'Not set' }}

                                                @if($req->book->meeting_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->book->meeting_end_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </p>

                                    </section>

                                    {{-- STUDENT A'S LATEST PROPOSAL --}}
                                    <section class="schedule-box proposed">

                                        <h3 class="schedule-title">
                                            <i class="bi bi-arrow-left-right"></i>

                                            @if($req->status === 'approved')
                                                Final Agreed Schedule
                                            @else
                                                Your Proposed Schedule
                                            @endif
                                        </h3>

                                        <p class="schedule-detail">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>
                                                <strong>Location</strong><br>
                                                {{ $req->proposed_location ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-calendar3"></i>
                                            <span>
                                                <strong>Date</strong><br>
                                                {{ $req->proposed_date
                                                    ? \Carbon\Carbon::parse($req->proposed_date)->format('d M Y')
                                                    : 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-clock"></i>
                                            <span>
                                                <strong>Time</strong><br>

                                                {{ $req->proposed_time
                                                    ? \Carbon\Carbon::parse($req->proposed_time)->format('g:i A')
                                                    : 'Not set' }}

                                                @if($req->proposed_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->proposed_end_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </p>

                                        @if(in_array($req->status, ['pending', 'negotiation']))
                                            <div class="proposal-manage">
                                                <button type="button"
                                                        class="manage-button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exchangeProposalModal-{{ $req->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                    Manage Proposed Schedule
                                                </button>
                                            </div>
                                        @endif

                                    </section>

                                @endif

                            @else

                                
                                {{-- SELL: FINAL AGREED SCHEDULE AFTER COMPLETION --}}
                                @if($req->status === 'completed')

                                    <section class="schedule-box final">

                                        <h3 class="schedule-title">
                                            <i class="bi bi-check-circle"></i>
                                            Final Agreed Schedule
                                        </h3>

                                        <p class="schedule-detail">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>
                                                <strong>Location</strong><br>
                                                {{ $req->proposed_location ?? $req->book->meeting_location ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-calendar3"></i>
                                            <span>
                                                <strong>Date</strong><br>
                                                {{ ($req->proposed_date ?? $req->book->meeting_date)
                                                    ? \Carbon\Carbon::parse($req->proposed_date ?? $req->book->meeting_date)->format('d M Y')
                                                    : 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-clock"></i>
                                            <span>
                                                <strong>Time</strong><br>

                                                {{ ($req->proposed_time ?? $req->book->meeting_time)
                                                    ? \Carbon\Carbon::parse($req->proposed_time ?? $req->book->meeting_time)->format('g:i A')
                                                    : 'Not set' }}

                                                @if($req->proposed_end_time ?? $req->book->meeting_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->proposed_end_time ?? $req->book->meeting_end_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </p>

                                    </section>

                                @else

                                    {{-- SELL: ORIGINAL SELLER SCHEDULE --}}
                                    <section class="schedule-box">

                                        <h3 class="schedule-title">
                                            <i class="bi bi-calendar2-check"></i>
                                            Owner Schedule
                                        </h3>

                                        <p class="schedule-detail">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>
                                                <strong>Location</strong><br>
                                                {{ $req->book->meeting_location ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-calendar3"></i>
                                            <span>
                                                <strong>Date</strong><br>
                                                {{ $req->book->meeting_date
                                                    ? \Carbon\Carbon::parse($req->book->meeting_date)->format('d M Y')
                                                    : 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-clock"></i>
                                            <span>
                                                <strong>Time</strong><br>
                                                {{ $req->book->meeting_time
                                                    ? \Carbon\Carbon::parse($req->book->meeting_time)->format('g:i A')
                                                    : 'Not set' }}

                                                @if($req->book->meeting_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->book->meeting_end_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </p>

                                    </section>

                                @endif

                                {{-- SELL: SHOW SELLER'S NEW PROPOSAL AFTER STUDENT B PROPOSES --}}
                                @if(
                                    $req->status === 'negotiation' &&
                                    $req->schedule_type === 'seller'
                                )

                                    <section class="schedule-box proposed">

                                        <h3 class="schedule-title">
                                            <i class="bi bi-calendar-plus"></i>
                                            Seller's Proposed Schedule
                                        </h3>

                                        <p class="schedule-detail">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>
                                                <strong>Location</strong><br>
                                                {{ $req->proposed_location ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-calendar3"></i>
                                            <span>
                                                <strong>Date</strong><br>
                                                {{ $req->proposed_date
                                                    ? \Carbon\Carbon::parse($req->proposed_date)->format('d M Y')
                                                    : 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-clock"></i>
                                            <span>
                                                <strong>Time</strong><br>
                                                {{ $req->proposed_time
                                                    ? \Carbon\Carbon::parse($req->proposed_time)->format('g:i A')
                                                    : 'Not set' }}

                                                @if($req->proposed_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->proposed_end_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </p>

                                    </section>

                                @endif

                                {{-- SELL: SHOW STUDENT A'S OWN PROPOSAL --}}
                                @if(
                                    $req->status === 'negotiation' &&
                                    $req->schedule_type === 'buyer'
                                )

                                    <section class="schedule-box proposed">

                                        <h3 class="schedule-title">
                                            <i class="bi bi-calendar-plus"></i>
                                            Your Proposed Schedule
                                        </h3>

                                        <p class="schedule-detail">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>
                                                <strong>Location</strong><br>
                                                {{ $req->proposed_location ?? 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-calendar3"></i>
                                            <span>
                                                <strong>Date</strong><br>
                                                {{ $req->proposed_date
                                                    ? \Carbon\Carbon::parse($req->proposed_date)->format('d M Y')
                                                    : 'Not set' }}
                                            </span>
                                        </p>

                                        <p class="schedule-detail">
                                            <i class="bi bi-clock"></i>
                                            <span>
                                                <strong>Time</strong><br>
                                                {{ $req->proposed_time
                                                    ? \Carbon\Carbon::parse($req->proposed_time)->format('g:i A')
                                                    : 'Not set' }}

                                                @if($req->proposed_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->proposed_end_time)->format('g:i A') }}
                                                @endif
                                            </span>
                                        </p>

                                        <div class="proposal-manage">

                                            <button type="button"
                                                    class="manage-button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#proposalModal-{{ $req->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                                Manage Proposed Schedule
                                            </button>

                                        </div>

                                    </section>

                                @endif

                            @endif

                        </div>

                        @if(in_array($req->status, ['approved', 'completed'], true))
                            <section class="schedule-box final mb-3" aria-label="Contact information">
                                <h3 class="schedule-title">
                                    <i class="bi bi-telephone" aria-hidden="true"></i>
                                    Contact {{ $req->owner->name }}
                                </h3>
                                @if($req->owner->phone)
                                    <p class="schedule-detail mb-0">
                                        <i class="bi bi-phone" aria-hidden="true"></i>
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $req->owner->phone) }}">{{ $req->owner->phone }}</a>
                                    </p>
                                @else
                                    <p class="schedule-detail mb-0">
                                        <i class="bi bi-info-circle" aria-hidden="true"></i>
                                        Phone number not added to this user’s profile.
                                    </p>
                                @endif
                            </section>
                        @endif

                        {{-- SELL: PHYSICAL BOOK HANDOVER CONFIRMATION --}}
                        @if(
                            !$isExchange &&
                            in_array($req->status, ['approved', 'completed'])
                        )

                            <div class="handover-progress">

                                <strong>
                                    <i class="bi bi-box-seam"></i>
                                    Physical book handover confirmation
                                </strong>

                                @if($req->requester_confirmed_handover)

                                    <p>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        You have confirmed receiving the book.
                                    </p>

                                @else

                                    <p>
                                        <i class="bi bi-clock text-warning"></i>
                                        You have not confirmed receiving the book.
                                    </p>

                                @endif

                                @if($req->owner_confirmed_handover)

                                    <p>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        {{ $req->owner->name }} has confirmed handing over the book.
                                    </p>

                                @else

                                    <p>
                                        <i class="bi bi-clock text-warning"></i>
                                        Waiting for {{ $req->owner->name }} to confirm handing over the book.
                                    </p>

                                @endif

                                @if($req->status === 'completed')

                                    <p>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        This sale has been completed. Both students confirmed the handover.
                                    </p>

                                @endif

                            </div>

                        @endif

                        {{-- EXISTING SELL ACTIONS --}}
                        @if(!$isExchange && (
                            $req->status == 'pending' ||
                            ($req->status == 'negotiation' && $req->schedule_type === 'buyer') ||
                            $req->status == 'approved' ||
                            $req->status == 'completed' 
                        ))
                            <div class="status-actions {{ $req->status === 'approved' ? 'sell-approved-actions' : '' }}">

                                @if($req->status == 'pending')
                                    <form method="POST" action="{{ route('request.cancel', $req->id) }}" class="mt-3"
                                        onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                        @csrf

                                        <button type="submit" class="btn cancel-button">
                                            <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                            Cancel Request
                                        </button>
                                    </form>

                                @elseif($req->status == 'negotiation' && $req->schedule_type === 'buyer')

                                    <form method="POST" action="{{ route('request.cancel', $req->id) }}" class="mt-3"
                                        onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                        @csrf

                                        <button type="submit" class="btn cancel-button">
                                            <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                            Cancel Request
                                        </button>
                                    </form>

                                @elseif($req->status == 'approved')

                                    @if(!$req->requester_confirmed_handover)

                                        <form method="POST"
                                            action="{{ route('request.confirm-handover', $req->id) }}"
                                            onsubmit="return confirm('Confirm that you have physically received the book from the seller?');">
                                            @csrf

                                            <button type="submit" class="btn complete-button">
                                                <i class="bi bi-check-circle me-1" aria-hidden="true"></i>
                                                Confirm Handover
                                            </button>
                                        </form>

                                    @else

                                        <span class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            Waiting for seller to confirm handover
                                        </span>

                                    @endif

                                    @if(!$req->requester_confirmed_handover && !$req->owner_confirmed_handover)

                                        <form method="POST" action="{{ route('request.cancel', $req->id) }}"
                                            onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                            @csrf

                                            <button type="submit" class="btn cancel-button">
                                                <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                                Cancel request
                                            </button>
                                        </form>

                                    @endif

                                @elseif($req->status == 'completed')

                                    @if(!$hasReview)
                                        <a href="{{ route('review.create', $req->id) }}" class="btn review-button mt-3">
                                            <i class="bi bi-star me-1" aria-hidden="true"></i>
                                            Write a review
                                        </a>
                                    @else
                                        <span class="reviewed-label">
                                            <i class="bi bi-check-circle" aria-hidden="true"></i>
                                            Already reviewed
                                        </span>
                                    @endif
                                @endif
                            </div>
                        @endif

                        {{-- EXCHANGE: PHYSICAL BOOK HANDOVER CONFIRMATION --}}
                        @if(
                            $isExchange &&
                            in_array($req->status, ['approved', 'completed'])
                        )

                            <div class="handover-progress">

                                <strong>
                                    <i class="bi bi-box-seam"></i>
                                    Physical book handover confirmation
                                </strong>

                                @if($req->requester_confirmed_handover)
                                    <p>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        You have confirmed receiving the offered book.
                                    </p>
                                @else
                                    <p>
                                        <i class="bi bi-clock text-warning"></i>
                                        You have not confirmed receiving the offered book.
                                    </p>
                                @endif

                                @if($req->owner_confirmed_handover)
                                    <p>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        {{ $req->owner->name }} has confirmed receiving your book.
                                    </p>
                                @else
                                    <p>
                                        <i class="bi bi-clock text-warning"></i>
                                        Waiting for {{ $req->owner->name }} to confirm receiving your book.
                                    </p>
                                @endif

                                @if($req->status === 'completed')
                                    <p>
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                        This Exchange has been completed. Both students confirmed the handover.
                                    </p>
                                @endif

                            </div>

                        @endif

                        {{-- EXCHANGE ACTIONS --}}
                        @if($isExchange)
                            <div class="status-actions exchange-status-actions">
                                {{-- Action 
                                <span class="status-label">Exchange actions</span>
                                --}}

                                @if($req->status === 'pending')
                                    <form method="POST" action="{{ route('exchange.cancel', $req->id) }}"
                                        onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                        @csrf

                                        <button type="submit" class="btn cancel-button">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Cancel Exchange
                                        </button>
                                    </form>

                                @elseif($req->status === 'negotiation' && $req->schedule_type === 'owner')

                                    <form method="POST" action="{{ route('exchange.accept-schedule', $req->id) }}">
                                        @csrf

                                        <button type="submit" class="btn complete-button">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Accept Proposed Schedule
                                        </button>
                                    </form>

                                    <button type="button"
                                            class="btn cancel-button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#counterSchedule-{{ $req->id }}">
                                        <i class="bi bi-calendar-plus me-1"></i>
                                        Propose Another Schedule
                                    </button>

                                    <div class="collapse mt-3" id="counterSchedule-{{ $req->id }}">
                                        <form method="POST" action="{{ route('exchange.counter-schedule', $req->id) }}">
                                            @csrf

                                            <div class="mb-2">
                                                <label class="form-label">Meeting location</label>
                                                <input type="text" name="proposed_location" class="form-control" required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">Meeting date</label>
                                                <input type="date"
                                                       name="proposed_date"
                                                       class="form-control"
                                                       min="{{ date('Y-m-d') }}"
                                                       required>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label">Start time</label>
                                                <input type="time" name="proposed_time" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">End time</label>
                                                <input type="time" name="proposed_end_time" class="form-control" required>
                                            </div>

                                            <button type="submit" class="btn complete-button">
                                                Proposed New Schedule
                                            </button>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{ route('exchange.cancel', $req->id) }}"
                                        onsubmit="return confirm('Are you sure you want to cancel this exchange?');">
                                        @csrf

                                        <button type="submit" class="btn cancel-button">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Cancel Exchange
                                        </button>
                                    </form>

                                @elseif($req->status === 'negotiation' && $req->schedule_type === 'requester')

                                    <form method="POST" action="{{ route('exchange.cancel', $req->id) }}"
                                        onsubmit="return confirm('Are you sure you want to cancel this exchange?');">
                                        @csrf

                                        <button type="submit" class="btn cancel-button">
                                            Cancel Exchange
                                        </button>
                                    </form>
                       
                                @elseif($req->status === 'approved')

                                    <div class="request-actions">

                                        @if(!$req->requester_confirmed_handover)

                                            <form method="POST" action="{{ route('exchange.confirm-handover', $req->id) }}"
                                                onsubmit="return confirm('Confirm that you have physically received the offered book?');">
                                                @csrf

                                                <button type="submit" class="btn complete-button">
                                                    <i class="bi bi-check-circle me-1"></i>
                                                    Confirm Handover
                                                </button>
                                            </form>

                                        @else

                                            <span class="reviewed-label">
                                                <i class="bi bi-check-circle"></i>
                                                You have confirmed the handover. Waiting for the other student.
                                            </span>

                                        @endif

                                        @if(!$req->requester_confirmed_handover && !$req->owner_confirmed_handover)

                                            <form method="POST"
                                                action="{{ route('exchange.cancel', $req->id) }}"
                                                onsubmit="return confirm('Are you sure you want to cancel this exchange?');">
                                                @csrf

                                                <button type="submit" class="btn cancel-button">
                                                    <i class="bi bi-x-lg me-1"></i>
                                                    Cancel Exchange
                                                </button>
                                            </form>

                                        @endif

                                
                                    </div>
                                @elseif($req->status === 'completed')

                                    @if(!$hasReview)
                                        <a href="{{ route('review.create', $req->id) }}" class="btn review-button mt-3">
                                            <i class="bi bi-star me-1" aria-hidden="true"></i>
                                            Write a review
                                        </a>
                                    @else
                                        <span class="reviewed-label">
                                            <i class="bi bi-check-circle" aria-hidden="true"></i>
                                            Already reviewed
                                        </span>
                                    @endif
                                @endif
                            </div>
                        @endif
                        @if(in_array($req->status, ['rejected', 'cancelled'], true))
                            <div class="request-actions">
                                <form method="POST"
                                    action="{{ route('book-request.delete', $req->id) }}"
                                    onsubmit="return confirm('Remove this request from your list?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash me-1"></i>
                                        Delete Request
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </article>

            </div>

        @empty

            <section class="empty-state">
                <div class="empty-icon">
                    <i class="bi bi-send" aria-hidden="true"></i>
                </div>

                <h2>No requests sent yet</h2>

                <p>
                    When you request a book from the catalogue, you can follow its status and meeting details here.
                </p>
            </section>

        @endforelse

    </main>

    {{-- EXCHANGE SCHEDULE PROPOSAL MODALS: OUTSIDE MAIN --}}
    @foreach($requests as $req)
        @if(
            $req->book &&
            $req->book->listing_type === 'exchange' &&
            in_array($req->status, ['pending', 'negotiation']) &&
            $req->schedule_type === 'requester' &&
            $req->requester_id == auth()->id()
        )
            <div class="modal fade"
                id="exchangeProposalModal-{{ $req->id }}"
                tabindex="-1"
                aria-labelledby="exchangeProposalModalTitle-{{ $req->id }}"
                aria-hidden="true">

                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="exchangeProposalModalTitle-{{ $req->id }}">
                                Manage Exchange Proposed Schedule
                            </h5>

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>What would you like to do with your proposed meeting schedule?</p>

                            <div class="collapse" id="editExchangeProposal-{{ $req->id }}">
                                <hr>

                                <form method="POST"
                                    action="{{ route('exchange.proposed-schedule.update', $req->id) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Meeting location</label>
                                        <input type="text"
                                            name="proposed_location"
                                            class="form-control"
                                            maxlength="255"
                                            required
                                            value="{{ $req->proposed_location }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Meeting date</label>
                                        <input type="date"
                                            name="proposed_date"
                                            class="form-control"
                                            min="{{ date('Y-m-d') }}"
                                            required
                                            value="{{ $req->proposed_date ? \Carbon\Carbon::parse($req->proposed_date)->format('Y-m-d') : '' }}">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Start time</label>
                                            <input type="time"
                                                name="proposed_time"
                                                class="form-control"
                                                required
                                                value="{{ $req->proposed_time ? substr($req->proposed_time, 0, 5) : '' }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">End time</label>
                                            <input type="time"
                                                name="proposed_end_time"
                                                class="form-control"
                                                required
                                                value="{{ $req->proposed_end_time ? substr($req->proposed_end_time, 0, 5) : '' }}">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn modal-edit-button">
                                        Save Changes
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer d-flex align-items-center justify-content-end flex-wrap gap-2">

                            <button type="button"
                                    class="btn modal-edit-button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#editExchangeProposal-{{ $req->id }}">
                                <i class="bi bi-pencil-square me-1"></i>
                                Edit Proposal
                            </button>

                            <button type="button"
                                    class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">
                                Keep Proposal
                            </button>

                            <form method="POST"
                                action="{{ route('exchange.proposed-schedule.delete', $req->id) }}"
                                class="m-0"
                                onsubmit="return confirm('Are you sure you want to delete this proposal?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-outline-danger">
                                    Delete Proposal
                                </button>
                            </form>

                        </div>  
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    
{{-- SELL SCHEDULE PROPOSAL MODALS: OUTSIDE MAIN --}}
@foreach($requests as $req)
    @if(
        $req->book &&
        $req->book->listing_type !== 'exchange' &&
        $req->status === 'negotiation' &&
        $req->schedule_type === 'buyer'
    )
        <div class="modal fade"
             id="proposalModal-{{ $req->id }}"
             tabindex="-1"
             aria-labelledby="proposalModalTitle-{{ $req->id }}"
             aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="proposalModalTitle-{{ $req->id }}">
                            Manage Sell Proposed Schedule
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p>
                            What would you like to do with your proposed meeting schedule?
                        </p>

                        {{-- HIDDEN EDIT FORM --}}
                        <div class="collapse"
                             id="editSellProposal-{{ $req->id }}">

                            <hr>

                            <form method="POST"
                                  action="{{ route('book.proposeSchedule', $req->book_id) }}">
                                @csrf
                                @method('PUT')

                                <input type="hidden"
                                       name="return_to"
                                       value="sent-requests">

                                <div class="mb-3">
                                    <label class="form-label">Meeting location</label>
                                    <input type="text"
                                           name="proposed_location"
                                           class="form-control"
                                           maxlength="255"
                                           required
                                           value="{{ $req->proposed_location }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meeting date</label>
                                    <input type="date"
                                           name="proposed_date"
                                           class="form-control"
                                           min="{{ date('Y-m-d') }}"
                                           required
                                           value="{{ $req->proposed_date ? \Carbon\Carbon::parse($req->proposed_date)->format('Y-m-d') : '' }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Start time</label>
                                        <input type="time"
                                               name="proposed_time"
                                               class="form-control"
                                               required
                                               value="{{ $req->proposed_time ? substr($req->proposed_time, 0, 5) : '' }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">End time</label>
                                        <input type="time"
                                               name="proposed_end_time"
                                               class="form-control"
                                               required
                                               value="{{ $req->proposed_end_time ? substr($req->proposed_end_time, 0, 5) : '' }}">
                                    </div>
                                </div>

                                <button type="submit"
                                        class="btn modal-edit-button">
                                    Save Changes
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer d-flex align-items-center justify-content-end flex-wrap gap-2">

                        {{-- EDIT PROPOSAL --}}
                        <button type="button"
                                class="btn modal-edit-button"
                                data-bs-toggle="collapse"
                                data-bs-target="#editSellProposal-{{ $req->id }}">
                            <i class="bi bi-pencil-square me-1"></i>
                            Edit Proposal
                        </button>

                        {{-- KEEP PROPOSAL --}}
                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">
                            Keep Proposal
                        </button>

                        {{-- DELETE PROPOSAL --}}
                        <form method="POST"
                              action="{{ route('book.proposeSchedule.delete', $req->book_id) }}"
                              onsubmit="return confirm('Are you sure you want to delete this proposal?');"
                              class="m-0">
                            @csrf
                            @method('DELETE')

                            <input type="hidden"
                                   name="return_to"
                                   value="sent-requests">

                            <button type="submit"
                                    class="btn btn-outline-danger">
                                Delete Proposal
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('[data-filter]');
            const requestItems = document.querySelectorAll('.request-item');
            const emptyMessage = document.getElementById('filter-empty');

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const filter = this.dataset.filter;
                    let visibleCount = 0;

                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    requestItems.forEach(item => {
                        const matches =
                            filter === 'all' ||
                            item.dataset.requestType === filter;

                        item.classList.toggle('d-none', !matches);

                        if (matches) visibleCount++;
                    });

                    emptyMessage.classList.toggle('d-none', visibleCount > 0);
                });
            });
        });
    </script>

</body>
</html>
