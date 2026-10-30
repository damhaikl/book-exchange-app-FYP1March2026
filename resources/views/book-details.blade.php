<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $book->title }} | UniKLBook Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --ink:#1f2937; --muted:#9ca3af; --line:#e5e7eb; --page:#f3f4f6; --blue:#1d4ed8; }
        body { background:var(--page); color:var(--ink); font-family:Arial,sans-serif; }
        .details-main { max-width:1050px; }
        .details-panel,.info-card,.seller-card { background:#fff; border:1px solid var(--line); border-radius:12px; }
        .details-panel { padding:1rem; }
        .book-cover { width:100%; max-height:440px; min-height:280px; object-fit:cover; border-radius:10px; background:#f9fafb; }
        .page-kicker { color:var(--muted); font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
        .book-title { color:var(--ink); font-size:clamp(1.5rem,3vw,2rem); font-weight:700; line-height:1.2; }
        .book-description { color:#4b5563; line-height:1.7; white-space:pre-line; }
        .price-tag { color:var(--blue); font-size:1.35rem; font-weight:700; }
        .badge-soft { display:inline-flex; align-items:center; gap:.35rem; padding:.35rem .65rem; border-radius:8px; font-size:.75rem; font-weight:600; }
        .badge-available { background:#dcfce7; color:#15803d; }
        .badge-reserved { background:#fef3c7; color:#92400e; }
        .badge-sold { background:#fee2e2; color:#b91c1c; }
        .badge-neutral { background:#f3f4f6; color:#4b5563; }
        .info-card,.seller-card { padding:1rem; }
        .info-label { color:#6b7280; font-size:.8rem; margin-bottom:.15rem; }
        .info-value { font-weight:600; margin:0; }
        .btn { border-radius:8px; font-weight:600; }
        .btn-primary { background:var(--blue); border-color:var(--blue); }
        .btn-primary:hover,.btn-primary:focus { background:#1e40af; border-color:#1e40af; }
        .btn-outline-primary { color:var(--blue); border-color:var(--blue); }
        .btn-outline-primary:hover { background:var(--blue); border-color:var(--blue); }
        .text-primary { color:var(--blue)!important; }
        .back-link { color:var(--blue); font-weight:600; text-decoration:none; }
        .back-link:hover { color:#1e40af; }
        .review-item { border-bottom:1px solid #f3f4f6; padding:.75rem 0; }
        .review-item:last-child { border-bottom:0; padding-bottom:0; }
        .details-header { background:#fff; border-bottom:1px solid var(--line); }
        .details-header a { color:var(--ink); }
        .details-header .btn-outline-secondary { color:#4b5563; border-color:#d1d5db; }
        .popup { display:none; position:fixed; inset:0; z-index:1100; align-items:center; justify-content:center; padding:1rem; background:rgba(17,24,39,.55); }
        .popup-content { width:min(440px,100%); background:#fff; padding:1.5rem; border:1px solid var(--line); border-radius:12px; box-shadow:0 16px 40px rgba(17,24,39,.18); }
        .popup-content input,.popup-content textarea { width:100%; padding:.65rem .75rem; margin-top:.5rem; border:1px solid #d1d5db; border-radius:8px; }
        @media(max-width:767.98px) { .book-cover { min-height:220px; max-height:340px; } }
    </style>
</head>
<body>
<header class="details-header">
    <div class="container details-main d-flex justify-content-between align-items-center py-3">
        <a href="{{ route('homepage') }}" class="text-decoration-none text-dark fw-bold"><i class="bi bi-book-half text-primary me-2"></i>UniKLBook Hub</a>
        <div class="d-flex gap-2">
            @auth
                <a href="{{ route('book.saved') }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-heart me-sm-1"></i><span class="d-none d-sm-inline">Saved books</span></a>
            @endauth
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-person me-sm-1"></i><span class="d-none d-sm-inline">Dashboard</span></a>
        </div>
    </div>
</header>

<main class="container details-main py-4 py-md-5">
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
    @endif

    <a href="{{ route('homepage') }}" class="back-link d-inline-block mb-3"><i class="bi bi-arrow-left me-1"></i>Back to catalogue</a>

    <section class="details-panel mb-3">
        <div class="row g-4 align-items-start">
            <div class="col-12 col-md-5">
                <img src="{{ asset('storage/' . $book->image) }}" class="book-cover" alt="Cover of {{ $book->title }}">
            </div>
            <div class="col-12 col-md-7">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @php($statusClass = ['available' => 'badge-available', 'reserved' => 'badge-reserved', 'sold' => 'badge-sold'][$book->status] ?? 'badge-neutral')
                    <span class="badge-soft {{ $statusClass }}"><i class="bi bi-circle-fill" style="font-size:7px"></i>{{ ucfirst($book->status) }}</span>
                    <span class="badge-soft badge-neutral"><i class="bi bi-bookmark"></i>{{ $book->condition }}</span>
                    <span class="badge-soft badge-neutral"><i class="bi bi-journal-text"></i>Subject {{ $book->subject_id }}</span>
                </div>
                <div class="page-kicker mb-2">Book details</div>
                <h1 class="book-title mb-3">{{ $book->title }}</h1>
                <p class="book-description">{{ $book->description }}</p>
                <p class="price-tag mb-4"><i class="bi bi-tag me-1"></i>{{ $book->price ? 'RM ' . number_format($book->price, 2) : 'Free / Not set' }}</p>

                <div class="d-flex flex-wrap gap-2 align-items-center">
                    @if($book->user_id != auth()->id())
                        <form method="POST" action="{{ route('book.save', $book->id) }}" onsubmit="handleSubmit(event, 'Saved for later', 'Book added to your saved books.')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger"><i class="bi bi-heart me-1"></i>Save for later</button>
                        </form>
                    @endif

                    @if($book->user_id == auth()->id())
                        <span class="badge-soft badge-neutral"><i class="bi bi-person-check"></i>Your listing</span>
                    @elseif($book->status == 'available')
                        @if($existingRequest)
                            @if($existingRequest->status === 'negotiation')
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#existingProposalModal"><i class="bi bi-arrow-left-right me-1"></i>Manage schedule proposal</button>
                            @else
                                <button type="button" class="btn btn-outline-secondary" disabled><i class="bi bi-check2 me-1"></i>Request already sent</button>
                            @endif
                        @else
                            <form method="POST" action="{{ route('book.request', $book->id) }}" onsubmit="handleSubmit(event, 'Request sent', 'Your request has been sent to the seller.')">
                                @csrf
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Request this book?')"><i class="bi bi-handshake me-1"></i>Request book</button>
                            </form>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#proposeModal"><i class="bi bi-calendar2-plus me-1"></i>Propose a time</button>
                        @endif
                    @else
                        <span class="badge-soft badge-sold"><i class="bi bi-slash-circle"></i>Not available</span>
                    @endif

                    @if(auth()->id() == $book->user_id)
                        <a href="{{ route('book.schedule.edit', $book->id) }}" class="btn btn-outline-primary"><i class="bi bi-calendar2-week me-1"></i>Edit availability</a>
                    @endif
                    @if($book->user_id != auth()->id())
                        <button type="button" class="btn btn-outline-secondary" onclick="openReportPopup()"><i class="bi bi-flag me-1"></i>Report book</button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="row g-3">
        <div class="col-12 col-lg-7">
            <section class="info-card h-100">
                <div class="page-kicker mb-3">Meeting information</div>
                <h2 class="h6 fw-semibold mb-3"><i class="bi bi-geo-alt text-primary me-2"></i>Seller’s proposed schedule</h2>
                <div class="row g-3">
                    <div class="col-sm-6"><div class="info-label">Location</div><p class="info-value">{{ $book->meeting_location ?? 'Not set yet' }}</p></div>
                    <div class="col-sm-6"><div class="info-label">Date</div><p class="info-value">{{ $book->meeting_date ? \Carbon\Carbon::parse($book->meeting_date)->format('M j, Y') : 'Not set yet' }}</p></div>
                    <div class="col-sm-6"><div class="info-label">Time</div><p class="info-value">{{ $book->meeting_time ? \Carbon\Carbon::parse($book->meeting_time)->format('g:i A') : 'Not set yet' }}@if($book->meeting_end_time) – {{ \Carbon\Carbon::parse($book->meeting_end_time)->format('g:i A') }}@endif</p></div>
                </div>
            </section>
        </div>
        <div class="col-12 col-lg-5">
            <section class="seller-card h-100">
                <div class="page-kicker mb-3">Seller</div>
                <h2 class="h6 fw-semibold"><i class="bi bi-person-circle text-primary me-2"></i>{{ $book->user->name }}</h2>
                <p class="text-secondary small mb-3"><i class="bi bi-star-fill text-warning me-1"></i>{{ number_format($sellerRating ?? 0, 1) }} / 5 average rating</p>
                <hr class="text-secondary opacity-25">
                <h3 class="small fw-semibold mb-2">Latest reviews</h3>
                @if($sellerReviews->count() > 0)
                    @foreach($sellerReviews as $review)
                        <div class="review-item">
                            <div class="small fw-semibold"><i class="bi bi-star-fill text-warning me-1"></i>{{ $review->rating }} / 5</div>
                            <p class="small text-secondary mb-0 mt-1">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="small text-secondary mb-0">No reviews yet.</p>
                @endif
            </section>
        </div>
    </div>
</main>

<div id="popup" class="popup" role="status" aria-live="polite">
    <div class="popup-content text-center">
        <div class="fs-2 text-success mb-2"><i class="bi bi-check-circle"></i></div>
        <h2 id="popupTitle" class="h5 fw-semibold"></h2>
        <p id="popupText" class="text-secondary"></p>
        <button type="button" class="btn btn-primary px-4" onclick="closePopup()">Continue</button>
    </div>
</div>

<div id="reportPopup" class="popup">
    <div class="popup-content">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 fw-semibold mb-0"><i class="bi bi-flag text-danger me-2"></i>Report book</h2>
            <button type="button" class="btn-close" onclick="closeReportPopup()" aria-label="Close"></button>
        </div>
        <form method="POST" action="{{ route('report.store', $book->id) }}">
            @csrf
            <label class="form-label small fw-semibold" for="report-reason">Reason</label>
            <input id="report-reason" type="text" name="reason" class="form-control mb-3" placeholder="Why are you reporting this listing?" required>
            <label class="form-label small fw-semibold" for="report-description">Details</label>
            <textarea id="report-description" name="description" class="form-control" rows="4" placeholder="Describe the issue" required></textarea>
            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" class="btn btn-outline-secondary" onclick="closeReportPopup()">Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="bi bi-send me-1"></i>Submit report</button>
            </div>
        </form>
    </div>
</div>

@if($existingRequest && $existingRequest->status === 'negotiation')
<div class="modal fade" id="existingProposalModal" tabindex="-1" aria-labelledby="existingProposalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow">
            <div class="modal-header"><h2 class="modal-title h5" id="existingProposalTitle">Schedule proposal already sent</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body"><p>You already proposed a new meeting schedule. Would you like to change it?</p><p class="mb-0 text-secondary">Deleting the proposal keeps your book request active and returns it to the seller’s original meeting schedule.</p></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="{{ route('book.proposeSchedule.delete', $book->id) }}">@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger">Delete proposal</button></form>
                <a href="{{ route('book.proposeScheduleForm', $book->id) }}" class="btn btn-primary">Edit proposal</a>
            </div>
        </div>
    </div>
</div>
@endif

<div class="modal fade" id="proposeModal" tabindex="-1" aria-labelledby="proposeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow">
            <div class="modal-header"><h2 class="modal-title h5" id="proposeModalTitle">Propose a new schedule</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body">By proposing a new schedule, you agree to request this book. Continue?</div>
            <div class="modal-footer"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button><a href="{{ route('book.proposeScheduleForm', $book->id) }}" class="btn btn-primary">Continue</a></div>
        </div>
    </div>
</div>

<script>
function showPopup(title, message) {
    document.getElementById('popupTitle').innerText = title;
    document.getElementById('popupText').innerText = message;
    document.getElementById('popup').style.display = 'flex';
}
function closePopup() { document.getElementById('popup').style.display = 'none'; }
function handleSubmit(event, title, message) {
    event.preventDefault();
    showPopup(title, message);
    setTimeout(() => event.target.submit(), 800);
}
function openReportPopup() { document.getElementById('reportPopup').style.display = 'flex'; }
function closeReportPopup() { document.getElementById('reportPopup').style.display = 'none'; }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
