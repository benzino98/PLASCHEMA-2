<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DownloadController extends Controller
{
    public function index(Request $request): View
    {
        $downloads = Download::query()
            ->when($request->filled('search'), fn ($q) => $q->where('title', 'like', '%'.$request->search.'%'))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->latest('created_at')->paginate(20);

        return view('admin.downloads.index', [
            'downloads' => $downloads,
            'categories' => $this->categories(),
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function create(): View
    {
        return view('admin.downloads.create', ['download' => new Download, 'categories' => $this->categories()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);
        $file = $request->file('file');
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['file_path'] = $file->store('downloads', 'public');
        $data['file_size'] = $file->getSize();
        $data['mime_type'] = $file->getMimeType();
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? now()) : null;
        unset($data['file']);

        Download::create($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Download created successfully.');
    }

    public function edit(Download $download): View
    {
        return view('admin.downloads.edit', compact('download') + ['categories' => $this->categories()]);
    }

    public function update(Request $request, Download $download): RedirectResponse
    {
        $data = $this->validated($request, false);
        $data['slug'] = $this->uniqueSlug($data['title'], $download->id);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? ($data['published_at'] ?? $download->published_at ?? now()) : null;
        unset($data['file']);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $newPath = $file->store('downloads', 'public');
            Storage::disk('public')->delete($download->file_path);
            $data['file_path'] = $newPath;
            $data['file_size'] = $file->getSize();
            $data['mime_type'] = $file->getMimeType();
        }

        $download->update($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Download updated successfully.');
    }

    public function destroy(Download $download): RedirectResponse
    {
        Storage::disk('public')->delete($download->file_path);
        $download->delete();

        return redirect()->route('admin.downloads.index')->with('success', 'Download deleted successfully.');
    }

    private function validated(Request $request, bool $required): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:form,policy,guideline,report,circular'],
            'description' => ['nullable', 'string', 'max:2000'],
            'file' => [$required ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,csv', 'max:20480'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'download';
        $slug = $base;
        $suffix = 2;
        while (Download::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function categories(): array
    {
        return ['form' => 'Form', 'policy' => 'Policy', 'guideline' => 'Guideline', 'report' => 'Report', 'circular' => 'Circular'];
    }
}
