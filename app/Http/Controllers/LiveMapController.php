<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LiveMapController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Public/Map', [
            'incidents' => $this->getIncidents(),
        ]);
    }

    public function incidents(Request $request): JsonResponse
    {
        return response()->json($this->getIncidents($request));
    }

    private function getIncidents(?Request $request = null): array
    {
        return Report::where('status', 'verified')
            ->with('category:id,name,color', 'district:id,name', 'upazila:id,name')
            ->select('id', 'title', 'category_id', 'district_id', 'upazila_id', 'latitude', 'longitude', 'severity', 'created_at')
            ->when($request?->district_id, fn ($q, $v) => $q->where('district_id', $v))
            ->when($request?->category_id, fn ($q, $v) => $q->where('category_id', $v))
            ->latest()
            ->limit(500)
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'title' => $r->title,
                'latitude' => $r->latitude,
                'longitude' => $r->longitude,
                'severity' => $r->severity,
                'category_name' => $r->category?->name,
                'category_color' => $r->category?->color,
                'district_name' => $r->district?->name,
                'upazila_name' => $r->upazila?->name,
                'created_at' => $r->created_at,
            ])
            ->all();
    }
}
