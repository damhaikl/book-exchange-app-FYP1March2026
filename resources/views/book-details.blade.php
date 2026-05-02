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
            cursor: pointer;
        }

        .back-btn {
            text-decoration: none;
            font-size: 14px;
            color: #0d6efd;
            display: inline-block;
            margin-bottom: 15px;
        }

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

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
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
            <form method="POST" action="{{ route('book.request', $book->id) }}" onsubmit="handleSubmit(event, 'Request Sent 🤝', 'Your request has been sent!')">
                @csrf
                <button type="submit" onclick="return confirm('Request this book?')">
                    🤝 Request Book
                </button>
            </form>
        @else
            <p style="color:red;">🚫 Not available</p>
        @endif

        <!-- 🚨 REPORT BUTTON -->
        @if($book->user_id != auth()->id())
            <button onclick="openReportPopup()">🚨 Report Book</button>
        @endif

    </div>

</div>

<!-- 🔔 NORMAL POPUP -->
<div id="popup" class="popup">
    <div class="popup-content">
        <h3 id="popupTitle"></h3>
        <p id="popupText"></p>
        <button onclick="closePopup()">OK</button>
    </div>
</div>

<!-- 🚨 REPORT POPUP -->
<div id="reportPopup" class="popup">
    <div class="popup-content">
        <h3>Report Book</h3>

        <form method="POST" action="{{ route('report.store', $book->id) }}">
            @csrf

            <input type="text" name="reason" placeholder="Reason (e.g. Fake, Spam)" required>

            <textarea name="description" placeholder="Describe the issue"></textarea>

            <br><br>
            <button type="submit">Submit</button>
            <button type="button" onclick="closeReportPopup()">Cancel</button>
        </form>
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

function handleSubmit(event, title, message) {
    event.preventDefault();
    showPopup(title, message);

    setTimeout(() => {
        event.target.submit();
    }, 800);
}

// 🚨 Report popup
function openReportPopup() {
    document.getElementById('reportPopup').style.display = 'block';
}

function closeReportPopup() {
    document.getElementById('reportPopup').style.display = 'none';
}
</script>

</body>
</html>