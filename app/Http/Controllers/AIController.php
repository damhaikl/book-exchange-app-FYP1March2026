<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Book;

class AIController extends Controller
{
    public function index()
    {
        return view('ai-chat');
    }

    public function send(Request $request)
    {
        // ✅ CLEAN INPUT
        $message = trim(strtolower($request->message));
        $message = str_replace(['"', "'"], '', $message);
        $message = preg_replace('/[^a-z0-9\s]/', '', $message);

        // 🔑 CHECK API KEY
        if (!env('GROQ_API_KEY')) {
            return response()->json([
                'reply' => 'Missing GROQ_API_KEY in .env'
            ]);
        }

        // 🔍 SEARCH DATABASE
        $keywords = explode(' ', $message);

        $books = Book::query();

        foreach ($keywords as $word) {
            $books->orWhere('title', 'like', "%{$word}%")
                  ->orWhere('description', 'like', "%{$word}%");
        }

        $books = $books->get();

        // 📚 FORMAT DATA
        $bookData = "";

        if ($books->count() > 0) {

            foreach ($books as $book) {

                $bookData .= "
Title: {$book->title}
Condition: {$book->condition}
Subject ID: {$book->subject_id}
Status: {$book->status}
Link: http://127.0.0.1:8000/book/{$book->id}

";
            }

        } else {
            $bookData = "No matching books found.";
        }

        // 🤖 CALL GROQ AI
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [

            'model' => 'llama-3.1-8b-instant',

            'messages' => [
                [
                    'role' => 'system',
                    'content' => "
You are a helpful AI assistant for a university book exchange system.

Use database results to answer users naturally.
Recommend books clearly if found.
If none found, say politely no books found.
"
                ],
                [
                    'role' => 'user',
                    'content' => "
User message:
{$message}

Database results:
{$bookData}
"
                ]
            ]

        ]);

        // ❌ ERROR HANDLING
        if (!$response->successful()) {
            return response()->json([
                'reply' => 'AI error: ' . $response->status() . ' - ' . $response->body()
            ]);
        }

        // ✅ RESPONSE
        $reply = $response->json()['choices'][0]['message']['content'];

        return response()->json([
            'reply' => nl2br($reply)
        ]);
    }
}