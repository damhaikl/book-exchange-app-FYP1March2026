<style>
    .report-container {
        padding: 20px;
    }

    .report-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #16a34a;
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
        background: #14532d;
        color: white;
        padding: 14px;
        font-size: 14px;
        text-align: left;
    }

    td {
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        word-wrap: break-word;
        overflow-wrap: break-word;
        vertical-align: top;
    }

    tr:hover {
        background: #f0fdf4;
    }

    th:nth-child(1), td:nth-child(1) { width: 12%; }
    th:nth-child(2), td:nth-child(2) { width: 12%; }
    th:nth-child(3), td:nth-child(3) { width: 15%; }
    th:nth-child(4), td:nth-child(4) { width: 25%; }
    th:nth-child(5), td:nth-child(5) { width: 10%; }
    th:nth-child(6), td:nth-child(6) { width: 12%; }
    th:nth-child(7), td:nth-child(7) { width: 12%; }
    th:nth-child(8), td:nth-child(8) { width: 12%; }
    th:nth-child(9), td:nth-child(9) { width: 8%; }

    .status-resolved {
        color: #16a34a;
        font-weight: bold;
        background: #ecfdf5;
        padding: 6px 10px;
        border-radius: 999px;
        display: inline-block;
    }

    .btn-view {
        background: #16a34a;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        text-decoration: none;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
        padding: 6px 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
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

    <div class="report-title">Resolved Reports</div>

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
            <th>View</th>
            <th>Action</th>
        </tr>

        @forelse($reports as $report)
        <tr>
            <td>{{ $report->user->name }}</td>
            <td>{{ $report->book->title ?? 'N/A' }}</td>
            <td>{{ $report->reason }}</td>
            <td>{{ $report->description }}</td>

            <td>
                <span class="status-resolved">Resolved</span>
            </td>

            <td>{{ $report->created_at->format('d M Y, h:i A') }}</td>
            <td>{{ $report->updated_at->format('d M Y, h:i A') }}</td>

            <td>
                <a href="{{ url('/book/' . $report->book_id) }}" class="btn-view" target="_blank">
                    View
                </a>
            </td>

            <td>
                <form method="POST" action="{{ route('admin.reports.delete', $report->id) }}"
                      onsubmit="return confirm('Delete this report?')">
                    @csrf
                    @method('DELETE')

                    <button class="btn-delete">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" style="text-align:center; padding:20px;">
                No resolved reports found.
            </td>
        </tr>
        @endforelse

    </table>
</div>
</x-app-layout>