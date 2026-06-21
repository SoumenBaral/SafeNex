<?php

use App\Http\Controllers\Admin\AlertController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\RescueTeamController;
use App\Http\Controllers\LiveMapController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Responder\AssignmentController as ResponderAssignmentController;
use App\Models\District;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', fn () => Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
]))->name('home');

Route::get('/map', [LiveMapController::class, 'index'])->name('map');
Route::get('/map/incidents.json', [LiveMapController::class, 'incidents'])->name('map.incidents');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// API: cascading upazilas
Route::get('/api/districts/{district}/upazilas', fn (District $district) => $district->upazilas()->select('id', 'district_id', 'name', 'name_bn')->get())->name('api.upazilas');

// User routes (auth)
Route::get('/dashboard', function () {
    $user = auth()->user();
    return Inertia::render('Dashboard', [
        'stats' => [
            'total_reports' => $user->reports()->count(),
            'pending' => $user->reports()->where('status', 'pending')->count(),
            'verified' => $user->reports()->where('status', 'verified')->count(),
            'rejected' => $user->reports()->where('status', 'rejected')->count(),
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/my-reports', [ReportController::class, 'myReports'])->name('my-reports');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'pending_reports' => \App\Models\Report::where('status', 'pending')->count(),
                'verified_reports' => \App\Models\Report::where('status', 'verified')->count(),
                'total_reports' => \App\Models\Report::count(),
                'total_users' => \App\Models\User::count(),
                'total_teams' => \App\Models\RescueTeam::count(),
                'published_news' => \App\Models\NewsArticle::where('status', 'published')->count(),
            ],
        ]);
    })->name('dashboard');

    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/verify', [AdminReportController::class, 'verify'])->name('reports.verify');
    Route::post('/reports/{report}/reject', [AdminReportController::class, 'reject'])->name('reports.reject');

    Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alerts.store');

    Route::get('/teams', [RescueTeamController::class, 'index'])->name('teams.index');
    Route::post('/teams', [RescueTeamController::class, 'store'])->name('teams.store');
    Route::put('/teams/{team}', [RescueTeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}', [RescueTeamController::class, 'destroy'])->name('teams.destroy');

    Route::get('/reports/{report}/assign', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/reports/{report}/assign', [AssignmentController::class, 'store'])->name('assignments.store');

    Route::get('/news', [AdminNewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [AdminNewsController::class, 'create'])->name('news.create');
    Route::post('/news', [AdminNewsController::class, 'store'])->name('news.store');
    Route::get('/news/{article}/edit', [AdminNewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{article}', [AdminNewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{article}', [AdminNewsController::class, 'destroy'])->name('news.destroy');
});

// Responder routes
Route::middleware(['auth', 'verified', 'role:responder'])->prefix('responder')->name('responder.')->group(function () {
    Route::get('/', [ResponderAssignmentController::class, 'index'])->name('dashboard');
    Route::post('/assignments/{assignment}/status', [ResponderAssignmentController::class, 'updateStatus'])->name('assignments.update-status');
});

require __DIR__.'/auth.php';
