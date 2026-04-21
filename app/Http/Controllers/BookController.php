<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    // 📚 Show all books
    public function index()
    {
        $books = Book::latest()->get();
        return view('browse', compact('books'));
    }

    // 📖 Show single book
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('book-details', compact('book'));
    }

    // ✏️ Edit book page
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
            'user_id' => auth()->id()
        ]);

        return redirect('/homepage')->with('success', 'Book added successfully!');
    }

    // 📚 My Listings (FIXED LOCATION)
    public function myListings()
    {
        $books = Book::where('user_id', auth()->id())->get();

        return view('books.my-listings', compact('books'));
    }
}