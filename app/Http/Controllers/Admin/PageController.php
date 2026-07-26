<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('admin.pages.index', [
            'pages' => Page::query()->withCount('sections')->orderBy('title')->get(),
        ]);
    }

    public function edit(Page $page): View
    {
        $page->load('sections');

        return view('admin.pages.edit', [
            'page' => $page,
            'objectives' => $page->section('objectives')?->jsonContent() ?? [],
            'dg' => $page->section('dg_profile')?->jsonContent() ?? [],
            'history' => $page->section('history')?->jsonContent() ?? [],
            'gallery' => $page->section('gallery')?->jsonContent() ?? [],
        ]);
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:320'],
            'mission_title' => ['required', 'string', 'max:255'],
            'mission_content' => ['required', 'string'],
            'vision_title' => ['required', 'string', 'max:255'],
            'vision_content' => ['required', 'string'],
            'objectives_title' => ['required', 'string', 'max:255'],
            'objectives' => ['required', 'array', 'min:1'],
            'objectives.*' => ['required', 'string', 'max:500'],
            'dg_name' => ['required', 'string', 'max:255'],
            'dg_title' => ['required', 'string', 'max:255'],
            'dg_bio' => ['required', 'string'],
            'dg_image' => ['nullable', 'url', 'max:2048'],
            'history' => ['required', 'array', 'min:1'],
            'history.*.year' => ['required', 'string', 'max:20'],
            'history.*.event' => ['required', 'string', 'max:1000'],
            'gallery' => ['nullable', 'array'],
            'gallery.*.src' => ['required', 'url', 'max:2048'],
            'gallery.*.caption' => ['required', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($page, $validated): void {
            $page->update([
                'title' => $validated['title'],
                'meta_description' => $validated['meta_description'],
            ]);

            $sections = [
                'mission' => [$validated['mission_title'], $validated['mission_content']],
                'vision' => [$validated['vision_title'], $validated['vision_content']],
                'objectives' => [$validated['objectives_title'], json_encode(array_values($validated['objectives']))],
                'dg_profile' => ['Director General', json_encode([
                    'name' => $validated['dg_name'],
                    'title' => $validated['dg_title'],
                    'bio' => $validated['dg_bio'],
                    'image' => $validated['dg_image'] ?? null,
                ])],
                'history' => ['Our History', json_encode(array_values($validated['history']))],
                'gallery' => ['Gallery', json_encode(array_values($validated['gallery'] ?? []))],
            ];

            foreach ($sections as $index => $section) {
                $page->sections()->updateOrCreate(
                    ['key' => $index],
                    ['title' => $section[0], 'content' => $section[1], 'sort_order' => array_search($index, array_keys($sections), true) + 1],
                );
            }
        });

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page content updated successfully.');
    }
}
