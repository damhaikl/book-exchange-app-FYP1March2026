<style>
    .report-container {
        padding: 20px;
    }

    .report-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #f59e0b;
    }

    table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    th {
        background: #78350f;
        color: white;
        padding: 12px;
        text-align: left;
        font-size: 14px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        vertical-align: top;
    }

    tr:hover {
        background: #fffbeb;
    }

    /* column width control */
    th:nth-child(1), td:nth-child(1) { width: 10%; } /* User */
    th:nth-child(2), td:nth-child(2) { width: 9%; } /* Book */
    th:nth-child(3), td:nth-child(3) { width: 9%; }  /* Reason */
    th:nth-child(4), td:nth-child(4) { width: 10%; } /* Description */
    th:nth-child(5), td:nth-child(5) { width: 8%; }  /* Status */
    th:nth-child(6), td:nth-child(6) { width: 8%; } /* Submitted */
    th:nth-child(7), td:nth-child(7) { width: 8%; } /* Updated */
    th:nth-child(8), td:nth-child(8) { width: 7%; } /* View */
    th:nth-child(9), td:nth-child(9) { width: 7%; }  /* Delete */
    th:nth-child(10), td:nth-child(10) { width: 10%; } /* Action */
    th:nth-child(11), td:nth-child(11) { width: 0%; } /* Update */

    .status-pending {
        color: #f59e0b;
        font-weight: bold;
        background: #fffbeb;
        padding: 6px 12px;
        border-radius: 999px;
        display: inline-block;
    }

    button {
        padding: 6px 10px;
        background: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover {
        background: #1d4ed8;
    }

    select {
        padding: 6px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .view-btn {
        background: #16a34a;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
    }

    .view-btn:hover {
        background: #15803d;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 15px;
        padding: 8px 14px;
        background: #111827;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
    }

    .back-btn:hover {
        background: #374151;
    }

    .delete-btn {
        background: #dc2626;
        color: white;
        padding: 6px 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .delete-btn:hover {
        background: #b91c1c;
    }

    .searchbutton{
        color: white;
    }

    .btn-box {
        margin-top: 10px;
        padding: 10px 16px;
        border: 1px solid #ccc;
        background-color: #f8f9fa;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Admin Reports
        </h2>
    </x-slot>

<div class="report-container">

    <a href="{{ route('dashboard') }}" class="back-btn">
        ← Back to Dashboard
    </a>

    <div class="report-title">Pending Reports</div>

    <form method="GET" action="{{ url()->current() }}" style="margin-bottom: 15px;">
        <input type="text"
            name="search"
            placeholder="Search user / book / reason..."
            value="{{ request('search') }}"
            style="padding:6px; width:250px; border:1px solid #ccc; border-radius:6px;">

        <button type="submit" style="padding:6px 10px;">
            <div class="searchbutton">
                Search    
            </div>
        </button>
        
        @if(request('search'))
        <a href="{{ url()->current() }}"
           style="padding:6px 10px; background:#6b7280; color:white; border-radius:6px; text-decoration:none;">
            Reset
        </a>
        @endif
    </form>

    <table>
        <tr>
            <th>User</th>
            <th>Book</th>
            <th>Reason</th>
            <th>Description</th>
            <th>Status</th>
            <th>Submitted</th>
            <th>Updated</th>
            <th>View Content</th>
            <th>Delete Report</th>
            <th>Action</th>
            <th></th>
        </tr>

        @forelse($reports as $report)
        <tr>
            <td>{{ $report->user->name }}</td>
            <td>{{ $report->book->title ?? 'N/A' }}</td>
            <td>{{ $report->reason }}</td>
            <td>{{ $report->description }}</td>

            <td>
                <span class="status-pending">Pending</span>
            </td>

            <td>{{ $report->created_at->format('d M Y, h:i A') }}</td>
            <td>{{ $report->updated_at->format('d M Y, h:i A') }}</td>

            <td>
                <a href="{{ url('/book/' . $report->book_id) }}" class="view-btn" target="_blank">
                    👁 View
                </a>
            </td>

            <!-- DELETE -->
            <td>
                <form method="POST"
                      action="{{ route('admin.reports.delete', $report->id) }}"
                      onsubmit="return confirm('Are you sure?')">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="delete-btn">
                        🗑 Delete
                    </button>
                </form>
            </td>

            <!-- UPDATE -->
            <td>
                <form method="POST" action="{{ route('admin.reports.update', $report->id) }}">
                    @csrf

                    <select name="status">
                        <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>

                    <!-- ✅ ADMIN REVIEW FIELD -->
                    <textarea name="admin_review"
                            placeholder="Write admin review..."
                            style="width:100%; margin-top:5px; padding:6px; border:1px solid #ccc; border-radius:6px;">{{ $report->admin_review }}</textarea>

                    <button type="submit" class="btn-box">
                        Update
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10" style="text-align:center; padding:20px;">
                No reports found
            </td>
        </tr>
        @endforelse

    </table>

</div>
</x-app-layout>