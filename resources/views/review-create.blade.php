
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Write a Review | UniKL MIIT BookHub</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --navy: #102f53;
            --navy-dark: #0b2542;
            --navy-mid: #245586;
            --sky: #dceafb;
            --ink: #14263d;
            --muted: #63758a;
            --line: #dce5ef;
            --page: #f4f7fb;
            --gold: #f5a623;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--ink);
            background: var(--page);
            font-family: 'Instrument Sans', Arial, sans-serif;
        }

        .site-header {
            position: relative;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(ellipse at 85% 20%, #2b5d8b 0, transparent 36%),
                linear-gradient(130deg, #0b2542, #173f6b);
        }

        .site-header::after {
            position: absolute;
            content: "";
            width: 380px;
            height: 380px;
            right: -145px;
            top: -245px;
            border: 1px solid #ffffff18;
            border-radius: 50%;
            box-shadow: 0 0 0 45px #ffffff08,
                        0 0 0 90px #ffffff05;
        }

        .header-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            max-width: 1000px;
            margin: auto;
            padding: 18px 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-weight: 800;
            letter-spacing: -.02em;
            text-decoration: none;
        }

        .brand-mark {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: #ffffff1d;
            color: #fff;
        }

        .header-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 13px;
            border: 1px solid #ffffff70;
            border-radius: 9px;
            color: #fff;
            font-size: .84rem;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s, color .2s;
        }

        .header-link:hover {
            color: var(--navy);
            background: #fff;
        }

        .page-intro {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: auto;
            padding: 28px 28px 55px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: #b8d5f5;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .page-intro h1 {
            margin: 0;
            color: #fff;
            font-size: clamp(2rem, 4vw, 2.7rem);
            font-weight: 800;
            letter-spacing: -.055em;
        }

        .page-intro p {
            max-width: 600px;
            margin: 9px 0 0;
            color: #d3e1f0;
            line-height: 1.65;
        }

        .page-main {
            position: relative;
            z-index: 2;
            max-width: 760px;
            margin: -25px auto 0;
            padding: 0 20px 55px;
        }

        .review-card {
            padding: 28px;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 12px 35px #173f6b10;
        }

        .section-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 18px;
            margin-bottom: 22px;
            border-bottom: 1px solid #e8edf3;
        }

        .section-icon {
            display: grid;
            place-items: center;
            width: 45px;
            height: 45px;
            flex-shrink: 0;
            border-radius: 12px;
            color: var(--navy-mid);
            background: var(--sky);
            font-size: 1.25rem;
        }

        .section-heading h2 {
            margin: 0;
            color: var(--navy);
            font-size: 1.1rem;
            font-weight: 800;
        }

        .section-heading p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: .82rem;
        }

        .info-box {
            padding: 16px;
            margin-bottom: 22px;
            border: 1px solid #dce7f3;
            border-radius: 11px;
            background: #f0f5fb;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 11px;
        }

        .info-item + .info-item {
            margin-top: 13px;
        }

        .info-item i {
            margin-top: 2px;
            color: var(--navy-mid);
        }

        .info-label {
            display: block;
            margin-bottom: 3px;
            color: var(--muted);
            font-size: .76rem;
            font-weight: 600;
        }

        .info-value {
            color: var(--navy);
            font-size: .9rem;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .form-label {
            margin-bottom: 8px;
            color: var(--navy);
            font-size: .87rem;
            font-weight: 800;
        }

        .form-select,
        .form-control {
            padding: 11px 13px;
            border: 1px solid var(--line);
            border-radius: 9px;
            color: var(--ink);
            font-size: .88rem;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--navy-mid);
            box-shadow: 0 0 0 3px #24558618;
        }

        .rating-hint {
            margin-top: 7px;
            color: var(--muted);
            font-size: .78rem;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 18px;
            border: 1px solid var(--navy);
            border-radius: 9px;
            color: #fff;
            background: var(--navy);
            font-size: .87rem;
            font-weight: 800;
            text-decoration: none;
            transition: background .2s;
        }

        .btn-submit:hover {
            color: #fff;
            background: var(--navy-dark);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            border: 1px solid var(--line);
            border-radius: 9px;
            color: var(--navy);
            background: #fff;
            font-size: .87rem;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-back:hover {
            background: #f4f7fb;
        }

        .alert {
            border: 0;
            border-radius: 10px;
        }

        @media (max-width: 620px) {
            .header-inner {
                padding: 14px 18px;
            }

            .page-intro {
                padding: 25px 20px 48px;
            }

            .page-main {
                padding: 0 14px 36px;
            }

            .review-card {
                padding: 19px;
            }

            .form-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .form-actions a,
            .form-actions button {
                width: 100%;
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
                <span>UniKL MIIT BookHub</span>
            </a>

            <a href="{{ route('dashboard') }}" class="header-link">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>

        </div>

        <div class="page-intro">
            <p class="eyebrow">Your feedback matters</p>

            <h1>Write a Review</h1>

            <p>
                Share your experience and help other UniKL MIIT students
                build a trusted book trading community.
            </p>
        </div>

    </header>

    <main class="page-main">

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>
                Please check your rating and try again.
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="review-card">

            <div class="section-heading">
                <div class="section-icon">
                    <i class="bi bi-chat-square-heart"></i>
                </div>

                <div>
                    <h2>Rating & Review Details</h2>
                    <p>Review your experience with the other student.</p>
                </div>
            </div>

            <div class="info-box">

                <div class="info-item">
                    <i class="bi bi-book"></i>

                    <div>
                        <span class="info-label">Book</span>
                        <div class="info-value">
                            {{ $request->book->title }}
                        </div>
                    </div>
                </div>

                <div class="info-item">
                    <i class="bi bi-person-badge"></i>

                    <div>
                        <span class="info-label">Reviewing Student</span>
                        <div class="info-value">
                            {{ $reviewedUser->name }}
                        </div>
                    </div>
                </div>

            </div>

            <form method="POST" action="{{ route('review.store', $request->id) }}">
                @csrf

                <div class="mb-4">
                    <label for="rating" class="form-label">
                        Rating <span class="text-danger">*</span>
                    </label>

                    <select
                        name="rating"
                        id="rating"
                        class="form-select"
                        required
                    >
                        <option value="">-- Select Rating --</option>
                        <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (Excellent)</option>
                        <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (Very Good)</option>
                        <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (Good)</option>
                        <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ (Fair)</option>
                        <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ (Poor)</option>
                    </select>

                    <p class="rating-hint">
                        Your rating helps other students understand their experience.
                    </p>
                </div>

                <div class="mb-2">
                    <label for="comment" class="form-label">
                        Written Review
                    </label>

                    <textarea
                        name="comment"
                        id="comment"
                        class="form-control"
                        rows="5"
                        maxlength="2000"
                        placeholder="Share your experience with this student..."
                    >{{ old('comment') }}</textarea>

                    <p class="rating-hint">
                        Optional. Maximum 2,000 characters.
                    </p>
                </div>

                <div class="form-actions">

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-send"></i>
                        Submit Review
                    </button>

                    <a href="{{ url()->previous() }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Go Back
                    </a>

                </div>

            </form>

        </section>

    </main>

</body>
</html>
