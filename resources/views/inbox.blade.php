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
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
        }

        .back-btn {
            text-decoration: none;
            display: inline-block;
            margin-bottom: 15px;
        }

        .schedule-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 12px;
            margin-top: 10px;
        }

        .status-badge {
            font-size: 13px;
        }
    </style>
</head>

<body>

<!-- 🔙 Back -->
<a href="/dashboard" class="back-btn">
    <i class="bi bi-arrow-left"></i> Back
</a>

<h2 class="mb-4">📥 Book Requests Inbox</h2>

<!-- 🔔 Success/Error -->
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

<!-- 📚 Request List -->
@forelse($requests as $req)

<div class="card-box shadow-sm">

    <h5>{{ $req->book->title }}</h5>

    <p>
        👤 <b>Requested by:</b> {{ $req->requester->name }}
    </p>

    <p>
        <b>Status:</b>

        @if($req->status == 'pending')
            <span class="badge bg-warning text-dark">Pending</span>

        @elseif($req->status == 'approved')
            <span class="badge bg-success">Approved</span>

        @elseif($req->status == 'rejected')
            <span class="badge bg-danger">Rejected</span>

        @elseif($req->status == 'negotiation')
            <span class="badge bg-info text-dark">Negotiation</span>

        @elseif($req->status == 'cancelled')
            <span class="badge bg-secondary">Cancelled</span>
        @endif

    </p>

    <hr>

    <div class="schedule-box">
        <h6>📍 Seller Schedule</h6>

        <p><b>Location:</b> {{ $req->book->meeting_location }}</p>
        <p><b>Date:</b> {{ $req->book->meeting_date }}</p>
        <p><b>Time:</b> {{ $req->book->meeting_time }}</p>
    </div>

    @if($req->status == 'negotiation')
    <div class="schedule-box mt-3 border border-warning">

        <h6>🔁 Buyer Proposed Schedule</h6>

        <p><b>Location:</b> {{ $req->proposed_location }}</p>
        <p><b>Date:</b> {{ $req->proposed_date }}</p>
        <p><b>Time:</b> {{ $req->proposed_time }}</p>

    </div>
    @endif

    @if($req->status == 'approved')
    <div class="schedule-box mt-3 border border-success">

        <h6>✅ Final Agreed Schedule</h6>

        <p><b>Location:</b> {{ $req->proposed_location ?? $req->book->meeting_location }}</p>
        <p><b>Date:</b> {{ $req->proposed_date ?? $req->book->meeting_date }}</p>
        <p><b>Time:</b> {{ $req->proposed_time ?? $req->book->meeting_time }}</p>

    </div>
    @endif

    @if($req->status == 'cancelled')
        <div class="alert alert-warning mt-3">
            ⚠️ {{ $req->requester->name }} cancelled this request.
        </div>
    @endif

    @if(in_array($req->status, ['pending', 'negotiation']))

    <div class="mt-3">

        <form method="POST" action="{{ route('request.approve', $req->id) }}" style="display:inline;">
            @csrf
            <button class="btn btn-success btn-sm">✅ Approve</button>
        </form>

        <form method="POST" action="{{ route('request.reject', $req->id) }}" style="display:inline;">
            @csrf
            <button class="btn btn-danger btn-sm">❌ Reject</button>
        </form>

    </div>

    @endif

</div>

@empty

<div class="alert alert-secondary">
    No requests yet 😴
</div>

@endforelse

</body>
</html>