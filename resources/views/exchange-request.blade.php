
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Request Book Exchange | UniKL BookHub</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --navy:#102f53;
            --navy-dark:#0b2542;
            --navy-mid:#245586;
            --sky:#dceafb;
            --ink:#14263d;
            --muted:#63758a;
            --line:#dce5ef;
            --page:#f4f7fb;
        }

        * { box-sizing:border-box; }

        body {
            margin:0;
            min-height:100vh;
            color:var(--ink);
            background:var(--page);
            font-family:'Instrument Sans',Arial,sans-serif;
        }

        .site-header {
            position:relative;
            overflow:hidden;
            color:#fff;
            background:radial-gradient(ellipse at 85% 20%,#2b5d8b 0,transparent 36%),linear-gradient(130deg,#0b2542,#173f6b);
        }

        .site-header::after {
            position:absolute;
            content:"";
            width:380px;
            height:380px;
            right:-145px;
            top:-245px;
            border:1px solid #ffffff18;
            border-radius:50%;
            box-shadow:0 0 0 45px #ffffff08,0 0 0 90px #ffffff05;
        }

        .header-inner {
            position:relative;
            z-index:1;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            max-width:1040px;
            margin:auto;
            padding:18px 28px;
        }

        .brand {
            display:flex;
            align-items:center;
            gap:10px;
            color:#fff;
            font-weight:800;
            letter-spacing:-.02em;
            text-decoration:none;
        }

        .brand-mark {
            display:grid;
            place-items:center;
            width:38px;
            height:38px;
            border-radius:12px;
            background:#ffffff1d;
            color:#fff;
        }

        .back-link {
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:9px 13px;
            border:1px solid #ffffff70;
            border-radius:9px;
            color:#fff;
            font-size:.86rem;
            font-weight:700;
            text-decoration:none;
            transition:background .2s,color .2s;
        }

        .back-link:hover {
            color:var(--navy);
            background:#fff;
        }

        .page-intro {
            position:relative;
            z-index:1;
            max-width:1040px;
            margin:auto;
            padding:27px 28px 47px;
        }

        .eyebrow {
            margin:0 0 8px;
            color:#b8d5f5;
            font-size:.75rem;
            font-weight:800;
            letter-spacing:.12em;
            text-transform:uppercase;
        }

        .page-intro h1 {
            margin:0;
            color:#fff;
            font-size:clamp(2rem,4vw,2.8rem);
            font-weight:800;
            letter-spacing:-.055em;
        }

        .page-intro p {
            max-width:620px;
            margin:9px 0 0;
            color:#d3e1f0;
            line-height:1.65;
        }

        .page-main {
            position:relative;
            z-index:2;
            max-width:900px;
            margin:-20px auto 0;
            padding:0 24px 52px;
        }

        .form-card {
            margin-bottom:18px;
            padding:clamp(22px,4vw,32px);
            border:1px solid var(--line);
            border-radius:18px;
            background:#fff;
            box-shadow:0 20px 55px #102f5312;
        }

        .section-heading {
            display:flex;
            align-items:center;
            gap:10px;
            margin:0 0 17px;
            color:var(--navy);
            font-size:1rem;
            font-weight:800;
        }

        .section-heading i {
            color:var(--navy-mid);
        }

        .section-number {
            display:grid;
            flex:0 0 29px;
            place-items:center;
            width:29px;
            height:29px;
            border-radius:9px;
            color:var(--navy-mid);
            background:var(--sky);
            font-size:.8rem;
            font-weight:800;
        }

        .book-reference {
            display:flex;
            align-items:flex-start;
            gap:13px;
            padding:16px;
            border:1px solid #dce8f4;
            border-radius:12px;
            background:#f4f8fc;
        }

        .book-reference-icon {
            display:grid;
            flex:0 0 42px;
            place-items:center;
            width:42px;
            height:42px;
            border-radius:12px;
            color:var(--navy-mid);
            background:var(--sky);
        }

        .book-reference-label {
            margin:0 0 3px;
            color:var(--navy-mid);
            font-size:.7rem;
            font-weight:800;
            letter-spacing:.09em;
            text-transform:uppercase;
        }

        .book-reference-title {
            margin:0;
            color:var(--navy);
            font-size:1rem;
            font-weight:800;
            line-height:1.4;
        }

        .book-reference-details {
            margin:5px 0 0;
            color:var(--muted);
            font-size:.84rem;
            line-height:1.6;
        }

        .wanted-list {
            display:flex;
            flex-direction:column;
            gap:9px;
            margin-top:17px;
        }

        .wanted-item {
            display:flex;
            align-items:center;
            gap:11px;
            padding:12px 14px;
            border:1px solid var(--line);
            border-radius:10px;
            background:#fff;
        }

        .wanted-item i {
            color:var(--navy-mid);
        }

        .wanted-item strong {
            color:#29435f;
            font-size:.88rem;
        }

        .wanted-item small {
            display:block;
            margin-top:2px;
            color:var(--muted);
            font-size:.77rem;
        }

        .form-label {
            margin-bottom:7px;
            color:#29435f;
            font-size:.86rem;
            font-weight:700;
        }

        .form-control,
        .form-select {
            min-height:46px;
            border:1px solid #d5dfeb;
            border-radius:10px;
            color:var(--ink);
            background-color:#fff;
            font-size:.92rem;
            box-shadow:none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color:#6e9bc9;
            box-shadow:0 0 0 3px #dceafb;
        }

        .form-control[readonly] {
            background:#f4f7fb;
            color:#52677d;
        }

        .form-text {
            color:var(--muted);
            font-size:.79rem;
        }

        .offer-option {
            display:flex;
            align-items:flex-start;
            gap:12px;
            padding:15px;
            border:1px solid var(--line);
            border-radius:12px;
            background:#fff;
            cursor:pointer;
            transition:border-color .2s,background .2s;
        }

        .offer-option:hover {
            border-color:#9bb9d8;
            background:#f7faff;
        }

        .offer-option:has(input:checked) {
            border-color:#6e9bc9;
            background:#f1f7fd;
        }

        .offer-option input {
            margin-top:4px;
            accent-color:var(--navy);
        }

        .offer-option strong {
            display:block;
            color:var(--navy);
            font-size:.9rem;
        }

        .offer-option small {
            display:block;
            margin-top:4px;
            color:var(--muted);
            font-size:.8rem;
            line-height:1.5;
        }

        .preview-card {
            padding:16px;
            border:1px solid #dce8f4;
            border-radius:12px;
            background:#f7faff;
        }

        .preview-image {
            width:100%;
            max-width:150px;
            max-height:190px;
            object-fit:contain;
            border-radius:9px;
            background:#fff;
        }

        .preview-detail {
            margin-bottom:9px;
            color:#52677d;
            font-size:.87rem;
        }

        .preview-detail strong {
            color:#29435f;
        }

        .schedule-note {
            margin-bottom:18px;
            padding:13px 15px;
            border:1px solid #c8dcef;
            border-radius:11px;
            color:#52677d;
            background:#f1f7fd;
            font-size:.83rem;
            line-height:1.6;
        }

        .schedule-note i {
            color:var(--navy-mid);
        }

        .submit-button {
            min-height:49px;
            border:0;
            border-radius:10px;
            color:#fff;
            background:var(--navy);
            font-weight:800;
            box-shadow:0 8px 18px #102f5324;
            transition:transform .2s,background .2s,box-shadow .2s;
        }

        .submit-button:hover,
        .submit-button:focus {
            color:#fff;
            background:var(--navy-dark);
            transform:translateY(-1px);
            box-shadow:0 12px 24px #102f5330;
        }

        .cancel-button {
            min-height:49px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:0 20px;
            border:1px solid #cbd7e4;
            border-radius:10px;
            color:#52677d;
            background:#fff;
            font-weight:700;
            text-decoration:none;
        }

        .cancel-button:hover {
            color:var(--navy);
            background:#f4f7fb;
        }

        .alert {
            border:0;
            border-radius:12px;
        }

        .field-error {
            display:block;
            margin-top:6px;
            color:#b42336;
            font-size:.82rem;
        }

        @media(max-width:620px) {
            .header-inner {
                padding:14px 18px;
            }

            .page-intro {
                padding:24px 20px 42px;
            }

            .page-main {
                padding:0 14px 36px;
            }

            .back-link span {
                display:none;
            }

            .form-card {
                padding:20px 17px;
            }

            .preview-image {
                max-width:115px;
            }
        }

        /* Exchange book selection cards */
        .book-choice {
            display: block;
            padding: 14px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            cursor: pointer;
            transition: .2s;
        }

        .book-choice:hover {
            border-color: #9bb9d8;
            background: #f7faff;
        }

        .book-choice:has(input:checked) {
            border: 2px solid #6e9bc9;
            background: #f1f7fd;
        }

        .book-choice input,
        .schedule-choice input,
        .offer-option input {
            accent-color: var(--navy);
        }

        .book-choice img {
            width: 65px;
            height: 85px;
            object-fit: contain;
            border-radius: 7px;
            background: #f4f7fb;
        }

        /* Schedule selection */
        .schedule-choice {
            display: block;
            padding: 15px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #fff;
            cursor: pointer;
            transition: .2s;
        }

        .schedule-choice:hover {
            border-color: #9bb9d8;
        }

        .schedule-choice:has(input:checked) {
            border: 2px solid #6e9bc9;
            background: #f1f7fd;
        }

        /* Selected book image */
        .preview-image {
            width: 100px;
            height: 125px;
            object-fit: contain;
            border-radius: 8px;
            background: #f4f7fb;
        }

        /* Book selection preview */
        .preview-detail {
            margin-bottom: 7px;
            font-size: 14px;
        }

        /* Hide unavailable book cards */
        .matching-book.d-none {
            display: none !important;
        }
    </style>
</head>

<body>

<header class="site-header">

    <div class="header-inner">

        <a class="brand" href="{{ url('/') }}">
            <span class="brand-mark" aria-hidden="true">
                <i class="bi bi-book-half"></i>
            </span>
            <span>UniKL BookHub</span>
        </a>

        <a href="{{ url('/book/' . $book->id) }}" class="back-link">
            <i class="bi bi-arrow-left" aria-hidden="true"></i>
            <span>Back to book details</span>
        </a>

    </div>

    <div class="page-intro">
        <p class="eyebrow">Book exchange</p>
        <h1>Request a book exchange</h1>
        <p>
            Choose one of the books the book owner is looking for and offer a book
            in return. You can use an existing listing or enter a new book.
        </p>
    </div>

</header>

<main class="page-main">

    @if(session('error'))
        <div class="alert alert-danger mb-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3" role="alert">
            <strong>Please check the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('exchange.request.store', $book->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        {{-- STEP 1: SELECTED EXCHANGE LISTING --}}

        <section class="form-card">

            <h2 class="section-heading">
                <span class="section-number">1</span>
                Book you want
            </h2>

            <div class="book-reference">

                <span class="book-reference-icon">
                    <i class="bi bi-book"></i>
                </span>

                <div>
                    <p class="book-reference-label">
                        Selected exchange listing
                    </p>

                    <p class="book-reference-title">
                        {{ $book->title }}
                    </p>

                    <p class="book-reference-details">
                        Subject Code: {{ $book->subject_id }}<br>
                        Listed by: {{ $book->user->name }}
                    </p>
                </div>

            </div>

            <h3 class="section-heading mt-4">
                <i class="bi bi-search"></i>
                Books the book owner is looking for
            </h3>

            <div class="wanted-list">

                @foreach($preferences as $preference)

                    <div class="wanted-item">
                        <i class="bi bi-bookmark-check"></i>

                        <div>
                            <strong>
                                {{ $preference->wanted_book_name }}
                            </strong>

                            <small>
                                {{ $preference->wanted_subject_id }}
                            </small>
                        </div>
                    </div>

                @endforeach

            </div>

        </section>


        {{-- STEP 2: SELECT THE WANTED BOOK --}}

        <section class="form-card">

            <h2 class="section-heading">
                <span class="section-number">2</span>
                Choose what you can offer
            </h2>

            <p class="text-muted small mb-3">
                Select one of the books the book owner is looking for.
                You will need to provide this book in return
                for the book you requested.
            </p>

            <div class="d-flex flex-column gap-2">

                @foreach($preferences as $preference)

                    <label class="book-choice">

                        <div class="d-flex align-items-center gap-3">

                            <input
                                type="radio"
                                name="preference_id"
                                value="{{ $preference->id }}"
                                data-title="{{ $preference->wanted_book_name }}"
                                data-subject="{{ $preference->wanted_subject_id }}"
                                @checked(old('preference_id') == $preference->id)
                                required
                            >

                            <div class="flex-grow-1">

                                <strong>
                                    {{ $preference->wanted_book_name }}
                                </strong>

                                <div class="text-muted small">
                                    {{ $preference->wanted_subject_id }}
                                </div>

                            </div>

                        </div>

                    </label>

                @endforeach

            </div>

            @error('preference_id')
                <small class="field-error">{{ $message }}</small>
            @enderror

        </section>


        {{-- STEP 3: YOUR OFFERED BOOK --}}

        <section class="form-card">

            <h2 class="section-heading">
                <span class="section-number">3</span>
                Your offered book
            </h2>

            <p class="text-muted small mb-3">
                Choose a matching book from your existing listings,
                or enter the details of a book that you have not
                listed on BookHub.
            </p>

            {{-- OFFER METHOD --}}

            <div class="d-flex flex-column gap-3">

                <label class="offer-option" for="existing">

                    <input
                        type="radio"
                        name="offer_type"
                        id="existing"
                        value="existing"
                        checked
                    >

                    <span>
                        <strong>Choose from my existing listings</strong>

                        <small>
                            Select one of your matching BookHub listings.
                        </small>
                    </span>

                </label>

                <label class="offer-option" for="manual">

                    <input
                        type="radio"
                        name="offer_type"
                        id="manual"
                        value="manual"
                    >

                    <span>
                        <strong>Enter book details manually</strong>

                        <small>
                            Offer a book that you have not listed on BookHub.
                        </small>
                    </span>

                </label>

            </div>


            {{-- EXISTING LISTINGS --}}

            <div id="existingSection" class="mt-4">

                <h3 class="section-heading">
                    <i class="bi bi-collection"></i>
                    Your matching listings
                </h3>

                <p class="form-text">
                    Select the actual listing you want to use for this exchange.
                </p>

                <div id="matchingBookCards"
                     class="d-flex flex-column gap-2">

                    @foreach($matchingBooks as $ownedBook)

                        <label
                            class="book-choice matching-book"
                            data-title="{{ strtolower(trim($ownedBook->title)) }}"
                            data-subject="{{ strtolower(trim($ownedBook->subject_id)) }}"
                        >

                            <div class="d-flex align-items-center gap-3">

                                <input
                                    type="radio"
                                    name="offered_book_id"
                                    value="{{ $ownedBook->id }}"
                                    data-title="{{ $ownedBook->title }}"
                                    data-subject="{{ $ownedBook->subject_id }}"
                                    data-condition="{{ $ownedBook->condition }}"
                                    data-image="{{ $ownedBook->image ? asset('storage/' . $ownedBook->image) : '' }}"
                                    disabled
                                >

                                @if($ownedBook->image)

                                    <img
                                        src="{{ asset('storage/' . $ownedBook->image) }}"
                                        alt="{{ $ownedBook->title }}"
                                    >

                                @else

                                    <div class="preview-image d-flex align-items-center justify-content-center">
                                        <i class="bi bi-book fs-2"></i>
                                    </div>

                                @endif

                                <div class="flex-grow-1">

                                    <strong>
                                        {{ $ownedBook->title }}
                                    </strong>

                                    <div class="text-muted small">
                                        {{ $ownedBook->subject_id }}
                                    </div>

                                    <div class="text-muted small">
                                        Condition: {{ $ownedBook->condition }}
                                    </div>

                                    <div class="text-muted small">
                                        Listing #{{ $ownedBook->id }}
                                    </div>

                                </div>

                                <i class="bi bi-chevron-right text-muted"></i>

                            </div>

                        </label>

                    @endforeach

                </div>


                <div id="noMatchingBooks"
                     class="alert alert-info mt-3 d-none">

                    <i class="bi bi-info-circle me-2"></i>

                    You do not have a matching existing listing
                    for this book. You can enter the details manually instead.

                </div>


                {{-- SELECTED BOOK PREVIEW --}}

                <div id="existingPreview"
                     class="preview-card mt-4 d-none">

                    <h3 class="section-heading">
                        <i class="bi bi-check-circle"></i>
                        Confirm your selected book
                    </h3>

                    <div class="d-flex align-items-center gap-3">

                        <img
                            id="existingImage"
                            src=""
                            alt="Selected book"
                            class="preview-image"
                        >

                        <div>

                            <p class="preview-detail">
                                <strong>Book Name:</strong>
                                <span id="existingTitle"></span>
                            </p>

                            <p class="preview-detail">
                                <strong>Subject Code:</strong>
                                <span id="existingSubject"></span>
                            </p>

                            <p class="preview-detail">
                                <strong>Condition:</strong>
                                <span id="existingCondition"></span>
                            </p>

                            <p class="preview-detail mb-0">
                                <strong>Listing ID:</strong>
                                <span id="existingListingId"></span>
                            </p>

                        </div>

                    </div>

                    <p class="form-text mt-3 mb-0">
                        Only the book details will be copied into this
                        exchange offer. Your original listing will remain
                        unchanged and available separately.
                    </p>

                </div>

            </div>


            {{-- MANUAL ENTRY --}}

            <div id="manualSection" class="mt-4 d-none">

                <h3 class="section-heading">
                    <i class="bi bi-pencil-square"></i>
                    Enter your book details
                </h3>

                <p class="form-text">
                    Your book name and subject code will be based on
                    the wanted book you selected above.
                </p>

                <div class="mb-3">

                    <label class="form-label">Book Name</label>

                    <input
                        type="text"
                        name="manual_title"
                        id="manualTitle"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">Subject Code</label>

                    <input
                        type="text"
                        name="manual_subject_id"
                        id="manualSubject"
                        class="form-control"
                        readonly
                    >

                </div>

                <div class="mb-3">

                    <label for="manual_condition" class="form-label">
                        Book Condition
                    </label>

                    <select
                        name="manual_condition"
                        id="manual_condition"
                        class="form-select"
                        disabled
                    >

                        <option value="">-- Select condition --</option>
                        <option value="New">New</option>
                        <option value="Like New">Like New</option>
                        <option value="Good">Good</option>
                        <option value="Fair">Fair</option>

                    </select>

                </div>

                <div class="mb-3">

                    <label for="manual_image" class="form-label">
                        Book Image
                    </label>

                    <input
                        type="file"
                        name="manual_image"
                        id="manual_image"
                        class="form-control"
                        accept="image/*"
                        disabled
                    >

                    <div class="form-text">
                        Upload a clear image of the book you are offering.
                    </div>

                    <img
                        id="manualImagePreview"
                        src=""
                        alt="Book preview"
                        class="preview-image d-none mt-3"
                    >

                </div>

            </div>

        </section>


        {{-- STEP 4: MEETING ARRANGEMENT --}}

        <section class="form-card">

            <h2 class="section-heading">
                <span class="section-number">4</span>
                Meeting arrangement
            </h2>

            <p class="text-muted small mb-3">
                The book owner has provided a preferred meeting schedule.
                You can agree to this schedule or suggest another time.
            </p>

            <div class="book-reference mb-3">

                <span class="book-reference-icon">
                    <i class="bi bi-calendar-event"></i>
                </span>

                <div>

                    <p class="book-reference-label">
                        Book owner's preferred schedule
                    </p>

                    @if($book->meeting_location && $book->meeting_date && $book->meeting_time)

                        <p class="book-reference-title">
                            {{ $book->meeting_location }}
                        </p>

                        <p class="book-reference-details">

                            Date: {{ $book->meeting_date }}<br>

                            Time: {{ $book->meeting_time }}

                            @if($book->meeting_end_time)
                                – {{ $book->meeting_end_time }}
                            @endif

                        </p>

                    @else

                        <p class="book-reference-details mb-0">
                            The book owner has not provided a preferred schedule.
                            You can propose your own schedule below.
                        </p>

                    @endif

                </div>

            </div>


            @if($book->meeting_location && $book->meeting_date && $book->meeting_time)

                <p class="form-label mb-2">
                    Would you like to use the book owner's preferred schedule?
                </p>

                <div class="d-flex flex-column gap-2 mb-4">

                    <label class="schedule-choice">

                        <input
                            type="radio"
                            name="schedule_choice"
                            value="owner"
                            checked
                        >

                        <strong class="ms-2">
                            Yes, use the book owner's schedule
                        </strong>

                        <div class="text-muted small ms-4">
                            Use the location, date and time shown above.
                        </div>

                    </label>

                    <label class="schedule-choice">

                        <input
                            type="radio"
                            name="schedule_choice"
                            value="custom"
                        >

                        <strong class="ms-2">
                            No, propose another schedule
                        </strong>

                        <div class="text-muted small ms-4">
                            I want to suggest a different meeting arrangement.
                        </div>

                    </label>

                </div>

            @else

                <input
                    type="hidden"
                    name="schedule_choice"
                    value="custom"
                >

            @endif


            {{-- CUSTOM SCHEDULE --}}

            <div id="customScheduleFields" class="d-none">

                <h3 class="section-heading">
                    <i class="bi bi-calendar-plus"></i>
                    Your proposed schedule
                </h3>

                <div class="mb-3">

                    <label for="proposed_location" class="form-label">
                        Meeting Location
                    </label>

                    <input
                        type="text"
                        name="proposed_location"
                        id="proposed_location"
                        class="form-control"
                        value="{{ old('proposed_location') }}"
                        placeholder="e.g. UniKL MIIT Library Entrance"
                        disabled
                    >

                </div>

                <div class="row g-3">

                    <div class="col-12 col-md-4">

                        <label for="proposed_date" class="form-label">
                            Preferred Date
                        </label>

                        <input
                            type="date"
                            name="proposed_date"
                            id="proposed_date"
                            class="form-control"
                            value="{{ old('proposed_date') }}"
                            min="{{ now()->toDateString() }}"
                            disabled
                        >

                    </div>

                    <div class="col-12 col-md-4">

                        <label for="proposed_time" class="form-label">
                            Start Time
                        </label>

                        <input
                            type="time"
                            name="proposed_time"
                            id="proposed_time"
                            class="form-control"
                            value="{{ old('proposed_time') }}"
                            disabled
                        >

                    </div>

                    <div class="col-12 col-md-4">

                        <label for="proposed_end_time" class="form-label">
                            End Time
                        </label>

                        <input
                            type="time"
                            name="proposed_end_time"
                            id="proposed_end_time"
                            class="form-control"
                            value="{{ old('proposed_end_time') }}"
                            disabled
                        >

                    </div>

                </div>

            </div>


            <div id="ownerScheduleNote" class="schedule-note">

                <i class="bi bi-info-circle me-1"></i>

                You have chosen the book owner's preferred schedule.
                The book owner will still need to confirm the exchange
                and meeting arrangement.

            </div>

        </section>


        {{-- SUBMIT --}}

        <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">

            <a href="{{ url('/book/' . $book->id) }}"
               class="cancel-button">
                Cancel
            </a>

            <button type="submit" class="btn submit-button px-4">

                Submit Exchange Request

                <i class="bi bi-arrow-right ms-1"></i>

            </button>

        </div>

    </form>

</main>

<script>

document.addEventListener('DOMContentLoaded', function () {

    // ELEMENTS

    const preferenceRadios = document.querySelectorAll(
        'input[name="preference_id"]'
    );

    const matchingCards = document.querySelectorAll('.matching-book');

    const existingRadio = document.getElementById('existing');
    const manualRadio = document.getElementById('manual');

    const existingSection = document.getElementById('existingSection');
    const manualSection = document.getElementById('manualSection');

    const existingPreview = document.getElementById('existingPreview');
    const noMatchingBooks = document.getElementById('noMatchingBooks');

    const manualTitle = document.getElementById('manualTitle');
    const manualSubject = document.getElementById('manualSubject');

    const manualCondition = document.getElementById('manual_condition');
    const manualImage = document.getElementById('manual_image');

    const scheduleRadios = document.querySelectorAll(
        'input[name="schedule_choice"]'
    );

    const customScheduleFields = document.getElementById(
        'customScheduleFields'
    );

    const ownerScheduleNote = document.getElementById(
        'ownerScheduleNote'
    );

    const scheduleFields = [
        document.getElementById('proposed_location'),
        document.getElementById('proposed_date'),
        document.getElementById('proposed_time'),
        document.getElementById('proposed_end_time')
    ];


    // STEP 2: FILTER MATCHING BOOKS

    function updatePreference() {

        const selected = document.querySelector(
            'input[name="preference_id"]:checked'
        );

        const title = selected?.dataset.title || '';
        const subject = selected?.dataset.subject || '';

        manualTitle.value = title;
        manualSubject.value = subject;

        let visibleCount = 0;

        matchingCards.forEach(function (card) {

            const matches = selected &&
                card.dataset.title === title.trim().toLowerCase() &&
                card.dataset.subject === subject.trim().toLowerCase();

            card.classList.toggle('d-none', !matches);

            if (matches) {
                visibleCount++;
            }

        });

        // Clear previous selected listing.

        document.querySelectorAll(
            'input[name="offered_book_id"]'
        ).forEach(function (input) {

            input.checked = false;

        });

        existingPreview.classList.add('d-none');

        noMatchingBooks.classList.toggle(
            'd-none',
            !selected || visibleCount > 0
        );

        updateOfferType();

    }


    // STEP 3: DISPLAY SELECTED BOOK

    function updateExistingPreview() {

        const selected = document.querySelector(
            'input[name="offered_book_id"]:checked'
        );

        if (!selected) {
            existingPreview.classList.add('d-none');
            return;
        }

        document.getElementById('existingTitle').textContent =
            selected.dataset.title;

        document.getElementById('existingSubject').textContent =
            selected.dataset.subject;

        document.getElementById('existingCondition').textContent =
            selected.dataset.condition;

        document.getElementById('existingListingId').textContent =
            selected.value;

        const image = document.getElementById('existingImage');

        if (selected.dataset.image) {

            image.src = selected.dataset.image;
            image.classList.remove('d-none');

        } else {

            image.removeAttribute('src');
            image.classList.add('d-none');

        }

        existingPreview.classList.remove('d-none');

    }


    // SWITCH BETWEEN EXISTING AND MANUAL

    function updateOfferType() {

        const isExisting = existingRadio.checked;

        const hasPreference = !!document.querySelector(
            'input[name="preference_id"]:checked'
        );

        existingSection.classList.toggle('d-none', !isExisting);
        manualSection.classList.toggle('d-none', isExisting);

        document.querySelectorAll(
            'input[name="offered_book_id"]'
        ).forEach(function (input) {

            const card = input.closest('.matching-book');

            const isVisible = card && !card.classList.contains('d-none');

            input.disabled = !isExisting || !isVisible;

            input.required = isExisting && hasPreference && isVisible;

        });

        manualTitle.disabled = isExisting;
        manualSubject.disabled = isExisting;

        manualCondition.disabled = isExisting;
        manualImage.disabled = isExisting;

        manualCondition.required = !isExisting;
        manualImage.required = !isExisting;

        if (!isExisting) {

            existingPreview.classList.add('d-none');

        } else {

            updateExistingPreview();

        }

    }


    // STEP 4: MEETING SCHEDULE

    function updateScheduleChoice() {

        const selected = document.querySelector(
            'input[name="schedule_choice"]:checked'
        );

        const useOwnerSchedule = selected?.value === 'owner';

        customScheduleFields.classList.toggle(
            'd-none',
            useOwnerSchedule
        );

        ownerScheduleNote.classList.toggle(
            'd-none',
            !useOwnerSchedule
        );

        scheduleFields.forEach(function (field) {

            if (!field) return;

            field.disabled = useOwnerSchedule;
            field.required = !useOwnerSchedule;

        });

    }


    // MANUAL BOOK IMAGE PREVIEW

    manualImage.addEventListener('change', function (event) {

        const file = event.target.files[0];

        const preview = document.getElementById(
            'manualImagePreview'
        );

        if (file) {

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');

        } else {

            preview.src = '';
            preview.classList.add('d-none');

        }

    });


    // EVENT LISTENERS

    preferenceRadios.forEach(function (radio) {

        radio.addEventListener('change', updatePreference);

    });


    document.querySelectorAll(
        'input[name="offered_book_id"]'
    ).forEach(function (input) {

        input.addEventListener('change', updateExistingPreview);

    });


    existingRadio.addEventListener('change', updateOfferType);
    manualRadio.addEventListener('change', updateOfferType);


    scheduleRadios.forEach(function (radio) {

        radio.addEventListener('change', updateScheduleChoice);

    });


    // INITIALISE

    updatePreference();
    updateOfferType();
    updateScheduleChoice();

});

</script>

</body>
</html>
