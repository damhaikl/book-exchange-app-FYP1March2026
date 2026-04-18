<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Book Exchange</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .auth-card {
            max-width: 420px;
            margin: 80px auto;
            border: none;
            border-radius: 14px;
        }

        .auth-header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .user-icon {
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

        <!-- Icon + Title -->
        <div class="auth-header">
            <div class="user-icon">
                <i class="bi bi-person-circle"></i>
            </div>
            <h4>Login</h4>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       class="form-control">

                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input id="password"
                       type="password"
                       name="password"
                       required
                       class="form-control">

                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember -->
            <div class="form-check mb-3">
                <input id="remember_me"
                       type="checkbox"
                       name="remember"
                       class="form-check-input">

                <label class="form-check-label">
                    Remember me
                </label>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-primary w-100">
                Log in
            </button>

            <!-- Forgot password -->
            @if (Route::has('password.request'))
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">
                        Forgot your password?
                    </a>
                </div>
            @endif

            <!-- Sign up link -->
            <div class="text-center mt-3">
                <span class="text-muted">Don’t have an account?</span>
                <a href="{{ route('register') }}" class="text-primary fw-medium text-decoration-none">
                    Sign up
                </a>
            </div>

        </form>

    </div>

</div>

</body>
</html>