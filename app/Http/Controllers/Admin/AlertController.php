<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\District;
use App\Models\User;
use App\Notifications\EmergencyAlert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Inertia\Response;

class AlertController extends Controller
{
    public function index(): Response
    {
        $alerts = Alert::with('district:id,name', 'sentBy:id,name')
            ->latest()
            ->paginate(20);

        return Inertia::render('Admin/Alerts', [
            'alerts' => $alerts,
            'districts' => District::select('id', 'name')
                ->with('upazilas:id,district_id,name')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'district_id' => 'nullable|exists:districts,id',
            'upazila_id' => 'nullable|exists:upazilas,id',
            'report_id' => 'nullable|exists:reports,id',
        ]);

        $alert = Alert::create([
            ...$validated,
            'sent_by' => $request->user()->id,
            'sent_at' => now(),
        ]);

        // Notify users in the targeted area
        $users = User::query()
            ->when($validated['district_id'] ?? null, fn ($q, $v) => $q->where('district_id', $v))
            ->when($validated['upazila_id'] ?? null, fn ($q, $v) => $q->where('upazila_id', $v))
            ->where('status', 'active')
            ->get();

        if ($users->isNotEmpty()) {
            Notification::send($users, new EmergencyAlert($alert));
        }

        return back()->with('success', "Emergency alert sent to {$users->count()} user(s).");
    }
}
