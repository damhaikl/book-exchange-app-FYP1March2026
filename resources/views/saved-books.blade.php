<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Saved Books | UniKLBook Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --ink:#1f2937; --muted:#9ca3af; --line:#e5e7eb; --page:#f3f4f6; --blue:#1d4ed8; }
        body { background:var(--page); color:var(--ink); font-family:Arial,sans-serif; }
        .saved-main { max-width:1050px; }
        .saved-header,.saved-card { background:#fff; border:1px solid var(--line); border-radius:12px; }
        .saved-header { padding:1.25rem; }
        .saved-card { height:100%; overflow:hidden; transition:transform .15s ease,border-color .15s ease,box-shadow .15s ease; }
        .saved-card:hover { transform:translateY(-2px); border-color:#d1d5db; box-shadow:0 8px 20px rgba(31,41,55,.07); }
        .saved-cover { height:210px; width:100%; object-fit:cover; background:#f9fafb; }
        .saved-card-body { padding:1rem; }
        .saved-title { font-size:1rem; font-weight:600; margin:0 0 .5rem; }
        .saved-description { color:#6b7280; font-size:.875rem; min-height:3.75rem; margin-bottom:.75rem; }
        .page-kicker { color:var(--muted); font-size:11px; font-weight:700; letter-spacing:.08em; text-transform:uppercase; }
        .btn { border-radius:8px; font-weight:600; }
        .btn-primary { background:var(--blue); border-color:var(--blue); }
        .btn-primary:hover,.btn-primary:focus { background:#1e40af; border-color:#1e40af; }
        .btn-outline-primary { color:var(--blue); border-color:var(--blue); }
        .btn-outline-primary:hover { background:var(--blue); border-color:var(--blue); }
        .text-primary { color:var(--blue)!important; }
        .empty-state { border:1px dashed #d1d5db; border-radius:12px; background:#fff; padding:3rem 1rem; color:#6b7280; text-align:center; }
    </style>
</head>
<body>
<main class="container saved-main py-4 py-md-5">
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
    @endif

    <section class="saved-header mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-2">
            <div>
                <div class="page-kicker">Your collection</div>
                <h1 class="h4 fw-bold mb-1"><i class="bi bi-heart-fill text-danger me-2"></i>Saved books</h1>
                <p class="text-secondary mb-0">Books you’ve saved to come back to later.</p>
            </div>
            <span class="badge rounded-3 text-bg-light border text-secondary px-3 py-2">{{ $saved->count() }} saved</span>
        </div>
    </section>

    <div class="row g-3">
        @forelse($saved as $item)
            @if($item->book)
                <div class="col-12 col-sm-6 col-lg-4">
                    <article class="saved-card">
                        <img src="{{ asset('storage/' . $item->book->image) }}" class="saved-cover" alt="Cover of {{ $item->book->title }}">
                        <div class="saved-card-body">
                            <h2 class="saved-title">{{ $item->book->title }}</h2>
                            <p class="saved-description">{{ \Illuminate\Support\Str::limit($item->book->description, 150) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="small text-secondary"><i class="bi bi-bookmark me-1"></i>{{ $item->book->condition }}</span>
                                <span class="fw-semibold">{{ $item->book->price ? 'RM ' . number_format($item->book->price, 2) : 'Free / Not set' }}</span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ url('/book/' . $item->book->id) }}" class="btn btn-primary btn-sm flex-grow-1"><i class="bi bi-eye me-1"></i>View details</a>
                                <form method="POST" action="{{ route('book.unsave', $item->book->id) }}" onsubmit="return confirm('Remove this book from your saved list?')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-heartbreak me-1"></i>Unsave</button>
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
            @endif
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <div class="fs-2 text-danger mb-2"><i class="bi bi-heart"></i></div>
                    <h2 class="h6 fw-semibold text-dark">No saved books yet</h2>
                    <p class="mb-3">Browse the catalogue and save books you’d like to revisit.</p>
                    <a href="{{ route('homepage') }}" class="btn btn-primary btn-sm"><i class="bi bi-compass me-1"></i>Browse books</a>
                </div>
            </div>
        @endforelse
    </div>
</main>
</body>
</html>
