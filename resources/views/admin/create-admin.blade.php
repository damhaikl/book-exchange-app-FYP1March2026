<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Create admin | UniKL MIIT BookHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --navy:#102f53; --navy-dark:#0b2542; --navy-mid:#245586; --sky:#dceafb; --ink:#14263d; --muted:#63758a; --line:#dce5ef; --page:#f4f7fb; }
        * { box-sizing:border-box; }
        body { margin:0;min-height:100vh;color:var(--ink);background:var(--page);font-family:'Instrument Sans',Arial,sans-serif; }
        .site-header { position:relative;overflow:hidden;color:#fff;background:radial-gradient(ellipse at 85% 20%,#2b5d8b 0,transparent 36%),linear-gradient(130deg,#0b2542,#173f6b); }
        .site-header::after { position:absolute;content:"";width:380px;height:380px;right:-145px;top:-245px;border:1px solid #ffffff18;border-radius:50%;box-shadow:0 0 0 45px #ffffff08,0 0 0 90px #ffffff05;pointer-events:none; }
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1000px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand:hover { color:#fff; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .header-actions { display:flex;align-items:center;gap:9px; }
        .header-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.86rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .header-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1000px;margin:auto;padding:28px 28px 48px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p:last-child { max-width:620px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .page-main { position:relative;z-index:2;max-width:760px;margin:-20px auto 0;padding:0 28px 56px; }
        .form-card { overflow:hidden;border:1px solid var(--line);border-radius:17px;background:#fff;box-shadow:0 14px 38px #173f6b0d; }
        .form-card-heading { display:flex;align-items:center;gap:14px;padding:21px 24px;border-bottom:1px solid #e8edf3; }
        .form-icon { display:grid;place-items:center;flex:0 0 48px;width:48px;height:48px;border-radius:14px;color:var(--navy-mid);background:var(--sky);font-size:1.3rem; }
        .form-card-heading h2 { margin:0;color:var(--navy);font-size:1.08rem;font-weight:800; }
        .form-card-heading p { margin:4px 0 0;color:var(--muted);font-size:.85rem; }
        .form-card-body { padding:24px; }
        .form-grid { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px 16px; }
        .field { min-width:0; }
        .field-full { grid-column:1/-1; }
        .form-label { display:block;margin:0 0 7px;color:#29435f;font-size:.84rem;font-weight:700; }
        .required-mark { color:#b43a45; }
        .form-control { min-height:45px;border:1px solid #d5dfeb;border-radius:10px;color:var(--ink);font-size:.9rem;box-shadow:none; }
        .form-control::placeholder { color:#91a0b0; }
        .form-control:focus { border-color:#6e9bc9;box-shadow:0 0 0 3px #dceafb; }
        .form-control.is-invalid { border-color:#d77a82;background-image:none; }
        .field-error { display:block;margin-top:6px;color:#a3313b;font-size:.78rem; }
        .field-hint { margin:6px 0 0;color:var(--muted);font-size:.76rem; }
        .alert { margin:0 0 18px;padding:12px 14px;border:1px solid transparent;border-radius:11px;font-size:.88rem; }
        .alert-success { color:#245e43;background:#eaf6ef;border-color:#cce8d5; }
        .alert-danger { color:#8b3038;background:#fff0f1;border-color:#f1d0d3; }
        .alert ul { margin:7px 0 0;padding-left:20px; }
        .form-actions { display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:24px;padding-top:20px;border-top:1px solid #e8edf3; }
        .form-note { display:flex;align-items:center;gap:7px;margin:0;color:var(--muted);font-size:.78rem; }
        .form-note i { color:var(--navy-mid); }
        .btn-primary { min-height:43px;padding:10px 16px;border:1px solid var(--navy);border-radius:10px;color:#fff;background:var(--navy);font-size:.88rem;font-weight:700; }
        .btn-primary:hover,.btn-primary:focus { color:#fff;background:var(--navy-dark);border-color:var(--navy-dark); }
        @media(max-width:600px) {
            .header-inner { padding:14px 18px; }
            .page-intro { padding:25px 20px 42px; }
            .page-main { padding:0 14px 36px; }
            .form-card-heading { padding:18px; }
            .form-card-body { padding:18px; }
            .form-grid { grid-template-columns:1fr;gap:15px; }
            .field-full { grid-column:auto; }
            .form-actions { align-items:stretch;flex-direction:column; }
            .form-actions .btn { width:100%; }
            .header-link span { display:none; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true"><i class="bi bi-book-half"></i></span>
                <span>UniKL MIIT BookHub</span>
            </a>
            <nav class="header-actions" aria-label="Page navigation">
                <a href="{{ route('admin.list') }}" class="header-link"><i class="bi bi-people" aria-hidden="true"></i><span>Admin list</span></a>
                <a href="{{ route('dashboard') }}" class="header-link"><i class="bi bi-arrow-left" aria-hidden="true"></i><span>Dashboard</span></a>
            </nav>
        </div>
        <div class="page-intro">
            <p class="eyebrow">Administration</p>
            <h1>Create an admin account</h1>
            <p>Add an administrator who can help manage UniKL MIIT BookHub.</p>
        </div>
    </header>

    <main class="page-main">
        <section class="form-card" aria-labelledby="form-title">
            <div class="form-card-heading">
                <div class="form-icon" aria-hidden="true"><i class="bi bi-person-plus"></i></div>
                <div>
                    <h2 id="form-title">Administrator details</h2>
                    <p>Enter the new administrator’s account information.</p>
                </div>
            </div>

            <div class="form-card-body">
                @if(session('success'))
                    <div class="alert alert-success" role="status">
                        <i class="bi bi-check-circle me-1" aria-hidden="true"></i>{{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <strong>Please check the following fields:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.store') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="field">
                            <label class="form-label" for="studentid">Admin ID <span class="required-mark" aria-hidden="true">*</span></label>
                            <input id="studentid" class="form-control @error('studentid') is-invalid @enderror" type="text" name="studentid" value="{{ old('studentid') }}" placeholder="Enter admin ID" autocomplete="username" required>
                            @error('studentid')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label class="form-label" for="name">Full name <span class="required-mark" aria-hidden="true">*</span></label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Enter full name" autocomplete="name" required>
                            @error('name')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="field field-full">
                            <label class="form-label" for="email">Email address <span class="required-mark" aria-hidden="true">*</span></label>
                            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>
                            @error('email')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label class="form-label" for="password">Password <span class="required-mark" aria-hidden="true">*</span></label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="At least 8 characters" autocomplete="new-password" required>
                            <p class="field-hint">Use at least 8 characters.</p>
                            @error('password')<span class="field-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label class="form-label" for="password_confirmation">Confirm password <span class="required-mark" aria-hidden="true">*</span></label>
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Enter the password again" autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="form-actions">
                        <p class="form-note"><i class="bi bi-shield-lock" aria-hidden="true"></i>New accounts are created with the admin role.</p>
                        <button class="btn btn-primary" type="submit"><i class="bi bi-person-plus me-1" aria-hidden="true"></i>Create admin</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
