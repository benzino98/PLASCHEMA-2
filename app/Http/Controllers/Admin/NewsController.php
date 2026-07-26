<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Support\SanitizesArticleHtml;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $articles = NewsArticle::query()
            ->when($request->filled('search'), fn ($q) => $q->where('title', 'like', '%'.$request->search.'%'))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->when($request->status === 'published', fn ($q) => $q->where('is_published', true))
            ->when($request->status === 'draft', fn ($q) => $q->where('is_published', false))
            ->latest('created_at')
            ->paginate(20);

        return view('admin.news.index', [
            'articles' => $articles,
            'filters' => $request->only(['search', 'category', 'status']),
            'categories' => $this->categories(),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create', ['article' => new NewsArticle, 'categories' => $this->categories()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['body'] = SanitizesArticleHtml::clean($data['body']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? now()) : null;

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('news', 'public');
        }

        NewsArticle::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News article created successfully.');
    }

    public function edit(NewsArticle $news): View
    {
        return view('admin.news.edit', ['article' => $news, 'categories' => $this->categories()]);
    }

    public function update(Request $request, NewsArticle $news): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title'], $news->id);
        $data['body'] = SanitizesArticleHtml::clean($data['body']);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? $news->published_at ?? now()) : null;

        if ($request->hasFile('featured_image')) {
            $newPath = $request->file('featured_image')->store('news', 'public');
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $data['featured_image'] = $newPath;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News article updated successfully.');
    }

    public function destroy(NewsArticle $news): RedirectResponse
    {
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News article deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'body' => ['required', 'string'],
            'category' => ['required', 'in:campaign,activity,press'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'article';
        $slug = $base;
        $suffix = 2;
        while (NewsArticle::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function categories(): array
    {
        return ['campaign' => 'Health Campaign', 'activity' => 'PLASCHEMA Activity', 'press' => 'Press Release'];
    }
}
