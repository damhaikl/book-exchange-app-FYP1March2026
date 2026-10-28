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
                <label for="studentid" class="form-label">Student ID</label>

                <input
                    type="text"
                    id="studentid"
                    name="studentid"
                    class="form-control"
                    value="{{ old('studentid') }}"
                    placeholder="Enter your Student ID"
                    required
                >

                <small id="studentid_message" class="text-muted">
                    Enter your Student ID to detect your education level.
                </small>

                @error('studentid')
                    <small class="text-danger d-block">{{ $message }}</small>
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
                <label for="education_level" class="form-label">
                    Education Level
                </label>

                <input
                    type="text"
                    id="education_level"
                    name="education_level"
                    class="form-control"
                    placeholder="Automatically detected"
                    value="{{ old('education_level') }}"
                    readonly
                    required
                >
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


<!-- AUTOMATIC EDUCATION LEVEL AND PROGRAMME -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const studentId = document.getElementById("studentid");
    const education = document.getElementById("education_level");
    const programme = document.getElementById("programme");
    const message = document.getElementById("studentid_message");

    const data = {
        Foundation: [
            "Foundation in Computer Technology",
            "Foundation in Science and Technology for Korean University"
        ],

        Diploma: [
            "Diploma in Networking Technology",
            "Diploma in Information Technology",
            "Diploma in Animation",
            "Diploma in Multimedia"
        ],

        Bachelor: [
            "Bachelor of Game Development Technology with Honours",
            "Bachelor in Information Technology (Honours) (Internet of Things)",
            "Bachelor of Multimedia Technology (Hons.) in Interactive Multimedia Design",
            "Bachelor of Computer Engineering Technology (Networking Systems) with Honours",
            "Bachelor of Software Engineering with Honours",
            "Bachelor of Cybersecurity Technology with Honours",
            "Bachelor of Multimedia Technology (Hons.) in Computer Animation",
            "Bachelor of Artificial Intelligence Technology with Honours"
        ]
    };

    function detectEducationLevel() {

        const id = studentId.value.trim();

        // Reset the fields whenever the ID changes
        education.value = "";

        programme.innerHTML =
            '<option value="">Select programme</option>';

        message.className = "text-muted";
        message.textContent =
            "Enter your Student ID to detect your education level.";

        if (id.length === 0) {
            programme.innerHTML =
                '<option value="">Enter Student ID first</option>';
            return;
        }

        // Check that the ID contains digits only
        if (!/^\d+$/.test(id)) {
            message.className = "text-danger";
            message.textContent =
                "Student ID must contain digits only.";

            programme.innerHTML =
                '<option value="">Invalid Student ID</option>';
            return;
        }

        if (id.length < 3) {
            programme.innerHTML =
                '<option value="">Enter at least 3 digits</option>';
            return;
        }

        const prefix = id.substring(0, 3);
        let level = "";

        // Detect education level from the Student ID prefix
        if (prefix === "520") {
            level = "Foundation";
        } else if (prefix === "521") {
            level = "Diploma";
        } else if (prefix === "522") {
            level = "Bachelor";
        } else {
            message.className = "text-danger";
            message.textContent =
                "Student ID prefix not recognised for UniKL MIIT.";

            programme.innerHTML =
                '<option value="">No programmes available</option>';
            return;
        }

        // Automatically display education level
        education.value = level;

        message.className = "text-success";
        message.textContent =
            "Education level detected: " + level;

        // Populate the programme dropdown
        data[level].forEach(function (item) {

            const option = document.createElement("option");

            option.value = item;
            option.textContent = item;

            programme.appendChild(option);
        });
    }

    // Update automatically while the student types
    studentId.addEventListener("input", detectEducationLevel);

    // Also detect an ID restored by Laravel after validation errors
    detectEducationLevel();

});
</script>


</body>
</html>