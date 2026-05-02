<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            My Reports
        </h2>
    </x-slot>

<style>
    .report-container {
        padding: 20px;
    }

    .report-title {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 15px;
        color: red;
    }

    /* TABLE STYLE */
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
        background: #1f2937;
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
        background: #f9fafb;
    }

    /* COLUMN WIDTH */
    th:nth-child(1), td:nth-child(1) { width: 18%; } /* Book */
    th:nth-child(2), td:nth-child(2) { width: 12%; } /* Reason */
    th:nth-child(3), td:nth-child(3) { width: 30%; } /* Description */
    th:nth-child(4), td:nth-child(4) { width: 15%; } /* Status */
    th:nth-child(5), td:nth-child(5) { width: 15%; } /* Submitted */
    th:nth-child(6), td:nth-child(6) { width: 10%; text-align:center; } /* Action */

    /* STATUS BADGES */
    .status-pending {
        color: #f59e0b;
        font-weight: bold;
        background: #fffbeb;
        padding: 5px 10px;
        border-radius: 999px;
        display: inline-block;
    }

    .status-resolved {
        color: #16a34a;
        font-weight: bold;
        background: #ecfdf5;
        padding: 5px 10px;
        border-radius: 999px;
        display: inline-block;
    }

    .status-rejected {
        color: #dc2626;
        font-weight: bold;
        background: #fef2f2;
        padding: 5px 10px;
        border-radius: 999px;
        display: inline-block;
    }

    /* DATE STYLE */
    .date {
        color: #6b7280;
        font-size: 13px;
        white-space: nowrap;
    }

    /* DELETE BUTTON */
    .delete-btn {
        background: #dc2626;
        color: white;
        padding: 6px 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    .delete-btn:hover {
        background: #b91c1c;
    }

    /* EMPTY STATE */
    .empty {
        text-align: center;
        padding: 30px;
        color: #6b7280;
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
        transition: 0.2s;
    }

    .back-btn:hover {
        background: #374151;
    }
</style>

<div class="report-container">

    <!-- BACK BUTTON -->
    <a href="{{ route('dashboard') }}" class="back-btn">
        Back to Dashboard
    </a>

    <h3 class="report-title">List of Report</h3>

    <table>

        <tr>
            <th>Book</th>
            <th>Reason</th>
            <th>Description</th>
            <th>Status</th>
            <th>Submitted At</th>
            <th>Action</th>
        </tr>

        @forelse($reports as $report)
        <tr>
            <td>{{ $report->book->title ?? 'N/A' }}</td>

            <td>{{ $report->reason }}</td>

            <td>{{ $report->description }}</td>

            <td>
                <span class="status-{{ $report->status }}">
                    {{ ucfirst($report->status) }}
                </span>
            </td>

            <td class="date">
                {{ $report->created_at->format('d M Y, h:i A') }}
            </td>

            <td>
                <form method="POST"
                      action="{{ route('report.delete', $report->id) }}"
                      onsubmit="return confirm('Are you sure you want to delete this report?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="delete-btn">
                        🗑 Delete
                    </button>
                </form>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="6" class="empty">
                No reports found.
            </td>
        </tr>
        @endforelse

    </table>

</div>

</x-app-layout>