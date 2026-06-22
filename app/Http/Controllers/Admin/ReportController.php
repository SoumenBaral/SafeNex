<?php

namespace App\Http\Controllers\Admin;

use App\Events\ReportVerified;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ReportController as UserReportController;
use App\Models\Report;
use App\Notifications\ReportApproved;
use App\Notifications\ReportRejected;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->input('status', 'pending');

        $reports = Report::with('user:id,name,email', 'category:id,name,slug,color', 'district:id,name', 'upazila:id,name')
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Reports', [
            'reports' => $reports,
            'currentStatus' => $status,
            'pendingCount' => Report::where('status', 'pending')->count(),
        ]);
    }

    public function show(Report $report): Response
    {
        $report->load('user:id,name,email,phone', 'category', 'district', 'upazila', 'media', 'verifiedByUser:id,name');

        return Inertia::render('Admin/ReportShow', [
            'report' => $report,
        ]);
    }

    public function verify(Request $request, Report $report): RedirectResponse
    {
        $report->update([
            'status' => 'verified',
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);

        // Broadcast to live map
        $report->load('category:id,name,color', 'district:id,name', 'upazila:id,name');
        event(new ReportVerified($report));

        // Notify the reporter their report was approved
        $report->user->notify(new ReportApproved($report));

        // Notify all other users about the new verified incident
        UserReportController::notifyAllUsers($report);

        return back()->with('success', 'Report verified and now visible publicly.');
    }

    public function reject(Request $request, Report $report): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $report->update([
            'status' => 'rejected',
            'rejection_reason' => $request->input('rejection_reason'),
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);

        // Notify the reporter
        $report->user->notify(new ReportRejected($report));

        return back()->with('success', 'Report rejected.');
    }
}
