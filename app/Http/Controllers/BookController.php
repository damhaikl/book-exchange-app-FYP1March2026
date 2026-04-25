<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\SavedBook;

class BookController extends Controller
{
    // 📚 Show all books (Homepage / Browse)
    public function index(Request $request)
    {
        $query = Book::query();
        // 🔎 Search by title / description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
            }

        // 🎯 Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // 📘 Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $books = $query->latest()->get();

        return view('browse', compact('books'));
    }

    // 📖 Show single book details
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('book-details', compact('book'));
    }

    // ✏️ Edit form
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('book-edit', compact('book'));
    }

    // 🔄 Update book
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'booktitle' => 'required',
            'bookdescription' => 'required',
            'condition' => 'required',
            'subject_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = [
            'title' => $request->booktitle,
            'description' => $request->bookdescription,
            'condition' => $request->condition,
            'subject_id' => $request->subject_id,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('books', 'public');
            $data['image'] = $path;
        }

        $book->update($data);

        return redirect('/homepage')->with('success', 'Book updated successfully!');
    }

    // ❌ Delete book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect('/homepage')->with('success', 'Book deleted successfully!');
    }

    // 💾 Store book
    public function store(Request $request)
    {
        $request->validate([
            'booktitle' => 'required',
            'bookdescription' => 'required',
            'condition' => 'required',
            'subject_id' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $path = $request->file('image')->store('books', 'public');

        Book::create([
            'title' => $request->booktitle,
            'description' => $request->bookdescription,
            'condition' => $request->condition,
            'subject_id' => $request->subject_id,
            'image' => $path,
            'user_id' => auth()->id(),
            'status' => 'available'
        ]);

        return redirect('/book/create')->with('success', 'Book added successfully!');
    }

    // 📚 My Listings
    public function myListings()
    {
        $books = Book::where('user_id', auth()->id())->get();
        return view('books.my-listings', compact('books'));
    }

    // 🤝 Request Book
    public function requestBook($id)
    {
        $book = Book::findOrFail($id);

        // 🚫 cannot request own book
        if ($book->user_id == auth()->id()) {
            return back()->with('error', 'You cannot request your own book.');
        }

        // 🚫 block if book not available
        if ($book->status !== 'available') {
            return back()->with('error', 'This book is no longer available.');
        }

        // 🚫 prevent duplicate request
        $exists = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->first();

        if ($exists) {
            return back()->with('error', 'You already requested this book.');
        }

        BookRequest::create([
            'book_id' => $id,
            'requester_id' => auth()->id(),
            'owner_id' => $book->user_id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Book request sent!');
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

    // ✅ Approve request
    public function approveRequest($id)
    {
        $request = BookRequest::findOrFail($id);

        if ($request->owner_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // 🚫 check if already approved
        $alreadyApproved = BookRequest::where('book_id', $request->book_id)
            ->where('status', 'approved')
            ->exists();

        if ($alreadyApproved) {
            return back()->with('error', '❌ This book already has an approved request. You cannot approve another one.');
        }

        // ✅ approve request
        $request->update([
            'status' => 'approved'
        ]);

        // 🔒 LOCK THE BOOK
        $request->book->update([
            'status' => 'reserved'
        ]);

        return back()->with('success', 'Request approved & book locked!');
    }

    // ❌ Reject request
    public function rejectRequest($id)
    {
        $request = BookRequest::findOrFail($id);

        if ($request->owner_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Request rejected!');
    }

    public function sentRequests()
    {
        $requests = BookRequest::where('requester_id', auth()->id())
            ->with('book', 'owner')
            ->latest()
            ->get();

        return view('sent-requests', compact('requests'));
    }

    public function cancelRequest($id)
    {
        $request = BookRequest::findOrFail($id);

        // 🚫 only requester can cancel
        if ($request->requester_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        // 🚫 only approved requests can be cancelled
        if ($request->status !== 'approved') {
            return back()->with('error', 'Only approved requests can be cancelled.');
        }

        // 🔁 update request
        $request->update([
            'status' => 'cancelled'
        ]);

        // 🔓 unlock book
        $request->book->update([
            'status' => 'available'
        ]);

        return back()->with('success', 'Request cancelled successfully!');
    }

    public function saveBook($id)
    {
        $book = Book::findOrFail($id);

        // 🚫 prevent saving own book
        if ($book->user_id == auth()->id()) {
            return back()->with('error', 'You cannot save your own book.');
        }

        // 🚫 prevent duplicates
        $exists = SavedBook::where('user_id', auth()->id())
            ->where('book_id', $id)
            ->first();

        if ($exists) {
            return back()->with('error', 'Book already saved!');
        }

        SavedBook::create([
            'user_id' => auth()->id(),
            'book_id' => $id
        ]);

        return back()->with('success', 'Book saved successfully!');
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
        $saved = SavedBook::where('user_id', auth()->id())
            ->where('book_id', $id)
            ->first();

        if (!$saved) {
            return back()->with('error', 'Book not found in saved list.');
        }

        $saved->delete();

        return back()->with('success', 'Book removed from saved list.');
    }
}