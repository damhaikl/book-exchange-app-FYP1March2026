<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Exchange - Browse</title>

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
    </style>
</head>

<body>

<!-- 🔥 HEADER (STANDARDISED) -->
<header class="app-header d-flex justify-content-between align-items-center px-4 py-3">

    <!-- LEFT: Brand -->
    <h4 class="m-0 fw-bold">📚 Book Exchange</h4>

    <!-- RIGHT: User -->
    <a href="/profile"
       class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center user-btn">

        <i class="bi bi-person"></i>
    </a>

</header>

<!-- 🧱 MAIN CONTENT -->
<div class="container py-4">

    <h5 class="mb-3">Browse Books</h5>

    <div class="row g-3">

    @forelse($books as $book)
        <div class="col-md-4">

            <div class="card p-3">

                <!-- IMAGE -->
                <img src="{{ asset('storage/' . $book->image) }}"
                     style="height:180px; object-fit:cover; border-radius:10px;"
                     class="mb-2">

                <!-- TITLE -->
                <h6 class="fw-bold">{{ $book->title }}</h6>

                <!-- CONDITION -->
                <p class="text-muted mb-1">
                    Condition: {{ $book->condition }}
                </p>

                <!-- SUBJECT -->
                <p class="text-muted mb-2">
                    Subject ID: {{ $book->subject_id }}
                </p>

                <!-- BUTTON -->
                <a href="/book/{{ $book->id }}" class="btn btn-primary btn-sm w-100">
                    View
                </a>

            </div>

        </div>
    @empty
        <p>No books available yet 😢</p>
    @endforelse

</div>

</div>

</body>
</html>