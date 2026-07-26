<?php

namespace Tests\Feature;

use App\Models\HealthcareProvider;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Database\Seeders\ProviderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProvidersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([ContentSeeder::class, ProviderSeeder::class]);
    }

    public function test_providers_index_loads_with_seeded_data(): void
    {
        $this->get('/providers')
            ->assertOk()
            ->assertSee('Jos University Teaching Hospital')
            ->assertSee('providers found');
    }

    public function test_providers_can_be_filtered_by_lga(): void
    {
        $this->get('/providers?lga=Jos+North')
            ->assertOk()
            ->assertSee('Jos University Teaching Hospital')
            ->assertDontSee('Shendam General Hospital');
    }

    public function test_providers_can_be_filtered_by_name(): void
    {
        $this->get('/providers?q=Mangu')
            ->assertOk()
            ->assertSee('Mangu General Hospital');
    }

    public function test_provider_detail_page_loads(): void
    {
        $provider = HealthcareProvider::where('slug', 'jos-university-teaching-hospital')->first();

        $this->get("/providers/{$provider->slug}")
            ->assertOk()
            ->assertSee($provider->name)
            ->assertSee('Accredited')
            ->assertSee('Services Offered');
    }

    public function test_map_view_loads(): void
    {
        $this->get('/providers?view=map')
            ->assertOk()
            ->assertSee('providers-map');
    }

    public function test_admin_can_create_provider(): void
    {
        $admin = User::where('role', 'admin')->first();

        $this->actingAs($admin)
            ->post(route('admin.providers.store'), [
                'name' => 'Test Clinic',
                'lga' => 'Jos North',
                'specialty' => 'General Practice',
                'ownership' => 'Private',
                'address' => '123 Test Street, Jos',
                'accreditation_status' => 'accredited',
                'services' => ['Outpatient', 'Pharmacy'],
                'is_published' => true,
            ])->assertRedirect(route('admin.providers.index'));

        $this->assertDatabaseHas('healthcare_providers', ['name' => 'Test Clinic']);
    }

    public function test_admin_can_update_provider(): void
    {
        $admin = User::where('role', 'admin')->first();
        $provider = HealthcareProvider::first();

        $this->actingAs($admin)
            ->put(route('admin.providers.update', $provider), [
                'name' => 'Updated Hospital Name',
                'lga' => $provider->lga,
                'address' => $provider->address,
                'accreditation_status' => 'accredited',
                'is_published' => true,
            ])->assertRedirect(route('admin.providers.index'));

        $this->assertDatabaseHas('healthcare_providers', [
            'id' => $provider->id,
            'name' => 'Updated Hospital Name',
        ]);
    }

    public function test_admin_can_delete_provider(): void
    {
        $admin = User::where('role', 'admin')->first();
        $provider = HealthcareProvider::first();

        $this->actingAs($admin)
            ->delete(route('admin.providers.destroy', $provider))
            ->assertRedirect(route('admin.providers.index'));

        $this->assertDatabaseMissing('healthcare_providers', ['id' => $provider->id]);
    }
}
