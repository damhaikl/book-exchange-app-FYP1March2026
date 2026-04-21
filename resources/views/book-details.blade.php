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

        /* POPUP */
        .popup {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
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

    <!-- Bootstrap Icons (for arrow) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<div class="container">

    <!-- 🔙 Back Button -->
    <a href="/homepage" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back
    </a>

    <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image" style="width:100%; height:300px; object-fit:cover; border-radius:10px;">
    <h1>{{ $book->title }}</h1>
    <p>{{ $book->description }}</p>
    <h3>RM {{ $book->price }}</h3>

    <div class="actions">
        <button onclick="showPopup()">💬 Chat Seller</button>
        <button onclick="showPopup()">❤️ Save Book</button>
    </div>
</div>

<!-- POPUP -->
<div id="loginPopup" class="popup">
    <div class="popup-content">
        <h3>Please login first</h3>
        <p>You need an account to continue.</p>

        <a href="/login">
            <button>Go to Login</button>
        </a>

        <br><br>

        <button onclick="closePopup()">No Thanks</button>
    </div>
</div>

<script>
function showPopup() {
    document.getElementById('loginPopup').style.display = 'block';
}

function closePopup() {
    document.getElementById('loginPopup').style.display = 'none';
}
</script>

</body>
</html>