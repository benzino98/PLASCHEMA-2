<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.home', [
            'hero' => SiteSetting::get('home', 'hero', $this->defaultHero()),
            'stats' => SiteSetting::get('home', 'stats', []),
            'chart' => SiteSetting::get('home', 'enrollment_chart', ['labels' => [], 'series' => []]),
            'features' => SiteSetting::get('home', 'why_plaschema', []),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero.eyebrow' => ['required', 'string', 'max:120'],
            'hero.title' => ['required', 'string', 'max:255'],
            'hero.description' => ['required', 'string', 'max:1000'],
            'hero.background_image' => ['nullable', 'url', 'max:2048'],
            'stats' => ['required', 'array', 'min:1', 'max:8'],
            'stats.*.label' => ['required', 'string', 'max:120'],
            'stats.*.value' => ['required', 'string', 'max:60'],
            'stats.*.icon' => ['required', 'string', 'max:60'],
            'chart.labels' => ['required', 'array', 'min:2'],
            'chart.labels.*' => ['required', 'string', 'max:40'],
            'chart.series' => ['required', 'array', 'min:2'],
            'chart.series.*' => ['required', 'numeric', 'min:0'],
            'features' => ['required', 'array', 'min:1', 'max:8'],
            'features.*.title' => ['required', 'string', 'max:120'],
            'features.*.description' => ['required', 'string', 'max:500'],
            'features.*.icon' => ['required', 'string', 'max:60'],
        ]);

        if (count($validated['chart']['labels']) !== count($validated['chart']['series'])) {
            return back()->withInput()->withErrors(['chart' => 'Chart labels and values must contain the same number of entries.']);
        }

        SiteSetting::set('home', 'hero', $validated['hero']);
        SiteSetting::set('home', 'stats', array_values($validated['stats']));
        SiteSetting::set('home', 'enrollment_chart', [
            'labels' => array_values($validated['chart']['labels']),
            'series' => array_map('floatval', array_values($validated['chart']['series'])),
        ]);
        SiteSetting::set('home', 'why_plaschema', array_values($validated['features']));

        return redirect()->route('admin.settings.home')->with('success', 'Home page settings updated successfully.');
    }

    public static function defaultHero(): array
    {
        return [
            'eyebrow' => 'Plateau State Healthcare',
            'title' => 'Affordable Healthcare For Every Plateau Citizen',
            'description' => 'Enroll in PLASCHEMA, verify your membership, find accredited providers, and access quality healthcare across Plateau State.',
            'background_image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=1600&q=80',
        ];
    }
}
