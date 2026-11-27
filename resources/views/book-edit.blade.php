
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Edit Book Listing | UniKL BookHub</title>

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
            max-width:1000px;
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

        .header-actions {
            display:flex;
            align-items:center;
            gap:9px;
        }

        .header-link {
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding:9px 13px;
            border:1px solid #ffffff70;
            border-radius:9px;
            color:#fff;
            font-size:.84rem;
            font-weight:700;
            text-decoration:none;
            transition:background .2s,color .2s;
        }

        .header-link:hover {
            color:var(--navy);
            background:#fff;
        }

        .page-intro {
            position:relative;
            z-index:1;
            max-width:1000px;
            margin:auto;
            padding:28px 28px 48px;
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
            font-size:clamp(2rem,4vw,3rem);
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
            max-width:1000px;
            margin:-20px auto 0;
            padding:0 28px 56px;
        }

        .form-card {
            padding:28px;
            border:1px solid var(--line);
            border-radius:18px;
            background:#fff;
            box-shadow:0 10px 30px #173f6b08;
        }

        .section-heading {
            display:flex;
            align-items:center;
            gap:11px;
            margin-bottom:20px;
        }

        .section-icon {
            display:grid;
            place-items:center;
            width:42px;
            height:42px;
            flex:0 0 auto;
            border-radius:12px;
            color:var(--navy-mid);
            background:var(--sky);
            font-size:1.1rem;
        }

        .section-heading h2 {
            margin:0;
            color:var(--navy);
            font-size:1.05rem;
            font-weight:800;
        }

        .section-heading p {
            margin:3px 0 0;
            color:var(--muted);
            font-size:.82rem;
        }

        .form-label {
            color:#344c66;
            font-size:.86rem;
            font-weight:700;
        }

        .form-control,
        .form-select {
            min-height:45px;
            border:1px solid var(--line);
            border-radius:9px;
            color:var(--ink);
            font-size:.9rem;
        }

        textarea.form-control {
            min-height:115px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color:#7299c0;
            box-shadow:0 0 0 .2rem #24558618;
        }

        .form-text {
            color:var(--muted);
            font-size:.78rem;
        }

        .listing-choice {
            display:flex;
            flex-wrap:wrap;
            gap:12px;
        }

        .listing-option {
            display:flex;
            align-items:center;
            gap:9px;
            flex:1;
            min-width:180px;
            padding:14px;
            border:1px solid var(--line);
            border-radius:11px;
            background:#fff;
            cursor:pointer;
            transition:border-color .2s,background .2s;
        }

        .listing-option:has(input:checked) {
            border-color:var(--navy-mid);
            background:#f1f6fc;
        }

        .listing-option input {
            accent-color:var(--navy);
        }

        .listing-option span {
            color:var(--navy);
            font-size:.88rem;
            font-weight:700;
        }

        .preference-card {
            padding:17px;
            border:1px solid var(--line);
            border-radius:12px;
            background:#fbfcfe;
        }

        .preference-card h6 {
            color:var(--navy);
            font-size:.88rem;
            font-weight:800;
        }

        .section-divider {
            margin:27px 0;
            border-color:var(--line);
            opacity:1;
        }

        .btn-primary {
            border-color:var(--navy);
            background:var(--navy);
            font-weight:700;
        }

        .btn-primary:hover {
            border-color:var(--navy-dark);
            background:var(--navy-dark);
        }

        .btn-outline-primary {
            border-color:var(--navy-mid);
            color:var(--navy-mid);
            font-weight:700;
        }

        .btn-outline-primary:hover {
            border-color:var(--navy);
            background:var(--navy);
        }

        .form-actions {
            display:flex;
            justify-content:space-between;
            gap:12px;
            margin-top:28px;
        }

        .form-actions .btn {
            min-height:46px;
            padding:11px 20px;
            border-radius:9px;
        }

        .required-mark {
            color:#dc3545;
        }

        @media(max-width:600px) {
            .header-inner {
                padding:14px 18px;
            }

            .page-intro {
                padding:25px 20px 42px;
            }

            .page-main {
                padding:0 14px 36px;
            }

            .form-card {
                padding:19px;
            }

            .header-link span {
                display:none;
            }

            .form-actions {
                flex-direction:column-reverse;
            }

            .form-actions .btn {
                width:100%;
            }
        }
    </style>
</head>

<body>

<header class="site-header">

    <div class="header-inner">

        <a class="brand" href="{{ url('/') }}">
            <span class="brand-mark">
                <i class="bi bi-book-half"></i>
            </span>
            <span>UniKL BookHub</span>
        </a>

        <div class="header-actions">

            <a href="{{ route('homepage') }}" class="header-link">
                <i class="bi bi-search"></i>
                <span>Browse books</span>
            </a>

            <a href="{{ route('book.myListings') }}" class="header-link">
                <i class="bi bi-arrow-left"></i>
                <span>My listings</span>
            </a>

        </div>

    </div>

    <div class="page-intro">

        <p class="eyebrow">Manage your listing</p>

        <h1>Edit book listing</h1>

        <p>
            Update your book information, listing type, exchange preferences
            and meeting details.
        </p>

    </div>

</header>

<main class="page-main">

    @if(session('success'))
        <div class="alert alert-success mb-3" role="status">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-3" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <strong>Please check the following information:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="editBookForm"
          method="POST"
          action="{{ route('book.update', $book->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-card">

            <!-- LISTING TYPE -->

            <div class="section-heading">
                <div class="section-icon">
                    <i class="bi bi-tags"></i>
                </div>

                <div>
                    <h2>Listing Type</h2>
                    <p>Choose how you want to offer this book.</p>
                </div>
            </div>

            <div class="listing-choice mb-3">

                <label class="listing-option">
                    <input type="radio"
                           name="listing_type"
                           value="sell"
                           {{ old('listing_type', $book->listing_type ?? 'sell') === 'sell' ? 'checked' : '' }}>

                    <span>
                        <i class="bi bi-cash-coin me-1"></i>
                        Sell a Book
                    </span>
                </label>

                <label class="listing-option">
                    <input type="radio"
                           name="listing_type"
                           value="exchange"
                           {{ old('listing_type', $book->listing_type ?? 'sell') === 'exchange' ? 'checked' : '' }}>

                    <span>
                        <i class="bi bi-arrow-left-right me-1"></i>
                        Exchange a Book
                    </span>
                </label>

            </div>

            @error('listing_type')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

            <hr class="section-divider">

            <!-- BOOK INFORMATION -->

            <div class="section-heading">
                <div class="section-icon">
                    <i class="bi bi-book"></i>
                </div>

                <div>
                    <h2>Book Information</h2>
                    <p>Update the details of your book.</p>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Title <span class="required-mark">*</span>
                </label>

                <input type="text"
                       name="booktitle"
                       class="form-control"
                       value="{{ old('booktitle', $book->title) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Description <span class="required-mark">*</span>
                </label>

                <textarea name="bookdescription"
                          class="form-control"
                          required>{{ old('bookdescription', $book->description) }}</textarea>
            </div>

            <div class="mb-3" id="priceSection">
                <label class="form-label">
                    Price (RM) <span class="required-mark">*</span>
                </label>

                <input type="number"
                       step="0.01"
                       min="0"
                       name="price"
                       id="price"
                       class="form-control"
                       value="{{ old('price', $book->price) }}">

                @error('price')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Book Condition <span class="required-mark">*</span>
                </label>

                <select name="condition" class="form-select" required>
                    <option value="New" {{ old('condition', $book->condition) == 'New' ? 'selected' : '' }}>New</option>
                    <option value="Like New" {{ old('condition', $book->condition) == 'Like New' ? 'selected' : '' }}>Like New</option>
                    <option value="Used" {{ old('condition', $book->condition) == 'Used' ? 'selected' : '' }}>Used</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Subject Code <span class="required-mark">*</span>
                </label>

                <input type="text"
                       name="subject_id"
                       class="form-control"
                       value="{{ old('subject_id', $book->subject_id) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Subject Category <span class="required-mark">*</span>
                </label>

                <select id="subject_category"
                        name="subject_category"
                        class="form-select"
                        required>

                    <option value="" disabled
                        {{ old('subject_category', $book->subject_category) ? '' : 'selected' }}>
                        Select a category
                    </option>

                    @foreach(\App\Models\Book::SUBJECT_CATEGORIES as $category)
                        <option value="{{ $category }}"
                            {{ old('subject_category', $book->subject_category) === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Replace Book Image</label>

                <input type="file"
                       name="image"
                       class="form-control"
                       accept=".jpg,.jpeg,.png">

                <div class="form-text">
                    Leave this field empty if you do not want to replace the current image.
                    Maximum file size: 2MB.
                </div>
            </div>

            <div id="exchangeSection">

                <hr class="section-divider">

                <!-- EXCHANGE PREFERENCES -->

                <div class="section-heading">
                    <div class="section-icon">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>

                    <div>
                        <h2>Exchange Preferences</h2>
                        <p>Choose the books you would like to receive in exchange.</p>
                    </div>
                </div>

                <div class="alert alert-info py-2 small">
                    <i class="bi bi-info-circle me-1"></i>
                    You can specify up to 3 wanted books.
                </div>

                <div id="exchangePreferences" class="d-grid gap-3">

                    @forelse($book->exchangePreferences as $index => $preference)

                        <div class="preference-card" data-preference>

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <h6 class="mb-0">
                                    Wanted Book {{ $index + 1 }}
                                </h6>

                                <button type="button"
                                        class="btn btn-sm btn-outline-danger remove-preference">
                                    <i class="bi bi-trash me-1"></i>
                                    Remove
                                </button>

                            </div>

                            <div class="row g-3">

                                <div class="col-md-5">
                                    <label class="form-label">Wanted Subject Code</label>

                                    <input type="text"
                                           name="exchange_preferences[{{ $index }}][wanted_subject_id]"
                                           class="form-control preference-code"
                                           value="{{ old("exchange_preferences.$index.wanted_subject_id", $preference->wanted_subject_id) }}">
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label">Wanted Book Name</label>

                                    <input type="text"
                                           name="exchange_preferences[{{ $index }}][wanted_book_name]"
                                           class="form-control preference-name"
                                           value="{{ old("exchange_preferences.$index.wanted_book_name", $preference->wanted_book_name) }}">
                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="preference-card" data-preference>

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <h6 class="mb-0">Wanted Book 1</h6>

                                <button type="button"
                                        class="btn btn-sm btn-outline-danger remove-preference">
                                    <i class="bi bi-trash me-1"></i>
                                    Remove
                                </button>

                            </div>

                            <div class="row g-3">

                                <div class="col-md-5">
                                    <label class="form-label">Wanted Subject Code</label>

                                    <input type="text"
                                           name="exchange_preferences[0][wanted_subject_id]"
                                           class="form-control preference-code"
                                           value="{{ old('exchange_preferences.0.wanted_subject_id') }}">
                                </div>

                                <div class="col-md-7">
                                    <label class="form-label">Wanted Book Name</label>

                                    <input type="text"
                                           name="exchange_preferences[0][wanted_book_name]"
                                           class="form-control preference-name"
                                           value="{{ old('exchange_preferences.0.wanted_book_name') }}">
                                </div>

                            </div>

                        </div>

                    @endforelse

                </div>

                <button type="button"
                        id="addPreference"
                        class="btn btn-outline-primary mt-3">

                    <i class="bi bi-plus-circle me-1"></i>
                    Add Another Wanted Book

                </button>

            </div>

            <hr class="section-divider">

            <!-- MEETING DETAILS -->

            <div class="section-heading">
                <div class="section-icon">
                    <i class="bi bi-geo-alt"></i>
                </div>

                <div>
                    <h2>Meeting Details</h2>
                    <p>Update your preferred meeting arrangements.</p>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Meeting Location</label>

                <input type="text"
                       name="meeting_location"
                       class="form-control"
                       value="{{ old('meeting_location', $book->meeting_location) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Meeting Date</label>

                <input type="date"
                       name="meeting_date"
                       class="form-control"
                       value="{{ old('meeting_date', $book->meeting_date ? \Illuminate\Support\Carbon::parse($book->meeting_date)->format('Y-m-d') : '') }}">
            </div>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Meeting Start Time</label>

                    <input type="time"
                           name="meeting_time"
                           class="form-control"
                           value="{{ old('meeting_time', $book->meeting_time ? substr($book->meeting_time, 0, 5) : '') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Meeting End Time</label>

                    <input type="time"
                           name="meeting_end_time"
                           class="form-control"
                           value="{{ old('meeting_end_time', $book->meeting_end_time ? substr($book->meeting_end_time, 0, 5) : '') }}">
                </div>

            </div>

            <!-- FORM ACTIONS -->

            <div class="form-actions">

                <a href="{{ route('book.myListings') }}"
                   class="btn btn-outline-secondary">

                    <i class="bi bi-arrow-left me-1"></i>
                    Cancel

                </a>

                <button type="submit" class="btn btn-primary">

                    <i class="bi bi-check-circle me-1"></i>
                    Update Book Listing

                </button>

            </div>

        </div>

    </form>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const editForm = document.getElementById('editBookForm');

    const listingTypeRadios = document.querySelectorAll('input[name="listing_type"]');

    const priceSection = document.getElementById('priceSection');
    const priceInput = document.getElementById('price');

    const exchangeSection = document.getElementById('exchangeSection');

    const preferencesContainer = document.getElementById('exchangePreferences');
    const addPreferenceButton = document.getElementById('addPreference');

    // Switch between Sell and Exchange.
    function updateListingType() {

        const selectedRadio = document.querySelector('input[name="listing_type"]:checked');

        if (!selectedRadio) {
            return;
        }

        const selectedType = selectedRadio.value;

        if (selectedType === 'sell') {

            priceSection.style.display = 'block';

            priceInput.required = true;
            priceInput.disabled = false;

            exchangeSection.style.display = 'none';

            exchangeSection.querySelectorAll('input').forEach(input => {
                input.required = false;
                input.disabled = true;
            });

        } else {

            priceSection.style.display = 'none';

            priceInput.required = false;
            priceInput.disabled = true;

            exchangeSection.style.display = 'block';

            exchangeSection.querySelectorAll('.preference-code, .preference-name').forEach(input => {
                input.required = true;
                input.disabled = false;
            });

        }
    }

    listingTypeRadios.forEach(radio => {
        radio.addEventListener('change', updateListingType);
    });

    // Update preference numbering and input names.
    function updatePreferenceNumbers() {

        const preferences = preferencesContainer.querySelectorAll('[data-preference]');

        preferences.forEach((preference, index) => {

            preference.querySelector('h6').textContent = 'Wanted Book ' + (index + 1);

            preference.querySelector('.preference-code').name =
                `exchange_preferences[${index}][wanted_subject_id]`;

            preference.querySelector('.preference-name').name =
                `exchange_preferences[${index}][wanted_book_name]`;

        });

        addPreferenceButton.disabled = preferences.length >= 3;

    }

    // Add a new wanted book.
    addPreferenceButton.addEventListener('click', function () {

        const preferences = preferencesContainer.querySelectorAll('[data-preference]');

        if (preferences.length >= 3) {
            return;
        }

        const newPreference = document.createElement('div');

        newPreference.className = 'preference-card';
        newPreference.setAttribute('data-preference', '');

        newPreference.innerHTML = `
            <div class="d-flex justify-content-between align-items-center mb-3">

                <h6 class="mb-0"></h6>

                <button type="button" class="btn btn-sm btn-outline-danger remove-preference">
                    <i class="bi bi-trash me-1"></i>
                    Remove
                </button>

            </div>

            <div class="row g-3">

                <div class="col-md-5">
                    <label class="form-label">Wanted Subject Code</label>
                    <input type="text" class="form-control preference-code">
                </div>

                <div class="col-md-7">
                    <label class="form-label">Wanted Book Name</label>
                    <input type="text" class="form-control preference-name">
                </div>

            </div>
        `;

        preferencesContainer.appendChild(newPreference);

        updatePreferenceNumbers();
        updateListingType();

    });

    // Remove a wanted book.
    preferencesContainer.addEventListener('click', function (event) {

        const removeButton = event.target.closest('.remove-preference');

        if (!removeButton) {
            return;
        }

        removeButton.closest('[data-preference]').remove();

        updatePreferenceNumbers();

    });

    // Prevent Exchange listings without at least one wanted book.
    editForm.addEventListener('submit', function (event) {

        const selectedType = document.querySelector('input[name="listing_type"]:checked').value;

        if (selectedType === 'exchange') {

            const preferences = preferencesContainer.querySelectorAll('[data-preference]');

            if (preferences.length === 0) {

                event.preventDefault();

                alert('Please add at least one wanted book before updating your listing.');

                return;
            }

        }

    });

    // Initial page setup.
    updatePreferenceNumbers();
    updateListingType();

});
</script>

</body>
</html>
