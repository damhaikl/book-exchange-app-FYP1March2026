<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UniKLBook Hub</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .app-header {
            background: white;
            border-bottom: 1px solid #e5e5e5;
        }

        .book-card {
            border: none;
            border-radius: 12px;
            transition: 0.2s ease-in-out;
        }

        .book-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .user-btn {
            width: 40px;
            height: 40px;
        }

        .hero {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e5e5e5;
        }

        .book-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body>

<!-- 🔥 HEADER -->
<header class="app-header d-flex justify-content-between align-items-center px-4 py-3">

    <!-- LEFT: Brand -->
    <h4 class="m-0 fw-bold">📚 UniKLBook Hub</h4>

    <!-- RIGHT: User -->
    <a href="/dashboard"
       class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center user-btn">

        <i class="bi bi-person"></i>
    </a>

</header>

<!-- 🧱 MAIN CONTENT -->
<div class="container py-4">

    <!-- 🧠 SYSTEM INTRO -->
    <div class="hero text-center">
        <h3 class="fw-bold mb-1">UniKLBook Hub</h3>
        <p class="text-muted mb-0">
            A Book Exchange System for UniKL MIIT Students
        </p>
    </div>
    <!-- 🔎 SEARCH + FILTER -->
    <form method="GET" action="{{ route('homepage') }}" class="mb-4">
        <div class="row g-2">
            <!-- SEARCH -->
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search book title..." value="{{ request('search') }}">
            </div>
            
            <!-- SUBJECT FILTER -->
            <div class="col-md-3">
                <input type="text" name="subject_id" class="form-control" placeholder="Subject ID" value="{{ request('subject_id') }}">
            </div>

            <!-- CONDITION FILTER -->
            <div class="col-md-3">
                <select name="condition" class="form-select" onchange="this.form.submit()">
                    <option value="">All Condition</option>
                    <option value="New" {{ request('condition') == 'New' ? 'selected' : '' }}>
                        New
                    </option>
                    <option value="Like New" {{ request('condition') == 'Like New' ? 'selected' : '' }}>
                        Like New
                    </option>
                    <option value="Used" {{ request('condition') == 'Used' ? 'selected' : '' }}>
                        Used
                    </option>
                </select>
            </div>

            <!-- BUTTON -->
            <!-- BUTTONS -->
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-primary w-100">
                    🔎 Search
                </button>
                <a href="{{ route('homepage') }}" class="btn btn-secondary w-100">
                    🔄 Reset
                </a>

</div>


        </div>
    </form>
    <h5 class="mb-3">Browse Books</h5>

    <div class="row g-3">

    @forelse($books as $book)

    <div class="col-md-4">
        <div class="card p-3 book-card">
            <img src="{{ asset('storage/' . $book->image) }}" class="book-img">
            <h6>{{ $book->title }}</h6>
            <p>Condition: {{ $book->condition }}</p>
            <p>Subject ID: {{ $book->subject_id }}</p>
            @if($book->status == 'available')
                <span style="color:green;">Available</span>
            @else
                <span style="color:red;">Reserved</span>
            @endif
            <a href="/book/{{ $book->id }}" class="btn btn-primary btn-sm w-100">
                View
            </a>
        </div>
    </div>
    @empty
    <p>No books available 😢</p>
    @endforelse


</div>

</body>
</html>