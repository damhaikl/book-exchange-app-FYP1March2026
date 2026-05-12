<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;

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

Route::post('/request/{id}/approve', [BookController::class, 'approveRequest'])
    ->middleware('auth')
    ->name('request.approve');

Route::post('/request/{id}/reject', [BookController::class, 'rejectRequest'])
    ->middleware('auth')
    ->name('request.reject');

Route::get('/sent-requests', [BookController::class, 'sentRequests'])
    ->middleware('auth')
    ->name('sent.requests');

Route::post('/request/{id}/cancel', [BookController::class, 'cancelRequest'])
    ->middleware('auth')
    ->name('request.cancel');

Route::post('/book/{id}/save', [BookController::class, 'saveBook'])
    ->middleware('auth')
    ->name('book.save');

Route::get('/saved-books', [BookController::class, 'savedBooks'])
    ->middleware('auth')
    ->name('book.saved');

Route::post('/book/{id}/unsave', [BookController::class, 'unsaveBook'])
    ->middleware('auth')
    ->name('book.unsave');

// Admin Dashboard //
// 👤 USER submit report
Route::post('/report/{bookId}', [ReportController::class, 'store'])
    ->middleware('auth')
    ->name('report.store');


// 🛡️ ADMIN ONLY ROUTES
Route::middleware(['auth', 'admin'])->group(function () {

    // view ALL reports
    Route::get('/admin/reports', [ReportController::class, 'index'])
        ->name('admin.reports');

    // update status
    Route::post('/admin/reports/{id}/update', [ReportController::class, 'updateStatus'])
        ->name('admin.reports.update');

    // Admin Report
    // View pending reports
    Route::get('/admin/reports/pending', [ReportController::class, 'pendingReports'])
        ->name('admin.reports.pending');

    // View Resolved reports
    Route::get('/admin/reports/resolved', [ReportController::class, 'resolvedReports'])
        ->name('admin.reports.resolved');

    // View Rejected reports
    Route::get('/admin/reports/rejected', [ReportController::class, 'rejectedReports'])
        ->name('admin.reports.rejected');

    // Delete Admin Report
    Route::delete('/admin/reports/{id}', [ReportController::class, 'adminDestroy'])
        ->name('admin.reports.delete');

});

// User Own Report
Route::get('/my-reports', [ReportController::class, 'myReports'])
    ->middleware('auth')
    ->name('report.my');

// Delete User Own Report
Route::delete('/report/{id}', [ReportController::class, 'destroy'])
    ->middleware('auth')
    ->name('report.delete');

// Super Admin Create Admin
Route::get('/admin/create', [AdminController::class, 'create'])
    ->name('admin.create')
    ->middleware(['auth', 'superadmin']);

Route::post('/admin/store', [AdminController::class, 'store'])
    ->name('admin.store')
    ->middleware(['auth', 'superadmin']);

// Take Book
Route::post('/request/take/{id}', [RequestController::class, 'takeBook'])
    ->name('request.take');

// Rating & Review
Route::get('/review/create/{requestId}', [ReviewController::class, 'create'])
    ->middleware('auth')
    ->name('review.create');

// Store Review
Route::post('/review/store/{requestId}', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('review.store');

// View My Review
Route::get('/my-reviews', [ReviewController::class, 'myReviews'])
    ->middleware('auth')
    ->name('review.my');

// Delete My Review
Route::delete('/review/{id}', [ReviewController::class, 'destroy'])
    ->middleware('auth')
    ->name('review.delete');

// View Rating & Review Received
Route::get('/reviews/received', [ReviewController::class, 'receivedReviews'])
    ->name('review.received');

// Display dashboard and average rating received
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// CRUD Admin List
Route::get('/admin/list', [AdminController::class, 'listAdmins'])->name('admin.list');

Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');

Route::put('/admin/update/{id}', [AdminController::class, 'update'])
    ->name('admin.update');

Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');