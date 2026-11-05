<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>{{ config('app.name', 'UniKL BookHub') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet">
    <style>
        :root { --navy:#102f53; --navy-2:#173f6b; --navy-3:#245586; --sky:#dceafb; --ink:#14263d; --muted:#63758a; --paper:#f4f7fb; --line:#dce5ef; }
        * { box-sizing:border-box; }
        html { scroll-behavior:smooth; scroll-padding-top:78px; }
        body { margin:0; color:var(--ink); background:var(--paper); font-family:'Instrument Sans',Arial,sans-serif; }
        a { color:inherit; text-decoration:none; }
        .site-nav { position:fixed; inset:0 0 auto; z-index:10; display:flex; align-items:center; justify-content:space-between; gap:1rem; padding:14px clamp(20px,6vw,88px); color:#fff; background:rgba(13,42,74,.94); backdrop-filter:blur(12px); box-shadow:0 6px 24px #0b25421c; }
        .brand { display:flex; align-items:center; gap:10px; font-weight:800; letter-spacing:-.02em; }
        .brand-mark { display:grid; place-items:center; width:36px; height:36px; border-radius:11px; background:#ffffff1c; color:#fff; }
        .nav-links { display:flex; align-items:center; gap:clamp(14px,2.5vw,32px); font-size:.92rem; font-weight:600; }
        .nav-links a:not(.nav-button) { color:#d9e6f5; transition:color .2s; }
        .nav-links a:not(.nav-button):hover { color:#fff; }
        .nav-button,.button { display:inline-flex; align-items:center; justify-content:center; gap:9px; border-radius:10px; font-weight:700; transition:transform .2s,background .2s,box-shadow .2s; }
        .nav-button { padding:10px 16px; color:var(--navy); background:#fff; }
        .button { padding:14px 20px; }
        .button:hover,.nav-button:hover { transform:translateY(-2px); box-shadow:0 10px 24px #071d3630; }
        .button-light { color:var(--navy); background:#fff; }
        .button-outline { color:#fff; border:1px solid #ffffff75; background:#ffffff0d; }
        .button-outline:hover { background:#ffffff1b; }
        .button-blue { color:#fff; background:var(--navy); box-shadow:0 8px 18px #102f5324; }
        .button-blue:hover { background:#0b2542; }
        .hero { position:relative; display:flex; align-items:center; min-height:100svh; overflow:hidden; padding:120px clamp(24px,7.3vw,140px) 72px; color:#fff; background:radial-gradient(ellipse at 78% 30%,#2b5d8b 0,transparent 37%),linear-gradient(130deg,#0b2542 0%,#123a66 60%,#174674 100%); }
        .hero::before,.hero::after { position:absolute; content:""; border:1px solid #ffffff14; border-radius:50%; pointer-events:none; }
        .hero::before { width:540px;height:540px; right:-130px;top:10%; }
        .hero::after { width:390px;height:390px; right:-55px;top:19%; }
        .hero-layout { display:grid; grid-template-columns:minmax(0,1.05fr) minmax(380px,.95fr); align-items:center; gap:clamp(36px,5vw,82px); width:min(100%,1600px); margin:0 auto; }
        .hero-content { position:relative; z-index:1; max-width:760px; }
        .hero-visual { position:relative; z-index:1; width:100%; margin:0; padding:10px; border:1px solid #ffffff48; border-radius:26px; background:#ffffff15; box-shadow:0 28px 70px #061b3370; backdrop-filter:blur(8px); transform:rotate(1deg); }
        .hero-visual img { display:block; width:100%; aspect-ratio:1.18/1; border-radius:18px; object-fit:cover; object-position:center; }
        .hero-visual-caption { position:absolute; right:22px; bottom:22px; left:22px; display:flex; align-items:center; gap:10px; width:max-content; max-width:calc(100% - 44px); padding:10px 13px; border:1px solid #ffffff50; border-radius:11px; color:#fff; background:#0b2542bd; box-shadow:0 8px 22px #071d3640; font-size:.8rem; font-weight:700; backdrop-filter:blur(9px); }
        .hero-visual-caption svg { flex:0 0 17px; color:#b8d5f5; }
        .eyebrow { display:inline-flex; align-items:center; gap:8px; margin-bottom:22px; padding:8px 13px; border:1px solid #ffffff35; border-radius:999px; color:#e1edfa; background:#ffffff0d; font-size:.78rem; font-weight:700; letter-spacing:.09em; text-transform:uppercase; }
        .eyebrow-dot { width:8px;height:8px;border-radius:50%;background:#9bc7f4;box-shadow:0 0 0 4px #9bc7f425; }
        h1 { max-width:720px; margin:0; font-size:clamp(2.8rem,7vw,6rem); line-height:.99; letter-spacing:-.065em; }
        h1 span { color:#b8d5f5; }
        .hero-copy { max-width:590px; margin:25px 0 32px; color:#d3e1f0; font-size:clamp(1.05rem,1.7vw,1.22rem); line-height:1.75; }
        .hero-actions { display:flex; flex-wrap:wrap; gap:12px; }
        .scroll-cue { position:absolute; bottom:27px; left:50%; display:grid; justify-items:center; gap:8px; color:#d3e1f0b8; font-size:.72rem; letter-spacing:.1em; text-transform:uppercase; transform:translateX(-50%); }
        .scroll-cue span { display:grid; place-items:center; width:30px;height:30px;border:1px solid #ffffff55;border-radius:50%;font-size:1rem; }
        .section { display:grid; align-items:center; min-height:88svh; padding:100px clamp(24px,9vw,140px); }
        .section-inner { width:min(100%,1080px); margin:auto; }
        .start-intro { display:grid;grid-template-columns:minmax(0,1.15fr) minmax(300px,.85fr);align-items:center;gap:clamp(28px,5vw,70px); }
        .start-copy .section-lead { max-width:600px; }
        .start-visual { position:relative;margin:0;padding:8px;border:1px solid #cbdced;border-radius:19px;background:#fff;box-shadow:0 18px 42px #173f6b18; }
        .start-visual img { display:block;width:100%;aspect-ratio:1.5/1;object-fit:cover;object-position:center;border-radius:13px; }
        .section-kicker { margin:0 0 13px; color:var(--navy-3); font-size:.78rem; font-weight:800; letter-spacing:.13em; text-transform:uppercase; }
        .section h2 { max-width:720px; margin:0; color:var(--navy); font-size:clamp(2.15rem,5vw,4rem); line-height:1.08; letter-spacing:-.05em; }
        .section-lead { max-width:660px; margin:18px 0 0; color:var(--muted); font-size:1.08rem; line-height:1.75; }
        .start-section { background:#eaf1f9; }
        .start-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:18px; margin-top:42px; }
        .start-card { display:flex; flex-direction:column; align-items:flex-start; min-height:250px; padding:25px; border:1px solid #d7e2ef; border-radius:18px; background:#fff; box-shadow:0 12px 35px #173f6b0b; transition:transform .2s,border-color .2s,box-shadow .2s; }
        .start-card:hover { transform:translateY(-5px); border-color:#a9c5e3; box-shadow:0 18px 40px #173f6b18; }
        .card-icon { display:grid; place-items:center; width:48px;height:48px; margin-bottom:20px; border-radius:14px; color:var(--navy); background:var(--sky); }
        .start-card h3 { margin:0; color:var(--navy); font-size:1.2rem; }
        .start-card p { flex:1; margin:10px 0 20px; color:var(--muted); line-height:1.6; }
        .card-link { display:inline-flex; align-items:center; gap:8px; color:var(--navy-3); font-weight:800; }
        .about-section { color:#fff; background:linear-gradient(145deg,#102f53,#0b2542); }
        .about-section .section-kicker { color:#a9c9ed; }
        .about-section h2 { color:#fff; }
        .about-section .section-lead { color:#d1dfef; }
        .about-layout { display:grid; grid-template-columns:1.15fr .85fr; align-items:center; gap:clamp(32px,7vw,90px); }
        .about-points { display:grid; gap:14px; }
        .about-point { display:flex; gap:14px; padding:19px; border:1px solid #ffffff20; border-radius:15px; background:#ffffff0b; }
        .about-point-icon { flex:0 0 38px; display:grid;place-items:center;width:38px;height:38px;border-radius:12px;color:#d7e9fc;background:#ffffff18; }
        .about-point strong { display:block; margin:1px 0 4px; color:#fff; }
        .about-point span { color:#c8d8e9; font-size:.92rem; line-height:1.55; }
        .footer { display:flex; justify-content:space-between; gap:16px; padding:22px clamp(24px,9vw,140px); color:#c8d8e9; background:#081e36; font-size:.86rem; }
        .footer a { color:#fff; font-weight:700; }
        .reveal { opacity:0; transform:translateY(22px); transition:opacity .65s ease,transform .65s ease; }
        .reveal.is-visible { opacity:1; transform:translateY(0); }
        @media(max-width:900px) { .hero-layout { grid-template-columns:minmax(0,1fr) minmax(300px,.8fr); gap:30px; } h1 { font-size:clamp(2.7rem,6.5vw,4.7rem); } }
        @media(max-width:760px) { .site-nav { padding:12px 18px; } .nav-links { gap:12px; } .nav-links .nav-about { display:none; } .nav-button { padding:9px 12px; } .hero { padding:110px 26px 80px; } .hero-layout { grid-template-columns:1fr; gap:32px; } .hero-content { max-width:680px; } .hero-visual { width:min(100%,540px); justify-self:center; transform:none; } .hero-visual img { aspect-ratio:1.5/1; } .hero::before { right:-370px; } .hero::after { right:-300px; } .section { min-height:auto; padding:88px 24px; } .start-intro { grid-template-columns:1fr;gap:24px; } .start-visual { width:min(100%,560px); } .start-grid { grid-template-columns:1fr; } .start-card { min-height:210px; } .about-layout { grid-template-columns:1fr; } .footer { padding-inline:24px; } }
        @media(max-width:420px) { .brand { font-size:.9rem; } .brand-mark { width:32px;height:32px; } .nav-links { font-size:.82rem; } .hero-actions .button { width:100%; } }
        @media(prefers-reduced-motion:reduce) { *,*::before,*::after { scroll-behavior:auto!important; transition-duration:.01ms!important; animation-duration:.01ms!important; } .reveal { opacity:1; transform:none; } }
    </style>
</head>
<body>
    <nav class="site-nav" aria-label="Main navigation">
        <a class="brand" href="#welcome" aria-label="UniKL BookHub home">
            <span class="brand-mark" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5v-16Z" stroke="currentColor" stroke-width="1.8"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20M8 7h8M8 10h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span>
            <span>UniKL BookHub</span>
        </a>
        <div class="nav-links">
            <a class="nav-about" href="#about">About</a>
            <a href="{{ route('homepage') }}">Browse books</a>
            @auth
                <a class="nav-button" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                @if(Route::has('login')) <a href="{{ route('login') }}">Log in</a> @endif
                @if(Route::has('register')) <a class="nav-button" href="{{ route('register') }}">Sign up</a> @endif
            @endauth
        </div>
    </nav>

    <main>
        <section class="hero" id="welcome" aria-labelledby="welcome-title">
            <div class="hero-layout">
                <div class="hero-content reveal">
                    <div class="eyebrow"><span class="eyebrow-dot"></span> A book community for UniKL students</div>
                    <h1 id="welcome-title">Welcome to<br><span>UniKL BookHub.</span></h1>
                    <p class="hero-copy">Find the books you need, share the ones you’ve finished, and make your next study resource easier to find.</p>
                    <div class="hero-actions">
                        <a class="button button-light" href="#get-started">Get started <span aria-hidden="true">↓</span></a>
                        <a class="button button-outline" href="{{ route('homepage') }}">Browse books <span aria-hidden="true">→</span></a>
                    </div>
                </div>
                <figure class="hero-visual reveal">
                    <img src="{{ asset('images/unikl-campus.png') }}" alt="Universiti Kuala Lumpur campus building and student community">
                    <figcaption class="hero-visual-caption"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m2 9 10-5 10 5-10 5L2 9Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M6 11v5c3.3 2.7 8.7 2.7 12 0v-5M22 9v6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>UniKL campus, Kuala Lumpur</figcaption>
                </figure>
            </div>
            <a class="scroll-cue" href="#get-started" aria-label="Scroll to get started">Scroll to explore <span aria-hidden="true">⌄</span></a>
        </section>

        <section class="section start-section" id="get-started" aria-labelledby="start-title">
            <div class="section-inner reveal">
                <div class="start-intro">
                    <div class="start-copy">
                        <p class="section-kicker">Your next step</p>
                        <h2 id="start-title">Make your next book easier to find.</h2>
                        <p class="section-lead">Join the UniKL BookHub community or start exploring the catalogue. Choose the option that works for you.</p>
                    </div>
                    <figure class="start-visual">
                        <img src="{{ asset('images/book-exchange.png') }}" alt="One student handing a book to another student">
                    </figure>
                </div>
                <div class="start-grid">
                    @guest
                        @if(Route::has('login'))
                            <a class="start-card" href="{{ route('login') }}">
                                <span class="card-icon" aria-hidden="true"><svg width="23" height="23" viewBox="0 0 24 24" fill="none"><path d="M10 17l5-5-5-5M15 12H3m9-8h5a4 4 0 0 1 4 4v8a4 4 0 0 1-4 4h-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                <h3>Log in</h3><p>Return to your account to manage listings, requests, and saved books.</p><span class="card-link">Log in to your account <span aria-hidden="true">→</span></span>
                            </a>
                        @endif
                        @if(Route::has('register'))
                            <a class="start-card" href="{{ route('register') }}">
                                <span class="card-icon" aria-hidden="true"><svg width="23" height="23" viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm11-3v6m3-3h-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                <h3>Create an account</h3><p>Sign up with your student details and take part in the campus book exchange.</p><span class="card-link">Sign up for UniKL BookHub <span aria-hidden="true">→</span></span>
                            </a>
                        @endif
                    @else
                        <a class="start-card" href="{{ route('dashboard') }}">
                            <span class="card-icon" aria-hidden="true"><svg width="23" height="23" viewBox="0 0 24 24" fill="none"><path d="M3 10.5 12 3l9 7.5V21H3V10.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 21v-7h6v7" stroke="currentColor" stroke-width="1.8"/></svg></span>
                            <h3>Go to dashboard</h3><p>Continue to your account and pick up where you left off.</p><span class="card-link">Open dashboard <span aria-hidden="true">→</span></span>
                        </a>
                    @endguest
                    <a class="start-card" href="{{ route('homepage') }}">
                        <span class="card-icon" aria-hidden="true"><svg width="23" height="23" viewBox="0 0 24 24" fill="none"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5v-16Z" stroke="currentColor" stroke-width="1.8"/><path d="M4 18.5A2.5 2.5 0 0 1 6.5 16H20M8 7h8M8 10h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></span>
                        <h3>Browse books</h3><p>Explore the book catalogue and see what UniKL students have listed.</p><span class="card-link">Explore the catalogue <span aria-hidden="true">→</span></span>
                    </a>
                </div>
            </div>
        </section>

        <section class="section about-section" id="about" aria-labelledby="about-title">
            <div class="section-inner about-layout reveal">
                <div>
                    <p class="section-kicker">About UniKL BookHub</p>
                    <h2 id="about-title">Good books deserve another chapter.</h2>
                    <p class="section-lead">UniKL BookHub helps students connect around the books that support their studies. Find useful learning materials, list books you’re ready to pass on, and arrange exchanges with fellow students.</p>
                </div>
                <div class="about-points">
                    <div class="about-point"><span class="about-point-icon" aria-hidden="true">⌕</span><div><strong>Discover study materials</strong><span>Search a shared catalogue of books listed by the UniKL community.</span></div></div>
                    <div class="about-point"><span class="about-point-icon" aria-hidden="true">↔</span><div><strong>Exchange with students</strong><span>Request books and coordinate a meeting with the book owner.</span></div></div>
                    <div class="about-point"><span class="about-point-icon" aria-hidden="true">♡</span><div><strong>Keep books in circulation</strong><span>Give used books a new reader and make learning resources easier to access.</span></div></div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer"><span>© {{ date('Y') }} UniKL BookHub</span><a href="#welcome">Back to top ↑</a></footer>
    <script>
        (() => {
            const items = document.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                items.forEach((item) => item.classList.add('is-visible'));
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            items.forEach((item) => observer.observe(item));
        })();
    </script>
</body>
</html>
