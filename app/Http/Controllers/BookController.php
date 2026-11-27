<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookRequest;
use App\Models\SavedBook;
use App\Models\Review;
use App\Models\ExchangeOffer;
use App\Mail\BookStatusMail;
use App\Mail\ExchangeMatchMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\BookSchedule;
use Illuminate\Validation\Rule;
use App\Notifications\BookRequestStatusNotification;
use App\Notifications\ExchangeMatchNotification;
use App\Notifications\ExchangeHandoverNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // 📚 Show all books
    
    public function index(Request $request)
    {
        // Existing Browse Books search and filter
        $query = Book::query();

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('subject_category')) {
            $query->where('subject_category', $request->subject_category);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Filter by listing type: Sell or Exchange
        if (in_array($request->listing_type, ['sell', 'exchange'], true)) {
            $query->where('listing_type', $request->listing_type);
        }

        // Sorting options
        $sort = $request->input('sort', 'newest');

        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;

            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $books = $query->get();

        // Exchange matches
        $exchangeMatches = collect();

        if (auth()->check()) {

            // Get current student's available Exchange listings
            $myExchangeListings = Book::with('exchangePreferences')
                ->where('user_id', auth()->id())
                ->where('listing_type', 'exchange')
                ->where('status', 'available')
                ->get();

            // Get other students' available Exchange listings
            $otherExchangeListings = Book::with('exchangePreferences', 'user')
                ->where('user_id', '!=', auth()->id())
                ->where('listing_type', 'exchange')
                ->where('status', 'available')
                ->get();

            // Check whether a listing's wanted book matches an offered book
            $matchesWantedBook = function ($preferences, $book) {

                return $preferences->contains(function ($preference) use ($book) {

                    $wantedCode = strtolower(trim($preference->wanted_subject_id));
                    $wantedName = strtolower(trim($preference->wanted_book_name));

                    $offeredCode = strtolower(trim($book->subject_id));
                    $offeredName = strtolower(trim($book->title));

                    return $wantedCode === $offeredCode
                        && $wantedName === $offeredName;
                });
            };

            // Check both directions for a reciprocal match
            foreach ($myExchangeListings as $myBook) {

                foreach ($otherExchangeListings as $otherBook) {

                    $myWantsOtherBook = $matchesWantedBook(
                        $myBook->exchangePreferences,
                        $otherBook
                    );

                    $otherWantsMyBook = $matchesWantedBook(
                        $otherBook->exchangePreferences,
                        $myBook
                    );

                    if ($myWantsOtherBook && $otherWantsMyBook) {

                        // Generate the same unique key for both students
                        $bookIds = [$myBook->id, $otherBook->id];
                        sort($bookIds);

                        $matchKey = implode('_', $bookIds);

                        // Check whether this match has already been notified
                        $alreadyNotified = DB::table('notifications')
                            ->where('type', ExchangeMatchNotification::class)
                            ->where('data->match_key', $matchKey)
                            ->exists();

                        if (!$alreadyNotified) {

                            $myStudent = auth()->user();
                            $otherStudent = $otherBook->user;

                            if ($myStudent && $otherStudent) {

                                // In-app notification for the current student
                                $myStudent->notify(new ExchangeMatchNotification(
                                    $myBook->id,
                                    $otherBook->id,
                                    $myBook->title,
                                    $otherBook->title,
                                    $otherStudent->name,
                                    $matchKey
                                ));

                                // Email for the current student
                                Mail::to($myStudent->email)->queue(
                                    new ExchangeMatchMail(
                                        $myStudent->name,
                                        $myBook->title,
                                        $otherBook->title,
                                        $otherStudent->name
                                    )
                                );

                                // In-app notification for the matched student
                                $otherStudent->notify(new ExchangeMatchNotification(
                                    $otherBook->id,
                                    $myBook->id,
                                    $otherBook->title,
                                    $myBook->title,
                                    $myStudent->name,
                                    $matchKey
                                ));

                                // Email for the matched student
                                Mail::to($otherStudent->email)->queue(
                                    new ExchangeMatchMail(
                                        $otherStudent->name,
                                        $otherBook->title,
                                        $myBook->title,
                                        $myStudent->name
                                    )
                                );
                            }
                        }

                        // Continue displaying the match on Browse Books
                        $exchangeMatches->push([
                            'my_book' => $myBook,
                            'matched_book' => $otherBook,
                        ]);
                    }
                }
            }
        }

        return view('browse', compact('books', 'exchangeMatches'));
    }


    // 📖 Show book details
    public function show($id)
    {
        $book = Book::with(['exchangePreferences', 'user'])
            ->findOrFail($id);

        $existingRequest = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->first();

        $sellerRating = Review::whereHas('book', function ($q) use ($book) {
            $q->where('user_id', $book->user_id);
        })->avg('rating');

        $sellerRating = number_format($sellerRating ?? 0, 1);

        $sellerReviews = Review::whereHas('book', function ($q) use ($book) {
            $q->where('user_id', $book->user_id);
        })->latest()->take(3)->get();

        return view('book-details', compact(
            'book',
            'existingRequest',
            'sellerRating',
            'sellerReviews'
        ));
    }

    public function showExchangeRequest($id)
    {
        // Get the Exchange listing and its wanted book preferences
        $book = Book::with(['exchangePreferences', 'user'])
            ->findOrFail($id);

        // Only Exchange listings can receive Exchange requests
        if ($book->listing_type !== 'exchange') {
            abort(404);
        }

        // Prevent students from requesting their own listing
        if ($book->user_id == auth()->id()) {
            return redirect()->route('homepage')
                ->with('error', 'You cannot request your own book.');
        }

        // Only available Exchange listings can receive requests
        if ($book->status !== 'available') {
            return redirect()->back()
                ->with('error', 'This book is no longer available.');
        }

        // Get the owner's wanted book preferences
        $preferences = $book->exchangePreferences;

        // Get the current student's available book listings
        // These can be Sell or Exchange listings
        $matchingBooks = Book::where('user_id', auth()->id())
            ->where('status', 'available')
            ->get()
            ->filter(function ($ownedBook) use ($preferences) {

                return $preferences->contains(function ($preference) use ($ownedBook) {

                    return strtolower(trim($ownedBook->subject_id))
                            === strtolower(trim($preference->wanted_subject_id))
                        && strtolower(trim($ownedBook->title))
                            === strtolower(trim($preference->wanted_book_name));

                });

            })
            ->values();

        return view('exchange-request', compact(
            'book',
            'preferences',
            'matchingBooks'
        ));
    }
   
    public function submitExchangeRequest(Request $request, $id)
    {
        // Get the Exchange listing
        $book = Book::with('exchangePreferences')->findOrFail($id);

        // Only Exchange listings can receive Exchange requests
        if ($book->listing_type !== 'exchange') {
            abort(404);
        }

        // Prevent requesting own listing
        if ($book->user_id == auth()->id()) {
            return redirect()->route('homepage')
                ->with('error', 'You cannot request your own book.');
        }

        // Check listing availability
        if ($book->status !== 'available') {
            return redirect()->back()
                ->with('error', 'This book is no longer available.');
        }

        // Validate submitted information
        $validated = $request->validate([

            'preference_id' => [
                'required',
                'integer'
            ],

            'offer_type' => [
                'required',
                'in:existing,manual'
            ],

            'offered_book_id' => [
                'required_if:offer_type,existing',
                'nullable',
                'integer'
            ],

            'manual_condition' => [
                'required_if:offer_type,manual',
                'nullable',
                'in:New,Like New,Good,Fair'
            ],

            'manual_image' => [
                'required_if:offer_type,manual',
                'nullable',
                'image',
                'max:5120'
            ],

            // Schedule selection
            'schedule_choice' => [
                'required',
                'in:owner,custom'
            ],

            // Only required when proposing a custom schedule
            'proposed_location' => [
                'required_if:schedule_choice,custom',
                'nullable',
                'string',
                'max:255'
            ],

            'proposed_date' => [
                'required_if:schedule_choice,custom',
                'nullable',
                'date',
                'after_or_equal:today'
            ],

            'proposed_time' => [
                'required_if:schedule_choice,custom',
                'nullable',
                'date_format:H:i'
            ],

            'proposed_end_time' => [
                'required_if:schedule_choice,custom',
                'nullable',
                'date_format:H:i',
                'after:proposed_time'
            ],

        ]);

        // Verify that the selected preference belongs to this Exchange listing
        $preference = $book->exchangePreferences()
            ->where('id', $validated['preference_id'])
            ->first();

        if (!$preference) {
            return back()->withErrors([
                'preference_id' => 'Invalid book preference selected.'
            ])->withInput();
        }

        // Prevent duplicate active Exchange requests
        $existingRequest = BookRequest::where('book_id', $book->id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->exists();

        if ($existingRequest) {
            return redirect('/book/' . $book->id)
                ->with('error', 'You already have an active Exchange request for this book.');
        }

        // Determine which schedule to use
        if ($validated['schedule_choice'] === 'owner') {

            // Use the Exchange listing owner's preferred schedule
            $proposedLocation = $book->meeting_location;
            $proposedDate = $book->meeting_date;
            $proposedTime = $book->meeting_time;
            $proposedEndTime = $book->meeting_end_time;

            // Make sure the owner has provided a complete schedule
            if (
                empty($proposedLocation) ||
                empty($proposedDate) ||
                empty($proposedTime) ||
                empty($proposedEndTime)
            ) {
                return back()->withErrors([
                    'schedule_choice' => 'The book owner has not provided a complete meeting schedule. Please propose your own schedule.'
                ])->withInput();
            }

            $scheduleType = 'owner';

        } else {

            // Use the requester's proposed schedule
            $proposedLocation = $validated['proposed_location'];
            $proposedDate = $validated['proposed_date'];
            $proposedTime = $validated['proposed_time'];
            $proposedEndTime = $validated['proposed_end_time'];

            $scheduleType = 'requester';
        }

        // Prepare offered book details
        $offeredTitle = $preference->wanted_book_name;
        $offeredSubject = $preference->wanted_subject_id;
        $offeredImage = null;

        if ($validated['offer_type'] === 'existing') {

            // Get the selected existing listing owned by the current student
            $ownedBook = Book::where('id', $validated['offered_book_id'])
                ->where('user_id', auth()->id())
                ->where('status', 'available')
                ->first();

            if (!$ownedBook) {
                return back()->withErrors([
                    'offered_book_id' => 'The selected book listing is unavailable.'
                ])->withInput();
            }

            // Verify that the selected listing matches the wanted book
            $matchesTitle = strtolower(trim($ownedBook->title))
                === strtolower(trim($preference->wanted_book_name));

            $matchesSubject = strtolower(trim($ownedBook->subject_id))
                === strtolower(trim($preference->wanted_subject_id));

            if (!$matchesTitle || !$matchesSubject) {
                return back()->withErrors([
                    'offered_book_id' => 'The selected book does not match the requested preference.'
                ])->withInput();
            }

            // Copy book details from the original listing
            $offeredTitle = $ownedBook->title;
            $offeredSubject = $ownedBook->subject_id;
            $offeredCondition = $ownedBook->condition;

            // Copy the image into a separate folder for the Exchange offer
            if (
                $ownedBook->image &&
                Storage::disk('public')->exists($ownedBook->image)
            ) {
                $extension = pathinfo($ownedBook->image, PATHINFO_EXTENSION);

                $newImagePath = 'exchange-offers/' .
                    uniqid('exchange_', true) . '.' . $extension;

                Storage::disk('public')->copy(
                    $ownedBook->image,
                    $newImagePath
                );

                $offeredImage = $newImagePath;
            }

        } else {

            // Manual offer: book name and subject code come from the preference
            $offeredCondition = $validated['manual_condition'];

            $offeredImage = $request->file('manual_image')
                ->store('exchange-offers', 'public');
        }

        // Save the Exchange request and offer together
        $bookRequest = DB::transaction(function () use (
            $book,
            $offeredTitle,
            $offeredSubject,
            $offeredCondition,
            $offeredImage,
            $proposedLocation,
            $proposedDate,
            $proposedTime,
            $proposedEndTime,
            $scheduleType
        ) {

            // Create the main Exchange request
            $bookRequest = BookRequest::create([

                'book_id' => $book->id,

                // Keep the original listing separate from the Exchange offer
                'offered_book_id' => null,

                'requester_id' => auth()->id(),

                'owner_id' => $book->user_id,

                'status' => $scheduleType === 'requester'
                    ? 'negotiation'
                    : 'pending',

                'proposed_location' => $proposedLocation,

                'proposed_date' => $proposedDate,

                'proposed_time' => $proposedTime,

                'proposed_end_time' => $proposedEndTime,

                'schedule_type' => $scheduleType,

            ]);

            // Save the offered book snapshot
            ExchangeOffer::create([

                'book_request_id' => $bookRequest->id,

                'offered_book_id' => null,

                'title' => $offeredTitle,

                'subject_id' => $offeredSubject,

                'condition' => $offeredCondition,

                'image' => $offeredImage,

            ]);

            return $bookRequest;

        });

        // Notify the book owner about the new Exchange request.
        $owner = User::find($bookRequest->owner_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($bookRequest, 'pending'));
        }

        return redirect()->route('homepage')
            ->with('success', 'Your Exchange request has been submitted successfully.');
    }

    // ✏️ Edit
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('book-edit', compact('book'));
    }

    // 🔄 Update
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'booktitle' => 'required',
            'bookdescription' => 'required',
            'condition' => 'required',
            'subject_id' => 'required',
            'subject_category' => ['required', 'string', Rule::in(Book::SUBJECT_CATEGORIES)],
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'meeting_location' => 'nullable|string|max:255',
            'meeting_date' => 'nullable|date',
            'meeting_time' => 'nullable|date_format:H:i',
            'meeting_end_time' => 'nullable|date_format:H:i|after:meeting_time',
        ]);

        $data = [
            'title' => $request->booktitle,
            'description' => $request->bookdescription,
            'condition' => $request->condition,
            'subject_id' => $request->subject_id,
            'subject_category' => $request->subject_category,
            'price' => $request->price,
            'meeting_location' => $request->meeting_location,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'meeting_end_time' => $request->meeting_end_time,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book->update($data);

        return redirect('/homepage')->with('success', 'Book updated!');
    }

    // ❌ Delete
    public function destroy($id)
    {
        Book::findOrFail($id)->delete();

        return redirect('/homepage')->with('success', 'Book deleted!');
    }

    // 💾 Store book

    public function store(Request $request)
    {
        $validated = $request->validate([
            'listing_type' => ['required', Rule::in(['sell', 'exchange'])],

            // Common book information
            'booktitle' => 'required|string|max:255',
            'bookdescription' => 'required|string',
            'condition' => 'required|string',
            'subject_id' => 'required|string|max:255',
            'subject_category' => [
                'required',
                'string',
                Rule::in(Book::SUBJECT_CATEGORIES)
            ],
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',

            // Sell information
            'price' => 'required_if:listing_type,sell|nullable|numeric|min:0',

            // Exchange preferences
            'exchange_preferences' => 'required_if:listing_type,exchange|array|min:1|max:3',
            'exchange_preferences.*.wanted_subject_id' => 'required|string|max:255',
            'exchange_preferences.*.wanted_book_name' => 'required|string|max:255',

            // Meeting preferences
            'meeting_location' => 'required|string|max:255',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_end_time' => 'required|date_format:H:i|after:meeting_time',
        ]);

        $book = Book::create([
            'title' => $validated['booktitle'],
            'description' => $validated['bookdescription'],
            'condition' => $validated['condition'],
            'subject_id' => $validated['subject_id'],
            'subject_category' => $validated['subject_category'],
            'image' => $request->file('image')->store('books', 'public'),
            'user_id' => auth()->id(),
            'status' => 'available',
            'listing_type' => $validated['listing_type'],
            'price' => $validated['listing_type'] === 'sell'
                ? $validated['price']
                : null,

            'meeting_location' => $validated['meeting_location'],
            'meeting_date' => $validated['meeting_date'],
            'meeting_time' => $validated['meeting_time'],
            'meeting_end_time' => $validated['meeting_end_time'],
        ]);

        // Save wanted books for Exchange listings
        if ($validated['listing_type'] === 'exchange') {
            foreach ($validated['exchange_preferences'] as $preference) {
                $book->exchangePreferences()->create([
                    'wanted_subject_id' => $preference['wanted_subject_id'],
                    'wanted_book_name' => $preference['wanted_book_name'],
                ]);
            }
        }

        // Check for mutual exchange matches immediately after publishing
        if ($validated['listing_type'] === 'exchange') {

            $myStudent = auth()->user();

            $otherExchangeListings = Book::with(['exchangePreferences', 'user'])
                ->where('user_id', '!=', auth()->id())
                ->where('listing_type', 'exchange')
                ->where('status', 'available')
                ->get();

            $matchesWantedBook = function ($preferences, $targetBook) {
                return $preferences->contains(function ($preference) use ($targetBook) {
                    return strtolower(trim($preference->wanted_subject_id))
                            === strtolower(trim($targetBook->subject_id))
                        && strtolower(trim($preference->wanted_book_name))
                            === strtolower(trim($targetBook->title));
                });
            };

            foreach ($otherExchangeListings as $otherBook) {

                $myWantsOtherBook = $matchesWantedBook(
                    $book->exchangePreferences,
                    $otherBook
                );

                $otherWantsMyBook = $matchesWantedBook(
                    $otherBook->exchangePreferences,
                    $book
                );

                if ($myWantsOtherBook && $otherWantsMyBook) {

                    $bookIds = [$book->id, $otherBook->id];
                    sort($bookIds);

                    $matchKey = implode('_', $bookIds);

                    $alreadyNotified = DB::table('notifications')
                        ->where('type', ExchangeMatchNotification::class)
                        ->where('data->match_key', $matchKey)
                        ->exists();

                    if (!$alreadyNotified && $otherBook->user) {

                        // Notify the student who submitted the new listing
                        $myStudent->notify(new ExchangeMatchNotification(
                            $book->id,
                            $otherBook->id,
                            $book->title,
                            $otherBook->title,
                            $otherBook->user->name,
                            $matchKey
                        ));

                        Mail::to($myStudent->email)->queue(
                            new ExchangeMatchMail(
                                $myStudent->name,
                                $book->title,
                                $otherBook->title,
                                $otherBook->user->name
                            )
                        );

                        // Notify the student with the existing listing
                        $otherBook->user->notify(new ExchangeMatchNotification(
                            $otherBook->id,
                            $book->id,
                            $otherBook->title,
                            $book->title,
                            $myStudent->name,
                            $matchKey
                        ));

                        Mail::to($otherBook->user->email)->queue(
                            new ExchangeMatchMail(
                                $otherBook->user->name,
                                $otherBook->title,
                                $book->title,
                                $myStudent->name
                            )
                        );
                    }
                }
            }
        }

        return redirect('/book/create')
            ->with('success', 'Your book listing has been published successfully!');
    }


    // 📚 My listings
    public function myListings()
    {
        $books = Book::where('user_id', auth()->id())->get();
        return view('books.my-listings', compact('books'));
    }

    // 🤝 REQUEST BOOK (FIXED)
    public function requestBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id == auth()->id()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'You cannot request your own book.'], 422);
            }

            return back()->with('error', 'You cannot request your own book.');
        }

        if ($book->status !== 'available') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'This book is no longer available.',
                    'alternatives' => $this->similarAvailableBooks($book, auth()->id()),
                ], 422);
            }

            return back()->with('error', 'Book not available.');
        }

        $existingRequest = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->first();

        if ($existingRequest) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You already have an active request for this book.',
                    'alternatives' => $this->similarAvailableBooks($book, auth()->id()),
                ], 422);
            }

            return back()->with('error', 'You already requested this book.');
        }

        $bookRequest = BookRequest::create([
            'book_id' => $id,
            'requester_id' => auth()->id(),
            'owner_id' => $book->user_id,
            'status' => 'pending'
        ]);

        // ❌ IMPORTANT: DO NOT create schedule here anymore

        $owner = User::find($book->user_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($bookRequest, 'pending'));
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Book request sent! The seller has been notified.',
                'status' => 'pending',
            ], 201);
        }

        return back()->with('success', 'Book request sent!');
    }

    private function similarAvailableBooks(Book $book, int $studentId): array
    {
        $activeBookIds = BookRequest::where('requester_id', $studentId)
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->pluck('book_id');

        $candidateBooks = Book::query()
            ->where('status', 'available')
            ->where('user_id', '!=', $studentId)
            ->where('id', '!=', $book->id)
            ->whereNotIn('id', $activeBookIds)
            ->latest()
            ->limit(100)
            ->get();

        $targetTokens = $this->similarityTokens($book->title . ' ' . $book->description);
        $targetSubjectId = strtolower(trim((string) $book->subject_id));
        $targetCategory = strtolower(trim((string) $book->subject_category));

        return $candidateBooks->map(function (Book $candidate) use ($targetTokens, $targetSubjectId, $targetCategory) {
            $candidateTokens = $this->similarityTokens($candidate->title . ' ' . $candidate->description);
            $sharedTokens = array_values(array_intersect($targetTokens, $candidateTokens));
            $sameSubjectId = $targetSubjectId !== ''
                && strtolower(trim((string) $candidate->subject_id)) === $targetSubjectId;
            $sameCategory = $targetCategory !== ''
                && strtolower(trim((string) $candidate->subject_category)) === $targetCategory;

            $score = ($sameSubjectId ? 8 : 0)
                + ($sameCategory ? 4 : 0)
                + min(count($sharedTokens), 3);

            if ($sameSubjectId) {
                $reason = 'Same subject ID: ' . $candidate->subject_id;
            } elseif ($sameCategory) {
                $reason = 'Same subject category';
            } elseif ($sharedTokens !== []) {
                $reason = 'Related topics: ' . implode(', ', array_slice($sharedTokens, 0, 3));
            } else {
                $reason = null;
            }

            return [
                'book' => $candidate,
                'score' => $score,
                'reason' => $reason,
            ];
        })
            ->filter(fn (array $match) => $match['score'] > 0)
            ->sortByDesc('score')
            ->take(3)
            ->map(fn (array $match) => [
                'id' => $match['book']->id,
                'title' => $match['book']->title,
                'subject_category' => $match['book']->subject_category,
                'subject_id' => $match['book']->subject_id,
                'price' => $match['book']->price,
                'reason' => $match['reason'],
            ])
            ->values()
            ->all();
    }

    private function similarityTokens(string $text): array
    {
        $tokens = preg_split('/[^a-z0-9]+/i', strtolower($text)) ?: [];
        $stopWords = ['about', 'after', 'book', 'books', 'covers', 'from', 'into', 'that', 'this', 'with', 'their', 'your', 'and', 'the'];

        return array_values(array_unique(array_filter(
            $tokens,
            fn (string $token) => strlen($token) >= 4 && !in_array($token, $stopWords, true)
        )));
    }

    public function proposeScheduleFromChat(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id == auth()->id()) {
            return response()->json(['message' => 'You cannot propose a schedule for your own book.'], 422);
        }

        if ($book->status !== 'available') {
            return response()->json(['message' => 'This book is no longer available.'], 422);
        }

        $validated = $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date|after_or_equal:today',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        $bookRequest = BookRequest::where('book_id', $book->id)
            ->where('requester_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if (!$bookRequest) {
            return response()->json([
                'message' => 'Your pending request was not found. Please check Sent Requests before trying again.',
            ], 422);
        }

        $bookRequest->update(array_merge($validated, [
            'status' => 'negotiation',
            'schedule_type' => 'buyer',
        ]));

        return response()->json([
            'message' => 'Your proposed meeting schedule has been sent to the seller.',
            'schedule' => $validated,
        ], 201);
    }

    public function showProposeSchedule(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id == auth()->id()) {
            return redirect('/book/' . $book->id)
                ->with('error', 'You cannot propose a schedule for your own book.');
        }

        $proposal = BookRequest::where('book_id', $book->id)
            ->where('requester_id', auth()->id())
            ->where('status', 'negotiation')
            ->first();

        $returnTo = $request->query('return_to') === 'sent-requests'
            ? 'sent-requests'
            : 'book-details';

        return view('propose-schedule', compact('book', 'proposal', 'returnTo'));

    }
    public function proposeSchedule(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // ❌ Prevent requesting own book
        if ($book->user_id == auth()->id()) {
            return back()->with('error', 'You cannot request your own book.');
        }

        if ($book->status !== 'available') {
            return back()->with('error', 'This book is no longer available.');
        }

        // ✅ Validate
        $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        // ❌ Prevent duplicate request
        $existingRequest = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'negotiation'])
            ->first();

        if ($existingRequest) {
            return redirect('/book/' . $book->id)
                ->with('error', 'You already have an active request for this book.');
        }

        // Create negotiation request
        $bookRequest = BookRequest::create([
            'book_id' => $book->id,
            'requester_id' => auth()->id(),
            'owner_id' => $book->user_id,

            'status' => 'negotiation',

            'proposed_location' => $request->proposed_location,
            'proposed_date' => $request->proposed_date,
            'proposed_time' => $request->proposed_time,
            'proposed_end_time' => $request->proposed_end_time,

            'schedule_type' => 'buyer'
        ]);

        // Send email to the book owner
        $owner = User::find($bookRequest->owner_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($bookRequest, 'pending'));
        }

        return redirect('/homepage')
            ->with('success', 'New schedule proposed to seller!');
    }

    public function updateProposedSchedule(Request $request, $id)
    {
        $validated = $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        $proposal = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->where('status', 'negotiation')
            ->firstOrFail();

        $proposal->update([
            'proposed_location' => $validated['proposed_location'],
            'proposed_date' => $validated['proposed_date'],
            'proposed_time' => $validated['proposed_time'],
            'proposed_end_time' => $validated['proposed_end_time'],
        ]);

        // Send updated schedule email to Student B (book owner)
        $owner = User::find($proposal->owner_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($proposal, 'sell_schedule_proposed'));
        }

        $redirect = $request->input('return_to') === 'sent-requests'
            ? redirect()->route('sent.requests')
            : redirect('/book/' . $id);

        return $redirect->with('success', 'Your proposed schedule has been updated.');
    }

    public function deleteProposedSchedule(Request $request, $id)
    {
        $proposal = BookRequest::where('book_id', $id)
            ->where('requester_id', auth()->id())
            ->where('status', 'negotiation')
            ->firstOrFail();

        // Keep the book request, but remove the buyer's proposed schedule.
        // The book's meeting fields still contain the seller's original schedule.
        $proposal->update([
            'status' => 'pending',
            'proposed_location' => null,
            'proposed_date' => null,
            'proposed_time' => null,
            'proposed_end_time' => null,
            'schedule_type' => 'seller',
        ]);

        $redirect = $request->input('return_to') === 'sent-requests'
            ? redirect()->route('sent.requests')
            : redirect('/book/' . $id);

        return $redirect->with('success', 'Your proposal was removed. The request will use the seller’s original schedule.');
    }

    
    // Received Requests
    public function inbox()
    {
        $requests = BookRequest::where('owner_id', auth()->id())
        ->where(function ($query) {
            $query->whereNull('hidden_by')
                ->orWhereJsonDoesntContain('hidden_by', auth()->id());
        })
            ->with([
                'book',
                'requester',
                'exchangeOffer'
            ])
            ->latest()
            ->get();

        return view('inbox', compact('requests'));
    }

    // Sent Requests
    public function sentRequests()
    {
        $requests = BookRequest::where('requester_id', auth()->id())
        ->where(function ($query) {
            $query->whereNull('hidden_by')
                ->orWhereJsonDoesntContain('hidden_by', auth()->id());
        })
            ->with([
                'book',
                'owner',
                'exchangeOffer'
            ])
            ->latest()
            ->get();

        return view('sent-requests', compact('requests'));
    }

    // 🟢 CREATE / UPDATE SCHEDULE (SELLER ONLY)
    public function storeSchedule(Request $request, $bookId)
    {
        $request->validate([
            'location' => 'required|string',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_end_time' => 'required|date_format:H:i|after:meeting_time',
        ]);

        $book = Book::findOrFail($bookId);

        BookSchedule::updateOrCreate(
            ['book_id' => $book->id],
            [
                'seller_id' => auth()->id(),
                'location' => $request->location,
                'meeting_date' => $request->meeting_date,
                'meeting_time' => $request->meeting_time,
                'meeting_end_time' => $request->meeting_end_time,
                'status' => 'available',
                'buyer_id' => null
            ]
        );

        return back()->with('success', 'Availability saved!');
    }

    // ✅ APPROVE REQUEST
    
    public function approveRequest($id)
    {
        $bookRequest = BookRequest::with('book')->findOrFail($id);

        // Only the book owner (Student B) can approve.
        if ($bookRequest->owner_id != auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $book = $bookRequest->book;

        // This method is strictly for Sell requests.
        // Exchange requests must use acceptExchangeSchedule().
        if (!$book || $book->listing_type !== 'sell') {
            abort(404);
        }

        // Student B can approve either:
        // 1. A normal pending request.
        // 2. Student A's latest proposed schedule.
        $isPending = $bookRequest->status === 'pending';

        $isBuyerProposal =
            $bookRequest->status === 'negotiation' &&
            $bookRequest->schedule_type === 'buyer';

        if (!$isPending && !$isBuyerProposal) {
            return back()->with('error', 'This request cannot be approved at this stage.');
        }

        if ($book->status !== 'available') {
            return back()->with('error', 'This book is no longer available.');
        }

        // Determine the final agreed schedule.
        if ($isBuyerProposal) {
            $finalLocation = $bookRequest->proposed_location;
            $finalDate = $bookRequest->proposed_date;
            $finalTime = $bookRequest->proposed_time;
            $finalEndTime = $bookRequest->proposed_end_time;
        } else {
            // Keep the original listing schedule.
            $finalLocation = $book->meeting_location;
            $finalDate = $book->meeting_date;
            $finalTime = $book->meeting_time;
            $finalEndTime = $book->meeting_end_time;
        }

        // Update the book and request together.
        DB::transaction(function () use (
            $book,
            $bookRequest,
            $finalLocation,
            $finalDate,
            $finalTime,
            $finalEndTime
        ) {
            $book->update([
                'meeting_location' => $finalLocation,
                'meeting_date' => $finalDate,
                'meeting_time' => $finalTime,
                'meeting_end_time' => $finalEndTime,
                'status' => 'reserved',
            ]);

            $bookRequest->update([
                'status' => 'approved',
                'is_taken' => 1,
            ]);
        });

        // Refresh the approved request before sending notifications.
        $bookRequest->refresh();

        $requester = User::find($bookRequest->requester_id);

        if ($requester) {
            $requester->notify(
                new BookRequestStatusNotification($bookRequest)
            );

            Mail::to($requester->email)
                ->queue(new BookStatusMail($bookRequest, 'approved'));
        }

        return back()->with('success', 'Request approved successfully!');
    }


    public function counterSellSchedule(Request $request, $id)
    {
        $bookRequest = BookRequest::with('book')->findOrFail($id);

        // Only the book owner can propose another schedule.
        if ($bookRequest->owner_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $book = $bookRequest->book;

        // This method is only for Sell requests.
        if (!$book || $book->listing_type === 'exchange') {
            abort(404);
        }

        // The request must still be active.
        if (!in_array($bookRequest->status, ['pending', 'negotiation'])) {
            return back()->with('error', 'This request cannot receive another schedule.');
        }

        // If the buyer has already proposed a schedule,
        // the seller can counter that proposal.
        if (
            $bookRequest->status === 'negotiation' &&
            $bookRequest->schedule_type !== 'buyer'
        ) {
            return back()->with('error', 'You cannot counter your own latest proposal.');
        }

        if ($book->status !== 'available') {
            return back()->with('error', 'This book is no longer available.');
        }

        $validated = $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date|after_or_equal:today',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        // Keep the same request, but save the seller's latest proposal.
        $bookRequest->update([
            'proposed_location' => $validated['proposed_location'],
            'proposed_date' => $validated['proposed_date'],
            'proposed_time' => $validated['proposed_time'],
            'proposed_end_time' => $validated['proposed_end_time'],
            'status' => 'negotiation',
            'schedule_type' => 'seller',
        ]);

        // Notify the requester about the seller's new proposed schedule.
        $requester = User::find($bookRequest->requester_id);

        if ($requester) {
            Mail::to($requester->email)
                ->queue(new BookStatusMail($bookRequest, 'sell_schedule_proposed'));
        }

        return back()->with('success', 'Your proposed meeting schedule has been sent to the student.');
    }

    public function acceptSellSchedule($id)
    {
        $bookRequest = BookRequest::with(['book', 'owner'])->findOrFail($id);

        // Only the requester (Student A) can accept the schedule.
        if ($bookRequest->requester_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $book = $bookRequest->book;

        // This method is only for Sell requests.
        if (!$book || $book->listing_type === 'exchange') {
            abort(404);
        }

        // Student A can only accept Student B's latest proposal.
        if (
            $bookRequest->status !== 'negotiation' ||
            $bookRequest->schedule_type !== 'seller'
        ) {
            return back()->with('error', 'There is no seller schedule waiting for your response.');
        }

        if ($book->status !== 'available') {
            return back()->with('error', 'This book is no longer available.');
        }

        // Save the accepted schedule to the book.
        $book->update([
            'meeting_location' => $bookRequest->proposed_location,
            'meeting_date' => $bookRequest->proposed_date,
            'meeting_time' => $bookRequest->proposed_time,
            'meeting_end_time' => $bookRequest->proposed_end_time,
            'status' => 'reserved',
        ]);

        // Approve the existing request.
        $bookRequest->update([
            'status' => 'approved',
            'is_taken' => 1,
        ]);

        // Notify Student B.
        $owner = User::find($bookRequest->owner_id);

        if ($owner) {
            $owner->notify(new BookRequestStatusNotification($bookRequest));

            Mail::to($owner->email)
                ->queue(new BookStatusMail($bookRequest, 'approved'));
        }

        return back()->with('success', 'You have accepted the seller’s proposed meeting schedule.');
    }

    public function counterSellScheduleByBuyer(Request $request, $id)
    {
        $bookRequest = BookRequest::with('book')->findOrFail($id);

        // Only the requester (Student A) can propose another schedule.
        if ($bookRequest->requester_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $book = $bookRequest->book;

        // This method is only for Sell requests.
        if (!$book || $book->listing_type === 'exchange') {
            abort(404);
        }

        // Student A can only counter Student B's latest proposal.
        if (
            $bookRequest->status !== 'negotiation' ||
            $bookRequest->schedule_type !== 'seller'
        ) {
            return back()->with('error', 'There is no seller proposal to respond to.');
        }

        if ($book->status !== 'available') {
            return back()->with('error', 'This book is no longer available.');
        }

        $validated = $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date|after_or_equal:today',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        // Keep the same request and save Student A's latest proposal.
        $bookRequest->update([
            'proposed_location' => $validated['proposed_location'],
            'proposed_date' => $validated['proposed_date'],
            'proposed_time' => $validated['proposed_time'],
            'proposed_end_time' => $validated['proposed_end_time'],
            'status' => 'negotiation',
            'schedule_type' => 'buyer',
        ]);

        // Notify the book owner about the buyer's new proposed schedule.
        $owner = User::find($bookRequest->owner_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($bookRequest, 'sell_schedule_proposed'));
        }

        return back()->with('success', 'Your new proposed meeting schedule has been sent to the seller.');
    }

    // ❌ REJECT
    public function rejectRequest($id)
    {
        $request = BookRequest::findOrFail($id);

        if ($request->owner_id != auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $request->update(['status' => 'rejected']);

        $request->book->update(['status' => 'available']);

        // 📧 SEND EMAIL TO REQUESTER
        $requester = User::find($request->requester_id);

        if ($requester) {
            $requester->notify(new BookRequestStatusNotification($request));
            Mail::to($requester->email)
                ->queue(new BookStatusMail($request, 'rejected'));
        }

        return back()->with('success', 'Rejected!');
    }

    // 📌 SAVED BOOKS
    
    // ==========================================
    // EXCHANGE REQUEST WORKFLOW
    // ==========================================

    // Student B: Accept Exchange using the current proposed schedule
    public function acceptExchange($id)
    {
        $exchangeRequest = BookRequest::with('book')->findOrFail($id);

        if ($exchangeRequest->owner_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if (!$exchangeRequest->book ||
            $exchangeRequest->book->listing_type !== 'exchange') {
            abort(404);
        }

        if (!in_array($exchangeRequest->status, ['pending', 'negotiation'])) {
            return back()->with('error', 'This Exchange request cannot be accepted.');
        }

        if ($exchangeRequest->book->status !== 'available') {
            return back()->with('error', 'This book is no longer available for exchange.');
        }

        // If negotiating, the owner can accept only the requester's latest proposal.
        if (
            $exchangeRequest->status === 'negotiation' &&
            $exchangeRequest->schedule_type === 'owner'
        ) {
            return back()->with('error', 'You cannot accept your own schedule proposal.');
        }

        if (
            empty($exchangeRequest->proposed_location) ||
            empty($exchangeRequest->proposed_date) ||
            empty($exchangeRequest->proposed_time) ||
            empty($exchangeRequest->proposed_end_time)
        ) {
            return back()->with('error', 'A complete meeting schedule is required.');
        }

        DB::transaction(function () use ($exchangeRequest) {
            $exchangeRequest->book->update([
                'status' => 'reserved',
            ]);

            $exchangeRequest->update([
                'status' => 'approved',
                'requester_confirmed_handover' => false,
                'owner_confirmed_handover' => false,
            ]);
        });

        // Refresh the approved Exchange request before sending notifications.
        $exchangeRequest->refresh();

        $requester = User::find($exchangeRequest->requester_id);

        if ($requester) {
            $requester->notify(
                new BookRequestStatusNotification($exchangeRequest)
            );

            Mail::to($requester->email)
                ->queue(new BookStatusMail($exchangeRequest, 'approved'));
        }

        return back()->with('success', 'Exchange accepted. The meeting schedule is confirmed.');
    }


    // Student B or Student A: Propose another meeting schedule
    public function counterExchangeSchedule(Request $request, $id)
    {
        $validated = $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date|after_or_equal:today',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        $exchangeRequest = BookRequest::with('book')->findOrFail($id);

        if (!$exchangeRequest->book ||
            $exchangeRequest->book->listing_type !== 'exchange') {
            abort(404);
        }

        $isOwner = $exchangeRequest->owner_id == auth()->id();
        $isRequester = $exchangeRequest->requester_id == auth()->id();

        if (!$isOwner && !$isRequester) {
            return back()->with('error', 'Unauthorized action.');
        }

        $canPropose = false;

        if ($isOwner && $exchangeRequest->status === 'pending') {
            $canPropose = true;
        }

        if (
            $isOwner &&
            $exchangeRequest->status === 'negotiation' &&
            $exchangeRequest->schedule_type === 'requester'
        ) {
            $canPropose = true;
        }

        if (
            $isRequester &&
            $exchangeRequest->status === 'negotiation' &&
            $exchangeRequest->schedule_type === 'owner'
        ) {
            $canPropose = true;
        }

        if (!$canPropose) {
            return back()->with('error', 'You cannot propose another schedule at this stage.');
        }

        if ($exchangeRequest->book->status !== 'available') {
            return back()->with('error', 'This book is no longer available for exchange.');
        }

        $exchangeRequest->update(array_merge($validated, [
            'status' => 'negotiation',
            'schedule_type' => $isOwner ? 'owner' : 'requester',
        ]));

        // Email the other student about the new Exchange schedule proposal.
        $otherStudent = $isOwner
            ? User::find($exchangeRequest->requester_id)
            : User::find($exchangeRequest->owner_id);

        if ($otherStudent) {
            Mail::to($otherStudent->email)
                ->queue(new BookStatusMail($exchangeRequest, 'exchange_schedule_proposed'));
        }

        return back()->with('success', 'Your new meeting schedule has been proposed.');
    }


    // Student A: Update their own Exchange proposed schedule
    public function updateExchangeProposedSchedule(Request $request, $id)
    {
        $validated = $request->validate([
            'proposed_location' => 'required|string|max:255',
            'proposed_date' => 'required|date|after_or_equal:today',
            'proposed_time' => 'required|date_format:H:i',
            'proposed_end_time' => 'required|date_format:H:i|after:proposed_time',
        ]);

        $exchangeRequest = BookRequest::with('book')->findOrFail($id);

        if (
            !$exchangeRequest->book ||
            $exchangeRequest->book->listing_type !== 'exchange'
        ) {
            abort(404);
        }

        // Only Student A can manage their own proposal.
        if (
            $exchangeRequest->requester_id != auth()->id() ||
            !in_array($exchangeRequest->status, ['pending', 'negotiation']) ||
            $exchangeRequest->schedule_type !== 'requester'
        ) {
            return back()->with('error', 'You cannot edit this proposed schedule.');
        }

        $exchangeRequest->update($validated);

        // Send email to Student B (book owner)
        $owner = User::find($exchangeRequest->owner_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($exchangeRequest, 'exchange_schedule_proposed'));
        }

        return back()->with('success', 'Your Exchange proposed schedule has been updated.');
    }

    // Student A: Delete their own Exchange proposed schedule
    public function deleteExchangeProposedSchedule($id)
    {
        $exchangeRequest = BookRequest::with('book')->findOrFail($id);

        if (
            !$exchangeRequest->book ||
            $exchangeRequest->book->listing_type !== 'exchange'
        ) {
            abort(404);
        }

        // Only Student A can delete their own proposal.
        if (
            $exchangeRequest->requester_id != auth()->id() ||
            !in_array($exchangeRequest->status, ['pending', 'negotiation']) ||
            $exchangeRequest->schedule_type !== 'requester'
        ) {
            return back()->with('error', 'You cannot delete this proposed schedule.');
        }

        $exchangeRequest->update([
            'proposed_location' => null,
            'proposed_date' => null,
            'proposed_time' => null,
            'proposed_end_time' => null,
            'status' => 'pending',
            'schedule_type' => 'owner',
        ]);

        return back()->with('success', 'Your proposed schedule has been deleted. Requester preferred schedule is restored.');
    }

    // Student A: Accept Student B's latest schedule proposal
    public function acceptExchangeSchedule($id)
    {
        $exchangeRequest = BookRequest::with('book')->findOrFail($id);

        if ($exchangeRequest->requester_id != auth()->id()) {
            return back()->with('error', 'Only the requester can accept this proposal.');
        }

        if (
            !$exchangeRequest->book ||
            $exchangeRequest->book->listing_type !== 'exchange'
        ) {
            abort(404);
        }

        if (
            $exchangeRequest->status !== 'negotiation' ||
            $exchangeRequest->schedule_type !== 'owner'
        ) {
            return back()->with('error', 'There is no schedule proposal waiting for your acceptance.');
        }

        if ($exchangeRequest->book->status !== 'available') {
            return back()->with('error', 'This book is no longer available for exchange.');
        }

        DB::transaction(function () use ($exchangeRequest) {
            $exchangeRequest->book->update([
                'status' => 'reserved',
            ]);

            $exchangeRequest->update([
                'status' => 'approved',
                'requester_confirmed_handover' => false,
                'owner_confirmed_handover' => false,
            ]);
        });

        // Notify the book owner that the requester accepted the proposed schedule.
        $owner = User::find($exchangeRequest->owner_id);

        if ($owner) {
            Mail::to($owner->email)
                ->queue(new BookStatusMail($exchangeRequest, 'exchange_schedule_accepted'));
        }

        return back()->with('success', 'Schedule accepted. Your Exchange is confirmed.');
    }


   
    // Student B: Reject Exchange request
    public function rejectExchange($id)
    {
        $exchangeRequest = BookRequest::with('book')->findOrFail($id);

        if ($exchangeRequest->owner_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        if (
            !$exchangeRequest->book ||
            $exchangeRequest->book->listing_type !== 'exchange'
        ) {
            abort(404);
        }

        if (!in_array($exchangeRequest->status, ['pending', 'negotiation'])) {
            return back()->with('error', 'This Exchange request cannot be rejected.');
        }

        $exchangeRequest->update([
            'status' => 'rejected',
        ]);

        // EMAIL STUDENT A (REQUESTER)
        $requester = User::find($exchangeRequest->requester_id);

        if ($requester) {
            Mail::to($requester->email)
                ->queue(new BookStatusMail($exchangeRequest, 'rejected'));
        }

        return back()->with('success', 'Exchange request rejected.');
    }
    
    // Both Student: Cancel Exchange
    public function cancelExchange($id)
    {
        $exchangeRequest = BookRequest::with(['book', 'exchangeOffer'])->findOrFail($id);

        $isRequester = $exchangeRequest->requester_id == auth()->id();
        $isOwner = $exchangeRequest->owner_id == auth()->id();

        // Allow only Student A or Student B
        if (!$isRequester && !$isOwner) {
            return back()->with('error', 'Unauthorized action.');
        }

        if (
            !$exchangeRequest->book ||
            $exchangeRequest->book->listing_type !== 'exchange'
        ) {
            abort(404);
        }

        if (!in_array($exchangeRequest->status, ['pending', 'negotiation', 'approved'])) {
            return back()->with('error', 'This Exchange request cannot be cancelled.');
        }

        DB::transaction(function () use ($exchangeRequest) {

            $lockedRequest = BookRequest::where('id', $exchangeRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!in_array($lockedRequest->status, ['pending', 'negotiation', 'approved'])) {
                return;
            }

            // Cancellation is not allowed once either student confirms handover
            if (
                $lockedRequest->requester_confirmed_handover ||
                $lockedRequest->owner_confirmed_handover
            ) {
                return;
            }

            // Release the exchange listing if it was already approved
            if ($lockedRequest->status === 'approved') {
                $lockedRequest->book()->update([
                    'status' => 'available',
                ]);
            }

            $lockedRequest->update([
                'status' => 'cancelled',
            ]);
        });

        $exchangeRequest->refresh();

        if ($exchangeRequest->status !== 'cancelled') {
            return back()->with('error', 'This Exchange cannot be cancelled.');
        }

        // Email the other student about the cancellation.
        $otherStudent = $isRequester
            ? User::find($exchangeRequest->owner_id)
            : User::find($exchangeRequest->requester_id);

        if ($otherStudent) {
            Mail::to($otherStudent->email)
                ->queue(new BookStatusMail(
                    $exchangeRequest,
                    'cancelled',
                    false,
                    auth()->user()->name
                ));
        }

        return back()->with('success', 'Exchange request cancelled successfully.');
    }
    
    // Both students: Confirm physical book handover
    public function confirmExchangeHandover($id)
    {
        $exchangeRequest = BookRequest::with([
            'book',
            'requester',
            'owner'
        ])->findOrFail($id);

        if (
            !$exchangeRequest->book ||
            $exchangeRequest->book->listing_type !== 'exchange'
        ) {
            abort(404);
        }

        $isRequester = $exchangeRequest->requester_id == auth()->id();
        $isOwner = $exchangeRequest->owner_id == auth()->id();

        if (!$isRequester && !$isOwner) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($exchangeRequest->status !== 'approved') {
            return back()->with('error', 'The Exchange must be approved before confirming handover.');
        }

        $result = DB::transaction(function () use ($exchangeRequest, $isRequester, $isOwner) {

            $lockedRequest = BookRequest::where('id', $exchangeRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedRequest->status !== 'approved') {
                return ['error' => true];
            }

            if (
                ($isRequester && $lockedRequest->requester_confirmed_handover) ||
                ($isOwner && $lockedRequest->owner_confirmed_handover)
            ) {
                return ['already_confirmed' => true];
            }

            if ($isRequester) {
                $lockedRequest->requester_confirmed_handover = true;
            }

            if ($isOwner) {
                $lockedRequest->owner_confirmed_handover = true;
            }

            $completed = false;

            if (
                $lockedRequest->requester_confirmed_handover &&
                $lockedRequest->owner_confirmed_handover
            ) {
                $lockedRequest->status = 'completed';

                $lockedRequest->book()->update([
                    'status' => 'exchanged',
                ]);

                $completed = true;
            }

            $lockedRequest->save();

            return ['completed' => $completed];
        });

        if (!empty($result['error'])) {
            return back()->with('error', 'The Exchange is no longer awaiting handover confirmation.');
        }

        if (!empty($result['already_confirmed'])) {
            return back()->with('info', 'You have already confirmed the handover.');
        }

        $exchangeRequest->refresh();
        $exchangeRequest->load(['book', 'requester', 'owner']);

        $bookTitle = $exchangeRequest->book->title;

        // Both students have confirmed the physical handover
        if ($exchangeRequest->status === 'completed') {

            $message = 'Both students have confirmed the physical handover for "' . $bookTitle . '". The Exchange is completed!';

            $notification = new ExchangeHandoverNotification(
                $exchangeRequest,
                'exchange_completed',
                $message
            );

            // In-app notifications for both students
            $exchangeRequest->requester->notify($notification);
            $exchangeRequest->owner->notify($notification);

            // Email notifications for both students
            Mail::to($exchangeRequest->requester->email)->queue(
                new BookStatusMail(
                    $exchangeRequest,
                    'completed',
                    true,
                    null,
                    $exchangeRequest->requester->name
                )
            );

            Mail::to($exchangeRequest->owner->email)->queue(
                new BookStatusMail(
                    $exchangeRequest,
                    'completed',
                    true,
                    null,
                    $exchangeRequest->owner->name
                )
            );

            return back()->with(
                'success',
                'Exchange completed! Both students confirmed the handover.'
            );
        }

        // Only one student has confirmed so far
        $confirmerName = auth()->user()->name;

        $confirmerMessage = 'Your handover confirmation for "' . $bookTitle . '" has been recorded. Waiting for the other student.';

        $otherStudentMessage = $confirmerName . ' has confirmed the physical handover for "' . $bookTitle . '". Please confirm once you have received the book.';

        $confirmerNotification = new ExchangeHandoverNotification(
            $exchangeRequest,
            'handover_confirmed',
            $confirmerMessage
        );

        $otherStudentNotification = new ExchangeHandoverNotification(
            $exchangeRequest,
            'handover_confirmed',
            $otherStudentMessage
        );

        if ($isRequester) {
            $exchangeRequest->requester->notify($confirmerNotification);
            $exchangeRequest->owner->notify($otherStudentNotification);

            // Email the other student who still needs to confirm
            Mail::to($exchangeRequest->owner->email)->queue(
                new BookStatusMail(
                    $exchangeRequest,
                    'handover_confirmed',
                    false,
                    null,
                    $exchangeRequest->owner->name
                )
            );
        } else {
            $exchangeRequest->owner->notify($confirmerNotification);
            $exchangeRequest->requester->notify($otherStudentNotification);

            // Email the other student who still needs to confirm
            Mail::to($exchangeRequest->requester->email)->queue(
                new BookStatusMail(
                    $exchangeRequest,
                    'handover_confirmed',
                    false,
                    null,
                    $exchangeRequest->requester->name
                )
            );
        }

        return back()->with(
            'success',
            'Your handover confirmation has been recorded. Waiting for the other student.'
        );
    }


    // Both students: Confirm physical handover for Sell
    public function confirmSellHandover($id)
    {
        $sellRequest = BookRequest::with('book')->findOrFail($id);

        // This method is strictly for Sell requests.
        if (
            !$sellRequest->book ||
            $sellRequest->book->listing_type !== 'sell'
        ) {
            abort(404);
        }

        $isRequester = $sellRequest->requester_id == auth()->id();
        $isOwner = $sellRequest->owner_id == auth()->id();

        if (!$isRequester && !$isOwner) {
            return back()->with('error', 'Unauthorized action.');
        }

        if ($sellRequest->status !== 'approved') {
            return back()->with('error', 'The Sell request must be approved before confirming handover.');
        }

        DB::transaction(function () use ($sellRequest, $isRequester, $isOwner) {

            $lockedRequest = BookRequest::where('id', $sellRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedRequest->status !== 'approved') {
                return;
            }

            if ($isRequester) {
                $lockedRequest->requester_confirmed_handover = true;
            }

            if ($isOwner) {
                $lockedRequest->owner_confirmed_handover = true;
            }

            if (
                $lockedRequest->requester_confirmed_handover &&
                $lockedRequest->owner_confirmed_handover
            ) {
                $lockedRequest->status = 'completed';

                $lockedRequest->book()->update([
                    'status' => 'sold',
                ]);
            }

            $lockedRequest->save();
        });

        $sellRequest->refresh();

        // Send emails after the handover confirmation has been recorded.
        if ($sellRequest->status === 'completed') {

            // Both students receive a transaction completion email.
            $requester = User::find($sellRequest->requester_id);
            $owner = User::find($sellRequest->owner_id);

            if ($requester) {
                Mail::to($requester->email)
                    ->queue(new BookStatusMail(
                        $sellRequest,
                        'completed',
                        true,
                        null,
                        $requester->name
                    ));
            }

            if ($owner) {
                Mail::to($owner->email)
                    ->queue(new BookStatusMail(
                        $sellRequest,
                        'completed',
                        true,
                        null,
                        $owner->name
                    ));
            }

        } else {

            // Notify the other student that handover has been confirmed.
            $otherStudent = $isRequester
                ? User::find($sellRequest->owner_id)
                : User::find($sellRequest->requester_id);

            if ($otherStudent) {
                Mail::to($otherStudent->email)
                    ->queue(new BookStatusMail(
                        $sellRequest,
                        'handover_confirmed',
                        false,
                        null,
                        $otherStudent->name
                    ));
            }
        }

        if ($sellRequest->status === 'completed') {
            return back()->with('success', 'Sale completed! Both students confirmed the handover.');
        }

        return back()->with('success', 'Your handover confirmation has been recorded. Waiting for the other student.');
    }

    public function saveBook($id)
    {
        $book = Book::findOrFail($id);

        $exists = SavedBook::where('user_id', auth()->id())
            ->where('book_id', $id)
            ->first();

        if ($exists) {
            return back()->with('error', 'Already saved.');
        }

        SavedBook::create([
            'user_id' => auth()->id(),
            'book_id' => $id
        ]);

        return back()->with('success', 'Saved!');
    }

    public function savedBooks()
    {
        $saved = SavedBook::where('user_id', auth()->id())
            ->with('book')
            ->latest()
            ->get();

        return view('saved-books', compact('saved'));
    }

    public function unsaveBook($id)
    {
        SavedBook::where('user_id', auth()->id())
            ->where('book_id', $id)
            ->delete();

        return back()->with('success', 'Removed!');
    }
    public function editSchedule($id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        return view('edit-schedule', compact('book'));
    }
    public function updateSchedule(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'meeting_location' => 'required|string|max:255',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'meeting_end_time' => 'required|date_format:H:i|after:meeting_time',
        ]);

        $book->update([
            'meeting_location' => $request->meeting_location,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'meeting_end_time' => $request->meeting_end_time,
        ]);

        return redirect('/homepage')->with('success', 'Schedule updated successfully!');
    }
    public function cancelRequest($id)
    {
        $bookRequest = BookRequest::with('book')->findOrFail($id);

        // Sell requests only. Exchange has its own cancellation method.
        if (
            !$bookRequest->book ||
            $bookRequest->book->listing_type !== 'sell'
        ) {
            abort(404);
        }

        $isRequester = $bookRequest->requester_id == auth()->id();
        $isOwner = $bookRequest->owner_id == auth()->id();

        if (!$isRequester && !$isOwner) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Student B can only cancel after approval.
        // Student A can cancel pending, negotiation or approved requests.
        if (
            ($isOwner && $bookRequest->status !== 'approved') ||
            ($isRequester && !in_array($bookRequest->status, [
                'pending',
                'negotiation',
                'approved'
            ]))
        ) {
            return back()->with('error', 'This request cannot be cancelled.');
        }

        DB::transaction(function () use ($bookRequest) {

            $lockedRequest = BookRequest::where('id', $bookRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedRequest->status !== $bookRequest->status) {
                return;
            }

            // Cancellation is not allowed after either student confirms.
            if (
                $lockedRequest->requester_confirmed_handover ||
                $lockedRequest->owner_confirmed_handover
            ) {
                return;
            }

            if ($lockedRequest->status === 'approved') {
                $lockedRequest->book()->update([
                    'status' => 'available',
                ]);
            }

            $lockedRequest->update([
                'status' => 'cancelled',
            ]);
        });

        $bookRequest->refresh();

        if ($bookRequest->status !== 'cancelled') {
            return back()->with(
                'error',
                'This request can no longer be cancelled.'
            );
        }

        // Notify the requester about the cancellation.
        $requester = User::find($bookRequest->requester_id);

        if ($requester) {
            $requester->notify(
                new BookRequestStatusNotification($bookRequest)
            );
        }

        // Email the other student about the cancellation.
        $otherStudent = $isRequester
            ? User::find($bookRequest->owner_id)
            : $requester;

        if ($otherStudent) {
            Mail::to($otherStudent->email)
                ->queue(new BookStatusMail(
                    $bookRequest,
                    'cancelled',
                    false,
                    auth()->user()->name
                ));
        }

        return back()->with('success', 'Request cancelled successfully.');
    }
    // HIDE REJECTED OR CANCELLED REQUEST
    public function deleteRequest($id)
    {
        $bookRequest = BookRequest::findOrFail($id);

        $userId = auth()->id();

        // Only the requester or book owner can hide this request.
        if (
            $bookRequest->requester_id != $userId &&
            $bookRequest->owner_id != $userId
        ) {
            abort(403);
        }

        // Only rejected and cancelled requests can be hidden.
        if (!in_array($bookRequest->status, ['rejected', 'cancelled'], true)) {
            return back()->with('error', 'Only rejected or cancelled requests can be hidden.');
        }

        $hiddenBy = $bookRequest->hidden_by ?? [];

        if (!in_array($userId, $hiddenBy)) {
            $hiddenBy[] = $userId;
        }

        $bookRequest->hidden_by = $hiddenBy;
        $bookRequest->save();

        return back()->with('success', 'Request removed from your list.');
    }
}
