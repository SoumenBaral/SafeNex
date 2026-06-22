<?php

namespace App\Http\Controllers;

use App\Events\ReportVerified;
use App\Http\Requests\StoreReportRequest;
use App\Models\Category;
use App\Models\District;
use App\Models\User;
use App\Notifications\NewVerifiedReport;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function __construct(private MediaService $mediaService) {}

    public function create(): Response
    {
        return Inertia::render('User/ReportCreate', [
            'categories' => Category::select('id', 'name', 'slug')->orderBy('name')->get(),
            'districts'  => District::select('id', 'name', 'name_bn')
                ->with('upazilas:id,district_id,name,name_bn,lat,lng')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(StoreReportRequest $request): RedirectResponse
    {
        $validated  = $request->validated();
        $mediaFiles = $validated['media'] ?? [];
        unset($validated['media']);

        // Convert empty strings to null for nullable fields
        foreach (['occurred_at', 'upazila_id', 'address', 'latitude', 'longitude'] as $field) {
            if (isset($validated[$field]) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        $isAdmin = $request->user()->hasRole('admin');

        $report = $request->user()->reports()->create([
            ...$validated,
            'status'      => $isAdmin ? 'verified' : 'pending',
            'verified_by' => $isAdmin ? $request->user()->id : null,
            'verified_at' => $isAdmin ? now() : null,
        ]);

        if ($mediaFiles) {
            $this->mediaService->attach($report, $mediaFiles);
        }

        if ($isAdmin) {
            $report->load('category:id,name,color', 'district:id,name', 'upazila:id,name');
            event(new ReportVerified($report));
            static::notifyAllUsers($report);

            return redirect()->route('my-reports')
                ->with('success', 'Report submitted and published immediately.');
        }

        return redirect()->route('my-reports')
            ->with('success', 'Report submitted. Awaiting admin verification.');
    }

    public function myReports(Request $request): Response
    {
        $reports = $request->user()
            ->reports()
            ->with('category:id,name,slug,color', 'district:id,name')
            ->latest()
            ->paginate(15);

        return Inertia::render('User/MyReports', [
            'reports' => $reports,
        ]);
    }

    public static function notifyAllUsers(object $report): void
    {
        User::role(['user', 'responder'])
            ->where('id', '!=', $report->user_id)
            ->each(fn (User $u) => $u->notify(new NewVerifiedReport($report)));
    }
}
