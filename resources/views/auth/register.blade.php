<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>Create account | UniKL BookHub</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --navy:#102f53; --navy-2:#173f6b; --navy-3:#245586; --sky:#dceafb; --ink:#14263d; --muted:#63758a; --line:#dce5ef; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; padding:32px; display:grid; place-items:center; color:var(--ink); background:radial-gradient(ellipse at 8% 8%,#dceafb 0,transparent 31%),#f4f7fb; font-family:'Instrument Sans',Arial,sans-serif; }
        .signup-shell { display:grid; grid-template-columns:.82fr 1.18fr; width:min(100%,1040px); min-height:690px; overflow:hidden; border:1px solid #dce5ef; border-radius:24px; background:#fff; box-shadow:0 28px 80px #102f531a; }
        .signup-aside { position:relative; display:flex; flex-direction:column; justify-content:space-between; overflow:hidden; padding:38px; color:#fff; background:radial-gradient(ellipse at 85% 20%,#2b5d8b 0,transparent 37%),linear-gradient(145deg,#0b2542,#173f6b); }
        .signup-aside::before,.signup-aside::after { position:absolute; content:""; border:1px solid #ffffff16; border-radius:50%; pointer-events:none; }
        .signup-aside::before { width:430px;height:430px; right:-225px;bottom:-120px; }
        .signup-aside::after { width:320px;height:320px; right:-170px;bottom:-65px; }
        .brand { position:relative; z-index:1; display:flex; align-items:center; gap:10px; color:#fff; font-weight:800; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d; }
        .aside-content { position:relative; z-index:1; padding:30px 0; }
        .aside-kicker { display:inline-flex; align-items:center; gap:8px; margin-bottom:20px; color:#d5e5f6; font-size:.75rem; font-weight:700; letter-spacing:.11em; text-transform:uppercase; }
        .aside-kicker i { color:#a9c9ed; }
        .aside-content h1 { max-width:400px; margin:0; font-size:clamp(2.3rem,4vw,3.7rem); font-weight:800; line-height:1.02; letter-spacing:-.06em; }
        .aside-content h1 span { color:#b8d5f5; }
        .aside-content p { max-width:360px; margin:20px 0 0; color:#d3e1f0; font-size:1rem; line-height:1.75; }
        .aside-note { position:relative; z-index:1; display:flex; align-items:center; gap:11px; color:#d3e1f0; font-size:.86rem; }
        .aside-note i { color:#b8d5f5; font-size:1.1rem; }
        .signup-main { padding:38px clamp(26px,5vw,60px); }
        .top-link { display:inline-flex; align-items:center; gap:8px; color:var(--navy-3); font-size:.9rem; font-weight:700; text-decoration:none; }
        .top-link:hover { color:#0b2542; }
        .form-heading { margin:31px 0 23px; }
        .form-heading .kicker { margin:0 0 7px; color:var(--navy-3); font-size:.75rem; font-weight:800; letter-spacing:.12em; text-transform:uppercase; }
        .form-heading h2 { margin:0; color:var(--navy); font-size:2rem; font-weight:800; letter-spacing:-.04em; }
        .form-heading p { margin:7px 0 0; color:var(--muted); font-size:.94rem; }
        .form-label { margin-bottom:6px; color:#233b56; font-size:.86rem; font-weight:700; }
        .form-control,.form-select { min-height:46px; border:1px solid #d5dfeb; border-radius:10px; color:var(--ink); background-color:#fff; font-size:.92rem; box-shadow:none; }
        .form-control::placeholder { color:#9aa9b9; }
        .form-control:focus,.form-select:focus { border-color:#6e9bc9; box-shadow:0 0 0 3px #dceafb; }
        .form-control[readonly] { color:#526b86; background:#f3f7fb; }
        .form-hint { display:block; margin-top:6px; color:#74869a; font-size:.78rem; line-height:1.45; }
        .form-hint.is-error { color:#b42336; }
        .form-hint.is-success { color:#23744a; }
        .field-error { display:block; margin-top:5px; color:#b42336; font-size:.8rem; }
        .form-section-title { display:flex; align-items:center; gap:10px; margin:23px 0 13px; color:var(--navy); font-size:.8rem; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
        .form-section-title::after { flex:1; height:1px; background:#e5ebf2; content:""; }
        .submit-button { min-height:49px; margin-top:8px; border:0; border-radius:10px; color:#fff; background:var(--navy); font-weight:800; box-shadow:0 8px 18px #102f5324; transition:transform .2s,background .2s,box-shadow .2s; }
        .submit-button:hover,.submit-button:focus { color:#fff; background:#0b2542; transform:translateY(-1px); box-shadow:0 12px 24px #102f5330; }
        .login-prompt { margin:19px 0 0; color:var(--muted); text-align:center; font-size:.9rem; }
        .login-prompt a { color:var(--navy-3); font-weight:800; text-decoration:none; }
        .login-prompt a:hover { text-decoration:underline; }
        @media(max-width:800px) { body { padding:18px; } .signup-shell { grid-template-columns:1fr; max-width:620px; } .signup-aside { min-height:250px; padding:25px 28px; } .aside-content { padding:25px 0 15px; } .aside-content h1 { font-size:2.5rem; } .aside-note { display:none; } .signup-main { padding:30px clamp(22px,6vw,42px) 36px; } .form-heading { margin-top:24px; } }
        @media(max-width:480px) { body { display:block; padding:0; background:#fff; } .signup-shell { min-height:100vh; border:0; border-radius:0; box-shadow:none; } .signup-aside { min-height:220px; padding:20px 22px; } .aside-content { padding:20px 0 12px; } .aside-content h1 { font-size:2.2rem; } .aside-content p { margin-top:12px; font-size:.9rem; } .signup-main { padding:25px 22px 35px; } .form-heading h2 { font-size:1.75rem; } }
    </style>
</head>
<body>
    <main class="signup-shell">
        <aside class="signup-aside">
            <a class="brand" href="{{ url('/') }}">
                <span class="brand-mark" aria-hidden="true"><i class="bi bi-book-half"></i></span>
                <span>UniKL BookHub</span>
            </a>
            <div class="aside-content">
                <div class="aside-kicker"><i class="bi bi-stars" aria-hidden="true"></i> Your campus book community</div>
                <h1>Find your next<br><span>chapter here.</span></h1>
                <p>Create your student account to discover books, connect with other UniKL students, and share learning resources.</p>
            </div>
            <div class="aside-note"><i class="bi bi-shield-check" aria-hidden="true"></i><span>Made for the UniKL student community</span></div>
        </aside>

        <section class="signup-main" aria-labelledby="signup-title">
            <a href="{{ url('/') }}" class="top-link"><i class="bi bi-arrow-left" aria-hidden="true"></i> Back to home</a>
            <div class="form-heading">
                <p class="kicker">Get started</p>
                <h2 id="signup-title">Create your account</h2>
                <p>Enter your details to join UniKL BookHub.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label for="studentid" class="form-label">Student ID</label>
                        <input type="text" id="studentid" name="studentid" class="form-control" value="{{ old('studentid') }}" placeholder="Enter your Student ID" autocomplete="username" required>
                        <small id="studentid_message" class="form-hint">Enter your Student ID to detect your education level.</small>
                        @error('studentid') <small class="field-error">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="name" class="form-label">Full name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Your full name" autocomplete="name" required>
                        @error('name') <small class="field-error">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
                        @error('email') <small class="field-error">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12"><div class="form-section-title">Account security</div></div>
                    <div class="col-12 col-sm-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Create a password" autocomplete="new-password" required>
                        @error('password') <small class="field-error">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="password_confirmation" class="form-label">Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter it again" autocomplete="new-password" required>
                    </div>
                    <div class="col-12"><div class="form-section-title">Student information</div></div>
                    <div class="col-12 col-sm-5">
                        <label for="education_level" class="form-label">Education level</label>
                        <input type="text" id="education_level" name="education_level" class="form-control" placeholder="Detected from Student ID" value="{{ old('education_level') }}" readonly required>
                    </div>
                    <div class="col-12 col-sm-7">
                        <label for="programme" class="form-label">Programme</label>
                        <select id="programme" name="programme" class="form-select" required>
                            <option value="" disabled selected>Select programme</option>
                        </select>
                        @error('programme') <small class="field-error">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn submit-button w-100">Create account <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i></button>
                        <p class="login-prompt">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
                    </div>
                </div>
            </form>
        </section>
    </main>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const studentId = document.getElementById("studentid");
        const education = document.getElementById("education_level");
        const programme = document.getElementById("programme");
        const message = document.getElementById("studentid_message");
        const previousProgramme = @json(old('programme'));

        const data = {
            Foundation: [
                "Foundation in Computer Technology",
                "Foundation in Science and Technology for Korean University"
            ],
            Diploma: [
                "Diploma in Networking Technology",
                "Diploma in Information Technology",
                "Diploma in Animation",
                "Diploma in Multimedia"
            ],
            Bachelor: [
                "Bachelor of Game Development Technology with Honours",
                "Bachelor in Information Technology (Honours) (Internet of Things)",
                "Bachelor of Multimedia Technology (Hons.) in Interactive Multimedia Design",
                "Bachelor of Computer Engineering Technology (Networking Systems) with Honours",
                "Bachelor of Software Engineering with Honours",
                "Bachelor of Cybersecurity Technology with Honours",
                "Bachelor of Multimedia Technology (Hons.) in Computer Animation",
                "Bachelor of Artificial Intelligence Technology with Honours"
            ]
        };

        function detectEducationLevel() {
            const id = studentId.value.trim();
            education.value = "";
            programme.innerHTML = '<option value="">Select programme</option>';
            message.className = "form-hint";
            message.textContent = "Enter your Student ID to detect your education level.";

            if (id.length === 0) {
                programme.innerHTML = '<option value="">Enter Student ID first</option>';
                return;
            }
            if (!/^\d+$/.test(id)) {
                message.className = "form-hint is-error";
                message.textContent = "Student ID must contain digits only.";
                programme.innerHTML = '<option value="">Invalid Student ID</option>';
                return;
            }
            if (id.length < 3) {
                programme.innerHTML = '<option value="">Enter at least 3 digits</option>';
                return;
            }

            const prefix = id.substring(0, 3);
            let level = "";
            if (prefix === "520") level = "Foundation";
            else if (prefix === "521") level = "Diploma";
            else if (prefix === "522") level = "Bachelor";
            else {
                message.className = "form-hint is-error";
                message.textContent = "Student ID prefix not recognised for UniKL MIIT.";
                programme.innerHTML = '<option value="">No programmes available</option>';
                return;
            }

            education.value = level;
            message.className = "form-hint is-success";
            message.textContent = "Education level detected: " + level;
            data[level].forEach(function (item) {
                const option = document.createElement("option");
                option.value = item;
                option.textContent = item;
                if (item === previousProgramme) option.selected = true;
                programme.appendChild(option);
            });
        }

        studentId.addEventListener("input", detectEducationLevel);
        detectEducationLevel();
    });
    </script>
</body>
</html>
