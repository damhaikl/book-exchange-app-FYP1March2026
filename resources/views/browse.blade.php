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

        <!-- Book 1 -->
        <div class="col-md-4">
            <div class="card book-card p-3">
                <h6 class="fw-bold">Database Systems</h6>
                <p class="text-muted mb-2">RM 20</p>
                <a href="/book/1" class="btn btn-primary btn-sm w-100">View</a>
            </div>
        </div>

        <!-- Book 2 -->
        <div class="col-md-4">
            <div class="card book-card p-3">
                <h6 class="fw-bold">Web Development</h6>
                <p class="text-muted mb-2">RM 15</p>
                <a href="/book/2" class="btn btn-primary btn-sm w-100">View</a>
            </div>
        </div>

    </div>

</div>

</body>
</html>