<style>
    body {
        background: #f3f4f6;
    }

    .admin-container {
        max-width: 500px;
        margin: 60px auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .admin-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 25px;
        color: #111827;
        text-align: center;
    }

    .admin-input {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        font-size: 14px;
    }

    .admin-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
    }

    .admin-button {
        width: 100%;
        padding: 12px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
    }

    .admin-button:hover {
        background: #15803d;
    }

    .success-msg {
        background: #dcfce7;
        color: #166534;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        text-align: center;
        font-size: 14px;
    }

    .error-box {
        background: #fee2e2;
        color: #991b1b;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 15px;
        color: #2563eb;
        text-decoration: none;
        font-size: 14px;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Create New Admin
        </h2>
    </x-slot>

    <div class="admin-container">

        <a href="{{ route('dashboard') }}" class="back-link">
            ← Back to Dashboard
        </a>

        <div class="admin-title">Please Enter Details:</div>

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="error-box">
                <ul style="margin:0; padding-left:20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.store') }}">
            @csrf

            <input class="admin-input" type="text" name="studentid"
                   value="{{ old('studentid') }}" placeholder="Admin ID" required>

            <input class="admin-input" type="text" name="name"
                   value="{{ old('name') }}" placeholder="Full Name" required>

            <input class="admin-input" type="email" name="email"
                   value="{{ old('email') }}" placeholder="Email Address" required>

            <input class="admin-input" type="password" name="password"
                   placeholder="Password (min 8 characters)" required>

            <input class="admin-input" type="password" name="password_confirmation"
                   placeholder="Confirm Password" required>

            <button class="admin-button" type="submit">
                Create Admin
            </button>

        </form>

    </div>
</x-app-layout>