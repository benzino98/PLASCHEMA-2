<?php

namespace Tests\Feature;

use Database\Seeders\ContentSeeder;
use Database\Seeders\ProviderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([ContentSeeder::class, ProviderSeeder::class]);
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertOk();
    }
}
