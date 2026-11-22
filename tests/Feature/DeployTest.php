<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class DeployTest extends TestCase
{
    use RefreshDatabase;

    public function test_deploy_endpoint_is_forbidden_when_key_is_not_configured(): void
    {
        Config::set('plaschema.deploy_key', '');

        $response = $this->get('/_deploy?key=secret');
        $response->assertStatus(403);

        $response = $this->post('/_deploy/run', ['key' => 'secret', 'action' => 'status']);
        $response->assertStatus(403);
    }

    public function test_deploy_endpoint_is_forbidden_with_invalid_key(): void
    {
        Config::set('plaschema.deploy_key', 'valid-secret-token-12345');

        $response = $this->get('/_deploy?key=wrong-token');
        $response->assertStatus(403);

        $response = $this->post('/_deploy/run', ['key' => 'wrong-token', 'action' => 'status']);
        $response->assertStatus(403);
    }

    public function test_deploy_dashboard_loads_with_valid_key(): void
    {
        Config::set('plaschema.deploy_key', 'valid-secret-token-12345');

        $response = $this->get('/_deploy?key=valid-secret-token-12345');
        $response->assertStatus(200);
        $response->assertSee('PLASCHEMA Deploy');
        $response->assertSee('Run Migrations');
    }

    public function test_deploy_run_returns_json_when_requested_via_header(): void
    {
        Config::set('plaschema.deploy_key', 'valid-secret-token-12345');

        $response = $this->postJson('/_deploy/run', [
            'action' => 'status',
        ], [
            'X-Deploy-Key' => 'valid-secret-token-12345',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'action' => 'status',
        ]);
    }

    public function test_deploy_run_executes_migrate_action(): void
    {
        Config::set('plaschema.deploy_key', 'valid-secret-token-12345');

        $response = $this->post('/_deploy/run', [
            'key' => 'valid-secret-token-12345',
            'action' => 'migrate',
        ]);

        $response->assertStatus(200);
        $response->assertSee('PLASCHEMA Deploy');
    }

    public function test_deploy_run_executes_clear_action(): void
    {
        Config::set('plaschema.deploy_key', 'valid-secret-token-12345');

        $response = $this->postJson('/_deploy/run', [
            'action' => 'clear',
        ], [
            'X-Deploy-Key' => 'valid-secret-token-12345',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'action' => 'clear',
        ]);
    }
}
