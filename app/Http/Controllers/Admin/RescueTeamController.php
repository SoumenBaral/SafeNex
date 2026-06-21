<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\RescueTeam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RescueTeamController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Teams', [
            'teams' => RescueTeam::with('district:id,name', 'members')
                ->withCount('members')
                ->latest()
                ->paginate(20),
            'districts' => District::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'leader_name' => 'required|string|max:255',
            'leader_phone' => 'nullable|string|max:20',
            'leader_email' => 'nullable|email|max:255',
            'district_id' => 'nullable|exists:districts,id',
            'members' => 'nullable|array',
            'members.*.name' => 'required|string|max:255',
            'members.*.email' => 'required|email|max:255',
            'members.*.phone' => 'nullable|string|max:20',
            'members.*.role_in_team' => 'nullable|string|max:100',
        ]);

        $team = RescueTeam::create(collect($validated)->except('members')->all());

        if (!empty($validated['members'])) {
            $team->members()->createMany($validated['members']);
        }

        return back()->with('success', 'Rescue team created.');
    }

    public function update(Request $request, RescueTeam $team): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'leader_name' => 'required|string|max:255',
            'leader_phone' => 'nullable|string|max:20',
            'leader_email' => 'nullable|email|max:255',
            'district_id' => 'nullable|exists:districts,id',
            'status' => 'required|in:available,busy,offline',
        ]);

        $team->update($validated);

        return back()->with('success', 'Team updated.');
    }

    public function destroy(RescueTeam $team): RedirectResponse
    {
        $team->delete();

        return back()->with('success', 'Team deleted.');
    }
}
