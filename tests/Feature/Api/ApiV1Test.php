<?php

namespace Tests\Feature\Api;

use App\Models\Faq;
use App\Models\HealthcareProvider;
use App\Models\NewsArticle;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiV1Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_public_resources_return_expected_json_shapes(): void
    {
        $this->getJson('/api/v1/plans')->assertOk()->assertJsonStructure(['data', 'links', 'meta']);
        $this->getJson('/api/v1/providers')->assertOk()->assertJsonStructure(['data', 'links', 'meta']);
        $this->getJson('/api/v1/news')->assertOk()->assertJsonStructure(['data', 'links', 'meta']);
        $this->getJson('/api/v1/faqs')->assertOk()->assertJsonStructure(['data']);
        $this->getJson('/api/v1/downloads')->assertOk()->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_unpublished_content_is_not_exposed(): void
    {
        $provider = $this->makeProvider();
        $provider->update(['is_published' => false]);
        $this->getJson('/api/v1/providers/'.$provider->slug)->assertNotFound();

        $article = NewsArticle::query()->firstOrFail();
        $article->update(['is_published' => false]);
        $this->getJson('/api/v1/news/'.$article->slug)->assertNotFound();

        $faq = Faq::query()->firstOrFail();
        $faq->update(['is_published' => false]);
        $this->getJson('/api/v1/faqs')->assertOk()->assertJsonMissing(['question' => $faq->question]);
    }

    public function test_provider_search_filters_results(): void
    {
        $provider = $this->makeProvider();
        $this->getJson('/api/v1/providers/search?lga='.urlencode($provider->lga))
            ->assertOk()
            ->assertJsonPath('data.0.lga', $provider->lga);
    }

    public function test_contact_endpoint_validates_and_creates_message(): void
    {
        $this->postJson('/api/v1/contact', [])->assertUnprocessable()->assertJsonValidationErrors(['name', 'email', 'subject', 'message']);

        $this->postJson('/api/v1/contact', [
            'name' => 'API Citizen', 'email' => 'citizen@example.com',
            'subject' => 'Coverage enquiry', 'message' => 'Please assist me.',
        ])->assertCreated()->assertJsonPath('data.name', 'API Citizen');

        $this->assertDatabaseHas('contact_messages', ['email' => 'citizen@example.com']);
    }

    public function test_token_issue_protected_access_and_revocation(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $response = $this->postJson('/api/v1/auth/token', [
            'email' => $admin->email, 'password' => 'password', 'device_name' => 'tests',
        ])->assertOk()->assertJsonPath('user.role', 'admin');

        $token = $response->json('token');
        $this->withToken($token)->getJson('/api/v1/admin/messages')->assertOk();
        $this->withToken($token)->deleteJson('/api/v1/auth/token')->assertOk();
        $this->assertDatabaseMissing('personal_access_tokens', ['token' => hash('sha256', explode('|', $token, 2)[1])]);
        $this->app['auth']->forgetGuards();
        $this->withToken($token)->getJson('/api/v1/admin/messages')->assertUnauthorized();
    }

    public function test_editor_token_cannot_access_admin_only_inbox(): void
    {
        $editor = User::where('role', 'editor')->firstOrFail();
        $token = $editor->createToken('tests', ['role:editor'])->plainTextToken;

        $this->withToken($token)->getJson('/api/v1/admin/providers')->assertOk();
        $this->withToken($token)->getJson('/api/v1/admin/messages')->assertForbidden();
    }

    public function test_stale_admin_ability_is_rejected_after_role_change(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $token = $admin->createToken('tests', ['role:admin'])->plainTextToken;
        $admin->update(['role' => 'editor']);

        $this->withToken($token)->getJson('/api/v1/admin/messages')->assertForbidden();
    }

    public function test_editor_can_create_and_delete_provider(): void
    {
        $editor = User::where('role', 'editor')->firstOrFail();
        $token = $editor->createToken('tests', ['role:editor'])->plainTextToken;
        $payload = [
            'name' => 'API Health Centre', 'lga' => 'Jos North', 'specialty' => 'Primary Care',
            'ownership' => 'public', 'services' => ['Outpatient'], 'address' => 'API Street',
            'phone' => null, 'email' => null, 'working_hours' => null, 'latitude' => null,
            'longitude' => null, 'accreditation_status' => 'accredited', 'is_published' => true,
        ];

        $created = $this->withToken($token)->postJson('/api/v1/admin/providers', $payload)
            ->assertCreated()->assertJsonPath('data.name', 'API Health Centre');

        $this->withToken($token)->deleteJson('/api/v1/admin/providers/'.$created->json('data.slug'))->assertOk();
        $this->assertDatabaseMissing('healthcare_providers', ['name' => 'API Health Centre']);
    }

    private function makeProvider(): HealthcareProvider
    {
        return HealthcareProvider::create([
            'name' => 'Test Provider',
            'slug' => 'test-provider',
            'lga' => 'Jos North',
            'specialty' => 'General',
            'ownership' => 'public',
            'services' => ['Outpatient'],
            'address' => 'Test Street',
            'accreditation_status' => 'accredited',
            'is_published' => true,
        ]);
    }
}
