<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Catalogue | UniKLBook Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --ink:#1f2937; --muted:#9ca3af; --line:#e5e7eb; --page:#f3f4f6; --blue:#1d4ed8; --blue-soft:#dbeafe; }
        body { background:var(--page); color:var(--ink); font-family:Arial,sans-serif; }
        .catalogue-header { background:#fff; border-bottom:1px solid var(--line); }
        .catalogue-main { max-width:1120px; }
        .catalogue-panel,.book-card { background:#fff; border:1px solid var(--line); border-radius:12px; }
        .catalogue-panel { padding:1.25rem; }
        .page-kicker { color:var(--muted); font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
        .page-title { color:var(--ink); font-size:1.6rem; font-weight:700; margin:.3rem 0; }
        .page-subtitle { color:#6b7280; margin:0; }
        .book-card { overflow:hidden; height:100%; transition:transform .15s ease,border-color .15s ease,box-shadow .15s ease; }
        .book-card:hover { transform:translateY(-2px); border-color:#d1d5db; box-shadow:0 8px 20px rgba(31,41,55,.07); }
        .book-cover { width:100%; height:220px; object-fit:cover; background:#f9fafb; }
        .book-card-body { padding:1rem; }
        .book-title { font-size:1rem; font-weight:600; margin:0 0 .45rem; }
        .book-meta { color:#6b7280; font-size:.875rem; margin-bottom:.45rem; }
        .badge-soft { display:inline-flex; align-items:center; gap:.35rem; padding:.3rem .6rem; border-radius:8px; font-size:.75rem; font-weight:600; }
        .badge-available { background:#dcfce7; color:#15803d; }
        .badge-reserved { background:#fef3c7; color:#92400e; }
        .badge-sold { background:#fee2e2; color:#b91c1c; }
        .badge-neutral { background:#f3f4f6; color:#4b5563; }
        .btn { border-radius:8px; font-weight:600; }
        .btn-primary { background:var(--blue); border-color:var(--blue); }
        .btn-primary:hover,.btn-primary:focus { background:#1e40af; border-color:#1e40af; }
        .btn-outline-primary { color:var(--blue); border-color:var(--blue); }
        .btn-outline-primary:hover { background:var(--blue); border-color:var(--blue); }
        .text-primary { color:var(--blue)!important; }
        .input-group-text { border-color:#d1d5db; }
        .btn-outline-secondary { color:#4b5563; border-color:#d1d5db; }
        .empty-state { border:1px dashed #d1d5db; border-radius:12px; background:#fff; padding:3rem 1rem; color:#6b7280; text-align:center; }
        @media(max-width:575.98px) { .catalogue-header .brand-name { font-size:1rem; } .book-cover { height:190px; } }
    </style>
</head>
<body>
<header class="catalogue-header d-flex justify-content-between align-items-center px-3 px-md-4 py-3">
    <a href="{{ route('homepage') }}" class="brand-name text-decoration-none text-dark fw-bold">
        <i class="bi bi-book-half text-primary me-2"></i>UniKLBook Hub
    </a>
    <div class="d-flex align-items-center gap-2">
        @auth
            <a href="{{ route('book.saved') }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-heart me-sm-1"></i><span class="d-none d-sm-inline">Saved books</span></a>
        @endauth
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:40px;height:40px" aria-label="Go to dashboard">
            <i class="bi bi-person"></i>
        </a>
    </div>
</header>

<main class="container catalogue-main py-4 py-md-5">
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
    @endif

    <section class="catalogue-panel mb-4">
        <div class="page-kicker">Book discovery</div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3">
            <div>
                <h1 class="page-title">Browse books</h1>
                <p class="page-subtitle">Search the catalogue and find your next book.</p>
            </div>
            <span class="badge-soft badge-neutral"><i class="bi bi-collection"></i>{{ $books->count() }} {{ \Illuminate\Support\Str::plural('book', $books->count()) }}</span>
        </div>
    </section>

    <form method="GET" action="{{ route('homepage') }}" class="catalogue-panel mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
                <label for="search" class="form-label small fw-semibold">Search by title</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input id="search" type="text" name="search" class="form-control" placeholder="e.g. Introduction to Programming" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-12 col-md-3">
                <label for="subject_id" class="form-label small fw-semibold">Subject ID</label>
                <input id="subject_id" type="text" name="subject_id" class="form-control" placeholder="Enter subject ID" value="{{ request('subject_id') }}">
            </div>
            <div class="col-12 col-md-3">
                <label for="condition" class="form-label small fw-semibold">Condition</label>
                <select id="condition" name="condition" class="form-select">
                    <option value="">All conditions</option>
                    @foreach(['New', 'Like New', 'Used'] as $condition)
                        <option value="{{ $condition }}" {{ request('condition') === $condition ? 'selected' : '' }}>{{ $condition }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1"><i class="bi bi-search me-1"></i>Search</button>
                <a href="{{ route('homepage') }}" class="btn btn-outline-secondary" aria-label="Reset filters" title="Reset filters"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </div>
    </form>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 fw-semibold mb-0">All books</h2>
        <span class="small text-secondary">Newest listings first</span>
    </div>

    <div class="row g-3">
        @forelse($books as $book)
            <div class="col-12 col-sm-6 col-lg-4">
                <article class="book-card">
                    <img src="{{ asset('storage/' . $book->image) }}" class="book-cover" alt="Cover of {{ $book->title }}">
                    <div class="book-card-body">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h3 class="book-title">{{ $book->title }}</h3>
                            @php($statusClass = ['available' => 'badge-available', 'reserved' => 'badge-reserved', 'sold' => 'badge-sold'][$book->status] ?? 'badge-neutral')
                            <span class="badge-soft {{ $statusClass }}">{{ ucfirst($book->status) }}</span>
                        </div>
                        <div class="book-meta"><i class="bi bi-bookmark me-1"></i>{{ $book->condition }} <span class="mx-1">·</span> Subject {{ $book->subject_id }}</div>
                        @if($book->meeting_location)
                            <div class="book-meta"><i class="bi bi-geo-alt me-1"></i>{{ $book->meeting_location }}</div>
                        @endif
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fw-semibold text-dark">{{ $book->price ? 'RM ' . number_format($book->price, 2) : 'Free / Not set' }}</span>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ url('/book/' . $book->id) }}" class="btn btn-primary btn-sm flex-grow-1"><i class="bi bi-eye me-1"></i>View details</a>
                            @if(auth()->check() && $book->user_id != auth()->id())
                                <form method="POST" action="{{ route('book.save', $book->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-secondary btn-sm" title="Save for later" aria-label="Save {{ $book->title }} for later"><i class="bi bi-heart"></i></button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="fs-2 text-primary mb-2"><i class="bi bi-search"></i></div>
                    <h3 class="h6 fw-semibold text-dark">No books found</h3>
                    <p class="mb-3">Try another title, subject ID, or condition.</p>
                    <a href="{{ route('homepage') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i>Clear filters</a>
                </div>
            </div>
        @endforelse
    </div>
</main>
</body>
</html>
