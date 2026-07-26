<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')
            ->assertRedirect(route('admin.login'));
    }

    public function test_login_page_renders(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('Sign in to Admin')
            ->assertSee('Email Address');
    }

    public function test_successful_login(): void
    {
        $user = User::where('role', 'admin')->first();

        $response = $this->post(route('admin.login.submit'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_failed_login_with_incorrect_password(): void
    {
        $user = User::where('role', 'admin')->first();

        $response = $this->post(route('admin.login.submit'), [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout(): void
    {
        $user = User::where('role', 'admin')->first();

        $this->actingAs($user)
            ->post(route('admin.logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_authenticated_user_cannot_access_login(): void
    {
        $user = User::where('role', 'admin')->first();

        $this->actingAs($user)
            ->get(route('admin.login'))
            ->assertRedirect(route('home'));
    }
}
