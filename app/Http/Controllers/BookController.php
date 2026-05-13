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
            ->whereIn('status', ['pending', 'approved'])
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
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = [
            'title' => $request->booktitle,
            'description' => $request->bookdescription,
            'condition' => $request->condition,
            'subject_id' => $request->subject_id,
            'price' => $request->price
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
        'price' => 'required|numeric|min:0',
        'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',

        // 🧠 SMART MEETING VALIDATION
        'meeting_location' => 'required|string|max:255',
        'meeting_date' => 'required|date',
        'meeting_time' => 'required'
    ]);

    Book::create([
        'title' => $request->booktitle,
        'description' => $request->bookdescription,
        'condition' => $request->condition,
        'subject_id' => $request->subject_id,
        'image' => $request->file('image')->store('books', 'public'),
        'user_id' => auth()->id(),
        'status' => 'available',
        'price' => $request->price,

        // 📍🧠 SMART MEETING DATA (NEW PART)
        'meeting_location' => $request->meeting_location,
        'meeting_date' => $request->meeting_date,
        'meeting_time' => $request->meeting_time,
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
    public function requestBook($id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id == auth()->id()) {
            return back()->with('error', 'You cannot request your own book.');
        }

        if ($book->status !== 'available') {
            return back()->with('error', 'Book not available.');
        }

        $existingRequest = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
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

        return back()->with('success', 'Book request sent!');
    }
    public function showProposeSchedule($id)
    {
        $book = Book::findOrFail($id);

        return view('propose-schedule', compact('book'));

        

    }
    public function proposeSchedule(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // ❌ Prevent requesting own book
        if ($book->user_id == auth()->id()) {
            return back()->with('error', 'You cannot request your own book.');
        }

        // ✅ Validate
        $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date',
            'proposed_time' => 'required'
        ]);

        // ❌ Prevent duplicate request
        $existingRequest = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You already requested this book.');
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

            'schedule_type' => 'buyer'
        ]);

        return redirect('/homepage')
            ->with('success', 'New schedule proposed to seller!');
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
            'meeting_time' => 'required'
        ]);

        $book = Book::findOrFail($bookId);

        BookSchedule::updateOrCreate(
            ['book_id' => $book->id],
            [
                'seller_id' => auth()->id(),
                'location' => $request->location,
                'meeting_date' => $request->meeting_date,
                'meeting_time' => $request->meeting_time,
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

        $request->book->schedule?->update([
            'status' => 'rejected',
            'buyer_id' => null
        ]);

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
            'meeting_time' => 'required'
        ]);

        $book->update([
            'meeting_location' => $request->meeting_location,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time
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

        // 🔁 if it was already approved, revert book back to available
        if ($wasApproved) {
            $request->book->update([
                'status' => 'available'
            ]);
        }

        return back()->with('success', 'Request cancelled successfully.');
    }
}