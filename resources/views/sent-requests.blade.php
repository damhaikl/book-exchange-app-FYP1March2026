<!DOCTYPE html>
<html>
<head>
    <title>Sent Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

<a href="/dashboard" class="btn btn-secondary mb-3">⬅ Back</a>

<h2>📤 My Sent Requests</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@forelse($requests as $req)
@php
    $hasReview = \App\Models\Review::where('book_id', $req->book_id)
        ->where('user_id', auth()->id())
        ->exists();
@endphp

<div class="card p-3 mb-3">

    <p><b>📚 Book:</b> {{ $req->book->title }}</p>
    <p><b>👤 Owner:</b> {{ $req->owner->name }}</p>

    <p>
        <b>Status:</b>
        
        @if($req->status == 'pending')

            <span class="badge bg-warning text-dark">Pending</span>

            <form method="POST" action="{{ route('request.cancel', $req->id) }}">
                @csrf
                <button class="btn btn-warning btn-sm">
                    ❌ Cancel Request
                </button>
            </form>

        @elseif($req->status == 'approved' && !$req->is_taken)

            <span class="badge bg-success">Approved</span>

            <form method="POST" action="{{ route('request.take', $req->id) }}">
                @csrf
                <button class="btn btn-primary btn-sm">
                    ✅ Already Take
                </button>
            </form>

            <form method="POST" action="{{ route('request.cancel', $req->id) }}">
                @csrf
                <button class="btn btn-danger btn-sm">
                    ❌ Cancel Request
                </button>
            </form>

        @elseif($req->status == 'completed' || $req->is_taken)

            <span class="badge bg-info">Completed</span>

            <!-- ⭐ Review Button -->
            @if(!$hasReview)
                <a href="{{ route('review.create', $req->id) }}"
                class="btn btn-success btn-sm mt-2">
                    ⭐ Make Review & Rating
                </a>
            @else
                <span class="badge bg-secondary mt-2">
                    ✔ Already Reviewed
                </span>
            @endif

        @elseif($req->status == 'cancelled')

            <span class="badge bg-secondary">Cancelled</span>

        @elseif($req->status == 'rejected')

            <span class="badge bg-danger">Rejected</span>

        @endif
    </p>

</div>

@empty
<p>No requests yet 😢</p>
@endforelse

</body>
</html>