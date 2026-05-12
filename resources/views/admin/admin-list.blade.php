<style>
    .container {
        max-width: 1000px;
        margin: 30px auto;
        font-family: Arial, sans-serif;
    }

    h2 {
        color: #7c3aed;
        margin-bottom: 15px;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .back-btn {
        text-decoration: none;
        padding: 6px 12px;
        background: #6b7280;
        color: white;
        border-radius: 6px;
        font-size: 14px;
    }

    .back-btn:hover {
        background: #4b5563;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    th {
        background: #7c3aed;
        color: white;
        padding: 10px;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #e5e7eb;
    }

    tr:hover {
        background: #f3f4f6;
    }

    .btn {
        padding: 6px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        border: none;
        cursor: pointer;
    }

    .search-box {
        padding: 6px;
        width: 250px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }
</style>

<div class="container">

    {{-- TOP BAR --}}
    <div class="top-bar">

        {{-- 🔙 BACK TO DASHBOARD --}}
        <a href="{{ route('dashboard') }}" class="back-btn">← Back to Dashboard</a>

        <h2>Admin List</h2>

    </div>

    {{-- SEARCH --}}
    <form method="GET" action="{{ url()->current() }}" style="margin-bottom: 15px;">
        <input type="text"
            name="search"
            placeholder="Search admin name / email..."
            value="{{ request('search') }}"
            class="search-box">

        <button type="submit" class="btn btn-warning">Search</button>

        @if(request('search'))
            <a href="{{ url()->current() }}" class="btn btn-danger">Reset</a>
        @endif
    </form>

    {{-- TABLE --}}
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>

        @forelse($admins as $admin)
        <tr>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->email }}</td>
            <td>{{ $admin->role }}</td>
            <td>{{ $admin->created_at->format('d M Y, h:i A') }}</td>

            <td>
                <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-warning">
                    ✏️ Update
                </a>
            </td>

            <td>
                <form method="POST"
                      action="{{ route('admin.delete', $admin->id) }}"
                      onsubmit="return confirm('Are you sure?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        🗑 Delete
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">
                No admin found
            </td>
        </tr>
        @endforelse
    </table>

</div>