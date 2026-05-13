<?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\BookController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Http\Request;
    use App\Http\Controllers\ReportController;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\AIController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\ReviewController;
    use App\Http\Controllers\RequestController;

    Route::get('/test-key', function () {
        dd(env('GROQ_API_KEY'));
    });



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

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');


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

    Route::get('/ai-chat', [AIController::class, 'index'])->name('ai.chat');
    Route::post('/ai-chat/send', [AIController::class, 'send'])
        ->middleware('auth');

    Route::get('/my-reviews', [ReviewController::class, 'myReviews'])
        ->name('reviews.my');

    Route::post('/review/store/{id}', [ReviewController::class, 'store'])
        ->name('review.store');

    Route::delete('/review/delete/{id}', [ReviewController::class, 'destroy'])
        ->name('review.delete');

    Route::get('/reviews/received', [ReviewController::class, 'received'])
        ->name('reviews.received');

    Route::get('/review/create/{bookId}', [ReviewController::class, 'create'])
        ->name('review.create');

    Route::post('/request/{id}/take', [RequestController::class, 'takeBook'])
        ->middleware('auth')
        ->name('request.take');

    Route::get('/admin/list', [AdminController::class, 'listAdmins'])
        ->name('admin.list');

    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])
        ->name('admin.edit');

    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy'])
        ->name('admin.delete');

    Route::put('/admin/update/{id}', [AdminController::class, 'update'])
        ->name('admin.update');

    Route::post('/book/{id}/schedule', [BookController::class, 'storeSchedule'])
        ->middleware('auth')
        ->name('book.schedule.store');

    Route::post('/book/change-schedule/{id}', [BookController::class, 'proposeSchedule'])
        ->name('book.changeSchedule');

    Route::get('/book/propose-schedule/{id}',[BookController::class, 'showProposeSchedule'])
        ->name('book.proposeScheduleForm');

    Route::post('/book/propose-schedule/{id}',[BookController::class, 'proposeSchedule'])
        ->name('book.proposeSchedule');

    Route::get('/book/{id}/schedule/edit',[BookController::class, 'editSchedule'])
        ->name('book.schedule.edit');

    Route::post('/book/{id}/schedule/update',[BookController::class, 'updateSchedule'])
        ->name('book.schedule.update');

    Route::post('/request/cancel/{id}',[BookController::class, 'cancelRequest'])
        ->name('book.cancelRequest');