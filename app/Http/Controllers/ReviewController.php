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
        $request = BookRequest::with('book')->findOrFail($requestId);

        if ($request->requester_id != auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        if ($request->status != 'completed') {
            return back()->with('error', 'You can only review completed books.');
        }

        return view('review-create', compact('request'));
    }

    // ⭐ store review
    public function store(Request $request, $requestId)
    {
        $bookRequest = BookRequest::findOrFail($requestId);

        if ($bookRequest->requester_id != auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        // 🚫 prevent double review
        $existing = Review::where('book_id', $bookRequest->book_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return back()->with('error', 'You already reviewed this book!');
        }

        Review::create([
            'book_id' => $bookRequest->book_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect('/sent-requests')->with('success', 'Review submitted!');
    }
}