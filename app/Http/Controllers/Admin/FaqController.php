<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $faqs = Faq::query()
            ->with('category')
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('faq_category_id', $request->category);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%'.$request->search.'%';
                $query->where(function ($q) use ($search) {
                    $q->where('question', 'like', $search)
                        ->orWhere('answer', 'like', $search);
                });
            })
            ->orderBy('faq_category_id')
            ->orderBy('sort_order')
            ->paginate(20);

        $categories = FaqCategory::orderBy('sort_order')->get();

        return view('admin.faqs.index', [
            'faqs' => $faqs,
            'categories' => $categories,
            'filters' => $request->only(['category', 'search']),
        ]);
    }

    public function create(): View
    {
        $categories = FaqCategory::orderBy('sort_order')->get();

        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['boolean'],
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 999;

        Faq::create($validated);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq): View
    {
        $categories = FaqCategory::orderBy('sort_order')->get();

        return view('admin.faqs.edit', compact('faq', 'categories'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:500'],
            'answer' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['boolean'],
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? $faq->sort_order;

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }
}
