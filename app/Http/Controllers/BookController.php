<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // 📚 Show all books (Homepage / Browse)
    public function index()
    {
        // Get all books from DB, latest first
        $books = Book::latest()->get();

        // Send data to browse.blade.php
        return view('browse', compact('books'));
    }

    // 📖 Show single book details
    public function show($id)
    {
        // Find book by ID or show 404 if not found
        $book = Book::findOrFail($id);

        // Send book data to book-details page
        return view('book-details', compact('book'));
    }

    // ✏️ Show edit form
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        return view('book-edit', compact('book'));
    }

    // 🔄 Update book in database
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // ✅ Validate form input
        $request->validate([
            'booktitle' => 'required',
            'bookdescription' => 'required',
            'condition' => 'required',
            'subject_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // 🧠 Map form fields → database columns
        $data = [
            'title' => $request->booktitle,
            'description' => $request->bookdescription,
            'condition' => $request->condition,
            'subject_id' => $request->subject_id,
        ];

        // 📸 If new image uploaded → store it
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('books', 'public');
            $data['image'] = $path;
        }

        // 💾 Update database
        $book->update($data);

        return redirect('/homepage')->with('success', 'Book updated successfully!');
    }

    // ❌ Delete book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Delete record
        $book->delete();

        return redirect('/homepage')->with('success', 'Book deleted successfully!');
    }

    // 💾 Store new book
    public function store(Request $request)
    {
        $request->validate([
            'booktitle' => 'required',
            'bookdescription' => 'required',
            'condition' => 'required',
            'subject_id' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // 📸 Store image in storage/app/public/books
        $path = $request->file('image')->store('books', 'public');

        // 💾 Save to DB
        Book::create([
            'title' => $request->booktitle,
            'description' => $request->bookdescription,
            'condition' => $request->condition,
            'subject_id' => $request->subject_id,
            'image' => $path,
            'user_id' => auth()->id()
        ]);

        return redirect('/homepage')->with('success', 'Book added successfully!');
    }

    // 📚 Show logged-in user's books
    public function myListings()
    {
        $books = Book::where('user_id', auth()->id())->get();

        return view('books.my-listings', compact('books'));
    }

    public function requestBook($id)
    {
        $book = Book::findOrFail($id);

        // prevent owner from requesting own book
        if ($book->user_id == auth()->id()) {
            return back()->with('error', 'You cannot request your own book.');
        }

        // prevent duplicate request
        $exists = \App\Models\BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->first();

        if ($exists) {
            return back()->with('error', 'You already requested this book.');
        }

        \App\Models\BookRequest::create([
            'book_id' => $id,
            'requester_id' => auth()->id(),
            'owner_id' => $book->user_id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Book request sent!');
    }
    public function inbox()
    {
        $requests = \App\Models\BookRequest::where('owner_id', auth()->id())
            ->with('book', 'requester')
            ->latest()
            ->get();

        return view('inbox', compact('requests'));
    }
}