<?php

namespace Tests\Feature;

use App\Models\NewsArticle;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminNewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_admin_can_create_sanitized_article_with_image(): void
    {
        Storage::fake('public');
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => 'Safe Health Update',
            'excerpt' => 'A concise summary.',
            'body' => '<h2 onclick="bad()">Headline</h2><script>alert(1)</script><p>Useful <strong>content</strong>.</p>',
            'category' => 'campaign',
            'featured_image' => UploadedFile::fake()->image('campaign.jpg'),
            'is_published' => 1,
        ])->assertRedirect(route('admin.news.index'));

        $article = NewsArticle::where('slug', 'safe-health-update')->firstOrFail();
        $this->assertStringNotContainsString('<script', $article->body);
        $this->assertStringNotContainsString('onclick', $article->body);
        $this->assertStringContainsString('<strong>content</strong>', $article->body);
        Storage::disk('public')->assertExists($article->featured_image);
    }

    public function test_duplicate_titles_receive_unique_slugs(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $payload = ['title' => 'Repeated Update', 'body' => '<p>Body</p>', 'category' => 'press', 'is_published' => 1];

        $this->actingAs($admin)->post(route('admin.news.store'), $payload);
        $this->actingAs($admin)->post(route('admin.news.store'), $payload);

        $this->assertDatabaseHas('news_articles', ['slug' => 'repeated-update']);
        $this->assertDatabaseHas('news_articles', ['slug' => 'repeated-update-2']);
    }

    public function test_admin_can_delete_article_and_image(): void
    {
        Storage::fake('public');
        $admin = User::where('role', 'admin')->firstOrFail();
        $path = UploadedFile::fake()->image('old.jpg')->store('news', 'public');
        $article = NewsArticle::create([
            'title' => 'Delete Me', 'slug' => 'delete-me', 'body' => '<p>Body</p>',
            'category' => 'activity', 'featured_image' => $path, 'is_published' => false,
        ]);

        $this->actingAs($admin)->delete(route('admin.news.destroy', $article))
            ->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseMissing('news_articles', ['id' => $article->id]);
        Storage::disk('public')->assertMissing($path);
    }
}
