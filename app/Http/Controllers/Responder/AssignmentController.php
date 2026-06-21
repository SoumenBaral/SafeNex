<?php

namespace App\Http\Controllers\Responder;

use App\Http\Controllers\Controller;
use App\Models\TeamAssignment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class AssignmentController extends Controller
{
    public function index(Request $request): Response
    {
        // Find teams where the responder's email matches a team member
        $assignments = TeamAssignment::with([
                'report:id,title,category_id,district_id,upazila_id,latitude,longitude,severity',
                'report.category:id,name,color',
                'report.district:id,name',
                'report.upazila:id,name',
                'team:id,name',
                'assignedBy:id,name',
            ])
            ->whereHas('team.members', fn ($q) => $q->where('email', $request->user()->email))
            ->latest()
            ->paginate(20);

        return Inertia::render('Responder/Dashboard', [
            'assignments' => $assignments,
        ]);
    }

    public function updateStatus(Request $request, TeamAssignment $assignment): RedirectResponse
    {
        // Verify the responder belongs to this team
        $isMember = $assignment->team->members()->where('email', $request->user()->email)->exists();
        if (!$isMember) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', Rule::in(['en_route', 'on_site', 'completed'])],
        ]);

        $assignment->update(['status' => $request->input('status')]);

        // If completed, mark team as available again
        if ($request->input('status') === 'completed') {
            $assignment->team->update(['status' => 'available']);
        }

        return back()->with('success', 'Assignment status updated.');
    }
}
