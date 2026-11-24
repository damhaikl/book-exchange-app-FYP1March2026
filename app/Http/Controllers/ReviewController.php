<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookRequest;
use App\Models\Review;

class ReviewController extends Controller
{
    // ⭐ show review form
    
    public function create($requestId)
    {
        $bookRequest = BookRequest::with(['book', 'requester', 'owner'])
            ->findOrFail($requestId);

        // Sell reviews only. Keep Exchange unchanged.
        if (!$bookRequest->book ||
            $bookRequest->book->listing_type !== 'sell') {
            abort(404);
        }

        // Only the buyer and seller can review each other.
        $isRequester = $bookRequest->requester_id == auth()->id();
        $isOwner = $bookRequest->owner_id == auth()->id();

        if (!$isRequester && !$isOwner) {
            return back()->with('error', 'Unauthorized.');
        }

        // Both students must confirm handover first.
        if ($bookRequest->status !== 'completed') {
            return back()->with('error', 'You can only review after both students confirm handover.');
        }

        // Determine who receives the review.
        $reviewedUser = $isRequester
            ? $bookRequest->owner
            : $bookRequest->requester;

        // Prevent duplicate reviews for this transaction.
        $existing = Review::where('book_request_id', $bookRequest->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this transaction.');
        }

        return view('review-create', [
            'request' => $bookRequest,
            'reviewedUser' => $reviewedUser,
        ]);
    }


    // ⭐ store review
    
    public function store(Request $request, $requestId)
    {
        $bookRequest = BookRequest::with('book')->findOrFail($requestId);

        // Sell reviews only. Keep Exchange unchanged.
        if (!$bookRequest->book ||
            $bookRequest->book->listing_type !== 'sell') {
            abort(404);
        }

        $isRequester = $bookRequest->requester_id == auth()->id();
        $isOwner = $bookRequest->owner_id == auth()->id();

        if (!$isRequester && !$isOwner) {
            return back()->with('error', 'Unauthorized.');
        }

        if ($bookRequest->status !== 'completed') {
            return back()->with('error', 'Both students must confirm handover before reviewing.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $existing = Review::where('book_request_id', $bookRequest->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this transaction.');
        }

        // Review the other student.
        $reviewedUserId = $isRequester
            ? $bookRequest->owner_id
            : $bookRequest->requester_id;

        Review::create([
            'book_id' => $bookRequest->book_id,
            'book_request_id' => $bookRequest->id,
            'user_id' => auth()->id(),
            'reviewed_user_id' => $reviewedUserId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        if ($isRequester) {
            return redirect('/sent-requests')
                ->with('success', 'Review submitted successfully!');
        }

        return redirect()->route('inbox')
            ->with('success', 'Review submitted successfully!');
    }


    public function myReviews()
    {
        $reviews = Review::with('book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('my-reviews', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // only owner can delete
        if ($review->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }

   public function received()
    {
        $reviews = Review::with(['book', 'user'])
            ->where(function ($query) {
                $query->where('reviewed_user_id', auth()->id())

                    // Preserve older reviews created before the new columns.
                    ->orWhere(function ($legacyQuery) {
                        $legacyQuery->whereNull('reviewed_user_id')
                            ->whereHas('book', function ($bookQuery) {
                                $bookQuery->where('user_id', auth()->id());
                            });
                    });
            })
            ->latest()
            ->get();

        return view('received', compact('reviews'));
    }

    public function adminreview()
    {
        $reviews = Review::with(['user', 'book'])
            ->latest()
            ->get();

        return view('admin.reviews.adminreview', compact('reviews'));
    }

    public function adminDestroy($id)
    {
        $review = Review::findOrFail($id);

        // optional: restrict only admin/super_admin
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            return back()->with('error', 'Unauthorized');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}