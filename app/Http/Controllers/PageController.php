<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\HomeSettingController;
use App\Models\Faq;
use App\Models\HealthPlan;
use App\Models\NewsArticle;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\SuccessStory;
use App\Support\DigitalServices;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'hero' => SiteSetting::get('home', 'hero', HomeSettingController::defaultHero()),
            'stats' => SiteSetting::get('home', 'stats', []),
            'chartData' => SiteSetting::get('home', 'enrollment_chart', []),
            'whyPlaschema' => SiteSetting::get('home', 'why_plaschema', []),
            'services' => DigitalServices::all(),
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

    public function services(): View
    {
        return view('pages.services', ['services' => DigitalServices::all()]);
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
}
