<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\District;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(Request $request): Response
    {
        $articles = NewsArticle::where('status', 'published')
            ->with('author:id,name', 'category:id,name,color', 'district:id,name')
            ->when($request->input('district_id'), fn ($q, $v) => $q->where('district_id', $v))
            ->when($request->input('category_id'), fn ($q, $v) => $q->where('category_id', $v))
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Public/NewsIndex', [
            'articles' => $articles,
            'districts' => District::select('id', 'name')->orderBy('name')->get(),
            'categories' => Category::select('id', 'name')->orderBy('name')->get(),
            'filters' => $request->only('district_id', 'category_id'),
        ]);
    }

    public function show(string $slug): Response
    {
        $article = NewsArticle::where('slug', $slug)
            ->where('status', 'published')
            ->with('author:id,name', 'category:id,name', 'district:id,name', 'report')
            ->firstOrFail();

        $article->increment('views');

        return Inertia::render('Public/NewsShow', [
            'article' => $article,
        ]);
    }
}
