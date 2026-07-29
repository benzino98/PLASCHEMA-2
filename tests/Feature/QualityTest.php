<?php

namespace Tests\Feature;

use App\Models\HealthcareProvider;
use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QualityTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_contains_static_and_dynamic_entries(): void
    {
        HealthcareProvider::create([
            'name' => 'Sitemap Hospital',
            'slug' => 'sitemap-hospital',
            'lga' => 'Jos North',
            'ownership' => 'public',
            'address' => 'Sitemap Street',
            'accreditation_status' => 'accredited',
            'is_published' => true,
        ]);
        NewsArticle::create([
            'title' => 'Sitemap News',
            'slug' => 'sitemap-news',
            'excerpt' => 'test',
            'body' => 'test body',
            'category' => 'press',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->get('/sitemap.xml');
        $response->assertOk()->assertHeader('Content-Type', 'application/xml');

        $body = $response->getContent();
        $this->assertStringContainsString('<loc>', $body);
        $this->assertStringContainsString('/providers/sitemap-hospital', $body);
        $this->assertStringContainsString('/news/sitemap-news', $body);
    }

    public function test_security_headers_are_present(): void
    {
        $response = $this->get('/');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Permissions-Policy');
        $response->assertHeader('Content-Security-Policy-Report-Only');
    }

    public function test_social_meta_tags_exist(): void
    {
        $response = $this->get('/');
        $response->assertSee('<meta property="og:site_name"', false);
        $response->assertSee('<meta property="og:type"', false);
        $response->assertSee('<meta property="og:title"', false);
        $response->assertSee('<meta property="og:description"', false);
        $response->assertSee('<meta name="twitter:card"', false);
        $response->assertSee('<link rel="canonical"', false);
    }

    public function test_robots_txt_disallows_admin_and_api(): void
    {
        $robots = file_get_contents(public_path('robots.txt'));
        $this->assertStringContainsString('Disallow: /admin', $robots);
        $this->assertStringContainsString('Disallow: /api', $robots);
        $this->assertStringContainsString('Sitemap:', $robots);
    }

    public function test_analytics_absent_by_default(): void
    {
        $response = $this->get('/');
        $response->assertDontSee('plausible.io', false);
        $response->assertDontSee('googletagmanager.com', false);
        $response->assertDontSee('umami.is', false);
    }

    public function test_canonical_link_matches_current_url(): void
    {
        $response = $this->get('/');
        $response->assertSee('<link rel="canonical"', false);
    }
}
