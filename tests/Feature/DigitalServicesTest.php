<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\DigitalServices;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DigitalServicesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_services_page_loads_with_all_cards(): void
    {
        $this->get(route('services'))
            ->assertOk()
            ->assertSee('Online Enrollment')
            ->assertSee('Membership Verification')
            ->assertSee('Premium Payment')
            ->assertSee('PLASCHEMA Support');
    }

    public function test_admin_can_update_service_urls_and_home_hero_footer_reflects_change(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $updated = [
            'enrollment_url' => 'https://custom-enroll.example.com',
            'verification_url' => 'https://custom-verify.example.com',
            'payment_url' => 'https://custom-pay.example.com',
            'support_url' => 'https://custom-help.example.com',
        ];

        $this->actingAs($admin)->put(route('admin.settings.services.update'), $updated)
            ->assertRedirect(route('admin.settings.services'));

        $this->assertSame($updated['enrollment_url'], DigitalServices::url('enrollment'));

        $this->get(route('home'))->assertOk()->assertSee('custom-enroll.example.com', false);
    }

    public function test_invalid_url_is_rejected(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)->from(route('admin.settings.services'))
            ->put(route('admin.settings.services.update'), [
                'enrollment_url' => 'not-a-url',
                'verification_url' => 'https://example.com',
                'payment_url' => 'https://example.com',
                'support_url' => 'https://example.com',
            ])->assertRedirect(route('admin.settings.services'))
            ->assertSessionHasErrors('enrollment_url');
    }
}
