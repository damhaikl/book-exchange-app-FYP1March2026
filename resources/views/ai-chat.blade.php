<!DOCTYPE html>
<html>
<head>
    <title>AI Assistant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .user-msg .bubble {
            background: #0d6efd;
            color: white;
        }

        .ai-msg .bubble {
            background: #e9ecef;
        }
    </style>
</head>

<body>

<div class="chat-container">

    <h3 class="mb-4">🤖 UniKLBook AI Assistant</h3>

    <!-- CHAT AREA -->
    <div class="chat-box" id="chatBox">

        <div class="ai-msg">
            <div class="bubble">
                Hi 👋 What kind of book are you looking for?
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

<!-- JAVASCRIPT -->
<script>

document.getElementById('chatForm').addEventListener('submit', async function(e) {

    e.preventDefault();

    const messageInput = document.getElementById('message');
    const message = messageInput.value.trim();

    if (!message) return;

    const chatBox = document.getElementById('chatBox');

    // 🧑 USER MESSAGE
    chatBox.innerHTML += `
        <div class="user-msg">
            <div class="bubble">${escapeHtml(message)}</div>
        </div>
    `;

    messageInput.value = '';

    try {

        const response = await fetch('/ai-chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        });

        // 🚨 check if server is OK
        if (!response.ok) {
            throw new Error("Server error: " + response.status);
        }

        const data = await response.json();

        // 🤖 AI MESSAGE
        chatBox.innerHTML += `
            <div class="ai-msg">
                <div class="bubble">${data.reply}</div>
            </div>
        `;

        chatBox.scrollTop = chatBox.scrollHeight;

    } catch (error) {

        console.error(error);

        chatBox.innerHTML += `
            <div class="ai-msg">
                <div class="bubble">
                    ⚠️ AI error, try again later.
                </div>
            </div>
        `;
    }

});

// 🛡️ Prevent HTML injection
function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

</script>

</body>
</html>