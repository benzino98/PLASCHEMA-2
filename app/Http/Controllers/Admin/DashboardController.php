<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Download;
use App\Models\Faq;
use App\Models\HealthcareProvider;
use App\Models\HealthPlan;
use App\Models\NewsArticle;
use App\Models\SiteSetting;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $recentNews = NewsArticle::query()
            ->latest('created_at')
            ->take(5)
            ->get(['id', 'title', 'created_at', 'is_published']);

        $recentMessages = ContactMessage::query()
            ->latest('created_at')
            ->take(5)
            ->get(['id', 'name', 'subject', 'created_at']);

        $recentProviders = HealthcareProvider::query()
            ->latest('created_at')
            ->take(5)
            ->get(['id', 'name', 'lga', 'created_at']);

        // Get enrollment chart data from site settings
        $enrollmentChart = SiteSetting::get('home', 'enrollment_chart', [
            'labels' => ['2021', '2022', '2023', '2024', '2025', '2026'],
            'series' => [45000, 82000, 145000, 230000, 380000, 520000],
        ]);

        return view('admin.dashboard', [
            'stats' => [
                'providers' => HealthcareProvider::count(),
                'accreditedProviders' => HealthcareProvider::where('accreditation_status', 'accredited')->count(),
                'news' => NewsArticle::count(),
                'publishedNews' => NewsArticle::where('is_published', true)->count(),
                'faqs' => Faq::count(),
                'messages' => ContactMessage::count(),
                'unreadMessages' => ContactMessage::whereNull('read_at')->count(),
                'downloads' => Download::count(),
                'healthPlans' => HealthPlan::count(),
            ],
            'recentNews' => $recentNews,
            'recentMessages' => $recentMessages,
            'recentProviders' => $recentProviders,
            'enrollmentChart' => $enrollmentChart,
        ]);
    }
}
