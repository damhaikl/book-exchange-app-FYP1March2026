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
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

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
                    </div>

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
                    </div>
                @else
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        <div style="font-weight:bold; color:#7c3aed;">
                            USER PANEL
                        </div>

                        <br>
                        <div style="padding:10px; background:#f9fafb; border-radius:10px;">
                            <div style="font-weight:bold; color:#111827;">
                                ⭐ Average Rating:
                                {{ $averageRating }} / 5
                            </div>

                            <a href="{{ route('reviews.received') }}"
                            style="display:inline-block; margin-top:8px; color:#2563eb; font-weight:600;">
                                🔗 View Received Rating & Review
                            </a>
                        </div>

                        <br>

                        <a href="/book/create" class="btn btn-success mt-2">
                            ➕ Sell a Book
                        </a>
                        <br><br>
                        <a href="/homepage" class="btn btn-primary mt-2">
                            🌍 Browse Books
                        </a>
                        <br><br>
                        <a href="{{ route('book.myListings') }}" class="btn btn-warning mt-2">
                            📚 My Listings
                        </a>
                        <br><br><br><br>
                        <a href="/inbox" class="btn btn-dark mt-2">
                            📥 Inbox (Requests)
                        </a>
                        <br><br>
                        <a href="{{ route('sent.requests') }}" class="btn btn-info mt-2">
                            📤 Sent Book Request
                        </a>
                        <br><br><br><br>
                        <a href="{{ route('reviews.my') }}" class="btn btn-danger mt-2">
                            ⭐ My Reviews
                        </a><br><br>
                        <a href="{{ route('report.my') }}" class="btn btn-danger mt-2">
                            🚨 My Reports
                        </a><br><br>
                        <a href="{{ route('book.saved') }}" class="btn btn-danger mt-2">
                            ❤️ Saved Books
                        </a><br><br>
                        <a href="{{ route('ai.chat') }}" class="btn btn-primary">
                            🤖 AI Chat
                        </a>
                    </div>

                @endif

            </div>
        </div>
    </div>
</x-app-layout>