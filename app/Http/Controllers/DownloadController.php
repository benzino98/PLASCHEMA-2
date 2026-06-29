<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');

        $downloads = Download::query()
            ->published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderByDesc('published_at')
            ->get()
            ->groupBy('category');

        $categories = [
            '' => 'All',
            'form' => 'Forms',
            'policy' => 'Policies',
            'guideline' => 'Guidelines',
            'report' => 'Reports',
            'circular' => 'Circulars',
        ];

        $allDownloads = Download::query()
            ->published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderByDesc('published_at')
            ->get();

        return view('pages.resources.index', compact('allDownloads', 'downloads', 'categories', 'category'));
    }

    public function download(Download $download): StreamedResponse
    {
        abort_unless($download->is_published && $download->fileExists(), 404);

        return Storage::disk('public')->download(
            $download->file_path,
            Str::slug($download->title).'.'.pathinfo($download->file_path, PATHINFO_EXTENSION),
        );
    }
}
