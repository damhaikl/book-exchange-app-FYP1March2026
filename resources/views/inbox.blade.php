
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Received requests | UniKL BookHub</title>

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

        .request-list { display:grid; gap:16px; }

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

        .requester {
            display:flex;
            align-items:center;
            gap:7px;
            margin:8px 0 0;
            color:var(--muted);
            font-size:.87rem;
        }

        .requester i { color:var(--navy-mid); }

        .status-badge {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:7px 10px;
            border-radius:8px;
            color:#825711;
            background:#fff2d7;
            font-size:.74rem;
            font-weight:800;
            white-space:nowrap;
        }

        .status-badge.approved,
        .status-badge.completed {
            color:#23744a;
            background:#e4f4eb;
        }

        .status-badge.rejected {
            color:#aa3038;
            background:#fde8e9;
        }

        .status-badge.negotiation {
            color:#245586;
            background:#e6f1fb;
        }

        .status-badge.cancelled {
            color:#526579;
            background:#e9eef4;
        }

        .request-card-body { padding:18px 22px 21px; }

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
        .schedule-box.final .schedule-title { color:#23744a; }

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

        .cancel-notice {
            margin:15px 0 0;
            padding:11px 13px;
            border:1px solid #f0dda9;
            border-radius:10px;
            color:#765517;
            background:#fff8e6;
            font-size:.87rem;
        }

        .request-actions {
            display:flex;
            flex-wrap:wrap;
            gap:9px;
            margin-top:17px;
            padding-top:15px;
            border-top:1px solid #e8edf3;
        }

        .request-actions form { margin:0; }

        .request-actions .btn {
            min-height:39px;
            border-radius:9px;
            font-size:.84rem;
            font-weight:800;
        }

        .approve-button {
            color:#fff;
            background:var(--navy);
            border-color:var(--navy);
        }

        .approve-button:hover {
            color:#fff;
            background:var(--navy-dark);
            border-color:var(--navy-dark);
        }

        .reject-button {
            color:#8b3038;
            border-color:#e8c3c7;
            background:#fff;
        }

        .reject-button:hover {
            color:#81252d;
            border-color:#ddaeb4;
            background:#fff0f1;
        }

        .secondary-button {
            color:var(--navy);
            border:1px solid #bdcfe2;
            background:#fff;
        }

        .secondary-button:hover {
            color:var(--navy-dark);
            background:#edf4fb;
        }

        .exchange-form {
            width:100%;
            margin-top:15px;
            padding:16px;
            border:1px solid #dce5ef;
            border-radius:12px;
            background:#f7f9fc;
        }

        .exchange-form h4 {
            margin:0 0 12px;
            color:var(--navy);
            font-size:.95rem;
            font-weight:800;
        }

        .exchange-form label {
            display:block;
            margin-bottom:5px;
            color:#29435f;
            font-size:.8rem;
            font-weight:700;
        }

        .exchange-form .form-control {
            min-height:40px;
            border-color:#d4dfeb;
            border-radius:8px;
            font-size:.87rem;
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

        .handover-progress i { margin-right:6px; }

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

        .alert { border:0; border-radius:12px; }

        @media(max-width:650px) {
            .header-inner { padding:14px 18px; }
            .page-intro { padding:25px 20px 42px; }
            .page-main { padding:0 14px 36px; }
            .request-card-header { padding:17px; }
            .request-card-body { padding:15px 17px 18px; }
            .schedule-grid { grid-template-columns:1fr; }
            .back-link span { display:none; }
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
        <p class="eyebrow">Seller inbox</p>
        <h1>Received book requests</h1>
        <p>Review requests from students and check the proposed meeting details.</p>
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


    {{-- REQUEST FILTERS --}}
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
            $statusClass = in_array(
                $req->status,
                ['pending', 'approved', 'rejected', 'negotiation', 'cancelled', 'completed'],
                true
            ) ? $req->status : '';

            $isExchange = $req->book && $req->book->listing_type === 'exchange';

            $scheduleTime = $req->proposed_time;
            $scheduleEndTime = $req->proposed_end_time;

            $scheduleLocation = $req->proposed_location ?? $req->book->meeting_location;
            $scheduleDate = $req->proposed_date ?? $req->book->meeting_date;
        @endphp


        <div class="request-list mb-3">

            <article
                class="request-card request-item"
                data-request-type="{{ $isExchange ? 'exchange' : 'sell' }}"
            >

                {{-- CARD HEADER --}}
                <header class="request-card-header">

                    <div>
                        <p class="book-kicker">
                            {{ $isExchange ? 'Exchange request for your book' : 'Sell request for your book' }}
                        </p>

                        <h2>{{ $req->book->title }}</h2>

                        <div class="mt-2 mb-2">
                            @if($isExchange)
                                <span class="badge text-bg-primary">Exchange</span>
                            @else
                                <span class="badge text-bg-secondary">Sell</span>
                            @endif
                        </div>

                        <p class="requester">
                            <i class="bi bi-person-circle" aria-hidden="true"></i>
                            Requested by <strong>{{ $req->requester->name }}</strong>
                        </p>
                    </div>

                    <span class="status-badge {{ $statusClass }}">
                        <i class="bi bi-circle-fill" style="font-size:.42rem" aria-hidden="true"></i>
                        {{ ucfirst($req->status) }}
                    </span>

                </header>


                <div class="request-card-body">


                    {{-- =====================================
                         EXCHANGE OFFERED BOOK
                    ====================================== --}}
                    @if($isExchange && $req->exchangeOffer)

                        <section class="schedule-box proposed mb-3">

                            <h3 class="schedule-title">
                                <i class="bi bi-arrow-left-right"></i>
                                Book offered in exchange
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


                    {{-- =====================================
                         EXCHANGE SCHEDULE DISPLAY
                    ====================================== --}}
                    @if($isExchange)

                        @if(in_array($req->status, ['pending', 'negotiation', 'approved']))

                            <section class="schedule-box {{ $req->status === 'approved' ? 'final' : 'proposed' }} mb-3">

                                <h3 class="schedule-title">

                                    @if($req->status === 'approved')
                                        <i class="bi bi-check-circle"></i>
                                        Final agreed schedule
                                    @else
                                        <i class="bi bi-calendar2-check"></i>

                                        @if($req->schedule_type === 'owner')
                                            Owner's proposed schedule
                                        @else
                                            Your proposed schedule
                                        @endif
                                    @endif

                                </h3>

                                <p class="schedule-detail">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>
                                        <strong>Location</strong><br>
                                        {{ $scheduleLocation ?? 'Not set' }}
                                    </span>
                                </p>

                                <p class="schedule-detail">
                                    <i class="bi bi-calendar3"></i>
                                    <span>
                                        <strong>Date</strong><br>
                                        {{ $scheduleDate ?? 'Not set' }}
                                    </span>
                                </p>

                                <p class="schedule-detail">
                                    <i class="bi bi-clock"></i>
                                    <span>
                                        <strong>Time</strong><br>

                                        @if($scheduleTime)
                                            {{ \Carbon\Carbon::parse($scheduleTime)->format('g:i A') }}

                                            @if($scheduleEndTime)
                                                – {{ \Carbon\Carbon::parse($scheduleEndTime)->format('g:i A') }}
                                            @endif
                                        @else
                                            Not set
                                        @endif
                                    </span>
                                </p>

                            </section>

                        @endif


                    {{-- =====================================
                         SELL SCHEDULE DISPLAY
                         KEEP EXISTING SELL BEHAVIOUR
                    ====================================== --}}
                    @else

                        <div class="schedule-grid">

                            <section class="schedule-box">

                                <h3 class="schedule-title">
                                    <i class="bi bi-calendar2-check" aria-hidden="true"></i>
                                    Seller’s proposed schedule
                                </h3>

                                <p class="schedule-detail">
                                    <i class="bi bi-geo-alt" aria-hidden="true"></i>
                                    <span>
                                        <strong>Location</strong><br>
                                        {{ $req->book->meeting_location }}
                                    </span>
                                </p>

                                <p class="schedule-detail">
                                    <i class="bi bi-calendar3" aria-hidden="true"></i>
                                    <span>
                                        <strong>Date</strong><br>
                                        {{ $req->book->meeting_date }}
                                    </span>
                                </p>

                                <p class="schedule-detail">
                                    <i class="bi bi-clock" aria-hidden="true"></i>
                                    <span>
                                        <strong>Time</strong><br>

                                        {{ $req->book->meeting_time ? \Carbon\Carbon::parse($req->book->meeting_time)->format('g:i A') : 'Not set' }}

                                        @if($req->book->meeting_end_time)
                                            – {{ \Carbon\Carbon::parse($req->book->meeting_end_time)->format('g:i A') }}
                                        @endif
                                    </span>
                                </p>

                            </section>


                            @if($req->status == 'negotiation')

                                <section class="schedule-box proposed">

                                    <h3 class="schedule-title">
                                        <i class="bi bi-arrow-left-right" aria-hidden="true"></i>
                                        Buyer’s proposed schedule
                                    </h3>

                                    <p class="schedule-detail">
                                        <i class="bi bi-geo-alt" aria-hidden="true"></i>
                                        <span>
                                            <strong>Location</strong><br>
                                            {{ $req->proposed_location }}
                                        </span>
                                    </p>

                                    <p class="schedule-detail">
                                        <i class="bi bi-calendar3" aria-hidden="true"></i>
                                        <span>
                                            <strong>Date</strong><br>
                                            {{ $req->proposed_date }}
                                        </span>
                                    </p>

                                    <p class="schedule-detail">
                                        <i class="bi bi-clock" aria-hidden="true"></i>
                                        <span>
                                            <strong>Time</strong><br>

                                            {{ $req->proposed_time ? \Carbon\Carbon::parse($req->proposed_time)->format('g:i A') : 'Not set' }}

                                            @if($req->proposed_end_time)
                                                – {{ \Carbon\Carbon::parse($req->proposed_end_time)->format('g:i A') }}
                                            @endif
                                        </span>
                                    </p>

                                </section>

                            @endif


                            @if($req->status == 'approved')

                                <section class="schedule-box final">

                                    <h3 class="schedule-title">
                                        <i class="bi bi-check-circle" aria-hidden="true"></i>
                                        Final agreed schedule
                                    </h3>

                                    <p class="schedule-detail">
                                        <i class="bi bi-geo-alt" aria-hidden="true"></i>
                                        <span>
                                            <strong>Location</strong><br>
                                            {{ $req->proposed_location ?? $req->book->meeting_location }}
                                        </span>
                                    </p>

                                    <p class="schedule-detail">
                                        <i class="bi bi-calendar3" aria-hidden="true"></i>
                                        <span>
                                            <strong>Date</strong><br>
                                            {{ $req->proposed_date ?? $req->book->meeting_date }}
                                        </span>
                                    </p>

                                    <p class="schedule-detail">
                                        <i class="bi bi-clock" aria-hidden="true"></i>
                                        <span>
                                            <strong>Time</strong><br>

                                            @if($req->proposed_time)
                                                {{ \Carbon\Carbon::parse($req->proposed_time)->format('g:i A') }}

                                                @if($req->proposed_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->proposed_end_time)->format('g:i A') }}
                                                @endif
                                            @else
                                                {{ $req->book->meeting_time ? \Carbon\Carbon::parse($req->book->meeting_time)->format('g:i A') : 'Not set' }}

                                                @if($req->book->meeting_end_time)
                                                    – {{ \Carbon\Carbon::parse($req->book->meeting_end_time)->format('g:i A') }}
                                                @endif
                                            @endif

                                        </span>
                                    </p>

                                </section>

                            @endif

                        </div>

                    @endif


                    {{-- =====================================
                         CANCELLED NOTICE
                    ====================================== --}}
                    @if($req->status == 'cancelled')

                        <div class="cancel-notice">
                            <i class="bi bi-info-circle me-1" aria-hidden="true"></i>
                            {{ $req->requester->name }} cancelled this
                            {{ $isExchange ? 'Exchange' : 'request' }}.
                        </div>

                    @endif


                    {{-- =====================================
                         EXCHANGE HANDOVER PROGRESS
                    ====================================== --}}
                    @if($isExchange && in_array($req->status, ['approved', 'completed']))

                        <div class="handover-progress">

                            <strong>
                                <i class="bi bi-box-seam"></i>
                                Physical book handover confirmation
                            </strong>

                            <p>
                                @if($req->owner_confirmed_handover)
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    You have confirmed receiving the offered book.
                                @else
                                    <i class="bi bi-hourglass-split"></i>
                                    You have not confirmed receiving the offered book.
                                @endif
                            </p>

                            <p>
                                @if($req->requester_confirmed_handover)
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    {{ $req->requester->name }} has confirmed receiving your book.
                                @else
                                    <i class="bi bi-hourglass-split"></i>
                                    Waiting for {{ $req->requester->name }} to confirm receiving your book.
                                @endif
                            </p>

                        </div>

                    @endif


                    {{-- =====================================
                         SELL ACTIONS
                         KEEP EXISTING SELL ROUTES
                    ====================================== --}}
                    @if(!$isExchange && in_array($req->status, ['pending', 'negotiation']))

                        <div class="request-actions">

                            <form method="POST" action="{{ route('request.approve', $req->id) }}">
                                @csrf

                                <button type="submit" class="btn approve-button">
                                    <i class="bi bi-check-lg me-1" aria-hidden="true"></i>
                                    Approve Request
                                </button>
                            </form>

                            <form method="POST" action="{{ route('request.reject', $req->id) }}">
                                @csrf

                                <button type="submit" class="btn reject-button">
                                    <i class="bi bi-x-lg me-1" aria-hidden="true"></i>
                                    Reject Request
                                </button>
                            </form>

                        </div>

                    @endif


                    {{-- =====================================
                         EXCHANGE ACTIONS
                    ====================================== --}}
                    @if($isExchange)


                        {{-- Student B: Pending Exchange request --}}
                        @if($req->status === 'pending')

                            <div class="request-actions">

                                <form method="POST" action="{{ route('exchange.accept', $req->id) }}">
                                    @csrf

                                    <button type="submit" class="btn approve-button">
                                        <i class="bi bi-check-lg me-1"></i>
                                        Accept Exchange
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('exchange.reject', $req->id) }}"
                                      onsubmit="return confirm('Are you sure you want to reject this Exchange request?');">
                                    @csrf

                                    <button type="submit" class="btn reject-button">
                                        <i class="bi bi-x-lg me-1"></i>
                                        Reject Exchange
                                    </button>
                                </form>

                            </div>


                            {{-- Student B can propose another schedule --}}
                            <details class="exchange-form">

                                <summary class="fw-bold" style="color:#102f53;cursor:pointer;">
                                    <i class="bi bi-calendar-plus me-1"></i>
                                    Accept but Propose Another Schedule
                                </summary>

                                <form method="POST"
                                      action="{{ route('exchange.counter-schedule', $req->id) }}"
                                      class="mt-3">

                                    @csrf

                                    <h4>Propose a meeting schedule</h4>

                                    <div class="mb-3">
                                        <label>Meeting location</label>
                                        <input
                                            type="text"
                                            name="proposed_location"
                                            class="form-control"
                                            value="{{ old('proposed_location', $req->book->meeting_location) }}"
                                            required
                                            maxlength="255"
                                            placeholder="Enter meeting location"
                                        >
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>Meeting date</label>
                                            <input
                                                type="date"
                                                name="proposed_date"
                                                class="form-control"
                                                min="{{ date('Y-m-d') }}"
                                                value="{{ old('proposed_date') }}"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Start time</label>
                                            <input
                                                type="time"
                                                name="proposed_time"
                                                class="form-control"
                                                value="{{ old('proposed_time') }}"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>End time</label>
                                            <input
                                                type="time"
                                                name="proposed_end_time"
                                                class="form-control"
                                                value="{{ old('proposed_end_time') }}"
                                                required
                                            >
                                        </div>

                                    </div>

                                    <button type="submit" class="btn approve-button">
                                        <i class="bi bi-calendar-check me-1"></i>
                                        Submit Proposed Schedule
                                    </button>

                                </form>

                            </details>

                        @endif


                        {{-- Student B: A has proposed another schedule --}}
                        @if($req->status === 'negotiation' && $req->schedule_type === 'requester')

                            <div class="request-actions">

                                <form method="POST" action="{{ route('exchange.accept', $req->id) }}">
                                    @csrf

                                    <button type="submit" class="btn approve-button">
                                        <i class="bi bi-check-lg me-1"></i>
                                        Accept Proposed Schedule
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('exchange.reject', $req->id) }}"
                                      onsubmit="return confirm('Are you sure you want to reject this Exchange request?');">
                                    @csrf

                                    <button type="submit" class="btn reject-button">
                                        <i class="bi bi-x-lg me-1"></i>
                                        Reject Exchange
                                    </button>
                                </form>

                            </div>


                            {{-- Student B can counter Student A's schedule --}}
                            <details class="exchange-form">

                                <summary class="fw-bold" style="color:#102f53;cursor:pointer;">
                                    <i class="bi bi-calendar-plus me-1"></i>
                                    Propose Another Schedule
                                </summary>

                                <form method="POST"
                                      action="{{ route('exchange.counter-schedule', $req->id) }}"
                                      class="mt-3">

                                    @csrf

                                    <h4>Propose a different meeting schedule</h4>

                                    <div class="mb-3">
                                        <label>Meeting location</label>
                                        <input
                                            type="text"
                                            name="proposed_location"
                                            class="form-control"
                                            value="{{ old('proposed_location', $req->proposed_location) }}"
                                            required
                                            maxlength="255"
                                        >
                                    </div>

                                    <div class="row">

                                        <div class="col-md-4 mb-3">
                                            <label>Meeting date</label>
                                            <input
                                                type="date"
                                                name="proposed_date"
                                                class="form-control"
                                                min="{{ date('Y-m-d') }}"
                                                value="{{ old('proposed_date') }}"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Start time</label>
                                            <input
                                                type="time"
                                                name="proposed_time"
                                                class="form-control"
                                                required
                                            >
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>End time</label>
                                            <input
                                                type="time"
                                                name="proposed_end_time"
                                                class="form-control"
                                                required
                                            >
                                        </div>

                                    </div>

                                    <button type="submit" class="btn approve-button">
                                        Submit Another Schedule
                                    </button>

                                </form>

                            </details>

                        @endif


                        {{-- Student B: Owner proposed the latest schedule.
                             Wait for Student A to respond. --}}
                        @if($req->status === 'negotiation' && $req->schedule_type === 'owner')

                            <div class="cancel-notice">
                                <i class="bi bi-hourglass-split me-1"></i>
                                Your proposed schedule is waiting for
                                {{ $req->requester->name }} to respond.
                            </div>

                        @endif


                        {{-- Student B: Confirm physical handover --}}
                        @if($req->status === 'approved' && !$req->owner_confirmed_handover)

                            <div class="request-actions">

                                <form method="POST"
                                      action="{{ route('exchange.confirm-handover', $req->id) }}"
                                      onsubmit="return confirm('Confirm that you have physically received the offered book?');">

                                    @csrf

                                    <button type="submit" class="btn approve-button">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Confirm Handover
                                    </button>

                                </form>

                            </div>

                        @elseif($req->status === 'approved' && $req->owner_confirmed_handover)

                            <div class="cancel-notice">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                You have confirmed the handover. Waiting for the other student.
                            </div>

                        @endif


                        @if($req->status === 'completed')

                            <div class="cancel-notice" style="border-color:#c5e6d2;color:#23744a;background:#f0f9f3;">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                This Exchange has been completed. Both students confirmed the handover.
                            </div>

                        @endif

                    @endif

                </div>

            </article>

        </div>

    @empty

        <section class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-inbox" aria-hidden="true"></i>
            </div>

            <h2>No requests yet</h2>

            <p>
                When another student requests one of your books,
                the request will appear here.
            </p>
        </section>

    @endforelse

</main>


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

                if (matches) {
                    visibleCount++;
                }

            });

            emptyMessage.classList.toggle('d-none', visibleCount > 0);

        });

    });

});
</script>

</body>
</html>
