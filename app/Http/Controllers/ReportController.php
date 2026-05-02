<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // 👤 USER: Submit report
    public function store(Request $request, $bookId)
    {
        // validation (important)
        $request->validate([
            'reason' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Report::create([
            'book_id' => $bookId,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Report submitted!');
    }

    // 🛡️ ADMIN: View all reports
    public function index()
    {
        $reports = Report::with('user', 'book')->latest()->get();
        return view('admin.reports', compact('reports'));
    }

    public function pendingReports()
    {
        $reports = Report::with('user', 'book')
                    ->where('status', 'pending')
                    ->latest()
                    ->get();

        return view('admin.pending-reports', compact('reports'));
    }

    // 🛡️ ADMIN: Update report status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved,rejected'
        ]);

        $report = Report::findOrFail($id);
        $report->status = $request->status;
        $report->save();

        return back()->with('success', 'Status updated');
    }

    public function myReports()
    {
        $reports = Report::with('book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('reports.my-reports', compact('reports'));
    }

    // User delete their own reports
    public function destroy($id)
    {
        $report = Report::where('id', $id)
            ->where('user_id', auth()->id()) // 🔒 only own report
            ->firstOrFail();

        $report->delete();

        return back()->with('success', 'Report deleted successfully!');
    }

    public function resolvedReports()
    {
        $reports = Report::with('user', 'book')
            ->where('status', 'resolved')
            ->latest()
            ->get();

        return view('admin.resolved-reports', compact('reports'));
    }

    public function rejectedReports()
    {
        $reports = Report::with('user', 'book')
            ->where('status', 'rejected')
            ->latest()
            ->get();

        return view('admin.rejected-reports', compact('reports'));
    }

    // admin delete reports
    public function adminDestroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Report deleted by admin!');
    }
}