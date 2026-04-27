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

<div class="card p-3 mb-3">

    <p><b>📚 Book:</b> {{ $req->book->title }}</p>
    <p><b>👤 Owner:</b> {{ $req->owner->name }}</p>

    <p>
        <b>Status:</b>
        
        @if($req->status == 'pending')
            <span class="badge bg-warning text-dark">Pending</span>
        @elseif($req->status == 'approved')
        @if($req->status == 'approved')
        <form method="POST" action="{{ route('request.cancel', $req->id) }}">
            @csrf
            <button class="btn btn-warning btn-sm" onclick="return confirm('Cancel this request?')">
                ❌ Cancel Request
            </button>
        </form>
        @endif
            <span class="badge bg-success">Approved</span>
        @else
            <span class="badge bg-danger">Rejected</span>
        @endif
    </p>

</div>

@empty
<p>No requests yet 😢</p>
@endforelse

</body>
</html>