<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\HealthPlan;
use App\Models\NewsArticle;
use App\Models\SuccessStory;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'stats' => SiteSetting::get('home', 'stats', []),
            'chartData' => SiteSetting::get('home', 'enrollment_chart', []),
            'whyPlaschema' => SiteSetting::get('home', 'why_plaschema', []),
            'plans' => HealthPlan::query()->orderBy('sort_order')->take(3)->get(),
            'stories' => SuccessStory::published()->take(3)->get(),
            'latestNews' => NewsArticle::published()->latest('published_at')->take(3)->get(),
            'faqs' => Faq::query()
                ->where('is_published', true)
                ->with('category')
                ->orderBy('sort_order')
                ->take(4)
                ->get(),
        ]);
    }

    public function about(): View
    {
        $page = Page::query()->where('slug', 'about')->with('sections')->firstOrFail();

        return view('pages.about', compact('page'));
    }

    public function healthPlans(): View
    {
        $plans = HealthPlan::query()->with('benefits')->orderBy('sort_order')->get();
        $benefitRows = $plans->first()?->benefits ?? collect();

        return view('pages.health-plans', compact('plans', 'benefitRows'));
    }

    public function providers(): View
    {
        return view('pages.placeholder', [
            'title' => 'Find Healthcare Provider',
            'description' => 'Search accredited hospitals and clinics across Plateau State.',
            'phase' => 3,
        ]);
    }
}
