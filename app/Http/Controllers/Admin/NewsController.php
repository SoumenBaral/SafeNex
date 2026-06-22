<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\District;
use App\Models\NewsArticle;
use App\Models\Report;
use App\Models\User;
use App\Notifications\NewNewsPublished;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $articles = NewsArticle::with('author:id,name', 'category:id,name', 'district:id,name')
            ->when($request->input('status'), fn ($q, $v) => $q->where('status', $v))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/News', [
            'articles' => $articles,
            'currentStatus' => $request->input('status', 'all'),
        ]);
    }

    public function create(Request $request): Response
    {
        $reportData = null;
        if ($request->has('from_report')) {
            $report = Report::with('category', 'district', 'media')->find($request->input('from_report'));
            if ($report) {
                $reportData = [
                    'report_id' => $report->id,
                    'title' => $report->title,
                    'excerpt' => Str::limit($report->description, 200),
                    'body' => $report->description,
                    'category_id' => $report->category_id,
                    'district_id' => $report->district_id,
                    'cover_image' => $report->media->where('type', 'image')->first()?->path,
                ];
            }
        }

        return Inertia::render('Admin/NewsCreate', [
            'categories' => Category::select('id', 'name')->orderBy('name')->get(),
            'districts' => District::select('id', 'name')->orderBy('name')->get(),
            'reportData' => $reportData,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'district_id' => 'nullable|exists:districts,id',
            'report_id' => 'nullable|exists:reports,id',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $slug = Str::slug($validated['title']);
        $slug = NewsArticle::where('slug', $slug)->exists()
            ? $slug . '-' . Str::random(5)
            : $slug;

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('news/covers', 'public');
        } elseif ($request->input('existing_cover')) {
            $coverPath = $request->input('existing_cover');
        }

        $article = NewsArticle::create([
            'author_id' => $request->user()->id,
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
            'category_id' => $validated['category_id'] ?: null,
            'district_id' => $validated['district_id'] ?: null,
            'report_id' => $validated['report_id'] ?: null,
            'cover_image' => $coverPath,
            'status' => $validated['status'],
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        // Notify all users when news is published
        if ($article->status === 'published') {
            $article->load('district');
            User::where('status', 'active')
                ->where('id', '!=', $request->user()->id)
                ->each(fn (User $u) => $u->notify(new NewNewsPublished($article)));
        }

        return redirect()->route('admin.news.index')->with('success', 'Article created.');
    }

    public function edit(NewsArticle $article): Response
    {
        return Inertia::render('Admin/NewsEdit', [
            'article' => $article,
            'categories' => Category::select('id', 'name')->orderBy('name')->get(),
            'districts' => District::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, NewsArticle $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'district_id' => 'nullable|exists:districts,id',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('news/covers', 'public');
        } else {
            unset($validated['cover_image']);
        }

        $wasPublished = $article->status === 'published';

        if ($validated['status'] === 'published' && !$article->published_at) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        // Notify users when a draft is published for the first time
        if (!$wasPublished && $article->status === 'published') {
            $article->load('district');
            User::where('status', 'active')
                ->where('id', '!=', $request->user()->id)
                ->each(fn (User $u) => $u->notify(new NewNewsPublished($article)));
        }

        return redirect()->route('admin.news.index')->with('success', 'Article updated.');
    }

    public function destroy(NewsArticle $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.news.index')->with('success', 'Article deleted.');
    }
}
