<?php

namespace App\Http\Controllers;

use App\Models\Review;

class DashboardController extends Controller
{
    
    public function index()
    {
        $averageRating = Review::where('reviewed_user_id', auth()->id())
            ->avg('rating');

        $averageRating = number_format($averageRating ?? 0, 1);

        return view('dashboard', compact('averageRating'));
    }

}
