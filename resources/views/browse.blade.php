<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Browse books | UniKL BookHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --navy:#102f53; --navy-dark:#0b2542; --navy-mid:#245586; --ink:#14263d; --muted:#63758a; --line:#dce5ef; --page:#f4f7fb; --blue-soft:#dceafb; }
        body { background:var(--page); color:var(--ink); font-family:'Instrument Sans',Arial,sans-serif; }
        .catalogue-header { position:sticky; top:0; z-index:5; background:rgba(13,42,74,.96); border-bottom:1px solid #ffffff1a; box-shadow:0 6px 24px #0b25421c; backdrop-filter:blur(12px); }
        .catalogue-header .brand-name { color:#fff!important; font-weight:800!important; letter-spacing:-.02em; }
        .catalogue-header .brand-name i { color:#b8d5f5!important; }
        .catalogue-header .btn-outline-danger { color:#fff; border-color:#ffffff70; }
        .catalogue-header .btn-outline-danger:hover { color:var(--navy); border-color:#fff; background:#fff; }
        .catalogue-header .btn-outline-secondary { color:#fff; border-color:#ffffff70; }
        .catalogue-header .btn-outline-secondary:hover { color:var(--navy); border-color:#fff; background:#fff; }
        .catalogue-main { max-width:1600px; }
        .catalogue-panel,.book-card { background:#fff; border:1px solid var(--line); border-radius:16px; box-shadow:0 10px 30px #173f6b08; }
        .catalogue-panel { padding:1.35rem; }
        .page-kicker { color:var(--navy-mid); font-size:11px; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .page-title { color:var(--navy); font-size:clamp(1.7rem,3vw,2.15rem); font-weight:800; letter-spacing:-.045em; margin:.25rem 0; }
        .page-subtitle { color:var(--muted); margin:0; }
        .book-card { overflow:hidden; height:100%; transition:transform .2s ease,border-color .2s ease,box-shadow .2s ease; }
        .book-card:hover { transform:translateY(-4px); border-color:#b7cbe0; box-shadow:0 18px 38px #173f6b18; }
        .book-cover { width:100%; height:180px; object-fit:cover; background:#edf3f9; }
        .book-card-body { display:flex; flex-direction:column; padding:.85rem; }
        .book-title { min-height:2.65em; color:var(--navy); font-size:.92rem; font-weight:700; line-height:1.35; margin:0 0 .3rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
        .book-meta { color:#64778c; font-size:.77rem; line-height:1.4; margin-bottom:.38rem; overflow-wrap:anywhere; }
        .badge-soft { display:inline-flex; align-items:center; gap:.35rem; padding:.34rem .62rem; border-radius:8px; font-size:.73rem; font-weight:700; white-space:nowrap; }
        .badge-available { background:#e4f4eb; color:#23744a; }
        .badge-reserved { background:#fff2d7; color:#8a5a12; }
        .badge-sold { background:#fde8e9; color:#aa3038; }
        .badge-neutral { background:#eaf1f9; color:var(--navy-mid); }
        .btn { border-radius:9px; font-weight:700; }
        .btn-primary { color:#fff; background:var(--navy); border-color:var(--navy); }
        .btn-primary:hover,.btn-primary:focus { color:#fff; background:var(--navy-dark); border-color:var(--navy-dark); }
        .btn-outline-primary { color:var(--navy); border-color:var(--navy); }
        .btn-outline-primary:hover { color:#fff; background:var(--navy); border-color:var(--navy); }
        .text-primary { color:var(--navy-mid)!important; }
        .input-group-text { color:var(--navy-mid); border-color:#d5dfeb; border-radius:10px 0 0 10px; }
        .form-control,.form-select { min-height:43px; border-color:#d5dfeb; border-radius:9px; color:var(--ink); box-shadow:none; }
        .input-group .form-control { border-radius:0 9px 9px 0; }
        .form-control:focus,.form-select:focus { border-color:#6e9bc9; box-shadow:0 0 0 3px #dceafb; }
        .btn-outline-secondary { color:#526b86; border-color:#c9d5e2; }
        .btn-outline-secondary:hover { color:var(--navy); border-color:#a9bed4; background:#eaf1f9; }
        .discovery-layout { display:grid; grid-template-columns:250px minmax(0,1fr); align-items:start; gap:22px; }
        .filter-panel { position:sticky; top:92px; padding:1.15rem; }
        .filter-heading { display:flex; align-items:center; gap:9px; margin-bottom:1rem; color:var(--navy); font-size:1.05rem; font-weight:800; }
        .filter-heading i { color:var(--navy-mid); }
        .filter-panel .form-label { margin-bottom:.35rem; color:#36506c; font-size:.78rem; font-weight:700; }
        .filter-panel .form-control,.filter-panel .form-select { min-height:40px; font-size:.83rem; }
        .filter-actions { display:grid; grid-template-columns:minmax(0,1fr) 42px; gap:8px; margin-top:1.1rem; }
        .results-heading { display:flex; justify-content:space-between; align-items:center; gap:12px; margin:.2rem 0 1rem; }
        .results-heading h2 { margin:0; color:var(--navy); font-size:1.15rem; font-weight:800; }
        .book-grid { display:grid; grid-template-columns:repeat(5,minmax(0,1fr)); gap:14px; }
        .book-grid > * { min-width:0; }
        .card-status-row { display:flex; justify-content:space-between; align-items:flex-start; gap:6px; margin-bottom:.45rem; }
        .card-status-row .badge-soft { padding:.28rem .45rem; font-size:.66rem; }
        .book-price { margin-top:auto; padding-top:.4rem; color:var(--navy); font-size:.88rem; font-weight:800; }
        .book-actions { display:flex; gap:6px; margin-top:.7rem; }
        .book-actions .btn { min-height:34px; padding:.35rem .45rem; font-size:.72rem; }
        .book-actions form { flex:0 0 auto; }
        .book-actions form .btn { width:35px; }
        .empty-state { grid-column:1/-1; border:1px dashed #b9cadd; border-radius:16px; background:#fff; padding:3.5rem 1rem; color:var(--muted); text-align:center; }
        .empty-state h3 { color:var(--navy)!important; }
        @media(max-width:1399.98px) { .book-grid { grid-template-columns:repeat(4,minmax(0,1fr)); } }
        @media(max-width:1199.98px) { .discovery-layout { grid-template-columns:230px minmax(0,1fr); gap:16px; } .book-grid { grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px; } }
        @media(max-width:767.98px) { .discovery-layout { grid-template-columns:1fr; } .filter-panel { position:static; } .filter-fields { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:0 12px; } .filter-field-search,.filter-field-category { grid-column:1/-1; } .book-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media(max-width:575.98px) { .catalogue-header .brand-name { font-size:.98rem; } .book-cover { height:170px; } .catalogue-panel { padding:1rem; } .book-grid { gap:10px; } .book-card-body { padding:.7rem; } .book-title { font-size:.85rem; } .book-meta { font-size:.72rem; } .card-status-row .badge-soft { font-size:.6rem; } .results-heading { align-items:flex-start; flex-direction:column; } }
        @media(max-width:380px) { .book-grid { grid-template-columns:1fr; } .book-cover { height:220px; } }
    </style>
</head>
<body>
<header class="catalogue-header d-flex justify-content-between align-items-center px-3 px-md-4 py-3">
    <a href="{{ url('/') }}" class="brand-name text-decoration-none fw-bold">
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
        </div>
    </section>

    <div class="discovery-layout">
        <aside>
            <form method="GET" action="{{ route('homepage') }}" class="catalogue-panel filter-panel">
                <div class="filter-heading"><i class="bi bi-sliders" aria-hidden="true"></i> Filter books</div>
                <div class="filter-fields">
                    <div class="mb-3 filter-field-search">
                        <label for="search" class="form-label">Search by title</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input id="search" type="text" name="search" class="form-control" placeholder="Book title" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject ID</label>
                        <input id="subject_id" type="text" name="subject_id" class="form-control" placeholder="e.g. CSC301" value="{{ request('subject_id') }}">
                    </div>
                    <div class="mb-3 filter-field-category">
                        <label for="subject_category" class="form-label">Subject category</label>
                        <select id="subject_category" name="subject_category" class="form-select">
                            <option value="">All categories</option>
                            @foreach(\App\Models\Book::SUBJECT_CATEGORIES as $category)
                                <option value="{{ $category }}" {{ request('subject_category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1">
                        <label for="condition" class="form-label">Condition</label>
                        <select id="condition" name="condition" class="form-select">
                            <option value="">All conditions</option>
                            @foreach(['New', 'Like New', 'Used'] as $condition)
                                <option value="{{ $condition }}" {{ request('condition') === $condition ? 'selected' : '' }}>{{ $condition }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search me-1"></i>Apply filters</button>
                    <a href="{{ route('homepage') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" aria-label="Reset filters" title="Reset filters"><i class="bi bi-arrow-counterclockwise"></i></a>
                </div>
            </form>
        </aside>

        <section class="catalogue-results" aria-labelledby="all-books-heading">
            <div class="results-heading">
                <h2 id="all-books-heading">All books</h2>
                <span class="badge-soft badge-neutral"><i class="bi bi-collection"></i>{{ $books->count() }} {{ \Illuminate\Support\Str::plural('book', $books->count()) }}</span>
            </div>
            <div class="book-grid">
        @forelse($books as $book)
            <div>
                <article class="book-card">
                    <img src="{{ asset('storage/' . $book->image) }}" class="book-cover" alt="Cover of {{ $book->title }}">
                    <div class="book-card-body">
                        <div class="card-status-row">
                            @php($statusClass = ['available' => 'badge-available', 'reserved' => 'badge-reserved', 'sold' => 'badge-sold'][$book->status] ?? 'badge-neutral')
                            <span class="badge-soft {{ $statusClass }}">{{ ucfirst($book->status) }}</span>
                        </div>
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <div class="book-meta"><i class="bi bi-bookmark me-1"></i>{{ $book->condition }} <span class="mx-1">·</span> Subject {{ $book->subject_id }}</div>
                        <div class="book-meta"><i class="bi bi-tag me-1"></i>{{ $book->subject_category ?? 'Category not set' }}</div>
                        @if($book->meeting_location)
                            <div class="book-meta"><i class="bi bi-geo-alt me-1"></i>{{ $book->meeting_location }}</div>
                        @endif
                        <div class="book-price">{{ $book->price ? 'RM ' . number_format($book->price, 2) : 'Free / Not set' }}</div>
                        <div class="book-actions">
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
            <div class="empty-state">
                <div class="fs-2 text-primary mb-2"><i class="bi bi-search"></i></div>
                <h3 class="h6 fw-semibold text-dark">No books found</h3>
                <p class="mb-3">Try another title, subject ID, category, or condition.</p>
                <a href="{{ route('homepage') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i>Clear filters</a>
            </div>
        @endforelse
            </div>
        </section>
    </div>
</main>
</body>
</html>
