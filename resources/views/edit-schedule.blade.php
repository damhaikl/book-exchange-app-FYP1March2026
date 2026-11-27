
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Edit Meeting Schedule | UniKL BookHub</title>

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

        .schedule-card {
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
            padding: 15px 16px;
            margin-bottom: 23px;
            border: 1px solid #dce7f3;
            border-radius: 11px;
            background: #f0f5fb;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 11px;
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
        }

        .form-label {
            margin-bottom: 8px;
            color: var(--navy);
            font-size: .87rem;
            font-weight: 800;
        }

        .form-control {
            padding: 11px 13px;
            border: 1px solid var(--line);
            border-radius: 9px;
            color: var(--ink);
            font-size: .88rem;
        }

        .form-control:focus {
            border-color: var(--navy-mid);
            box-shadow: 0 0 0 3px #24558618;
        }

        .form-hint {
            margin-top: 7px;
            color: var(--muted);
            font-size: .78rem;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 25px;
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

            .schedule-card {
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
                <span>UniKL BookHub</span>
            </a>

            <a href="{{ route('dashboard') }}" class="header-link">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>

        </div>

        <div class="page-intro">
            <p class="eyebrow">Meeting arrangements</p>

            <h1>Edit Meeting Schedule</h1>

            <p>
                Update your meeting location, date and time to arrange
                a convenient book handover with the other student.
            </p>
        </div>

    </header>

    <main class="page-main">

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-circle me-2"></i>
                Please check your schedule details and try again.

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="schedule-card">

            <div class="section-heading">
                <div class="section-icon">
                    <i class="bi bi-calendar-week"></i>
                </div>

                <div>
                    <h2>Meeting Schedule Details</h2>
                    <p>Update the arrangements for your book exchange.</p>
                </div>
            </div>

            <div class="info-box">
                <div class="info-item">
                    <i class="bi bi-info-circle"></i>

                    <div>
                        <span class="info-label">Schedule Information</span>
                        <div class="info-value">
                            Make sure the proposed meeting details are
                            convenient for both students.
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST"
                  action="{{ route('book.schedule.update', $book->id) }}">

                @csrf

                <div class="mb-4">
                    <label for="meeting_location" class="form-label">
                        <i class="bi bi-geo-alt me-1"></i>
                        Meeting Location <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        id="meeting_location"
                        name="meeting_location"
                        class="form-control"
                        value="{{ old('meeting_location', $book->meeting_location) }}"
                        placeholder="Enter meeting location"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="meeting_date" class="form-label">
                        <i class="bi bi-calendar3 me-1"></i>
                        Meeting Date <span class="text-danger">*</span>
                    </label>

                    <input
                        type="date"
                        id="meeting_date"
                        name="meeting_date"
                        class="form-control"
                        value="{{ old('meeting_date', $book->meeting_date) }}"
                        required
                    >
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="meeting_time" class="form-label">
                            <i class="bi bi-clock me-1"></i>
                            Start Time <span class="text-danger">*</span>
                        </label>

                        <input
                            type="time"
                            id="meeting_time"
                            name="meeting_time"
                            class="form-control"
                            value="{{ old('meeting_time', $book->meeting_time ? substr($book->meeting_time, 0, 5) : '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="meeting_end_time" class="form-label">
                            <i class="bi bi-clock-history me-1"></i>
                            End Time <span class="text-danger">*</span>
                        </label>

                        <input
                            type="time"
                            id="meeting_end_time"
                            name="meeting_end_time"
                            class="form-control"
                            value="{{ old('meeting_end_time', $book->meeting_end_time ? substr($book->meeting_end_time, 0, 5) : '') }}"
                            required
                        >
                    </div>
                </div>

                <p class="form-hint">
                    <i class="bi bi-lightbulb me-1"></i>
                    Please ensure the end time is later than the start time.
                </p>

                <div class="form-actions">

                    <button type="submit" class="btn-submit">
                        <i class="bi bi-check-circle"></i>
                        Save Changes
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
