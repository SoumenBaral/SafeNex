<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        $shared = [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'roles' => $user?->getRoleNames() ?? [],
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
        ];

        // Share admin-specific props for the AdminLayout situation bar
        if ($user?->hasRole('admin')) {
            $shared['pendingReportsCount'] = fn () => \App\Models\Report::where('status', 'pending')->count();
            $shared['situationCritical'] = fn () => \App\Models\Report::where('status', 'verified')->where('severity', 'critical')->count();
            $shared['situationHigh'] = fn () => \App\Models\Report::where('status', 'verified')->where('severity', 'high')->count();
        }

        return $shared;
    }
}
