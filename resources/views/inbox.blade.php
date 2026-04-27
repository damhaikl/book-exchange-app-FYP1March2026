<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inbox</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f8f9fa;
            padding: 20px;
        }

        .card-box {
            background: white;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .back-btn {
            text-decoration: none;
            display: inline-block;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<!-- 🔙 Back -->
<a href="/dashboard" class="back-btn">
    <i class="bi bi-arrow-left"></i> Back
</a>

<h2>📥 Book Requests</h2>

<!-- 🔔 Messages (IMPORTANT PLACE) -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<!-- 📚 Requests List -->
@forelse($requests as $req)

<div class="card-box">

    <p><b>Book:</b> {{ $req->book->title }}</p>
    <p><b>Requested by:</b> {{ $req->requester->name }}</p>
    <p><b>Status:</b> {{ $req->status }}</p>
    
    @if($req->status == 'cancelled')
    <div class="alert alert-warning">
        ⚠️ {{ $req->requester->name }} cancelled request for 
        <b>{{ $req->book->title }}</b>
    </div>
    @endif
    @if($req->status == 'pending')

        <!-- ✅ Approve -->
        <form method="POST" action="{{ route('request.approve', $req->id) }}" style="display:inline;">
            @csrf
            <button class="btn btn-success btn-sm">
                ✅ Approve
            </button>
        </form>

        <!-- ❌ Reject -->
        <form method="POST" action="{{ route('request.reject', $req->id) }}" style="display:inline;">
            @csrf
            <button class="btn btn-danger btn-sm">
                ❌ Reject
            </button>
        </form>

    @else
        <span class="text-muted">Decision made</span>
    @endif

</div>

@empty
    <p>No requests yet 😴</p>
@endforelse

</body>
</html>