<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHomeSettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_admin_can_update_home_settings_and_public_hero(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $payload = [
            'hero' => ['eyebrow' => 'Healthy Plateau', 'title' => 'Healthcare For Everyone', 'description' => 'A new public message.', 'background_image' => 'https://example.com/hero.jpg'],
            'stats' => [['label' => 'Members', 'value' => '700K+', 'icon' => 'users']],
            'chart' => ['labels' => ['2025', '2026'], 'series' => [500000, 700000]],
            'features' => [['title' => 'Accessible', 'description' => 'Care across the state.', 'icon' => 'map-pin']],
        ];

        $this->actingAs($admin)->put(route('admin.settings.home.update'), $payload)
            ->assertRedirect(route('admin.settings.home'));

        $this->assertSame('Healthcare For Everyone', SiteSetting::get('home', 'hero')['title']);
        $this->assertSame([500000, 700000], SiteSetting::get('home', 'enrollment_chart')['series']);
        $this->get(route('home'))->assertOk()->assertSee('Healthcare For Everyone');
    }

    public function test_chart_labels_and_values_must_align(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $payload = [
            'hero' => ['eyebrow' => 'Eyebrow', 'title' => 'Title', 'description' => 'Description', 'background_image' => ''],
            'stats' => [['label' => 'Members', 'value' => '1', 'icon' => 'users']],
            'chart' => ['labels' => ['2025', '2026'], 'series' => [100]],
            'features' => [['title' => 'Feature', 'description' => 'Description', 'icon' => 'heart']],
        ];

        $this->actingAs($admin)->from(route('admin.settings.home'))
            ->put(route('admin.settings.home.update'), $payload)
            ->assertRedirect(route('admin.settings.home'))
            ->assertSessionHasErrors('chart.series');
    }
}
