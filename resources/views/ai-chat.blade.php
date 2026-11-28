<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102f53">
    <title>AI Book Assistant | UniKL MIIT BookHub</title>
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
        .header-inner { position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;gap:20px;max-width:1100px;margin:auto;padding:18px 28px; }
        .brand { display:flex;align-items:center;gap:10px;color:#fff;font-weight:800;letter-spacing:-.02em;text-decoration:none; }
        .brand:hover { color:#fff; }
        .brand-mark { display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:#ffffff1d;color:#fff; }
        .header-link { display:inline-flex;align-items:center;gap:8px;padding:9px 13px;border:1px solid #ffffff70;border-radius:9px;color:#fff;font-size:.86rem;font-weight:700;text-decoration:none;transition:background .2s,color .2s; }
        .header-link:hover { color:var(--navy);background:#fff; }
        .page-intro { position:relative;z-index:1;max-width:1100px;margin:auto;padding:27px 28px 46px; }
        .eyebrow { margin:0 0 8px;color:#b8d5f5;font-size:.75rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase; }
        .page-intro h1 { margin:0;color:#fff;font-size:clamp(2rem,4vw,2.8rem);font-weight:800;letter-spacing:-.055em; }
        .page-intro p:last-child { max-width:680px;margin:9px 0 0;color:#d3e1f0;line-height:1.65; }
        .page-main { position:relative;z-index:2;max-width:1100px;margin:-19px auto 0;padding:0 28px 48px; }
        .chat-shell { overflow:hidden;border:1px solid var(--line);border-radius:17px;background:#fff;box-shadow:0 14px 38px #173f6b0d; }
        .chat-context { display:flex;align-items:center;gap:12px;padding:15px 20px;border-bottom:1px solid #e8edf3;background:#fff; }
        .context-icon { display:grid;place-items:center;flex:0 0 40px;width:40px;height:40px;border-radius:12px;color:var(--navy-mid);background:var(--sky);font-size:1.1rem; }
        .context-copy { min-width:0; }
        .context-title { margin:0;color:var(--navy);font-size:.9rem;font-weight:800; }
        .context-description { margin:3px 0 0;color:var(--muted);font-size:.79rem; }
        .programme-pill { display:inline-flex;align-items:center;gap:7px;max-width:45%;margin-left:auto;padding:7px 10px;border:1px solid #dce8f4;border-radius:999px;color:var(--navy-mid);background:#f5f9fd;font-size:.75rem;font-weight:700; }
        .programme-pill span { overflow:hidden;text-overflow:ellipsis;white-space:nowrap; }
        .chat-box { height:min(62vh,650px);min-height:400px;overflow-y:auto;padding:22px;background:#f7f9fc;scroll-behavior:smooth; }
        .user-msg,.ai-msg { margin-bottom:15px; }
        .user-msg { text-align:right; }
        .ai-msg { text-align:left; }
        .bubble { display:inline-block;max-width:min(82%,680px);padding:11px 15px;border-radius:15px;color:#263d56;background:#fff;border:1px solid #e0e8f1;box-shadow:0 3px 10px #173f6b07;line-height:1.6;text-align:left;overflow-wrap:anywhere; }
        .ai-msg .bubble { width:min(100%,850px);max-width:100%; }
        .user-msg .bubble { color:#fff;background:var(--navy);border-color:var(--navy);border-bottom-right-radius:5px; }
        .ai-msg .bubble { border-bottom-left-radius:5px; }
        .recommendation-intro { margin-bottom:12px; }
        .recommendation-grid { display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:10px;margin:10px 0; }
        .recommendation-card { min-width:0;padding:13px;border:1px solid var(--line);border-radius:11px;background:#fff; }
        .recommendation-title { margin:0 0 8px;color:var(--navy);font-size:.96rem;font-weight:800; }
        .recommendation-meta { margin:0 0 5px;color:var(--muted);font-size:.78rem; }
        .recommendation-reason { margin:8px 0;color:#425a73;font-size:.85rem; }
        .recommendation-price { margin:0 0 8px;color:var(--navy-mid);font-size:.87rem;font-weight:800; }
        .recommendation-link { color:var(--navy-mid);font-size:.84rem;font-weight:700;text-decoration:none; }
        .recommendation-link:hover { color:var(--navy-dark);text-decoration:underline; }
        .recommendation-actions { display:flex;align-items:center;flex-wrap:wrap;gap:9px;margin-top:10px; }
        .request-book-button { padding:7px 10px;border:1px solid var(--navy);border-radius:8px;color:#fff;background:var(--navy);font-size:.8rem;font-weight:700;cursor:pointer; }
        .request-book-button:hover { background:var(--navy-dark);border-color:var(--navy-dark); }
        .request-book-button.btn-success { background:#217a51;border-color:#217a51; }
        .request-book-button:disabled { cursor:default;opacity:.72; }
        .ai-list { margin:8px 0;padding-left:1.4rem; }
        .ai-list li { margin-bottom:8px;padding:10px 12px;border:1px solid var(--line);border-radius:9px;color:#374f68;background:#fff; }
        .chat-composer { padding:16px 20px 18px;border-top:1px solid #e8edf3;background:#fff; }
        .chat-composer .form-control { min-height:46px;border:1px solid #d5dfeb;border-radius:11px 0 0 11px;color:var(--ink);font-size:.9rem;box-shadow:none; }
        .chat-composer .form-control:focus { border-color:#6e9bc9;box-shadow:0 0 0 3px #dceafb; }
        .chat-send { min-width:98px;border:1px solid var(--navy);border-radius:0 11px 11px 0!important;color:#fff;background:var(--navy);font-weight:700; }
        .chat-send:hover,.chat-send:focus { color:#fff;background:var(--navy-dark);border-color:var(--navy-dark); }
        .chat-send:disabled { color:#fff;background:#71869d;border-color:#71869d; }
        .btn-primary { color:#fff;background:var(--navy);border-color:var(--navy);font-weight:700; }
        .btn-primary:hover,.btn-primary:focus { color:#fff;background:var(--navy-dark);border-color:var(--navy-dark); }
        .btn-outline-secondary { color:#526b86;border-color:#c9d5e2;font-weight:700; }
        .btn-outline-secondary:hover,.btn-outline-secondary:focus { color:var(--navy);border-color:#a9bed4;background:#eaf1f9; }
        .text-primary { color:var(--navy-mid)!important; }
        .composer-note { margin:8px 2px 0;color:#8796a6;font-size:.72rem; }
        .popup { display:none;position:fixed;inset:0;z-index:1100;align-items:center;justify-content:center;padding:1rem;background:rgba(11,37,66,.58); }
        .popup-content { width:min(440px,100%);padding:1.5rem;border:1px solid var(--line);border-radius:15px;background:#fff;box-shadow:0 20px 50px rgba(11,37,66,.22); }
        .popup-actions { display:flex;justify-content:center;flex-wrap:wrap;gap:8px;margin-top:1.25rem; }
        .schedule-proposal-form .form-label { color:#29435f;font-size:.82rem;font-weight:700; }
        .schedule-proposal-form .form-control { border-color:#d5dfeb;border-radius:9px; }
        @media(max-width:650px) {
            .header-inner { padding:14px 18px; }
            .page-intro { padding:24px 20px 40px; }
            .page-main { padding:0 14px 32px; }
            .chat-context { align-items:flex-start;flex-wrap:wrap;padding:14px; }
            .programme-pill { max-width:100%;margin-left:52px; }
            .chat-box { height:62vh;min-height:360px;padding:15px; }
            .bubble { max-width:94%;padding:10px 12px; }
            .ai-msg .bubble { width:100%;max-width:100%; }
            .recommendation-grid { grid-template-columns:1fr; }
            .chat-composer { padding:13px; }
            .chat-send { min-width:48px;font-size:0; }
            .chat-send i { font-size:1rem; }
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
            <a href="{{ route('dashboard') }}" class="header-link"><i class="bi bi-arrow-left" aria-hidden="true"></i><span>Dashboard</span></a>
        </div>
        <div class="page-intro">
            <p class="eyebrow">Your book-finding assistant</p>
            <h1>UniKL MIIT BookHub AI</h1>
            <p>Get programme-aware book suggestions, explore the catalogue, and start a book request right from the chat.</p>
        </div>
    </header>

    <main class="page-main">
        <section class="chat-shell" aria-label="AI book assistant conversation">
            <div class="chat-context">
                <div class="context-icon" aria-hidden="true"><i class="bi bi-stars"></i></div>
                <div class="context-copy">
                    <p class="context-title">Book recommendations and exchange help</p>
                    <p class="context-description">Ask about a subject, book, or meeting proposal.</p>
                </div>
                @if($studentProgramme)
                    <span class="programme-pill"><i class="bi bi-mortarboard" aria-hidden="true"></i><span>{{ $studentProgramme }}</span></span>
                @else
                    <span class="programme-pill"><i class="bi bi-mortarboard" aria-hidden="true"></i><span>General suggestions</span></span>
                @endif
            </div>

            <div class="chat-box" id="chatBox" aria-live="polite" aria-relevant="additions text">
                <div class="ai-msg" id="welcomeMessage">
                    <div class="bubble">
                        @if($studentProgramme)
                            Hi {{ $studentName }}! I’m checking the catalogue for books related to your programme…
                        @else
                            Hi {{ $studentName }}! Tell me what subject or topic you’re interested in, and I’ll look for a book.
                        @endif
                    </div>
                </div>
            </div>

            <div class="chat-composer">
                <form id="chatForm">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="message" class="form-control" placeholder="Ask about a book or subject…" aria-label="Your message" required>
                        <button type="submit" class="btn chat-send"><i class="bi bi-send-fill me-1" aria-hidden="true"></i><span>Send</span></button>
                    </div>
                    <p class="composer-note">Book suggestions are based on your programme and available listings.</p>
                </form>
            </div>
        </section>
    </main>

<div id="requestBookPopup" class="popup" role="dialog" aria-modal="true" aria-labelledby="requestBookPopupTitle" aria-describedby="requestBookPopupMessage">
    <div class="popup-content text-center">
        <div id="requestBookPopupIcon" class="fs-2 mb-2"><i class="bi bi-question-circle text-primary"></i></div>
        <h2 id="requestBookPopupTitle" class="h5 fw-semibold"></h2>
        <p id="requestBookPopupMessage" class="text-secondary mb-0"></p>
        <div class="popup-actions">
            <button id="cancelBookRequest" type="button" class="btn btn-outline-secondary" onclick="closeBookRequestPopup()">Cancel</button>
            <button id="confirmRequestButton" type="button" class="btn btn-primary" onclick="submitConfirmedBookRequest()">Request book</button>
            <button id="closeRequestPopupButton" type="button" class="btn btn-primary" onclick="continueAfterBookRequest()" hidden>Continue</button>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script>
const chatBox = document.getElementById('chatBox');
const chatForm = document.getElementById('chatForm');
const messageInput = document.getElementById('message');
const sendButton = chatForm.querySelector('button[type="submit"]');
const initialRecommendationsEnabled = @json((bool) $studentProgramme);
const maintenanceMessage = 'AI is currently under maintenance. Please try again later.';
let requestInProgress = false;
let requestableBooks = [];

chatForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const message = messageInput.value.trim();
    if (!message || requestInProgress) return;

    messageInput.value = '';
    sendMessage(message, { showUserMessage: true });
});

chatBox.addEventListener('click', function (event) {
    const button = event.target.closest('.request-book-button');
    if (button) requestRecommendedBook(button);

    const scheduleChoice = event.target.closest('.schedule-choice-button');
    if (scheduleChoice) {
        if (scheduleChoice.dataset.choice === 'yes') {
            startScheduleProposal(scheduleChoice.dataset.bookId, scheduleChoice.dataset.bookTitle);
        } else {
            const message = document.createElement('div');
            message.className = 'ai-msg';
            const bubble = document.createElement('div');
            bubble.className = 'bubble';
            bubble.textContent = 'No problem. The seller can respond using the meeting schedule already listed for the book.';
            message.appendChild(bubble);
            scheduleChoice.closest('.ai-msg').replaceWith(message);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }
});

chatBox.addEventListener('submit', function (event) {
    const form = event.target.closest('.schedule-proposal-form');
    if (!form) return;
    event.preventDefault();
    submitScheduleProposal(form);
});

async function sendMessage(message, { showUserMessage = true, initialRecommendation = false } = {}) {
    if (requestInProgress) return;
    requestInProgress = true;
    sendButton.disabled = true;

    if (showUserMessage) {
        chatBox.innerHTML += `
            <div class="user-msg">
                <div class="bubble">${escapeHtml(message)}</div>
            </div>
        `;
    }

    if (initialRecommendation) {
        sendButton.textContent = 'Finding books…';
    }

    try {
        const response = await fetch('/ai-chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': @json(csrf_token())
            },
            body: JSON.stringify({ message, initial_recommendation: initialRecommendation })
        });

        if (!response.ok) throw new Error('Server error: ' + response.status);

        const data = await response.json();
        requestableBooks = Array.isArray(data.requestable_books) ? data.requestable_books : [];
        const reply = formatAIReply(data.reply || maintenanceMessage);

        if (initialRecommendation) {
            document.querySelector('#welcomeMessage .bubble').innerHTML = reply;
        } else {
            chatBox.innerHTML += `<div class="ai-msg"><div class="bubble">${reply}</div></div>`;
        }
    } catch (error) {
        console.error(error);
        if (initialRecommendation) {
            document.querySelector('#welcomeMessage .bubble').textContent = maintenanceMessage;
        } else {
            chatBox.innerHTML += `<div class="ai-msg"><div class="bubble">${maintenanceMessage}</div></div>`;
        }
    } finally {
        requestInProgress = false;
        sendButton.disabled = false;
        sendButton.textContent = 'Send';
        chatBox.scrollTop = chatBox.scrollHeight;
        messageInput.focus();
    }
}

if (initialRecommendationsEnabled) {
    sendMessage('Recommend available books that suit my programme and explain briefly why.', {
        showUserMessage: false,
        initialRecommendation: true
    });
}

// 🛡️ Prevent HTML injection
function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function formatInlineMarkdown(text) {
    let html = escapeHtml(text);
    html = html.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
    html = html.replace(/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/g, (match, label, url) => safeBookLink(url, label));
    return html;
}

function safeBookLink(rawUrl, label = 'View book') {
    const bookId = extractBookId(rawUrl);
    if (!bookId) return escapeHtml(label);
    return `<a class="recommendation-link" href="/book/${bookId}">${escapeHtml(label)}</a>`;
}

function extractBookId(rawUrl) {
    try {
        const url = new URL(rawUrl, window.location.origin);
        return url.pathname.match(/^\/book\/(\d+)$/)?.[1] || null;
    } catch (error) {
        return null;
    }
}

function requestBookButton(bookId) {
    return `<button type="button" class="request-book-button" data-book-id="${bookId}">Request this book</button>`;
}

function findRequestableBook(title) {
    const normalizedTitle = title.toLowerCase().replace(/[^a-z0-9]+/g, ' ').trim();
    if (!normalizedTitle) return null;
    return requestableBooks.find(book => {
        const normalizedBookTitle = book.title.toLowerCase().replace(/[^a-z0-9]+/g, ' ').trim();
        return normalizedTitle === normalizedBookTitle;
    }) || null;
}

function hasRequestableRecommendation(item) {
    const title = item.match(/^\*\*(.+?)\*\*/)?.[1];
    if (title && findRequestableBook(title)) return true;
    const url = item.match(/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/)?.[2];
    const bookId = url ? extractBookId(url) : null;
    return Boolean(bookId && requestableBooks.some(book => String(book.id) === bookId));
}

let pendingBookRequest = null;

function requestRecommendedBook(button) {
    const bookId = button.dataset.bookId;
    const card = button.closest('.recommendation-card');
    const title = card?.querySelector('.recommendation-title')?.textContent?.trim() || 'this book';
    if (!bookId) return;

    pendingBookRequest = { bookId, title, button };
    document.getElementById('requestBookPopupIcon').innerHTML = '<i class="bi bi-question-circle text-primary"></i>';
    document.getElementById('requestBookPopupTitle').textContent = 'Request this book?';
    document.getElementById('requestBookPopupMessage').textContent = `Send a request for “${title}”? The seller will be notified.`;
    document.getElementById('cancelBookRequest').hidden = false;
    document.getElementById('cancelBookRequest').textContent = 'Cancel';
    document.getElementById('confirmRequestButton').hidden = false;
    document.getElementById('confirmRequestButton').disabled = false;
    document.getElementById('confirmRequestButton').textContent = 'Request book';
    document.getElementById('closeRequestPopupButton').hidden = true;
    document.getElementById('requestBookPopup').style.display = 'flex';
}

function closeBookRequestPopup() {
    document.getElementById('requestBookPopup').style.display = 'none';
    pendingBookRequest = null;
}

async function submitConfirmedBookRequest() {
    if (!pendingBookRequest) return;

    const { bookId, button } = pendingBookRequest;
    const confirmButton = document.getElementById('confirmRequestButton');
    const cancelButton = document.getElementById('cancelBookRequest');
    confirmButton.disabled = true;
    cancelButton.hidden = true;
    document.getElementById('requestBookPopupIcon').innerHTML = '<span class="spinner-border spinner-border-sm text-primary" role="status" aria-label="Sending"></span>';
    document.getElementById('requestBookPopupTitle').textContent = 'Sending request…';
    document.getElementById('requestBookPopupMessage').textContent = 'Please wait while your request is sent to the seller.';

    try {
        const response = await fetch(`/book/${bookId}/request`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': @json(csrf_token())
            }
        });
        const data = await response.json();
        if (!response.ok) {
            const error = new Error(data.message || 'Unable to request this book.');
            if (Array.isArray(data.alternatives)) error.alternatives = data.alternatives;
            error.bookTitle = pendingBookRequest?.title || 'this book';
            throw error;
        }

        button.textContent = 'Request sent';
        button.classList.add('btn-success');
        button.disabled = true;
        document.getElementById('requestBookPopupIcon').innerHTML = '<i class="bi bi-check-circle text-success"></i>';
        document.getElementById('requestBookPopupTitle').textContent = 'Request sent';
        document.getElementById('requestBookPopupMessage').textContent = data.message || 'The seller has been notified.';
        document.getElementById('confirmRequestButton').hidden = true;
        document.getElementById('closeRequestPopupButton').hidden = false;
    } catch (error) {
        document.getElementById('requestBookPopupIcon').innerHTML = '<i class="bi bi-exclamation-circle text-danger"></i>';
        document.getElementById('requestBookPopupTitle').textContent = 'Unable to send request';
        document.getElementById('requestBookPopupMessage').textContent = error.message || 'Please try again.';
        document.getElementById('cancelBookRequest').hidden = false;
        document.getElementById('cancelBookRequest').textContent = error.alternatives?.length ? 'View alternatives' : 'Cancel';
        document.getElementById('confirmRequestButton').disabled = false;
        document.getElementById('confirmRequestButton').textContent = 'Try again';
        if (Array.isArray(error.alternatives)) {
            showBookAlternatives(error.bookTitle || 'this book', error.alternatives);
        }
    }
}

function showBookAlternatives(originalTitle, alternatives) {
    const message = document.createElement('div');
    message.className = 'ai-msg';
    const bubble = document.createElement('div');
    bubble.className = 'bubble';
    const heading = document.createElement('p');
    heading.className = 'mb-2';
    heading.textContent = alternatives.length
        ? `Here are similar available books instead of “${originalTitle}”:`
        : `I couldn’t find a close alternative to “${originalTitle}” in the available listings.`;
    bubble.appendChild(heading);

    if (alternatives.length) {
        const grid = document.createElement('div');
        grid.className = 'recommendation-grid';
        grid.innerHTML = alternatives.map(book => {
            const bookId = Number(book.id);
            if (!Number.isInteger(bookId) || bookId < 1) return '';
            const meta = [book.subject_category, book.subject_id].filter(Boolean).join(' · ');
            const price = book.price !== null && book.price !== undefined ? `RM ${escapeHtml(String(book.price))}` : '';
            return `<article class="recommendation-card">
                <h4 class="recommendation-title">${escapeHtml(book.title || 'Book')}</h4>
                ${meta ? `<p class="recommendation-meta">${escapeHtml(meta)}</p>` : ''}
                ${book.reason ? `<p class="recommendation-reason">${escapeHtml(book.reason)}</p>` : ''}
                ${price ? `<p class="recommendation-price">${price}</p>` : ''}
                <div class="recommendation-actions"><a class="recommendation-link" href="/book/${bookId}">View book</a>${requestBookButton(bookId)}</div>
            </article>`;
        }).join('');
        bubble.appendChild(grid);
    }

    message.appendChild(bubble);
    chatBox.appendChild(message);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function continueAfterBookRequest() {
    if (!pendingBookRequest) return closeBookRequestPopup();
    const { bookId, title } = pendingBookRequest;
    closeBookRequestPopup();
    const message = document.createElement('div');
    message.className = 'ai-msg';
    const bubble = document.createElement('div');
    bubble.className = 'bubble';
    bubble.innerHTML = `<p class="mb-2">Would you like to propose a new meeting schedule for <strong>${escapeHtml(title)}</strong>?</p><button type="button" class="btn btn-primary btn-sm me-2 schedule-choice-button" data-choice="yes" data-book-id="${escapeHtml(bookId)}" data-book-title="${escapeHtml(title)}">Yes, propose a time</button><button type="button" class="btn btn-outline-secondary btn-sm schedule-choice-button" data-choice="no">No, thanks</button>`;
    message.appendChild(bubble);
    chatBox.appendChild(message);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function startScheduleProposal(bookId, title) {
    if (!bookId || !/^\d+$/.test(bookId)) return;
    const today = new Date();
    const minDate = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
    const bubble = document.createElement('div');
    bubble.className = 'ai-msg';
    bubble.innerHTML = `
        <div class="bubble">
            <p class="mb-3">Sure! To propose a meeting for <strong>${escapeHtml(title)}</strong>, please provide the meeting location, date, and start and end times.</p>
            <form class="schedule-proposal-form" data-book-id="${escapeHtml(bookId)}">
                <div class="mb-2"><label class="form-label" for="proposal-location-${bookId}">Meeting location</label><input id="proposal-location-${bookId}" name="proposed_location" class="form-control" maxlength="255" required placeholder="e.g. UniKL library"></div>
                <div class="mb-2"><label class="form-label" for="proposal-date-${bookId}">Date</label><input id="proposal-date-${bookId}" name="proposed_date" type="date" class="form-control" min="${minDate}" required></div>
                <div class="row g-2 mb-3">
                    <div class="col"><label class="form-label" for="proposal-start-${bookId}">Start time</label><input id="proposal-start-${bookId}" name="proposed_time" type="time" class="form-control" required></div>
                    <div class="col"><label class="form-label" for="proposal-end-${bookId}">End time</label><input id="proposal-end-${bookId}" name="proposed_end_time" type="time" class="form-control" required></div>
                </div>
                <p class="schedule-proposal-error text-danger small" role="alert"></p>
                <button type="submit" class="btn btn-primary">Send meeting proposal</button>
            </form>
        </div>`;
    chatBox.appendChild(bubble);
    chatBox.scrollTop = chatBox.scrollHeight;
    bubble.querySelector('input[name="proposed_location"]').focus();
}

async function submitScheduleProposal(form) {
    const submitButton = form.querySelector('button[type="submit"]');
    const errorElement = form.querySelector('.schedule-proposal-error');
    const start = form.elements.proposed_time.value;
    const end = form.elements.proposed_end_time.value;
    errorElement.textContent = '';
    if (end <= start) {
        errorElement.textContent = 'The end time must be later than the start time.';
        return;
    }

    submitButton.disabled = true;
    submitButton.textContent = 'Sending…';
    try {
        const response = await fetch(`/ai-chat/propose-schedule/${form.dataset.bookId}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': @json(csrf_token())
            },
            body: new FormData(form)
        });
        const data = await response.json();
        if (!response.ok) {
            const validationMessage = data.errors ? Object.values(data.errors).flat().join(' ') : data.message;
            throw new Error(validationMessage || 'Unable to send the meeting proposal.');
        }

        const proposal = data.schedule;
        const startTime = new Date(`2000-01-01T${proposal.proposed_time}`).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
        const endTime = new Date(`2000-01-01T${proposal.proposed_end_time}`).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
        const success = document.createElement('div');
        success.className = 'ai-msg';
        const successBubble = document.createElement('div');
        successBubble.className = 'bubble';
        successBubble.textContent = `Your meeting proposal was sent to the seller: ${proposal.proposed_location}, ${proposal.proposed_date}, ${startTime}–${endTime}.`;
        success.appendChild(successBubble);
        form.closest('.ai-msg').replaceWith(success);
    } catch (error) {
        errorElement.textContent = error.message || 'Unable to send the meeting proposal. Please try again.';
        submitButton.disabled = false;
        submitButton.textContent = 'Send meeting proposal';
    }
    chatBox.scrollTop = chatBox.scrollHeight;
}

function formatAIReply(text) {
    const table = renderRecommendationTable(text);
    return table === null ? formatPlainMarkdown(text) : table;
}

function renderRecommendationTable(text) {
    const lines = text.split(/\r?\n/);
    let start = -1;

    for (let index = 0; index < lines.length - 1; index++) {
        const headers = splitTableRow(lines[index]);
        const separators = splitTableRow(lines[index + 1]);
        if (headers && separators && separators.every(cell => /^:?-{3,}:?$/.test(cell))) {
            start = index;
            break;
        }
    }

    if (start === -1) return null;

    const headers = splitTableRow(lines[start]);
    const rows = [];
    let end = start + 2;
    for (; end < lines.length; end++) {
        const row = splitTableRow(lines[end]);
        if (!row) break;
        rows.push(row);
    }

    const column = phrase => headers.findIndex(header => header.toLowerCase().includes(phrase));
    const getCell = (row, phrase, fallbackIndex = -1) => {
        const index = column(phrase);
        return row[index >= 0 ? index : fallbackIndex] || '';
    };
    const intro = formatPlainMarkdown(lines.slice(0, start).join('\n'));
    const cards = rows.map(row => {
        const title = getCell(row, 'title', 0);
        const category = getCell(row, 'category', 1);
        const subject = getCell(row, 'subject id', 2);
        const price = getCell(row, 'price', 3);
        const reason = getCell(row, 'why', 4) || getCell(row, 'useful', 4);
        const link = getCell(row, 'url', 5) || getCell(row, 'link', 5);
        const displayPrice = price && !/^RM\s*/i.test(price) ? `RM ${price}` : price;
        const markdownLink = link.match(/^\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)$/);
        const rawUrl = markdownLink ? markdownLink[2] : link;
        const linkedBookId = rawUrl ? extractBookId(rawUrl) : null;
        const bookId = requestableBooks.some(book => String(book.id) === linkedBookId)
            ? linkedBookId
            : findRequestableBook(title)?.id;
        const url = rawUrl ? safeBookLink(rawUrl, markdownLink?.[1] || 'View book') : '';

        return `<article class="recommendation-card">
            <h4 class="recommendation-title">${formatInlineMarkdown(title)}</h4>
            <p class="recommendation-meta">${escapeHtml(category)}${subject ? ` · ${escapeHtml(subject)}` : ''}</p>
            ${reason ? `<p class="recommendation-reason">${formatInlineMarkdown(reason)}</p>` : ''}
            ${displayPrice ? `<p class="recommendation-price">${escapeHtml(displayPrice)}</p>` : ''}
            ${url || bookId ? `<div class="recommendation-actions">${url}${bookId ? requestBookButton(bookId) : ''}</div>` : ''}
        </article>`;
    }).join('');
    const ending = formatPlainMarkdown(lines.slice(end).join('\n'));

    return `${intro}<div class="recommendation-grid">${cards}</div>${ending}`;
}

function splitTableRow(line) {
    const trimmed = line.trim();
    if (!trimmed.startsWith('|') || !trimmed.endsWith('|')) return null;
    return trimmed.slice(1, -1).split('|').map(cell => cell.trim());
}

function formatPlainMarkdown(text) {
    const blocks = text.trim().split(/\n\s*\n/).filter(Boolean);
    return blocks.map(block => {
        const lines = block.split(/\r?\n/).map(line => line.trim()).filter(Boolean);
        const numbered = lines.every(line => /^\d+[.)]\s+/.test(line));
        const bulleted = lines.every(line => /^[-*]\s+/.test(line));

        if (numbered || bulleted) {
            const items = lines.map(line => line.replace(numbered ? /^\d+[.)]\s+/ : /^[-*]\s+/, ''));
            const recommendationList = items.some(hasRequestableRecommendation);
            if (numbered || recommendationList) {
                return `<div class="recommendation-grid">${items.map(renderRecommendationItem).join('')}</div>`;
            }
            return `<${numbered ? 'ol' : 'ul'} class="ai-list">${items.map(item => `<li>${formatInlineMarkdown(item)}</li>`).join('')}</${numbered ? 'ol' : 'ul'}>`;
        }

        if (lines.length > 0 && lines.every(hasRequestableRecommendation)) {
            return `<div class="recommendation-grid">${lines.map(renderRecommendationItem).join('')}</div>`;
        }

        return `<p class="recommendation-intro">${lines.map(formatInlineMarkdown).join('<br>')}</p>`;
    }).join('');
}

function renderRecommendationItem(item) {
    const markdownLink = item.match(/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/);
    const titleMatch = item.match(/^\*\*(.+?)\*\*/);
    const title = titleMatch?.[1] || 'Book recommendation';
    const linkedBookId = markdownLink ? extractBookId(markdownLink[2]) : null;
    const bookId = requestableBooks.some(book => String(book.id) === linkedBookId)
        ? linkedBookId
        : findRequestableBook(title)?.id;
    const description = item
        .replace(/^\*\*.+?\*\*\s*[—–-]?\s*/, '')
        .replace(/\s*\[([^\]]+)\]\(https?:\/\/[^\s)]+\)\.?\s*$/, '')
        .trim();

    return `<article class="recommendation-card">
        <h4 class="recommendation-title">${escapeHtml(title)}</h4>
        <p class="recommendation-reason">${formatInlineMarkdown(description)}</p>
        <div class="recommendation-actions">
            ${markdownLink ? safeBookLink(markdownLink[2], markdownLink[1]) : ''}
            ${bookId ? requestBookButton(bookId) : ''}
        </div>
    </article>`;
}

</script>

</body>
</html>
