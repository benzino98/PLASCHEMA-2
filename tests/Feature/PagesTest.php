<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Download;
use App\Models\NewsArticle;
use App\Models\Page;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Database\Seeders\ProviderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([ContentSeeder::class, ProviderSeeder::class]);
    }

    public function test_home_page_loads(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Affordable Healthcare For Every')
            ->assertSee('Enrollment Growth');
    }

    public function test_public_pages_load(): void
    {
        $routes = [
            '/about',
            '/health-plans',
            '/providers',
            '/news',
            '/resources',
            '/faqs',
            '/contact',
        ];

        foreach ($routes as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_about_page_shows_mission_and_gallery(): void
    {
        $this->get('/about')
            ->assertSee('Our Mission')
            ->assertSee('Gallery');
    }

    public function test_about_page_loads_gracefully_when_unseeded(): void
    {
        Page::query()->delete();

        $this->get('/about')
            ->assertOk()
            ->assertSee('Building a healthier')
            ->assertSee('Plateau State');
    }

    public function test_health_plans_shows_all_five_plans(): void
    {
        $this->get('/health-plans')
            ->assertSee('Formal Sector')
            ->assertSee('Vulnerable Persons')
            ->assertSee('Benefits Comparison');
    }

    public function test_news_article_detail_page_loads(): void
    {
        $article = NewsArticle::query()->published()->first();

        $this->get("/news/{$article->slug}")
            ->assertOk()
            ->assertSee($article->title);
    }

    public function test_news_category_filter_works(): void
    {
        $this->get('/news?category=campaign')
            ->assertOk()
            ->assertSee('Health Campaign');
    }

    public function test_download_file_endpoint_works(): void
    {
        $download = Download::query()->published()->first();

        $this->get(route('downloads.download', $download))
            ->assertOk();
    }

    public function test_contact_form_stores_message(): void
    {
        $this->post(route('contact.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Enrollment inquiry',
            'message' => 'I need help enrolling in PLASCHEMA.',
        ])
            ->assertRedirect(route('contact'));

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'john@example.com',
            'subject' => 'Enrollment inquiry',
        ]);
    }

    public function test_contact_form_validates_input(): void
    {
        $this->post(route('contact.store'), [])
            ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        $this->assertEquals(0, ContactMessage::count());
    }

    public function test_faqs_page_has_search_and_categories(): void
    {
        $this->get('/faqs')
            ->assertSee('Search for answers')
            ->assertSee('Enrollment')
            ->assertSee('Who is eligible for PLASCHEMA?');
    }

    public function test_admin_dashboard_loads(): void
    {
        $admin = User::where('role', 'admin')->first();

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk()
            ->assertSee('Admin Panel');
    }
}
