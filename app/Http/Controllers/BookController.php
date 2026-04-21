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

    // 📖 Show single book (NOW USING DATABASE)
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('book-detail', compact('book'));
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
        'image' => $path
    ]);

    return redirect('/homepage')->with('success', 'Book added successfully!');
}
}