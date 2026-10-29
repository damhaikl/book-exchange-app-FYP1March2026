<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Book;
use Throwable;

class AIController extends Controller
{
    public function index()
    {
        return view('ai-chat');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = trim($validated['message']);
        $apiKey = config('services.groq.key');

        if (!$apiKey) {
            Log::warning('Groq AI is unavailable because GROQ_API_KEY is not configured.');
            return $this->maintenanceResponse();
        }

        // Search using meaningful words while preserving the original message for the AI.
        $searchText = strtolower(preg_replace('/[^a-z0-9\s]/i', ' ', $message) ?? '');
        $keywords = array_values(array_filter(
            array_unique(preg_split('/\s+/', trim($searchText)) ?: []),
            fn (string $word): bool => strlen($word) >= 3
        ));

        $books = collect();
        if ($keywords !== []) {
            $books = Book::query()
                ->where(function ($query) use ($keywords) {
                    foreach ($keywords as $word) {
                        $query->orWhere('title', 'like', "%{$word}%")
                            ->orWhere('description', 'like', "%{$word}%");
                    }
                })
                ->limit(20)
                ->get();
        }

        // 📚 FORMAT DATA
        $bookData = "";

        if ($books->count() > 0) {
            foreach ($books as $book) {
                $bookData .= "
Title: {$book->title}
Condition: {$book->condition}
Subject ID: {$book->subject_id}
Status: {$book->status}
Meeting location: {$book->meeting_location}
Meeting date: {$book->meeting_date}
Meeting time: {$book->meeting_time} - {$book->meeting_end_time}
Link: http://127.0.0.1:8000/book/{$book->id}

";
            }
        } else {
            $bookData = "No matching books found.";
        }

        try {
            // 🤖 CALL GROQ AI
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->connectTimeout(10)
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => config('services.groq.model'),
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
                        ],
                    ]
                ]);

            // ❌ HANDLE API FAILURE CLEANLY
            if (!$response->successful()) {

                Log::error('Groq AI request failed.', [
                    'status' => $response->status(),
                    'error' => $response->json('error.message'),
                ]);

                return $this->maintenanceResponse();
            }

            // ✅ RESPONSE SAFE CHECK
            $reply = $response->json()['choices'][0]['message']['content'] ?? null;

            if (!$reply) {
                Log::warning('Groq AI response did not contain a reply.');
                return $this->maintenanceResponse();
            }

            return response()->json([
                'reply' => $reply
            ]);

        } catch (Throwable $e) {

            Log::error('Groq AI request raised an exception.', [
                'message' => $e->getMessage()
            ]);

            return $this->maintenanceResponse();
        }
    }

    private function maintenanceResponse()
    {
        return response()->json([
            'reply' => 'AI is currently under maintenance. Please try again later.',
        ]);
    }
}
