<!DOCTYPE html>
<html>
<head>
    <title>AI Assistant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f5f5f5;
        }

        .chat-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .chat-box {
            height: 500px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background: #fafafa;
        }

        .user-msg {
            text-align: right;
            margin-bottom: 15px;
        }

        .ai-msg {
            text-align: left;
            margin-bottom: 15px;
        }

        .bubble {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 15px;
            max-width: 70%;
        }

        .ai-msg .bubble {
            width: 95%;
            max-width: 95%;
            line-height: 1.55;
        }

        .user-msg .bubble {
            background: #0d6efd;
            color: white;
        }

        .ai-msg .bubble {
            background: #e9ecef;
        }

        .recommendation-intro { margin-bottom: 12px; }
        .recommendation-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(190px,1fr)); gap:10px; margin:10px 0; }
        .recommendation-card { background:#fff; border:1px solid #dbe3ef; border-radius:10px; padding:12px; min-width:0; }
        .recommendation-title { color:#1f2937; font-size:.98rem; font-weight:700; margin:0 0 8px; }
        .recommendation-meta { color:#64748b; font-size:.8rem; margin:0 0 5px; }
        .recommendation-reason { color:#374151; font-size:.88rem; margin:8px 0; }
        .recommendation-price { color:#1d4ed8; font-size:.88rem; font-weight:700; margin:0 0 8px; }
        .recommendation-link { color:#1d4ed8; font-size:.88rem; font-weight:600; text-decoration:none; }
        .recommendation-link:hover { text-decoration:underline; }
        .recommendation-actions { display:flex; align-items:center; flex-wrap:wrap; gap:9px; margin-top:10px; }
        .request-book-button { background:#1d4ed8; border:1px solid #1d4ed8; border-radius:7px; color:#fff; cursor:pointer; font-size:.82rem; font-weight:600; padding:6px 10px; }
        .request-book-button:hover { background:#1e40af; border-color:#1e40af; }
        .request-book-button.btn-success { background:#15803d; border-color:#15803d; }
        .request-book-button:disabled { cursor:default; opacity:.7; }
        .ai-list { margin:8px 0; padding-left:1.4rem; }
        .ai-list li { background:#fff; border:1px solid #dbe3ef; border-radius:9px; color:#374151; margin-bottom:8px; padding:10px 12px; }
        .popup { display:none; position:fixed; inset:0; z-index:1100; align-items:center; justify-content:center; padding:1rem; background:rgba(17,24,39,.55); }
        .popup-content { width:min(440px,100%); background:#fff; padding:1.5rem; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 16px 40px rgba(17,24,39,.18); }
        .popup-actions { display:flex; justify-content:center; flex-wrap:wrap; gap:8px; margin-top:1.25rem; }

        @media (max-width: 576px) {
            .chat-container { margin:15px auto; padding:15px; }
            .chat-box { height:65vh; }
            .ai-msg .bubble { width:100%; max-width:100%; }
            .recommendation-grid { grid-template-columns:1fr; }
        }
    </style>
</head>


<body>

<div class="chat-container">

    <div class="top-bar">
        <a href="/dashboard" class="btn btn-outline-secondary">
            ⬅️ Back
        </a>
    </div>
    <br><br>

    <h3 class="mb-4">🤖 UniKLBook AI Assistant</h3>
    @if($studentProgramme)
        <p class="text-muted small mb-3"><i class="bi bi-mortarboard me-1"></i>Book suggestions will consider your programme: <strong>{{ $studentProgramme }}</strong>.</p>
    @else
        <p class="text-muted small mb-3"><i class="bi bi-mortarboard me-1"></i>Your profile does not list a programme yet, so suggestions may be general.</p>
    @endif

    <!-- CHAT AREA -->
    <div class="chat-box" id="chatBox">

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

    <!-- CHAT FORM -->
    <form id="chatForm">
        @csrf

        <div class="input-group">
            <input type="text"
                   id="message"
                   class="form-control"
                   placeholder="Type your message..."
                   required>

            <button type="submit" class="btn btn-primary">
                Send
            </button>
        </div>
    </form>

</div>

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
