<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Book Exchange</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .auth-card {
            max-width: 500px;
            margin: 50px auto;
            border: none;
            border-radius: 14px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .auth-icon {
            font-size: 40px;
            color: #333;
            margin-bottom: 10px;
        }

        .back-btn {
            text-decoration: none;
            font-size: 14px;
            color: #0d6efd;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card auth-card p-4 shadow-sm">

        <!-- 🔙 Back Button -->
        <div class="mb-3">
            <a href="/homepage" class="back-btn">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <!-- Header -->
        <div class="auth-header">
            <div class="auth-icon">
                <i class="bi bi-person-plus"></i>
            </div>
            <h4>Create Account</h4>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Student ID -->
            <div class="mb-3">
                <label class="form-label">Student ID</label>
                <input type="text" name="studentid" class="form-control" required>
                @error('studentid')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <!-- Education Level -->
            <div class="mb-3">
                <label class="form-label">Education Level</label>
                <select id="education_level" name="education_level" class="form-control" required>
                    <option disabled selected>Select level</option>
                    <option value="Foundation">Foundation</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Bachelor">Bachelor</option>
                </select>
            </div>

            <!-- Programme -->
            <div class="mb-3">
                <label class="form-label">Programme</label>
                <select id="programme" name="programme" class="form-control" required>
                    <option disabled selected>Select programme</option>
                </select>
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn btn-primary w-100">
                Register
            </button>

            <!-- Login link -->
            <div class="text-center mt-3">
                <span class="text-muted">Already registered?</span>
                <a href="{{ route('login') }}" class="text-primary text-decoration-none">
                    Login
                </a>
            </div>

        </form>

    </div>

</div>

<!-- ⚡ DEPENDENT DROPDOWN SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const education = document.getElementById("education_level");
    const programme = document.getElementById("programme");

    const data = {
        Foundation: [
            "Foundation IT 1",
            "Foundation IT 2",
            "Foundation IT 3"
        ],
        Diploma: [
            "Diploma CS 1",
            "Diploma CS 2",
            "Diploma CS 3"
        ],
        Bachelor: [
            "Software Engineering",
            "Computer Security",
            "Artificial Intelligence"
        ]
    };

    education.addEventListener("change", function () {

        const selected = this.value;

        programme.innerHTML = '<option disabled selected>Select programme</option>';

        if (data[selected]) {
            data[selected].forEach(function (item) {
                let option = document.createElement("option");
                option.value = item;
                option.textContent = item;
                programme.appendChild(option);
            });
        }
    });

});
</script>

</body>
</html>