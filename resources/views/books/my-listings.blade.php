@php
use Illuminate\Support\Str;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>My listings | UniKL BookHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --navy:#102f53; --navy-dark:#0b2542; --navy-mid:#245586; --sky:#dceafb; --ink:#14263d; --muted:#63758a; --line:#dce5ef; --page:#f4f7fb; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; color:var(--ink); background:var(--page); font-family:'Instrument Sans',Arial,sans-serif; }
        .site-header { position:relative; overflow:hidden; color:#fff; background:radial-gradient(ellipse at 85% 20%,#2b5d8b 0,transparent 36%),linear-gradient(130deg,#0b2542,#173f6b); }
        .site-header::after { position:absolute; content:""; width:380px;height:380px; right:-145px;top:-245px;border:1px solid #ffffff18;border-radius:50%;box-shadow:0 0 0 45px #ffffff08,0 0 0 90px #ffffff05; }
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1350px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .back-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.86rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .back-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1350px;margin:auto;padding:29px 28px 48px; }
        .intro-row { display:flex;align-items:flex-end;justify-content:space-between;gap:24px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p { max-width:620px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .create-button { display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 16px;border:0;border-radius:10px;color:var(--navy);background:#fff;font-size:.9rem;font-weight:800;text-decoration:none;white-space:nowrap;transition:transform .2s,box-shadow .2s; }
        .create-button:hover { color:var(--navy-dark);transform:translateY(-2px);box-shadow:0 10px 24px #071d3630; }
        .page-main { max-width:1350px;margin:-20px auto 0;padding:0 28px 56px;position:relative;z-index:2; }
        .listing-grid { display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px; }
        .listing-card { overflow:hidden;border:1px solid var(--line);border-radius:16px;background:#fff;box-shadow:0 10px 30px #173f6b08;transition:transform .2s,border-color .2s,box-shadow .2s; }
        .listing-card:hover { transform:translateY(-3px);border-color:#b7cbe0;box-shadow:0 18px 38px #173f6b15; }
        .book-image { display:block;width:100%;height:220px;object-fit:cover;background:#eaf1f9; }
        .listing-body { padding:17px; }
        .listing-topline { display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:9px; }
        .listing-kicker { color:var(--navy-mid);font-size:.72rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase; }
        .status-badge { display:inline-flex;align-items:center;gap:5px;padding:5px 8px;border-radius:7px;color:#23744a;background:#e4f4eb;font-size:.68rem;font-weight:800;text-transform:capitalize;white-space:nowrap; }
        .status-badge.reserved { color:#8a5a12;background:#fff2d7; }
        .status-badge.sold { color:#aa3038;background:#fde8e9; }
        .status-badge.other { color:var(--navy-mid);background:#eaf1f9; }
        .listing-title { display:-webkit-box;min-height:2.7em;margin:0 0 9px;overflow:hidden;color:var(--navy);font-size:1.08rem;font-weight:800;line-height:1.35;-webkit-line-clamp:2;-webkit-box-orient:vertical; }
        .listing-meta { display:flex;flex-wrap:wrap;gap:7px;margin-bottom:12px; }
        .meta-chip { display:inline-flex;align-items:center;gap:6px;padding:5px 8px;border-radius:7px;color:#4b647f;background:#f1f5f9;font-size:.73rem;font-weight:600; }
        .listing-description { min-height:3.2em;margin:0 0 15px;color:var(--muted);font-size:.84rem;line-height:1.6; }
        .listing-actions { display:flex;gap:8px;padding-top:13px;border-top:1px solid #e8edf3; }
        .listing-actions .btn { flex:1;min-height:38px;border-radius:9px;font-size:.82rem;font-weight:700; }
        .edit-button { color:var(--navy);border-color:#c9d5e2;background:#fff; }
        .edit-button:hover { color:var(--navy);border-color:#a9bed4;background:#eaf1f9; }
        .delete-button { flex:0 0 auto!important;width:42px;color:#a7333d;border-color:#f0c8cc;background:#fff; }
        .delete-button:hover { color:#8b2029;border-color:#e7aeb4;background:#fff0f1; }
        .empty-state { padding:58px 24px;border:1px dashed #b9cadd;border-radius:18px;background:#fff;text-align:center; }
        .empty-icon { display:grid;place-items:center;width:60px;height:60px;margin:0 auto 17px;border-radius:18px;color:var(--navy-mid);background:var(--sky);font-size:1.55rem; }
        .empty-state h2 { margin:0 0 8px;color:var(--navy);font-size:1.2rem;font-weight:800; }
        .empty-state p { max-width:420px;margin:0 auto 20px;color:var(--muted);line-height:1.6; }
        .primary-button { display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:11px 15px;border-radius:9px;color:#fff;background:var(--navy);font-weight:800;text-decoration:none; }
        .primary-button:hover { color:#fff;background:var(--navy-dark); }
        .alert { border:0;border-radius:12px; }
        @media(max-width:1000px) { .listing-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media(max-width:620px) { .header-inner { padding:14px 18px; } .page-intro { padding:25px 20px 42px; } .intro-row { align-items:flex-start;flex-direction:column; } .create-button { width:100%; } .page-main { padding:0 14px 36px; } .listing-grid { grid-template-columns:1fr;gap:14px; } .book-image { height:230px; } .back-link span { display:none; } }
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
            <div class="intro-row">
                <div>
                    <p class="eyebrow">Your bookshelf</p>
                    <h1>My book listings</h1>
                    <p>Manage the books you have shared with the UniKL community.</p>
                </div>
                <a href="{{ route('book.create') }}" class="create-button"><i class="bi bi-plus-lg" aria-hidden="true"></i>Sell a book</a>
            </div>
        </div>
    </header>

    <main class="page-main">
        @if(session('success'))
            <div class="alert alert-success mb-3" role="status"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-3" role="alert"><i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}</div>
        @endif

        @if($books->isEmpty())
            <section class="empty-state">
                <div class="empty-icon"><i class="bi bi-journal-plus" aria-hidden="true"></i></div>
                <h2>No book listings yet</h2>
                <p>When you list a book, you’ll be able to manage it here and share it with other UniKL students.</p>
                <a href="{{ route('book.create') }}" class="primary-button"><i class="bi bi-plus-lg" aria-hidden="true"></i>Create your first listing</a>
            </section>
        @else
            <div class="listing-grid">
                @foreach($books as $book)
                    @php
                        $status = strtolower($book->status ?? 'available');
                        $statusClass = in_array($status, ['available', 'reserved', 'sold'], true) ? $status : 'other';
                    @endphp
                    <article class="listing-card">
                        <img src="{{ asset('storage/' . $book->image) }}" class="book-image" alt="Cover of {{ $book->title }}">
                        <div class="listing-body">
                            <div class="listing-topline">
                                <span class="listing-kicker">Your listing</span>
                                <span class="status-badge {{ $statusClass }}"><i class="bi bi-circle-fill" style="font-size:.42rem" aria-hidden="true"></i>{{ $status }}</span>
                            </div>
                            <h2 class="listing-title">{{ $book->title }}</h2>
                            <div class="listing-meta">
                                <span class="meta-chip"><i class="bi bi-bookmark" aria-hidden="true"></i>{{ $book->condition }}</span>
                                <span class="meta-chip"><i class="bi bi-tag" aria-hidden="true"></i>{{ $book->subject_category ?? 'Category not set' }}</span>
                            </div>
                            <p class="listing-description">{{ Str::limit($book->description, 100) }}</p>
                            <div class="listing-actions">
                                <a href="{{ route('book.edit', $book->id) }}" class="btn edit-button"><i class="bi bi-pencil-square me-1" aria-hidden="true"></i>Edit listing</a>
                                <form action="{{ route('book.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Delete this book?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn delete-button" title="Delete listing" aria-label="Delete {{ $book->title }}"><i class="bi bi-trash3" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
