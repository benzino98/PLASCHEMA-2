<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_home_page_loads(): void
    {
        $this->get('/')->assertOk()->assertSee('Affordable Healthcare For Every');
    }

    public function test_public_pages_load(): void
    {
        $routes = [
            '/about',
            '/health-plans',
            '/providers',
            '/news',
            '/resources',
            '/contact',
        ];

        foreach ($routes as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_admin_dashboard_loads(): void
    {
        $this->get('/admin')->assertOk()->assertSee('Admin Panel');
    }

    public function test_navigation_links_present_on_home(): void
    {
        $this->get('/')
            ->assertSee('Health Plans')
            ->assertSee('Providers')
            ->assertSee('Contact');
    }
}
