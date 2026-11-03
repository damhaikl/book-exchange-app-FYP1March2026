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
.request-bot { position:fixed; right:24px; bottom:24px; z-index:50; font-family:inherit; }
.request-bot-toggle { position:relative; display:flex; align-items:center; gap:9px; border:0; border-radius:999px; padding:12px 17px; color:#fff; background:#123a66; box-shadow:0 8px 24px rgba(15,23,42,.25); font-weight:600; cursor:pointer; }
.request-bot-toggle:hover { background:#0f2f52; }
.request-bot-badge { position:absolute; top:-5px; right:-4px; min-width:21px; height:21px; padding:0 5px; border:2px solid #fff; border-radius:999px; display:flex; align-items:center; justify-content:center; color:#fff; background:#dc2626; font-size:11px; line-height:1; }
.request-bot-panel { position:absolute; right:0; bottom:68px; width:min(360px, calc(100vw - 32px)); overflow:hidden; border:1px solid #dbe3ef; border-radius:14px; background:#fff; box-shadow:0 16px 40px rgba(15,23,42,.22); color:#1f2937; }
.request-bot-panel-header { padding:15px 17px; color:#fff; background:#123a66; }
.request-bot-panel-header h3 { margin:0; font-size:15px; font-weight:700; }
.request-bot-panel-header p { margin:4px 0 0; color:#dbeafe; font-size:12px; }
.request-bot-list { max-height:300px; overflow-y:auto; margin:0; padding:8px 16px; list-style:none; }
.request-bot-item { display:flex; gap:10px; padding:11px 0; border-bottom:1px solid #eef2f7; font-size:13px; }
.request-bot-item:last-child { border-bottom:0; }
.request-bot-item-icon { color:#1d4ed8; font-size:16px; }
.request-bot-empty { padding:20px 16px; color:#64748b; text-align:center; font-size:13px; }
@media (max-width: 576px) { .request-bot { right:16px; bottom:16px; } }
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

                        <div id="requestBot" class="request-bot">
                            <section id="requestBotPanel" class="request-bot-panel" aria-label="Book exchange notifications" hidden>
                                <div class="request-bot-panel-header">
                                    <h3>Notifications</h3>
                                    <p>Requests received and updates on requests you sent.</p>
                                </div>
                                <p id="requestBotEmpty" class="request-bot-empty mb-0">No new notifications.</p>
                                <ul id="requestBotList" class="request-bot-list" aria-live="polite"></ul>
                            </section>
                            <button id="requestBotToggle" class="request-bot-toggle" type="button" aria-expanded="false" aria-controls="requestBotPanel">
                                <span aria-hidden="true">🔔</span><span>Notifications</span>
                                <span id="requestBotBadge" class="request-bot-badge" aria-label="Unread notifications" hidden>0</span>
                            </button>
                        </div>

                        <script>
                        (function () {
                            const root = document.getElementById('requestBot');
                            if (!root) return;

                            const toggle = document.getElementById('requestBotToggle');
                            const panel = document.getElementById('requestBotPanel');
                            const badge = document.getElementById('requestBotBadge');
                            const list = document.getElementById('requestBotList');
                            const emptyMessage = document.getElementById('requestBotEmpty');
                            let currentSignature = '';
                            let unreadStatusCount = 0;
                            let polling = false;

                            toggle.addEventListener('click', function () {
                                const isOpening = panel.hidden;
                                panel.hidden = !isOpening;
                                toggle.setAttribute('aria-expanded', String(isOpening));
                                if (isOpening && unreadStatusCount > 0) markStatusNotificationsRead();
                            });

                            function updateBadge(count) {
                                badge.textContent = count > 9 ? '9+' : String(count);
                                badge.hidden = count === 0;
                            }

                            function renderNotifications(data) {
                                const notifications = [];
                                if (data.request) {
                                    notifications.push({
                                        key: `received-${data.request.id}`,
                                        icon: '📥',
                                        message: `${data.request.requester_name} requested “${data.request.book_title}”.`,
                                        createdAt: data.request.created_at || null,
                                        kind: 'received'
                                    });
                                }
                                (data.status_updates || []).forEach(notification => {
                                    notifications.push({
                                        key: `status-${notification.id}`,
                                        icon: notification.status === 'approved' ? '✅' : (notification.status === 'cancelled' ? '↩️' : '📤'),
                                        message: notification.message,
                                        createdAt: notification.created_at || null,
                                        kind: 'status',
                                        unread: Boolean(notification.unread)
                                    });
                                });

                                notifications.sort((a, b) => (Date.parse(b.createdAt || '') || 0) - (Date.parse(a.createdAt || '') || 0));
                                unreadStatusCount = Number(data.unread_status_count) || 0;
                                updateBadge((data.request ? 1 : 0) + unreadStatusCount);

                                const signature = notifications.map(notification => `${notification.key}:${notification.message}:${notification.unread ? 'unread' : 'read'}`).join('|');
                                if (signature === currentSignature) return;
                                currentSignature = signature;
                                list.replaceChildren();
                                emptyMessage.hidden = notifications.length > 0;

                                notifications.forEach(notification => {
                                    const item = document.createElement('li');
                                    item.className = `request-bot-item${notification.unread ? ' notification-unread' : ''}`;
                                    const icon = document.createElement('span');
                                    icon.className = 'request-bot-item-icon';
                                    icon.setAttribute('aria-hidden', 'true');
                                    icon.textContent = notification.icon;
                                    const text = document.createElement('span');
                                    if (notification.unread) text.className = 'fw-semibold';
                                    text.textContent = notification.message;
                                    item.append(icon, text);
                                    list.append(item);
                                });
                            }

                            async function markStatusNotificationsRead() {
                                try {
                                    const response = await fetch(`{{ route('dashboard.request-notifications.read-status-updates') }}`, {
                                        method: 'POST',
                                        headers: {
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': @json(csrf_token())
                                        }
                                    });
                                    if (response.ok) checkForRequests();
                                } catch (error) {
                                    // Keep the updates unread and retry when the panel is opened again.
                                }
                            }

                            async function checkForRequests() {
                                if (polling || document.visibilityState !== 'visible') return;
                                polling = true;
                                try {
                                    const response = await fetch(`{{ route('dashboard.request-notifications') }}`, {
                                        headers: { 'Accept': 'application/json' },
                                        cache: 'no-store'
                                    });
                                    if (!response.ok) return;
                                    const data = await response.json();
                                    renderNotifications(data);
                                } catch (error) {
                                    // Keep polling; a temporary network issue should not disable notifications.
                                } finally {
                                    polling = false;
                                }
                            }

                            checkForRequests();
                            window.setInterval(checkForRequests, 15000);
                            document.addEventListener('visibilitychange', checkForRequests);
                        })();
                        </script>

                    @endif

            </div>
        </div>
    </div>
</x-app-layout>
