<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\SavedBook;
use App\Models\Review;
use App\Mail\BookStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\BookSchedule;
use Illuminate\Validation\Rule;
use App\Notifications\BookRequestStatusNotification;

class BookController extends Controller
{
    // 📚 Show all books
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('subject_category')) {
            $query->where('subject_category', $request->subject_category);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $books = $query->latest()->get();

        return view('browse', compact('books'));
    }

    // 📖 Show book details
    public function show($id)
    {
        $book = Book::findOrFail($id);

        $existingRequest = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->first();

        $sellerRating = Review::whereHas('book', function ($q) use ($book) {
            $q->where('user_id', $book->user_id);
        })->avg('rating');

        $sellerRating = number_format($sellerRating ?? 0, 1);

        $sellerReviews = Review::whereHas('book', function ($q) use ($book) {
            $q->where('user_id', $book->user_id);
        })->latest()->take(3)->get();

        return view('book-details', compact(
            'book',
            'existingRequest',
            'sellerRating',
            'sellerReviews'
        ));
    }

    // ✏️ Edit
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('book-edit', compact('book'));
    }

    // 🔄 Update
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'booktitle' => 'required',
            'bookdescription' => 'required',
            'condition' => 'required',
            'subject_id' => 'required',
            'subject_category' => ['required', 'string', Rule::in(Book::SUBJECT_CATEGORIES)],
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'meeting_location' => 'nullable|string|max:255',
            'meeting_date' => 'nullable|date',
            'meeting_time' => 'nullable|date_format:H:i',
            'meeting_end_time' => 'nullable|date_format:H:i|after:meeting_time',
        ]);

        $data = [
            'title' => $request->booktitle,
            'description' => $request->bookdescription,
            'condition' => $request->condition,
            'subject_id' => $request->subject_id,
            'subject_category' => $request->subject_category,
            'price' => $request->price,
            'meeting_location' => $request->meeting_location,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'meeting_end_time' => $request->meeting_end_time,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return redirect('/homepage')->with('success', 'Book updated!');
    }

    // ❌ Delete
    public function destroy($id)
    {
        Book::findOrFail($id)->delete();

        return redirect('/homepage')->with('success', 'Book deleted!');
    }

    // 💾 Store book
    public function store(Request $request)
{
    $request->validate([
        'booktitle' => 'required',
        'bookdescription' => 'required',
        'condition' => 'required',
        'subject_id' => 'required',
        'subject_category' => ['required', 'string', Rule::in(Book::SUBJECT_CATEGORIES)],
        'price' => 'required|numeric|min:0',
        'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',

        // 🧠 SMART MEETING VALIDATION
        'meeting_location' => 'required|string|max:255',
        'meeting_date' => 'required|date',
        'meeting_time' => 'required|date_format:H:i',
        'meeting_end_time' => 'required|date_format:H:i|after:meeting_time',
    ]);

    Book::create([
        'title' => $request->booktitle,
        'description' => $request->bookdescription,
        'condition' => $request->condition,
        'subject_id' => $request->subject_id,
        'subject_category' => $request->subject_category,
        'image' => $request->file('image')->store('books', 'public'),
        'user_id' => auth()->id(),
        'status' => 'available',
        'price' => $request->price,

        // 📍🧠 SMART MEETING DATA (NEW PART)
        'meeting_location' => $request->meeting_location,
        'meeting_date' => $request->meeting_date,
        'meeting_time' => $request->meeting_time,
        'meeting_end_time' => $request->meeting_end_time,
    ]);

    return redirect('/book/create')->with('success', 'Book added with meeting schedule!');
}

    // 📚 My listings
    public function myListings()
    {
        $books = Book::where('user_id', auth()->id())->get();
        return view('books.my-listings', compact('books'));
    }

    // 🤝 REQUEST BOOK (FIXED)
    public function requestBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id == auth()->id()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You cannot request your own book.'], 422);
            }

            return back()->with('error', 'You cannot request your own book.');
        }

        if ($book->status !== 'available') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'This book is no longer available.',
                    'alternatives' => $this->similarAvailableBooks($book, auth()->id()),
                ], 422);
            }

            return back()->with('error', 'Book not available.');
        }

        $existingRequest = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->first();

        if ($existingRequest) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You already have an active request for this book.',
                    'alternatives' => $this->similarAvailableBooks($book, auth()->id()),
                ], 422);
            }

            return back()->with('error', 'You already requested this book.');
        }

        $bookRequest = BookRequest::create([
            'book_id' => $id,
            'requester_id' => auth()->id(),
            'owner_id' => $book->user_id,
            'status' => 'pending'
        ]);

        // ❌ IMPORTANT: DO NOT create schedule here anymore

        $owner = User::find($book->user_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($bookRequest, 'pending'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Book request sent! The seller has been notified.',
                'status' => 'pending',
            ], 201);
        }

        return back()->with('success', 'Book request sent!');
    }

    private function similarAvailableBooks(Book $book, int $studentId): array
    {
        $activeBookIds = BookRequest::where('requester_id', $studentId)
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->pluck('book_id');

        $candidateBooks = Book::query()
            ->where('status', 'available')
            ->where('user_id', '!=', $studentId)
            ->where('id', '!=', $book->id)
            ->whereNotIn('id', $activeBookIds)
            ->latest()
            ->limit(100)
            ->get();

        $targetTokens = $this->similarityTokens($book->title . ' ' . $book->description);
        $targetSubjectId = strtolower(trim((string) $book->subject_id));
        $targetCategory = strtolower(trim((string) $book->subject_category));

        return $candidateBooks->map(function (Book $candidate) use ($targetTokens, $targetSubjectId, $targetCategory) {
            $candidateTokens = $this->similarityTokens($candidate->title . ' ' . $candidate->description);
            $sharedTokens = array_values(array_intersect($targetTokens, $candidateTokens));
            $sameSubjectId = $targetSubjectId !== ''
                && strtolower(trim((string) $candidate->subject_id)) === $targetSubjectId;
            $sameCategory = $targetCategory !== ''
                && strtolower(trim((string) $candidate->subject_category)) === $targetCategory;

            $score = ($sameSubjectId ? 8 : 0)
                + ($sameCategory ? 4 : 0)
                + min(count($sharedTokens), 3);

            if ($sameSubjectId) {
                $reason = 'Same subject ID: ' . $candidate->subject_id;
            } elseif ($sameCategory) {
                $reason = 'Same subject category';
            } elseif ($sharedTokens !== []) {
                $reason = 'Related topics: ' . implode(', ', array_slice($sharedTokens, 0, 3));
            } else {
                $reason = null;
            }

            return [
                'book' => $candidate,
                'score' => $score,
                'reason' => $reason,
            ];
        })
            ->filter(fn (array $match) => $match['score'] > 0)
            ->sortByDesc('score')
            ->take(3)
            ->map(fn (array $match) => [
                'id' => $match['book']->id,
                'title' => $match['book']->title,
                'subject_category' => $match['book']->subject_category,
                'subject_id' => $match['book']->subject_id,
                'price' => $match['book']->price,
                'reason' => $match['reason'],
            ])
            ->values()
            ->all();
    }

    private function similarityTokens(string $text): array
    {
        $tokens = preg_split('/[^a-z0-9]+/i', strtolower($text)) ?: [];
        $stopWords = ['about', 'after', 'book', 'books', 'covers', 'from', 'into', 'that', 'this', 'with', 'their', 'your', 'and', 'the'];

        return array_values(array_unique(array_filter(
            $tokens,
            fn (string $token) => strlen($token) >= 4 && !in_array($token, $stopWords, true)
        )));
    }

    public function proposeScheduleFromChat(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id == auth()->id()) {
            return response()->json(['message' => 'You cannot propose a schedule for your own book.'], 422);
        }

        if ($book->status !== 'available') {
            return response()->json(['message' => 'This book is no longer available.'], 422);
        }

        $validated = $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date|after_or_equal:today',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        $bookRequest = BookRequest::where('book_id', $book->id)
            ->where('requester_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$bookRequest) {
            return response()->json([
                'message' => 'Your pending request was not found. Please check Sent Requests before trying again.',
            ], 422);
        }

        $bookRequest->update(array_merge($validated, [
            'status' => 'negotiation',
            'schedule_type' => 'buyer',
        ]));

        return response()->json([
            'message' => 'Your proposed meeting schedule has been sent to the seller.',
            'schedule' => $validated,
        ], 201);
    }

    public function showProposeSchedule(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id == auth()->id()) {
            return redirect('/book/' . $book->id)
                ->with('error', 'You cannot propose a schedule for your own book.');
        }

        $proposal = BookRequest::where('book_id', $book->id)
            ->where('requester_id', auth()->id())
            ->where('status', 'negotiation')
            ->first();

        $returnTo = $request->query('return_to') === 'sent-requests'
            ? 'sent-requests'
            : 'book-details';

        return view('propose-schedule', compact('book', 'proposal', 'returnTo'));

    }
    public function proposeSchedule(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // ❌ Prevent requesting own book
        if ($book->user_id == auth()->id()) {
            return back()->with('error', 'You cannot request your own book.');
        }

        if ($book->status !== 'available') {
            return back()->with('error', 'This book is no longer available.');
        }

        // ✅ Validate
        $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        // ❌ Prevent duplicate request
        $existingRequest = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->first();

        if ($existingRequest) {
            return redirect('/book/' . $book->id)
                ->with('error', 'You already have an active request for this book.');
        }

        // ✅ Create negotiation request
        BookRequest::create([
            'book_id' => $book->id,
            'requester_id' => auth()->id(),
            'owner_id' => $book->user_id,

            'status' => 'negotiation',

            'proposed_location' => $request->proposed_location,
            'proposed_date' => $request->proposed_date,
            'proposed_time' => $request->proposed_time,
            'proposed_end_time' => $request->proposed_end_time,

            'schedule_type' => 'buyer'
        ]);

        return redirect('/homepage')
            ->with('success', 'New schedule proposed to seller!');
    }

    public function updateProposedSchedule(Request $request, $id)
    {
        $validated = $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        $proposal = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->where('status', 'negotiation')
            ->firstOrFail();

        $proposal->update($validated);

        $redirect = $request->input('return_to') === 'sent-requests'
            ? redirect()->route('sent.requests')
            : redirect('/book/' . $id);

        return $redirect->with('success', 'Your proposed schedule has been updated.');
    }

    public function deleteProposedSchedule(Request $request, $id)
    {
        $proposal = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->where('status', 'negotiation')
            ->firstOrFail();

        // Keep the book request, but remove the buyer's proposed schedule.
        // The book's meeting fields still contain the seller's original schedule.
        $proposal->update([
            'status' => 'pending',
            'proposed_location' => null,
            'proposed_date' => null,
            'proposed_time' => null,
            'proposed_end_time' => null,
            'schedule_type' => 'seller',
        ]);

        $redirect = $request->input('return_to') === 'sent-requests'
            ? redirect()->route('sent.requests')
            : redirect('/book/' . $id);

        return $redirect->with('success', 'Your proposal was removed. The request will use the seller’s original schedule.');
    }

    // 📥 Inbox
    public function inbox()
    {
        $requests = BookRequest::where('owner_id', auth()->id())
            ->with('book', 'requester')
            ->latest()
            ->get();

        return view('inbox', compact('requests'));
    }
    public function sentRequests()
    {
        $requests = BookRequest::where('requester_id', auth()->id())
            ->with('book', 'owner')
            ->latest()
            ->get();

        return view('sent-requests', compact('requests'));
    }

    // 🟢 CREATE / UPDATE SCHEDULE (SELLER ONLY)
    public function storeSchedule(Request $request, $bookId)
    {
        $request->validate([
            'location' => 'required|string',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_end_time' => 'required|date_format:H:i|after:meeting_time',
        ]);

        $book = Book::findOrFail($bookId);

        BookSchedule::updateOrCreate(
            ['book_id' => $book->id],
            [
                'seller_id' => auth()->id(),
                'location' => $request->location,
                'meeting_date' => $request->meeting_date,
                'meeting_time' => $request->meeting_time,
                'meeting_end_time' => $request->meeting_end_time,
                'status' => 'available',
                'buyer_id' => null
            ]
        );

        return back()->with('success', 'Availability saved!');
    }

    // ✅ APPROVE REQUEST
    public function approveRequest($id)
{
    $request = BookRequest::findOrFail($id);

    if ($request->owner_id != auth()->id()) {
        return back()->with('error', 'Unauthorized.');
    }

    $book = $request->book;

    // 🧠 CASE 1: Buyer proposed schedule (NEGOTIATION)
    if ($request->status === 'negotiation') {

        $book->update([
            'meeting_location' => $request->proposed_location,
            'meeting_date' => $request->proposed_date,
            'meeting_time' => $request->proposed_time,
            'meeting_end_time' => $request->proposed_end_time,
            'status' => 'reserved'
        ]);
    }

    // 🧠 CASE 2: Normal request (seller schedule stays)
    else {

        $book->update([
            'status' => 'reserved'
        ]);
    }

    $request->update([
        'status' => 'approved',
        'is_taken' => 1
    ]);

    // 📧 SEND EMAIL TO REQUESTER
    $requester = User::find($request->requester_id);

    if ($requester) {
        $requester->notify(new BookRequestStatusNotification($request));
        Mail::to($requester->email)
            ->queue(new BookStatusMail($request, 'approved'));
    }

    return back()->with('success', 'Request approved successfully!');
}

    // ❌ REJECT
    public function rejectRequest($id)
    {
        $request = BookRequest::findOrFail($id);

        if ($request->owner_id != auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->update(['status' => 'rejected']);

        $request->book->update(['status' => 'available']);

        // 📧 SEND EMAIL TO REQUESTER
        $requester = User::find($request->requester_id);

        if ($requester) {
            $requester->notify(new BookRequestStatusNotification($request));
            Mail::to($requester->email)
                ->queue(new BookStatusMail($request, 'rejected'));
        }

        return back()->with('success', 'Rejected!');
    }

    // 📌 SAVED BOOKS
    public function saveBook($id)
    {
        $book = Book::findOrFail($id);

        $exists = SavedBook::where('user_id', auth()->id())
            ->where('book_id', $id)
            ->first();

        if ($exists) {
            return back()->with('error', 'Already saved.');
        }

        SavedBook::create([
            'user_id' => auth()->id(),
            'book_id' => $id
        ]);

        return back()->with('success', 'Saved!');
    }

    public function savedBooks()
    {
        $saved = SavedBook::where('user_id', auth()->id())
            ->with('book')
            ->latest()
            ->get();

        return view('saved-books', compact('saved'));
    }

    public function unsaveBook($id)
    {
        SavedBook::where('user_id', auth()->id())
            ->where('book_id', $id)
            ->delete();

        return back()->with('success', 'Removed!');
    }
    public function editSchedule($id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        return view('edit-schedule', compact('book'));
    }
    public function updateSchedule(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'meeting_location' => 'required|string|max:255',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_end_time' => 'required|date_format:H:i|after:meeting_time',
        ]);

        $book->update([
            'meeting_location' => $request->meeting_location,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'meeting_end_time' => $request->meeting_end_time,
        ]);

        return redirect('/homepage')->with('success', 'Schedule updated successfully!');
    }
    public function cancelRequest($id)
    {
        $request = BookRequest::findOrFail($id);

        // 🔒 Only requester can cancel
        if ($request->requester_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // 💾 store old status BEFORE changing it
        $wasApproved = $request->status === 'approved';

        // ❌ cancel request
        $request->update([
            'status' => 'cancelled'
        ]);

        $requester = User::find($request->requester_id);
        if ($requester) {
            $requester->notify(new BookRequestStatusNotification($request));
        }

        // 🔁 if it was already approved, revert book back to available
        if ($wasApproved) {
            $request->book->update([
                'status' => 'available'
            ]);
        }

        // 📧 SEND EMAIL TO OWNER
        $owner = User::find($request->owner_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($request, 'cancelled'));
        }

        return back()->with('success', 'Request cancelled successfully.');
    }
}
