<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Mail\ReportStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

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

        // Create Report
        $report = Report::create([
            'book_id' => $bookId,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        $report->load(['user', 'book']);

        // 📧 NOTIFY ADMIN & SUPERADMIN
        $admins = User::whereIn('role', ['admin', 'super_admin'])->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)
                ->queue(new ReportStatusMail($report, 'pending'));
        }

        return back()->with('success', 'Report submitted!');
    }

    // 🛡️ ADMIN: View all reports
    public function index(Request $request)
    {
        $query = Report::with('user', 'book');

        // search
        if ($request->search) {
            $query->where(function ($q) use ($request) {

                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->search . '%');
                })

                ->orWhereHas('book', function ($b) use ($request) {
                    $b->where('title', 'like', '%' . $request->search . '%');
                })

                ->orWhere('reason', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $reports = $query->latest()->get();

        return view('admin.reports', compact('reports'));
    }

    public function pendingReports(Request $request)
    {
        $query = Report::with('user', 'book')
            ->where('status', 'pending');

        if ($request->search) {
            $query->where(function ($q) use ($request) {

                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->search . '%');
                })

                ->orWhereHas('book', function ($b) use ($request) {
                    $b->where('title', 'like', '%' . $request->search . '%');
                })

                ->orWhere('reason', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $reports = $query->latest()->get();

        return view('admin.pending-reports', compact('reports'));
    }

    // 🛡️ ADMIN: Update report status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved,rejected',
            'admin_review' => 'nullable|string|max:1000'
        ]);

        $report = Report::findOrFail($id);

        $oldStatus = $report->status;

        $report->status = $request->status;

         // ✅ SAVE ADMIN REVIEW
        $report->admin_review = $request->admin_review;
        
        $report->save();

        // 📧 NOTIFY USER WHO MADE REPORT
        $user = $report->user;

        if ($user && $oldStatus !== $request->status) {
            Mail::to($user->email)
                ->queue(new ReportStatusMail($report, $request->status));
        }

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

    public function resolvedReports(Request $request)
    {
        $query = Report::with('user', 'book')
            ->where('status', 'resolved');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"))
                ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%{$request->search}%"))
                ->orWhere('reason', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $reports = $query->latest()->get();

        return view('admin.resolved-reports', compact('reports'));
    }

    public function rejectedReports(Request $request)
    {
        $query = Report::with('user', 'book')
            ->where('status', 'rejected');

        // 🔍 search feature
        if ($request->search) {
            $query->where(function ($q) use ($request) {

                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', '%' . $request->search . '%');
                })

                ->orWhereHas('book', function ($b) use ($request) {
                    $b->where('title', 'like', '%' . $request->search . '%');
                })

                ->orWhere('reason', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $reports = $query->latest()->get();

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