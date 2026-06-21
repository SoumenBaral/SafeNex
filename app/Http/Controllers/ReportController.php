<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Category;
use App\Models\District;
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
            'districts' => District::select('id', 'name', 'name_bn')
                ->with('upazilas:id,district_id,name,name_bn')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(StoreReportRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $mediaFiles = $validated['media'] ?? [];
        unset($validated['media']);

        $report = $request->user()->reports()->create([
            ...$validated,
            'status' => 'pending',
        ]);

        if ($mediaFiles) {
            $this->mediaService->attach($report, $mediaFiles);
        }

        return redirect()->route('my-reports')->with('success', 'Report submitted. Awaiting admin verification.');
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
}
