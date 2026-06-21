<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->get('status', 'pending');

        $reports = Report::with('user:id,name,email', 'category:id,name,slug,color', 'district:id,name', 'upazila:id,name')
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Reports', [
            'reports' => $reports,
            'currentStatus' => $status,
        ]);
    }

    public function show(Report $report): Response
    {
        $report->load('user:id,name,email,phone', 'category', 'district', 'upazila', 'media', 'verifiedBy:id,name');

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

        return back()->with('success', 'Report verified and now visible publicly.');
    }

    public function reject(Request $request, Report $report): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $report->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'verified_by' => $request->user()->id,
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Report rejected.');
    }
}
