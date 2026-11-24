
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Create a book listing | UniKL BookHub</title>

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
            max-width:1250px;
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
            max-width:1250px;
            margin:auto;
            padding:32px 28px 48px;
        }

        .page-intro .eyebrow {
            margin:0 0 9px;
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
            margin:10px 0 0;
            color:#d3e1f0;
            line-height:1.65;
        }

        .page-main {
            position:relative;
            z-index:2;
            max-width:1050px;
            margin:-22px auto 0;
            padding:0 24px 56px;
        }

        .form-card {
            padding:clamp(22px,4vw,42px);
            border:1px solid var(--line);
            border-radius:18px;
            background:#fff;
            box-shadow:0 20px 55px #102f5312;
        }

        .section-heading {
            display:flex;
            align-items:center;
            gap:12px;
            margin:4px 0 19px;
            padding-bottom:12px;
            border-bottom:1px solid #e8edf3;
            color:var(--navy);
            font-size:1rem;
            font-weight:800;
        }

        .section-heading:not(:first-child) {
            margin-top:28px;
        }

        .section-icon {
            display:grid;
            place-items:center;
            width:37px;
            height:37px;
            border-radius:11px;
            color:var(--navy-mid);
            background:var(--sky);
            font-size:1rem;
        }

        .form-label {
            margin-bottom:7px;
            color:#29435f;
            font-size:.86rem;
            font-weight:700;
        }

        .form-control,.form-select {
            min-height:46px;
            border:1px solid #d5dfeb;
            border-radius:10px;
            color:var(--ink);
            background-color:#fff;
            font-size:.92rem;
            box-shadow:none;
        }

        textarea.form-control {
            min-height:120px;
            resize:vertical;
        }

        .form-control::placeholder {
            color:#9aa9b9;
        }

        .form-control:focus,.form-select:focus {
            border-color:#6e9bc9;
            box-shadow:0 0 0 3px #dceafb;
        }

        input[type=file].form-control {
            padding:.55rem .75rem;
        }

        input[type=file]::file-selector-button {
            margin:-.55rem .75rem -.55rem -.75rem;
            padding:.75rem .85rem;
            border:0;
            border-right:1px solid #d5dfeb;
            color:var(--navy-mid);
            background:#f3f7fb;
            font-weight:700;
        }

        .form-hint {
            display:block;
            margin-top:7px;
            color:var(--muted);
            font-size:.8rem;
            line-height:1.5;
        }

        .field-error {
            display:block;
            margin-top:6px;
            color:#b42336;
            font-size:.82rem;
        }

        .alert {
            border:0;
            border-radius:12px;
        }

        .meeting-tip {
            display:flex;
            align-items:flex-start;
            gap:12px;
            margin:23px 0 0;
            padding:15px 16px;
            border:1px solid #c8dcef;
            border-radius:12px;
            color:#35526f;
            background:#f1f7fd;
            font-size:.88rem;
            line-height:1.55;
        }

        .meeting-tip i {
            color:var(--navy-mid);
            font-size:1.1rem;
        }

        .submit-button {
            min-height:50px;
            margin-top:24px;
            border:0;
            border-radius:10px;
            color:#fff;
            background:var(--navy);
            font-weight:800;
            box-shadow:0 8px 18px #102f5324;
            transition:transform .2s,background .2s,box-shadow .2s;
        }

        .submit-button:hover,.submit-button:focus {
            color:#fff;
            background:var(--navy-dark);
            transform:translateY(-1px);
            box-shadow:0 12px 24px #102f5330;
        }

        .listing-choice {
            display:block;
            height:100%;
            padding:18px;
            border:1px solid var(--line);
            border-radius:12px;
            cursor:pointer;
            transition:.2s;
        }

        .listing-choice:has(input:checked) {
            border:2px solid var(--navy-mid);
            background:#f1f7fd;
        }

        .listing-choice input {
            margin-right:7px;
            accent-color:var(--navy);
        }

        .listing-choice strong {
            color:var(--navy);
        }

        .exchange-item {
            padding:17px;
            border:1px solid var(--line);
            border-radius:12px;
            background:#f8fafd;
        }

        .exchange-item h3 {
            margin:0 0 14px;
            color:var(--navy);
            font-size:.92rem;
            font-weight:800;
        }

        .add-preference {
            min-height:42px;
            border:1px dashed #8ba8c7;
            border-radius:9px;
            color:var(--navy-mid);
            background:#f5f9fd;
            font-weight:700;
        }

        .add-preference:hover {
            color:var(--navy);
            background:#eaf2fb;
        }

        @media(max-width:575px) {
            .header-inner { padding:14px 18px; }
            .page-intro { padding:27px 20px 42px; }
            .back-link span { display:none; }
            .page-main { padding:0 14px 36px; }
            .form-card { padding:22px 18px; }
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

            <a href="{{ route('book.myListings') }}" class="back-link">
                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                <span>Back to my listings</span>
            </a>
        </div>

        <div class="page-intro">
            <p class="eyebrow">Share a learning resource</p>
            <h1>Create a book listing</h1>
            <p>Add your book details and choose whether you want to sell or exchange your book with other UniKL students.</p>
        </div>
    </header>

    <main class="page-main">

        @if(session('success'))
            <div class="alert alert-success mb-3" role="status">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-3" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                Please check the highlighted fields below.
            </div>
        @endif

        <section class="form-card" aria-label="Book listing details">

            <form method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- LISTING TYPE -->
                <h2 class="section-heading">
                    <span class="section-icon"><i class="bi bi-arrow-left-right"></i></span>
                    Listing type
                </h2>

                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-6">
                        <label class="listing-choice">
                            <input type="radio" name="listing_type" value="sell"
                                {{ old('listing_type', 'sell') === 'sell' ? 'checked' : '' }}>
                            <strong><i class="bi bi-tag me-1"></i> Sell a Book</strong>
                            <span class="form-hint">List your book with a selling price.</span>
                        </label>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="listing-choice">
                            <input type="radio" name="listing_type" value="exchange"
                                {{ old('listing_type') === 'exchange' ? 'checked' : '' }}>
                            <strong><i class="bi bi-arrow-left-right me-1"></i> Exchange a Book</strong>
                            <span class="form-hint">Offer your book in exchange for another book.</span>
                        </label>
                    </div>
                </div>

                @error('listing_type')
                    <small class="field-error">{{ $message }}</small>
                @enderror

                <!-- BOOK INFORMATION -->
                <h2 class="section-heading">
                    <span class="section-icon"><i class="bi bi-book"></i></span>
                    Book information
                </h2>

                <div class="row g-3">

                    <div class="col-12">
                        <label for="booktitle" class="form-label">Book title</label>
                        <input id="booktitle" type="text" name="booktitle"
                            class="form-control" value="{{ old('booktitle') }}"
                            placeholder="Enter the title printed on the book" required>
                        @error('booktitle')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12">
                        <label for="bookdescription" class="form-label">Description</label>
                        <textarea id="bookdescription" name="bookdescription"
                            class="form-control" rows="4"
                            placeholder="Add details about the book, edition, or included materials" required>{{ old('bookdescription') }}</textarea>
                        @error('bookdescription')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <!-- SELL PRICE -->
                    <div class="col-12 col-md-6" id="priceSection">
                        <label for="price" class="form-label">Selling price (RM)</label>
                        <input id="price" type="number" step="0.01" min="0"
                            name="price" class="form-control"
                            value="{{ old('price') }}" placeholder="e.g. 25.00">
                        @error('price')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="condition" class="form-label">Book condition</label>
                        <select id="condition" name="condition" class="form-select" required>
                            <option value="" disabled {{ old('condition') ? '' : 'selected' }}>Select condition</option>
                            @foreach(['New', 'Like New', 'Used'] as $condition)
                                <option value="{{ $condition }}" {{ old('condition') === $condition ? 'selected' : '' }}>
                                    {{ $condition }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12">
                        <label for="image" class="form-label">Book cover image</label>
                        <input id="image" type="file" name="image"
                            class="form-control" accept=".jpg,.jpeg,.png" required>
                        <small class="form-hint">Upload a clear photo of the book cover.</small>
                        @error('image')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12 col-md-5">
                        <label for="subject_id" class="form-label">Subject ID / Course Code</label>
                        <input id="subject_id" type="text" name="subject_id"
                            class="form-control" value="{{ old('subject_id') }}"
                            placeholder="e.g. WMD10101" required>
                        @error('subject_id')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12 col-md-7">
                        <label for="subject_category" class="form-label">Subject category</label>
                        <select id="subject_category" name="subject_category" class="form-select" required>
                            <option value="" disabled {{ old('subject_category') ? '' : 'selected' }}>Select a category</option>
                            @foreach(\App\Models\Book::SUBJECT_CATEGORIES as $category)
                                <option value="{{ $category }}" {{ old('subject_category') === $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-hint">Choose the category that best describes this book’s subject.</small>
                        @error('subject_category')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                </div>

                <!-- EXCHANGE PREFERENCES -->
                <div id="exchangeSection" style="display:none;">

                    <h2 class="section-heading">
                        <span class="section-icon"><i class="bi bi-arrow-left-right"></i></span>
                        Books you want in exchange
                    </h2>

                    <p class="form-hint mb-3">
                        Enter at least one book you would like in return. You can add up to 3 choices.
                        You only need to receive one of your selected books.
                    </p>

                    <div id="exchangePreferences" class="d-grid gap-3">

                        @for($i = 0; $i < max(1, count(old('exchange_preferences', []))); $i++)
                            <div class="exchange-item" data-preference>
                                <h3>Wanted Book {{ $i + 1 }}</h3>

                                <div class="row g-3">
                                    <div class="col-12 col-md-5">
                                        <label class="form-label">Wanted course code</label>
                                        <input type="text"
                                            name="exchange_preferences[{{ $i }}][wanted_subject_id]"
                                            class="form-control preference-code"
                                            value="{{ old("exchange_preferences.$i.wanted_subject_id") }}"
                                            placeholder="e.g. WMD10101">
                                    </div>

                                    <div class="col-12 col-md-7">
                                        <label class="form-label">Wanted book name</label>
                                        <input type="text"
                                            name="exchange_preferences[{{ $i }}][wanted_book_name]"
                                            class="form-control preference-name"
                                            value="{{ old("exchange_preferences.$i.wanted_book_name") }}"
                                            placeholder="Enter the book name">
                                    </div>
                                </div>

                                @error("exchange_preferences.$i.wanted_subject_id")
                                    <small class="field-error">{{ $message }}</small>
                                @enderror

                                @error("exchange_preferences.$i.wanted_book_name")
                                    <small class="field-error">{{ $message }}</small>
                                @enderror
                            </div>
                        @endfor

                    </div>

                    <button type="button" id="addPreference" class="btn add-preference mt-3">
                        <i class="bi bi-plus-circle me-1"></i> Add another wanted book
                    </button>

                </div>

                <!-- MEETING DETAILS -->
                <h2 class="section-heading">
                    <span class="section-icon"><i class="bi bi-geo-alt"></i></span>
                    Meeting details
                </h2>

                <p class="form-hint mb-3">
                    Set your preferred public meeting place and available time.
                    These are your meeting preferences, not a confirmed appointment.
                </p>

                <div class="row g-3">

                    <div class="col-12">
                        <label for="meeting_location" class="form-label">Meeting location</label>
                        <input id="meeting_location" type="text" name="meeting_location"
                            class="form-control" value="{{ old('meeting_location') }}"
                            placeholder="e.g. UniKL MIIT Lobby / Library Entrance" required>
                        @error('meeting_location')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="meeting_date" class="form-label">Available date</label>
                        <input id="meeting_date" type="date" name="meeting_date"
                            class="form-control" value="{{ old('meeting_date') }}" required>
                        @error('meeting_date')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="meeting_time" class="form-label">Start time</label>
                        <input id="meeting_time" type="time" name="meeting_time"
                            class="form-control" value="{{ old('meeting_time') }}" required>
                        @error('meeting_time')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="meeting_end_time" class="form-label">End time</label>
                        <input id="meeting_end_time" type="time" name="meeting_end_time"
                            class="form-control" value="{{ old('meeting_end_time') }}" required>
                        @error('meeting_end_time')<small class="field-error">{{ $message }}</small>@enderror
                    </div>

                </div>

                <div class="meeting-tip">
                    <i class="bi bi-lightbulb" aria-hidden="true"></i>
                    <span>
                        <strong>Smart meeting tip:</strong>
                        Choose a safe, public location and set a time range when you are available.
                    </span>
                </div>

                <button type="submit" class="btn submit-button w-100">
                    Publish book listing
                    <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
                </button>

            </form>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const listingTypes = document.querySelectorAll('input[name="listing_type"]');
            const priceSection = document.getElementById('priceSection');
            const priceInput = document.getElementById('price');
            const exchangeSection = document.getElementById('exchangeSection');
            const preferencesContainer = document.getElementById('exchangePreferences');
            const addPreferenceButton = document.getElementById('addPreference');

            function updateListingType() {
                const selectedType = document.querySelector('input[name="listing_type"]:checked')?.value || 'sell';

                const isSell = selectedType === 'sell';
                const isExchange = selectedType === 'exchange';

                priceSection.style.display = isSell ? '' : 'none';
                priceInput.required = isSell;
                priceInput.disabled = !isSell;

                exchangeSection.style.display = isExchange ? '' : 'none';

                preferencesContainer.querySelectorAll('input').forEach(input => {
                    input.required = isExchange;
                    input.disabled = !isExchange;
                });
            }

            listingTypes.forEach(radio => {
                radio.addEventListener('change', updateListingType);
            });

            function updatePreferenceNumbers() {
                const items = preferencesContainer.querySelectorAll('[data-preference]');

                items.forEach((item, index) => {
                    item.querySelector('h3').textContent = 'Wanted Book ' + (index + 1);
                    item.querySelectorAll('input').forEach(input => {
                        const field = input.classList.contains('preference-code')
                            ? 'wanted_subject_id'
                            : 'wanted_book_name';

                        input.name = `exchange_preferences[${index}][${field}]`;
                    });
                });

                addPreferenceButton.style.display = items.length >= 3 ? 'none' : '';
            }

            addPreferenceButton.addEventListener('click', function () {
                const currentItems = preferencesContainer.querySelectorAll('[data-preference]');

                if (currentItems.length >= 3) {
                    return;
                }

                const index = currentItems.length;

                const item = document.createElement('div');
                item.className = 'exchange-item';
                item.setAttribute('data-preference', '');

                item.innerHTML = `
                    <h3>Wanted Book ${index + 1}</h3>
                    <div class="row g-3">
                        <div class="col-12 col-md-5">
                            <label class="form-label">Wanted course code</label>
                            <input type="text"
                                class="form-control preference-code"
                                placeholder="e.g. WMD10101">
                        </div>
                        <div class="col-12 col-md-7">
                            <label class="form-label">Wanted book name</label>
                            <input type="text"
                                class="form-control preference-name"
                                placeholder="Enter the book name">
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-3 remove-preference">
                        <i class="bi bi-trash me-1"></i> Remove
                    </button>
                `;

                preferencesContainer.appendChild(item);

                updatePreferenceNumbers();
                updateListingType();
            });

            preferencesContainer.addEventListener('click', function (event) {
                const removeButton = event.target.closest('.remove-preference');

                if (!removeButton) {
                    return;
                }

                removeButton.closest('[data-preference]').remove();

                updatePreferenceNumbers();
                updateListingType();
            });

            updatePreferenceNumbers();
            updateListingType();
        });
    </script>

</body>
</html>
