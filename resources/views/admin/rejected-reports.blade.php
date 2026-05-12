<style>
    .report-container {
        padding: 20px;
    }

    .report-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #dc2626;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        table-layout: fixed;
    }

    th {
        background: #7f1d1d; /* red theme */
        color: white;
        padding: 14px;
        text-align: left;
        font-size: 14px;
    }

    td {
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        vertical-align: top;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    tr:hover {
        background: #fef2f2;
    }

    /* column widths */
    th:nth-child(1), td:nth-child(1) { width: 12%; } /* User */
    th:nth-child(2), td:nth-child(2) { width: 12%; } /* Book */
    th:nth-child(3), td:nth-child(3) { width: 15%; } /* Reason */
    th:nth-child(4), td:nth-child(4) { width: 25%; } /* Description */
    th:nth-child(5), td:nth-child(5) { width: 10%; } /* Status */
    th:nth-child(6), td:nth-child(6) { width: 12%; } /* Submitted */
    th:nth-child(7), td:nth-child(7) { width: 12%; } /* Updated */
    th:nth-child(8), td:nth-child(8) { width: 12%; } /* View */
    th:nth-child(9), td:nth-child(9) { width: 10%; } /* Delete */

    .status-rejected {
        color: #dc2626;
        font-weight: bold;
        background: #fef2f2;
        padding: 6px 12px;
        border-radius: 999px;
        display: inline-block;
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

    .btn-view {
        background: #16a34a;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
        padding: 6px 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-delete:hover {
        background: #b91c1c;
    }

    .searchbutton{
        color: white;
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

    <div class="report-title">Rejected Reports</div>

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
            <th>Submitted At</th>
            <th>Updated At</th>
            <th>View Book</th>
            <th>Delete</th>
        </tr>

        @forelse($reports as $report)
        <tr>
            <td>{{ $report->user->name }}</td>
            <td>{{ $report->book->title ?? 'N/A' }}</td>
            <td>{{ $report->reason }}</td>
            <td>{{ $report->description }}</td>

            <td>
                <span class="status-rejected">Rejected</span>
            </td>

            <td>{{ $report->created_at->format('d M Y, h:i A') }}</td>

            <td>{{ $report->updated_at->format('d M Y, h:i A') }}</td>

            <td>
                <a href="{{ url('/book/' . $report->book_id) }}" 
                   target="_blank"
                   class="btn-view">
                    👁 View
                </a>
            </td>

            <td>
                <form method="POST" action="{{ route('admin.reports.delete', $report->id) }}"
                      onsubmit="return confirm('Delete this report?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-delete">
                        🗑 Delete
                    </button>
                </form>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="9" style="text-align:center; padding:20px; color:#6b7280;">
                No rejected reports found.
            </td>
        </tr>
        @endforelse

    </table>

</div>

</x-app-layout>