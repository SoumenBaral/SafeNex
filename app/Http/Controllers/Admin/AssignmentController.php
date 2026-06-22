<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\NotifyRescueTeam;
use App\Models\Report;
use App\Models\RescueTeam;
use App\Models\TeamAssignment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AssignmentController extends Controller
{
    public function create(Report $report): Response
    {
        $report->load('category', 'district', 'upazila');

        return Inertia::render('Admin/AssignTeam', [
            'report' => $report,
            'teams' => RescueTeam::where('status', 'available')
                ->with('members')
                ->withCount('members')
                ->get(),
            'existingAssignments' => $report->assignments()
                ->with('team:id,name', 'assignedByUser:id,name')
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'rescue_team_id' => 'required|exists:rescue_teams,id',
            'reason' => 'required|string|max:2000',
        ]);

        $assignment = TeamAssignment::create([
            'report_id' => $report->id,
            'rescue_team_id' => $validated['rescue_team_id'],
            'assigned_by' => $request->user()->id,
            'reason' => $validated['reason'],
            'status' => 'assigned',
        ]);

        // Mark team as busy
        RescueTeam::where('id', $validated['rescue_team_id'])->update(['status' => 'busy']);

        // Dispatch job to email all team members
        NotifyRescueTeam::dispatch($assignment);

        return back()->with('success', 'Team assigned and email notifications queued.');
    }
}
