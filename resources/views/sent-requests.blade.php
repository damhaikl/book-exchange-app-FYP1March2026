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
    <div class="card-box">
        <p><b>Book:</b> {{ $req->book->title }}</p>
        <p><b>Status:</b> {{ $req->status }}</p>
        <hr>
        <h5>📍 Meeting Details</h5>
        <p>📍 Location:
            <strong>{{ $req->book->meeting_location ?? 'Not set' }}</strong>
        </p>
        <p>📅 Date:
            <strong>{{ $req->book->meeting_date ?? 'Not set' }}</strong>
        </p>
        <p>⏰ Time:
            <strong>
                {{ $req->book->meeting_time ? \Carbon\Carbon::parse($req->book->meeting_time)->format('g:i A') : 'Not set' }}
                @if($req->book->meeting_end_time)
                    – {{ \Carbon\Carbon::parse($req->book->meeting_end_time)->format('g:i A') }}
                @endif
            </strong>
        </p>
    </div>

    @if($req->status === 'negotiation')
        <div class="card-box mt-3">
            <h5>Your proposed meeting schedule</h5>
            <p>📍 Location: <strong>{{ $req->proposed_location }}</strong></p>
            <p>📅 Date: <strong>{{ $req->proposed_date }}</strong></p>
            <p>⏰ Time:
                <strong>
                    {{ $req->proposed_time ? \Carbon\Carbon::parse($req->proposed_time)->format('g:i A') : 'Not set' }}
                    @if($req->proposed_end_time)
                        – {{ \Carbon\Carbon::parse($req->proposed_end_time)->format('g:i A') }}
                    @endif
                </strong>
            </p>
            <button type="button"
                    class="btn btn-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#proposalModal-{{ $req->id }}">
                Manage proposed schedule
            </button>
        </div>

        <div class="modal fade" id="proposalModal-{{ $req->id }}" tabindex="-1" aria-labelledby="proposalModalTitle-{{ $req->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="proposalModalTitle-{{ $req->id }}">Schedule proposal already sent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>You already proposed a new meeting schedule. Would you like to change it?</p>
                        <p class="mb-0">Deleting the proposal keeps your book request active and returns it to the seller’s original meeting schedule.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form method="POST" action="{{ route('book.proposeSchedule.delete', $req->book_id) }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="return_to" value="sent-requests">
                            <button type="submit" class="btn btn-outline-danger">Delete proposal</button>
                        </form>
                        <a href="{{ route('book.proposeScheduleForm', $req->book_id) }}?return_to=sent-requests" class="btn btn-primary">Edit proposal</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    

</div>

@empty
<p>No requests yet 😢</p>
@endforelse

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
