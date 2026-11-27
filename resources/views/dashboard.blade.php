<style>
.dash-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.875rem 1rem;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    text-decoration: none;
    color: inherit;
    transition: background 0.15s, border-color 0.15s;
    margin-bottom: 10px;
}
.dash-card:hover {
    background: #f9fafb;
    border-color: #d1d5db;
}
.dark .dash-card {
    background: #1f2937;
    border-color: #374151;
}
.dark .dash-card:hover {
    background: #374151;
}
.card-icon {
    width: 38px; height: 38px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.card-label { font-size: 14px; font-weight: 500; margin: 0; }
.card-sub { font-size: 12px; color: #9ca3af; margin: 1px 0 0; }
.section-label {
    font-size: 11px; font-weight: 600; letter-spacing: 0.06em;
    text-transform: uppercase; color: #9ca3af;
    margin: 1.25rem 0 0.6rem;
}
.role-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; border-radius: 8px;
    font-size: 12px; font-weight: 600;
    margin-bottom: 1.25rem;
}
.role-badge.super { background:#ede9fe; color:#6d28d9; }
.role-badge.admin { background:#dbeafe; color:#1d4ed8; }
.role-badge.user  { background:#dcfce7; color:#15803d; }
.card-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.dash-divider { border: none; border-top: 1px solid #f3f4f6; margin: 1rem 0; }
.dark .dash-divider { border-color: #374151; }
.dashboard-shell { max-width:1120px!important; }
.dashboard-hero { position:relative; display:flex; align-items:center; justify-content:space-between; gap:24px; overflow:hidden; margin-bottom:22px; padding:30px 34px; border-radius:16px; color:#fff; background:radial-gradient(ellipse at 85% 15%,#2b5d8b 0,transparent 36%),linear-gradient(130deg,#0b2542,#173f6b); box-shadow:0 16px 36px rgba(16,47,83,.16); }
.dashboard-hero::after { position:absolute; right:-72px; top:-180px; width:350px; height:350px; border:1px solid #ffffff20; border-radius:50%; box-shadow:0 0 0 42px #ffffff09,0 0 0 84px #ffffff05; content:""; pointer-events:none; }
.dashboard-hero-copy { position:relative; z-index:1; }
.dashboard-hero-kicker { margin:0 0 8px; color:#b8d5f5; font-size:11px; font-weight:700; letter-spacing:.12em; text-transform:uppercase; }
.dashboard-hero h1 { margin:0; color:#fff; font-size:clamp(1.7rem,3.6vw,2.6rem); font-weight:800; letter-spacing:-.045em; line-height:1.1; }
.dashboard-hero p:last-child { max-width:580px; margin:10px 0 0; color:#d3e1f0; font-size:14px; line-height:1.65; }
.dashboard-hero-mark { position:relative; z-index:1; display:grid; flex:0 0 66px; place-items:center; width:66px; height:66px; border:1px solid #ffffff35; border-radius:20px; color:#fff; background:#ffffff16; font-size:30px; }
.dashboard-panel { padding:26px!important; border:1px solid #dce5ef!important; border-radius:16px!important; background:#fff!important; box-shadow:0 12px 34px rgba(16,47,83,.07)!important; }
.dash-card { border-color:#dce5ef; border-radius:12px; color:#193b5f; box-shadow:0 3px 10px rgba(16,47,83,.025); }
.dash-card:hover { background:#f4f8fc; border-color:#a9c5e3; box-shadow:0 7px 18px rgba(16,47,83,.07); }
.card-icon { background:#dceafb!important; color:#245586!important; }
.card-label { color:#193b5f; font-weight:700; }
.card-sub { color:#6c8095; }
.section-label { color:#245586; font-size:10px; font-weight:800; letter-spacing:.11em; }
.role-badge { color:#173f6b!important; background:#e7f0fa!important; border:1px solid #d5e4f3; }
.dash-divider { border-top-color:#e3ebf3; }
.card-grid-2 { gap:10px; }
@media(max-width:640px) { .dashboard-hero { padding:24px 22px; } .dashboard-hero-mark { flex-basis:48px; width:48px; height:48px; border-radius:15px; font-size:23px; } .dashboard-panel { padding:19px!important; } .card-grid-2 { grid-template-columns:1fr; } }
.dark .dashboard-panel { border-color:#274360!important; background:#102f53!important; }
.dark .dash-card { color:#e2edf8; background:#173b60; border-color:#2b4c6d; }
.dark .dash-card:hover { background:#1d466e; border-color:#527ba3; }
.dark .card-label { color:#f1f6fb; }
.dark .card-sub { color:#b5c9dd; }
.dark .section-label { color:#a9c9ed; }
.dark .dash-divider { border-top-color:#2b4c6d; }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="dashboard-shell mx-auto px-4 sm:px-6 lg:px-8">
            <section class="dashboard-hero">
                <div class="dashboard-hero-copy">
                    <p class="dashboard-hero-kicker">UniKL MIIT BookHub</p>
                    <h1>Welcome back, {{ Auth::user()->name }}</h1>
                    <p>Find your next read, manage your book exchanges, and keep up with your BookHub activity.</p>
                </div>
                <div class="dashboard-hero-mark" aria-hidden="true">📚</div>
            </section>
            <div class="dashboard-panel">

                @if(Auth::user()->role == 'super_admin')

                    <div class="role-badge super">⚡ Super Admin</div>

                    <div class="section-label">Quick actions</div>
                    <a href="/homepage" class="dash-card">
                        <div class="card-icon" style="background:#dbeafe; color:#1d4ed8;">📚</div>
                        <div><p class="card-label">View book listing</p><p class="card-sub">Browse all listed books</p></div>
                    </a>
                    <a href="{{ route('admin.create') }}" class="dash-card">
                        <div class="card-icon" style="background:#ede9fe; color:#6d28d9;">➕</div>
                        <div><p class="card-label">Create new admin</p><p class="card-sub">Add a new admin account</p></div>
                    </a>

                    <a href="{{ route('ai.chat') }}" class="dash-card">
                        <div class="card-icon" style="background:#ede9fe; color: lightpink;">🤖</div>
                        <div><p class="card-label">AI Chat</p></div>
                    </a>

                    <a href="{{ route('admin.reviews.adminreview') }}" class="dash-card">
                        <div class="card-icon" style="background:#f1f5f9; color:#0f172a;">⭐</div>
                        <div>
                            <p class="card-label">View Student Rating & Review</p>
                            <p class="card-sub">See all student reviews</p>
                        </div>
                    </a>

                    <hr class="dash-divider">
                    <div class="section-label">Reports</div>
                    <div class="card-grid-2">
                        <a href="{{ route('admin.reports.pending') }}" class="dash-card">
                            <div class="card-icon" style="background:#fef3c7; color:#92400e;">🕐</div>
                            <div><p class="card-label">Pending</p><p class="card-sub">Awaiting review</p></div>
                        </a>
                        <a href="{{ route('admin.reports.resolved') }}" class="dash-card">
                            <div class="card-icon" style="background:#dcfce7; color:#15803d;">✅</div>
                            <div><p class="card-label">Resolved</p><p class="card-sub">Closed reports</p></div>
                        </a>

                        <a href="{{ route('admin.reports.rejected') }}" class="dash-card">
                            <div class="card-icon" style="background:#fee2e2; color:#b91c1c;">❌</div>
                            <div><p class="rejected_text">Rejected</p><p class="card-sub">Closed reports</p></div>
                        </a>

                        <a href="{{ route('admin.reports.deleted') }}" class="dash-card">
                            <div class="card-icon" style="background:#e2e8f0; color:#475569;">🗑️</div>
                            <div><p class="card-label">Deleted</p><p class="card-sub">Recover removed reports</p></div>
                        </a>

                    </div>
                    <hr class="dash-divider">
                    <div class="section-label">Admin</div>
                    <div class="card-grid-2">
                        <a href="{{ route('admin.list') }}" class="dash-card">
                            <div class="card-icon" style="background:orange; color:#92400e;">🕐</div>
                            <div><p class="card-label">Admin List</p><p class="card-sub">View All Admin</p></div>
                        </a>
                    </div>

                @elseif(Auth::user()->role == 'admin')

                    <div class="role-badge admin">🛡️ Admin</div>

                    <div class="section-label">Quick actions</div>
                        <a href="/homepage" class="dash-card">
                            <div class="card-icon" style="background:#dbeafe; color:#1d4ed8;">📚</div>
                            <div><p class="card-label">View book listing</p><p class="card-sub">Browse all listed books</p></div>
                        </a>
                        <a href="{{ route('ai.chat') }}" class="dash-card">
                            <div class="card-icon" style="background:#ede9fe; color: lightpink;">🤖</div>
                            <div><p class="card-label">AI Chat</p></div>
                        </a>

                        <a href="{{ route('admin.reviews.adminreview') }}" class="dash-card">
                            <div class="card-icon" style="background:#f1f5f9; color:#0f172a;">⭐</div>
                            <div>
                                <p class="card-label">View Student Rating & Review</p>
                                <p class="card-sub">See all student reviews</p>
                            </div>
                        </a>

                    <hr class="dash-divider">
                    <div class="section-label">Reports</div>
                    <div class="card-grid-2">
                        <a href="{{ route('admin.reports.pending') }}" class="dash-card">
                            <div class="card-icon" style="background:#fef3c7; color:#92400e;">🕐</div>
                            <div><p class="card-label">Pending</p><p class="card-sub">Awaiting review</p></div>
                        </a>
                        <a href="{{ route('admin.reports.resolved') }}" class="dash-card">
                            <div class="card-icon" style="background:#dcfce7; color:#15803d;">✅</div>
                            <div><p class="card-label">Resolved</p><p class="card-sub">Closed reports</p></div>
                        </a>

                        <a href="{{ route('admin.reports.rejected') }}" class="dash-card">
                            <div class="card-icon" style="background:#fee2e2; color:#b91c1c;">❌</div>
                            <div><p class="rejected_text">Rejected</p><p class="card-sub">Closed reports</p></div>
                        </a>

                        <a href="{{ route('admin.reports.deleted') }}" class="dash-card">
                            <div class="card-icon" style="background:#e2e8f0; color:#475569;">🗑️</div>
                            <div><p class="card-label">Deleted</p><p class="card-sub">Recover removed reports</p></div>
                        </a>
                    </div>
                    @else

                        {{-- User Panel Header --}}
                        <div class="role-badge user">👤 Student Panel</div>

                        <div class="section-label">My Rating</div>

                        <div class="dash-card">
                            <div class="card-icon"
                                style="background:#fef3c7; color:#92400e;">⭐</div>
                            <div>
                                <p class="card-label">
                                    Average Rating: {{ number_format((float) $averageRating, 1) }} / 5
                                </p>
                                <a href="{{ route('reviews.received') }}"
                                style="font-size:12px; color:#2563eb; text-decoration:none;">
                                    View Received Ratings & Reviews →
                                </a>
                            </div>
                        </div>

                        {{-- Book Management --}}
                        <hr class="dash-divider">
                        <div class="section-label">Book Management</div>

                        <div class="card-grid-2">

                            <a href="/book/create" class="dash-card">
                                <div class="card-icon"
                                    style="background:#dcfce7; color:#15803d;">➕</div>
                                <div>
                                    <p class="card-label">Sell a Book</p>
                                    <p class="card-sub">Create a listing</p>
                                </div>
                            </a>

                            <a href="/homepage" class="dash-card">
                                <div class="card-icon"
                                    style="background:#dbeafe; color:#1d4ed8;">🌍</div>
                                <div>
                                    <p class="card-label">Browse Books</p>
                                    <p class="card-sub">Discover books</p>
                                </div>
                            </a>

                            <a href="{{ route('book.myListings') }}" class="dash-card">
                                <div class="card-icon"
                                    style="background:#fef3c7; color:#92400e;">📚</div>
                                <div>
                                    <p class="card-label">My Listings</p>
                                    <p class="card-sub">Manage your books</p>
                                </div>
                            </a>

                            <a href="{{ route('book.saved') }}" class="dash-card">
                                <div class="card-icon"
                                    style="background:#fce7f3; color:#be185d;">❤️</div>
                                <div>
                                    <p class="card-label">Saved Books</p>
                                    <p class="card-sub">Your saved books</p>
                                </div>
                            </a>

                        </div>

                        {{-- Exchange Management --}}
                        <hr class="dash-divider">
                        <div class="section-label">Exchange Management</div>

                        <div class="card-grid-2">

                            <a href="/inbox" class="dash-card">
                                <div class="card-icon"
                                    style="background:#e0e7ff; color:#4338ca;">📥</div>
                                <div>
                                    <p class="card-label">Received Requests</p>
                                    <p class="card-sub">Manage incoming requests</p>
                                </div>
                            </a>

                            <a href="{{ route('sent.requests') }}" class="dash-card">
                                <div class="card-icon"
                                    style="background:#cffafe; color:#0e7490;">📤</div>
                                <div>
                                    <p class="card-label">Sent Requests</p>
                                    <p class="card-sub">Track your requests</p>
                                </div>
                            </a>

                        </div>

                        {{-- Reviews and Reports --}}
                        <hr class="dash-divider">
                        <div class="section-label">Reviews & Reports</div>

                        <div class="card-grid-2">

                            <a href="{{ route('reviews.my') }}" class="dash-card">
                                <div class="card-icon"
                                    style="background:#f3e8ff; color:#7e22ce;">⭐</div>
                                <div>
                                    <p class="card-label">My Reviews</p>
                                    <p class="card-sub">Reviews you submitted</p>
                                </div>
                            </a>

                            <a href="{{ route('report.my') }}" class="dash-card">
                                <div class="card-icon"
                                    style="background:#fee2e2; color:#b91c1c;">🚨</div>
                                <div>
                                    <p class="card-label">My Reports</p>
                                    <p class="card-sub">Track submitted reports</p>
                                </div>
                            </a>

                        </div>

                        {{-- AI Assistant --}}
                        <hr class="dash-divider">
                        <div class="section-label">Support & Assistance</div>

                        <a href="{{ route('ai.chat') }}" class="dash-card">
                            <div class="card-icon"
                                style="background:#ede9fe; color:#7c3aed;">🤖</div>
                            <div>
                                <p class="card-label">AI Chat</p>
                                <p class="card-sub">Get help from the BookHub AI assistant</p>
                            </div>
                        </a>

                    @endif

            </div>
        </div>
    </div>
</x-app-layout>
