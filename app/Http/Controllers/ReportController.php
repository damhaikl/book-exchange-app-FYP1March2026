<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
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

        $reports = $this->applyReportFilters($query, $request)->get();

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

        $reports = $this->applyReportFilters($query, $request)->get();

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

        $previousStatus = $report->status;
        $newStatus = $request->status;

        // Update report details
        $report->status = $newStatus;
        $report->admin_review = $request->admin_review;

        // Record reviewing administrator
        if (in_array($newStatus, ['resolved', 'rejected'])) {
            $report->reviewed_by = auth()->id();
        } else {
            $report->reviewed_by = null;
        }

        $report->save();

         // Load relationships for email template
        $report->load(['user', 'book']);

        if (
            $previousStatus !== $newStatus &&
            in_array($newStatus, ['resolved', 'rejected'])
        ) {
            // Get all admins except the reviewing admin
            $admins = User::whereIn('role', ['admin', 'super_admin'])
                ->where('id', '!=', auth()->id())
                ->get();

            $reviewerName = auth()->user()->name;

            // Send Gmail to other admins
            foreach ($admins as $admin) {
                Mail::to($admin->email)->queue(
                    new ReportStatusMail($report, $newStatus, 'admin', $reviewerName)
                );
            }

            // Send Gmail to the reporting student
            $student = User::find($report->user_id);

            if ($student) {
                Mail::to($student->email)->queue(
                    new ReportStatusMail($report, $newStatus, 'student', $reviewerName)
                );
            }
        }

        return back()->with('success', 'Status updated successfully.');
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

        // Keep the existing student-side delete behavior unchanged.
        $report->forceDelete();

        return back()->with('success', 'Report deleted successfully!');
    }

    public function resolvedReports(Request $request)
    {
        $query = Report::with(['user', 'book', 'reviewer'])
            ->where('status', 'resolved');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"))
                ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%{$request->search}%"))
                ->orWhere('reason', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $reports = $this->applyReportFilters($query, $request)->get();

        return view('admin.resolved-reports', compact('reports'));
    }

    public function rejectedReports(Request $request)
    {
        $query = Report::with(['user', 'book', 'reviewer'])
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

        $reports = $this->applyReportFilters($query, $request)->get();

        return view('admin.rejected-reports', compact('reports'));
    }

    // admin delete reports
    public function adminDestroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Report moved to Deleted reports.');
    }

    public function deletedReports(Request $request)
    {
        $query = Report::onlyTrashed()
            ->with(['user', 'book', 'reviewer']);

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function (Builder $q) use ($search) {
                $q->whereHas('user', fn (Builder $user) => $user->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('book', fn (Builder $book) => $book->where('title', 'like', "%{$search}%"))
                    ->orWhere('reason', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $reports = $request->filled('filter_by')
            ? $this->applyReportFilters($query, $request)->get()
            : $query->orderByDesc('deleted_at')->get();

        return view('admin.deleted-reports', compact('reports'));
    }

    public function restoreDeleted($id)
    {
        $report = Report::onlyTrashed()->findOrFail($id);
        $report->restore();

        return back()->with('success', 'Report recovered and returned to its previous status.');
    }

    private function applyReportFilters(Builder $query, Request $request): Builder
    {
        $filters = $request->validate([
            'filter_by' => ['nullable', 'in:reporter,date,specific_date,reviewer'],
            'reporter_name' => ['required_if:filter_by,reporter', 'nullable', 'string', 'max:255'],
            'start_date' => ['required_if:filter_by,date', 'nullable', 'date'],
            'end_date' => ['required_if:filter_by,date', 'nullable', 'date', 'after_or_equal:start_date'],
            'specific_date' => ['required_if:filter_by,specific_date', 'nullable', 'date'],
            'reviewer_role' => ['required_if:filter_by,reviewer', 'nullable', 'in:admin,super_admin'],
        ]);

        $filterBy = $filters['filter_by'] ?? null;

        if ($filterBy === 'reporter') {
            $reporterName = trim($filters['reporter_name']);
            $query->whereHas('user', fn (Builder $user) => $user->where('name', 'like', "%{$reporterName}%"));
            $query->orderBy(
                User::select('name')
                    ->whereColumn('users.id', 'reports.user_id')
                    ->limit(1),
                'asc'
            );
        } elseif ($filterBy === 'date') {
            $query->whereDate('reports.created_at', '>=', $filters['start_date'])
                ->whereDate('reports.created_at', '<=', $filters['end_date'])
                ->orderByDesc('reports.created_at');
        } elseif ($filterBy === 'specific_date') {
            $query->whereDate('reports.created_at', $filters['specific_date'])
                ->orderByDesc('reports.created_at');
        } elseif ($filterBy === 'reviewer') {
            $reviewerRole = $filters['reviewer_role'];
            $query->whereHas('reviewer', fn (Builder $reviewer) => $reviewer->where('role', $reviewerRole));
            $query->orderBy(
                User::select('name')
                    ->whereColumn('users.id', 'reports.reviewed_by')
                    ->limit(1),
                'asc'
            );
        } else {
            $query->orderByDesc('reports.created_at');
        }

        return $query->orderByDesc('reports.id');
    }
}
