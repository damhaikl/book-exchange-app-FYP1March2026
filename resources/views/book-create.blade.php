<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sell Book</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-card {
            max-width: 600px;
            margin: 50px auto;
            border-radius: 12px;
            padding: 25px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card form-card shadow-sm">

        <h4 class="mb-4">📚 Submit Book Listing</h4>
        <form method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data">
    @csrf

    <!-- Book Title -->
    <div class="mb-3">
        <label class="form-label">Book Title</label>
        <input type="text" name="booktitle" class="form-control" required>
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label class="form-label">Book Description</label>
        <textarea name="bookdescription" class="form-control" rows="3" required></textarea>
    </div>

    <!-- Condition -->
    <div class="mb-3">
        <label class="form-label">Condition</label>
        <select name="condition" class="form-control" required>
            <option disabled selected>Select condition</option>
            <option value="New">New</option>
            <option value="Like New">Like New</option>
            <option value="Used">Used</option>
        </select>
    </div>

    <!-- Image -->
    <div class="mb-3">
        <label class="form-label">Book Image</label>
        <input type="file" name="image" class="form-control" required>
    </div>

    <!-- Subject ID -->
    <div class="mb-3">
        <label class="form-label">Subject ID</label>
        <input type="text" name="subject_id" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        Submit Listing
    </button>
</form>

    </div>

</div>

</body>
</html>