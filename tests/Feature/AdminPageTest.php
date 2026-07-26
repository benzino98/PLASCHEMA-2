<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_guest_cannot_access_page_management(): void
    {
        $this->get(route('admin.pages.index'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_page_editor(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $page = Page::where('slug', 'about')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.pages.edit', $page))
            ->assertOk()
            ->assertSee('History timeline');
    }

    public function test_admin_can_update_about_page_sections(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $page = Page::where('slug', 'about')->firstOrFail();

        $this->actingAs($admin)
            ->put(route('admin.pages.update', $page), [
                'title' => 'About PLASCHEMA Updated',
                'meta_description' => 'Updated page description.',
                'mission_title' => 'Mission',
                'mission_content' => 'Updated mission content.',
                'vision_title' => 'Vision',
                'vision_content' => 'Updated vision content.',
                'objectives_title' => 'Objectives',
                'objectives' => ['First objective', 'Second objective'],
                'dg_name' => 'Dr Example Person',
                'dg_title' => 'Director General',
                'dg_bio' => 'Updated leadership biography.',
                'history' => [['year' => '2026', 'event' => 'CMS launched']],
                'gallery' => [['src' => 'https://example.com/photo.jpg', 'caption' => 'Launch event']],
            ])
            ->assertRedirect(route('admin.pages.index'));

        $page->refresh()->load('sections');

        $this->assertSame('About PLASCHEMA Updated', $page->title);
        $this->assertSame(['First objective', 'Second objective'], $page->section('objectives')->jsonContent());
        $this->assertSame('Dr Example Person', $page->section('dg_profile')->jsonContent()['name']);
        $this->assertSame('2026', $page->section('history')->jsonContent()[0]['year']);
        $this->assertSame('Launch event', $page->section('gallery')->jsonContent()[0]['caption']);
    }
}
