<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('/homepage');
});

/* =========================
   📚 BOOK ROUTES (IMPORTANT ORDER)
========================= */

// ✅ create MUST come first
Route::get('/book/create', function () {
    return view('book-create');
})->middleware('auth');

// ✅ store
Route::post('/book/store', [BookController::class, 'store'])
    ->middleware('auth')
    ->name('book.store');


// ✅ show (dynamic route ALWAYS last)
Route::get('/book/{id}', [BookController::class, 'show']);


/* =========================
   🏠 MAIN PAGES
========================= */

Route::get('/homepage', [BookController::class, 'index'])->name('homepage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/* =========================
   👤 PROFILE
========================= */

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';