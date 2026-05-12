<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

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
}