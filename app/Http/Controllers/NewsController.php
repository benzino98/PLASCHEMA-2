<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $search = $request->query('q');

        $query = NewsArticle::query()
            ->published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($search, fn ($q) => $q->where(fn($q2) => $q2->where('title', 'like', "%{$search}%")->orWhere('excerpt', 'like', "%{$search}%")));

        // If no filters are applied, the first article becomes the featured article
        $featured = null;
        if (!$category && !$search) {
            $featured = (clone $query)->latest('published_at')->first();
            if ($featured) {
                $query->where('id', '!=', $featured->id);
            }
        }

        $articles = $query->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $categories = [
            '' => 'All',
            'article' => 'Articles',
            'campaign' => 'Health Campaigns',
            'activity' => 'PLASCHEMA Activities',
            'press' => 'Press Releases',
        ];

        return view('pages.news.index', compact('articles', 'categories', 'category', 'search', 'featured'));
    }

    public function show(string $slug): View
    {
        $article = NewsArticle::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = NewsArticle::query()
            ->published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.news.show', compact('article', 'related'));
    }
}
