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
})->middleware('auth')->name('book.create');

// ✅ store
Route::post('/book/store', [BookController::class, 'store'])
    ->middleware('auth')
    ->name('book.store');


// ✅ show (dynamic route ALWAYS last)
Route::get('/book/{id}', [BookController::class, 'show']);

Route::get('/book/{id}/edit', [BookController::class, 'edit'])
    ->middleware('auth')
    ->name('book.edit');

Route::put('/book/{id}', [BookController::class, 'update'])
    ->middleware('auth')
    ->name('book.update');

Route::delete('/book/{id}', [BookController::class, 'destroy'])
    ->middleware('auth')
    ->name('book.destroy');

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

Route::get('/my-listings', [BookController::class, 'myListings'])
    ->middleware(['auth'])
    ->name('book.myListings');

Route::post('/book/{id}/request', [BookController::class, 'requestBook'])
    ->middleware('auth')
    ->name('book.request');

Route::get('/inbox', [BookController::class, 'inbox'])
    ->middleware('auth')
    ->name('inbox');