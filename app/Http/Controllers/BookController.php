<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = [];

        return view('browse', compact('books'));
    }

    public function show($id)
    {
        $book = (object)[
            'id' => $id,
            'title' => 'Sample Book',
            'description' => 'This is a full description of the book.',
            'price' => 25,
            'subject' => 'Programming',
            'image' => 'https://via.placeholder.com/150'
        ];

        return view('book-details', compact('book'));
    }
}