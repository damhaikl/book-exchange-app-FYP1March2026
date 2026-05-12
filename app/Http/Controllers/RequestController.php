<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookRequest;
use App\Mail\BookStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

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

        $requester = User::find($request->requester_id);

        if ($requester) {
            Mail::to($requester->email)
                ->send(new BookStatusMail($request, 'completed'));
        }

        return back()->with('success', 'Marked as taken!');
    }
}