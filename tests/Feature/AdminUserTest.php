<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_editor_cannot_access_user_management(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $this->actingAs($editor)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_admin_can_create_user(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'New Author',
            'email' => 'author@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'editor',
        ])->assertRedirect(route('admin.users.index'));

        $user = User::where('email', 'author@example.com')->firstOrFail();
        $this->assertSame('editor', $user->role);
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin))
            ->assertSessionHasErrors('delete');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_cannot_delete_last_admin(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $other = User::factory()->create(['role' => 'admin']);

        $this->actingAs($other)
            ->delete(route('admin.users.destroy', $admin))
            ->assertRedirect(route('admin.users.index'));

        // Now only one admin left
        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $other))
            ->assertSessionHasErrors('delete');
    }

    public function test_admin_cannot_demote_last_admin(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)->from(route('admin.users.edit', $admin))
            ->put(route('admin.users.update', $admin), [
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => 'editor',
            ])->assertForbidden();
    }
}
