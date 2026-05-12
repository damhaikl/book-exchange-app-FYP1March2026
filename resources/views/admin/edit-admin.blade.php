<style>
    .edit-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 25px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        font-family: Arial, sans-serif;
    }

    h3 {
        text-align: center;
        color: #7c3aed;
        margin-bottom: 20px;
    }

    h4 {
        margin-top: 20px;
        color: #374151;
    }

    label {
        display: block;
        margin-top: 12px;
        font-weight: bold;
        color: #374151;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        outline: none;
        transition: 0.2s;
    }

    input:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 3px rgba(124,58,237,0.3);
    }

    hr {
        margin: 20px 0;
        border: none;
        border-top: 1px solid #e5e7eb;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #7c3aed;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 15px;
        cursor: pointer;
        margin-top: 15px;
        transition: 0.2s;
    }

    button:hover {
        background-color: #6d28d9;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 15px;
        text-decoration: none;
        color: #6b7280;
        font-size: 14px;
    }

    .back-link:hover {
        color: #374151;
    }
</style>

<div class="edit-container">

    <a href="{{ route('admin.list') }}" class="back-link">← Back</a>

    <h3>Edit Admin</h3>

    @if ($errors->any())
        <div style="background:#fee2e2; color:#991b1b; padding:10px; border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.update', $admin->id) }}">
        @csrf
        @method('PUT')

        <label>Name</label>
        <input type="text" name="name" value="{{ $admin->name }}">

        <label>Email</label>
        <input type="email" name="email" value="{{ $admin->email }}">

        <hr>

        <h4>🔐 Reset Password (optional)</h4>

        <label>New Password</label>
        <input type="password" name="password" minlength="8" placeholder="New Password">

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" minlength="8" placeholder="Confirm Password">

        <button type="submit">Update Admin</button>
    </form>

</div>