<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookRequest;

class RequestController extends Controller
{
    public function takeBook($id)
    {
        $request = BookRequest::findOrFail($id);

        if ($request->requester_id != auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        $request->update([
            'is_taken' => true,
            'status' => 'completed'            
        ]);

        $request->book->update([
            'status' => 'sold'
        ]);

        return back()->with('success', 'Marked as taken!');
    }
}