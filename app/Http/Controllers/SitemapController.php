<?php

namespace App\Http\Controllers;

use App\Models\HealthcareProvider;
use App\Models\NewsArticle;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $static = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('providers'), 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => route('health-plans'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('news'), 'priority' => '0.7', 'changefreq' => 'daily'],
            ['loc' => route('faqs'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['loc' => route('services'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('contact'), 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        $providers = HealthcareProvider::query()->published()->get(['updated_at', 'slug'])->map(fn ($p) => [
            'loc' => route('providers.show', ['provider' => $p->slug]),
            'priority' => '0.6',
            'changefreq' => 'monthly',
            'lastmod' => $p->updated_at,
        ]);

        $news = NewsArticle::query()->published()->latest('published_at')->get(['updated_at', 'slug'])->map(fn ($a) => [
            'loc' => route('news.show', ['slug' => $a->slug]),
            'priority' => '0.6',
            'changefreq' => 'monthly',
            'lastmod' => $a->updated_at,
        ]);

        $entries = collect($static)
            ->merge($providers)
            ->merge($news);

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($entries as $entry) {
            $content .= '<url>';
            $content .= '<loc>'.e($entry['loc']).'</loc>';
            $content .= '<priority>'.$entry['priority'].'</priority>';
            $content .= '<changefreq>'.$entry['changefreq'].'</changefreq>';
            if (isset($entry['lastmod'])) {
                $content .= '<lastmod>'.$entry['lastmod']->toIso8601String().'</lastmod>';
            }
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }
}
