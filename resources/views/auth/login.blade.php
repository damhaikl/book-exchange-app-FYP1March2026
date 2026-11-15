<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Log in | UniKL BookHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --navy:#102f53; --navy-2:#173f6b; --navy-3:#245586; --sky:#dceafb; --ink:#14263d; --muted:#63758a; --line:#dce5ef; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; padding:32px; display:grid; place-items:center; color:var(--ink); background:radial-gradient(ellipse at 8% 8%,#dceafb 0,transparent 31%),#f4f7fb; font-family:'Instrument Sans',Arial,sans-serif; }
        .auth-shell { display:grid; grid-template-columns:.9fr 1.1fr; width:min(100%,940px); min-height:590px; overflow:hidden; border:1px solid #dce5ef; border-radius:24px; background:#fff; box-shadow:0 28px 80px #102f531a; }
        .auth-aside { position:relative; display:flex; flex-direction:column; justify-content:space-between; overflow:hidden; padding:38px; color:#fff; background:radial-gradient(ellipse at 85% 20%,#2b5d8b 0,transparent 37%),linear-gradient(145deg,#0b2542,#173f6b); }
        .auth-aside::before,.auth-aside::after { position:absolute; content:""; border:1px solid #ffffff16; border-radius:50%; pointer-events:none; }
        .auth-aside::before { width:430px;height:430px; right:-225px;bottom:-120px; }
        .auth-aside::after { width:320px;height:320px; right:-170px;bottom:-65px; }
        .brand { position:relative; z-index:1; display:flex; align-items:center; gap:10px; color:#fff; font-weight:800; text-decoration:none; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d; }
        .aside-content { position:relative; z-index:1; padding:30px 0; }
        .aside-kicker { display:inline-flex; align-items:center; gap:8px; margin-bottom:20px; color:#d5e5f6; font-size:.75rem; font-weight:700; letter-spacing:.11em; text-transform:uppercase; }
        .aside-kicker i { color:#a9c9ed; }
        .aside-content h1 { max-width:390px; margin:0; font-size:clamp(2.3rem,4vw,3.7rem); font-weight:800; line-height:1.02; letter-spacing:-.06em; }
        .aside-content h1 span { color:#b8d5f5; }
        .aside-content p { max-width:350px; margin:20px 0 0; color:#d3e1f0; font-size:1rem; line-height:1.75; }
        .aside-note { position:relative; z-index:1; display:flex; align-items:center; gap:11px; color:#d3e1f0; font-size:.86rem; }
        .aside-note i { color:#b8d5f5; font-size:1.1rem; }
        .auth-main { display:flex; flex-direction:column; justify-content:center; padding:42px clamp(28px,6vw,68px); }
        .top-link { display:inline-flex; align-items:center; gap:8px; color:var(--navy-3); font-size:.9rem; font-weight:700; text-decoration:none; }
        .top-link:hover { color:#0b2542; }
        .form-heading { margin:38px 0 27px; }
        .form-heading .kicker { margin:0 0 7px; color:var(--navy-3); font-size:.75rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .form-heading h2 { margin:0; color:var(--navy); font-size:2.15rem; font-weight:800; letter-spacing:-.045em; }
        .form-heading p { margin:8px 0 0; color:var(--muted); font-size:.96rem; }
        .form-label { margin-bottom:7px; color:#233b56; font-size:.88rem; font-weight:700; }
        .form-control { min-height:49px; border:1px solid #d5dfeb; border-radius:10px; color:var(--ink); background:#fff; font-size:.94rem; box-shadow:none; }
        .form-control::placeholder { color:#9aa9b9; }
        .form-control:focus { border-color:#6e9bc9; box-shadow:0 0 0 3px #dceafb; }
        .input-group .form-control { border-radius:10px 0 0 10px; }
        .input-group .form-control:focus { z-index:2; }
        .password-toggle { min-width:50px; border:1px solid #d5dfeb; border-left:0; border-radius:0 10px 10px 0; color:var(--navy-3); background:#f7f9fc; }
        .password-toggle:hover,.password-toggle:focus { color:var(--navy); background:#eaf1f9; }
        .form-check-input { border-color:#bdcad8; }
        .form-check-input:checked { border-color:var(--navy); background-color:var(--navy); }
        .form-check-input:focus { border-color:#6e9bc9; box-shadow:0 0 0 3px #dceafb; }
        .form-check-label { color:#536a82; font-size:.88rem; }
        .field-error { display:block; margin-top:6px; color:#b42336; font-size:.82rem; }
        .status-message { margin:0 0 18px; padding:11px 13px; border:1px solid #b9e5cc; border-radius:10px; color:#23744a; background:#effaf3; font-size:.9rem; }
        .submit-button { min-height:50px; border:0; border-radius:10px; color:#fff; background:var(--navy); font-weight:800; box-shadow:0 8px 18px #102f5324; transition:transform .2s,background .2s,box-shadow .2s; }
        .submit-button:hover,.submit-button:focus { color:#fff; background:#0b2542; transform:translateY(-1px); box-shadow:0 12px 24px #102f5330; }
        .forgot-link { display:block; margin-top:15px; color:var(--navy-3); text-align:center; font-size:.86rem; font-weight:700; text-decoration:none; }
        .forgot-link:hover,.signup-prompt a:hover { text-decoration:underline; }
        .signup-prompt { margin:27px 0 0; padding-top:22px; border-top:1px solid #e8edf3; color:var(--muted); text-align:center; font-size:.9rem; }
        .signup-prompt a { color:var(--navy-3); font-weight:800; text-decoration:none; }
        @media(max-width:760px) { body { padding:18px; } .auth-shell { grid-template-columns:1fr; max-width:560px; } .auth-aside { min-height:250px; padding:25px 28px; } .aside-content { padding:25px 0 15px; } .aside-content h1 { font-size:2.5rem; } .aside-note { display:none; } .auth-main { padding:30px clamp(22px,6vw,42px) 36px; } .form-heading { margin:25px 0 22px; } }
        @media(max-width:480px) { body { display:block; padding:0; background:#fff; } .auth-shell { min-height:100vh; border:0; border-radius:0; box-shadow:none; } .auth-aside { min-height:220px; padding:20px 22px; } .aside-content { padding:20px 0 12px; } .aside-content h1 { font-size:2.2rem; } .aside-content p { margin-top:12px; font-size:.9rem; } .auth-main { padding:25px 22px 35px; } .form-heading h2 { font-size:1.9rem; } }
    </style>
</head>
<body>
    <main class="auth-shell">
        <aside class="auth-aside">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true"><i class="bi bi-book-half"></i></span>
                <span>UniKL BookHub</span>
            </a>
            <div class="aside-content">
                <div class="aside-kicker"><i class="bi bi-stars" aria-hidden="true"></i> Welcome back</div>
                <h1>Your next<br><span>chapter awaits.</span></h1>
                <p>Log in to continue discovering books, managing your listings, and connecting with the UniKL student community.</p>
            </div>
            <div class="aside-note"><i class="bi bi-bookmark-heart" aria-hidden="true"></i><span>Your campus book community</span></div>
        </aside>

        <section class="auth-main" aria-labelledby="login-title">
            <a href="{{ url('/') }}" class="top-link"><i class="bi bi-arrow-left" aria-hidden="true"></i> Back to home</a>
            <div class="form-heading">
                <p class="kicker">Welcome back</p>
                <h2 id="login-title">Log in to BookHub</h2>
                <p>Enter your account details to continue.</p>
            </div>

            @if (session('status'))
                <div class="status-message" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" autocomplete="username" placeholder="you@example.com">
                    @error('email') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control" placeholder="Enter your password">
                        <button id="togglePassword" class="btn password-toggle" type="button" aria-label="Show password" aria-controls="password" aria-pressed="false">
                            <i class="bi bi-eye" aria-hidden="true"></i>
                            <span class="visually-hidden">Show password</span>
                        </button>
                    </div>
                    @error('password') <small class="field-error">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                        <label for="remember_me" class="form-check-label">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link" style="margin:0;text-align:right">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn submit-button w-100">Log in <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i></button>
                <p class="signup-prompt">Don’t have an account? <a href="{{ route('register') }}">Sign up</a></p>
            </form>
        </section>
    </main>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const emailInput = document.getElementById("email");
        const rememberCheckbox = document.getElementById("remember_me");
        const passwordInput = document.getElementById("password");
        const togglePasswordButton = document.getElementById("togglePassword");

        togglePasswordButton.addEventListener("click", function () {
            const showPassword = passwordInput.type === "password";
            passwordInput.type = showPassword ? "text" : "password";
            togglePasswordButton.setAttribute("aria-label", showPassword ? "Hide password" : "Show password");
            togglePasswordButton.setAttribute("aria-pressed", String(showPassword));
            togglePasswordButton.querySelector("i").className = showPassword ? "bi bi-eye-slash" : "bi bi-eye";
            togglePasswordButton.querySelector(".visually-hidden").textContent = showPassword ? "Hide password" : "Show password";
        });

        const savedEmail = localStorage.getItem("remembered_email");
        if (savedEmail) {
            emailInput.value = savedEmail;
            rememberCheckbox.checked = true;
        }

        document.querySelector("form").addEventListener("submit", function () {
            if (rememberCheckbox.checked) {
                localStorage.setItem("remembered_email", emailInput.value);
            } else {
                localStorage.removeItem("remembered_email");
            }
        });
    });
    </script>
</body>
</html>
