<!DOCTYPE html>
<html>
<head>
    <title>{{ $book->title }}</title>

    <style>
        body { 
            font-family: Arial; 
            padding: 20px; 
            background-color: #f8f9fa;
        }

        .container { 
            max-width: 800px; 
            margin: auto; 
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        img { 
            width: 100%; 
            height: 300px; 
            object-fit: cover; 
            border-radius: 10px;
        }

        .actions button {
            padding: 10px;
            margin-right: 10px;
            cursor: pointer;
        }

        /* 🔙 Back button */
        .back-btn {
            text-decoration: none;
            font-size: 14px;
            color: #0d6efd;
            display: inline-block;
            margin-bottom: 15px;
        }

        .back-btn:hover {
            text-decoration: underline;
        }

        /* 🔔 POPUP */
        .popup {
            display: none;
            position: fixed;
            top: 0; 
            left: 0;
            width: 100%; 
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .popup-content {
            background: white;
            padding: 20px;
            margin: 15% auto;
            width: 300px;
            text-align: center;
            border-radius: 10px;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<div class="container">

    <!-- 🔙 Back -->
    <a href="/homepage" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back
    </a>

    <!-- 📚 Book Info -->
    <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image">

    <h1>{{ $book->title }}</h1>
    <p>{{ $book->description }}</p>

    <h3>RM {{ $book->price }}</h3>

    <!-- 🎯 ACTIONS -->
    <div class="actions" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">

        <!-- 💬 Chat -->
        <button type="button" onclick="showPopup('Chat Seller', 'Chat feature coming soon 👀')">
            💬 Chat Seller
        </button>

        <!-- ❤️ Save -->
        @if($book->user_id != auth()->id())
            <form method="POST" action="{{ route('book.save', $book->id) }}" onsubmit="handleSubmit(event, 'Saved ❤️', 'Book successfully saved!')">
                @csrf
                <button type="submit">❤️ Save Book</button>
            </form>
        @endif

        <!-- 🤝 Request -->
        @if($book->status == 'available')
            <form method="POST" action="{{ route('book.request', $book->id) }}" onsubmit="handleSubmit(event, 'Request Sent 🤝', 'Your request has been sent to the seller!')">
                @csrf
                <button type="submit" onclick="return confirm('Request this book?')">
                    🤝 Request Book
                </button>
            </form>
        @else
            <p style="color:red; margin:0;">
                🚫 This book is no longer available
            </p>
        @endif

    </div>

</div>

<!-- 🔔 POPUP -->
<div id="popup" class="popup">
    <div class="popup-content">
        <h3 id="popupTitle">Message</h3>
        <p id="popupText"></p>

        <button onclick="closePopup()">OK</button>
    </div>
</div>

<script>
function showPopup(title, message) {
    document.getElementById('popupTitle').innerText = title;
    document.getElementById('popupText').innerText = message;
    document.getElementById('popup').style.display = 'block';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

// ⭐ NEW: handle submit properly
function handleSubmit(event, title, message) {
    event.preventDefault(); // stop reload

    showPopup(title, message);

    // submit AFTER showing popup
    setTimeout(() => {
        event.target.submit();
    }, 800);
}
</script>

</body>
</html>