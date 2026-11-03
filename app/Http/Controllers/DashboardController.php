<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\BookRequest;
use App\Notifications\BookRequestStatusNotification;

class DashboardController extends Controller
{
    public function index()
    {
        $averageRating = Review::whereHas('book', function ($query) {
            $query->where('user_id', auth()->id());
        })->avg('rating');

        $averageRating = number_format($averageRating ?? 0, 1);

        return view('dashboard', compact('averageRating'));
    }

    public function requestNotifications(Request $request)
    {
        $latestRequest = BookRequest::query()
            ->with(['book:id,title', 'requester:id,name'])
            ->where('owner_id', $request->user()->id)
            ->whereIn('status', ['pending', 'negotiation'])
            ->latest('id')
            ->first();

        $statusUpdates = $request->user()
            ->notifications()
            ->where('type', BookRequestStatusNotification::class)
            ->latest()
            ->get()
            ->map(fn ($notification) => [
                'id' => $notification->id,
                'message' => $notification->data['message'] ?? 'A request you sent has a status update.',
                'status' => $notification->data['status'] ?? null,
                'created_at' => $notification->created_at?->toIso8601String(),
                'unread' => $notification->read_at === null,
            ])
            ->values();
        $unreadStatusCount = $request->user()
            ->unreadNotifications()
            ->where('type', BookRequestStatusNotification::class)
            ->count();

        return response()->json([
            'request' => $latestRequest ? [
                'id' => $latestRequest->id,
                'book_title' => $latestRequest->book?->title ?? 'A book listing',
                'requester_name' => $latestRequest->requester?->name ?? 'A student',
                'status' => $latestRequest->status,
                'created_at' => $latestRequest->created_at?->toIso8601String(),
            ] : null,
            'status_updates' => $statusUpdates,
            'unread_status_count' => $unreadStatusCount,
        ]);
    }

    public function markStatusNotificationsRead(Request $request)
    {
        $request->user()
            ->unreadNotifications()
            ->where('type', BookRequestStatusNotification::class)
            ->update(['read_at' => now()]);

        return response()->json(['message' => 'Status notifications marked as read.']);
    }

}
