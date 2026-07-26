<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFaqTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_guest_cannot_access_faq_management(): void
    {
        $this->get(route('admin.faqs.index'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_faq_management(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.faqs.index'))
            ->assertOk()
            ->assertSee('Add New FAQ');
    }

    public function test_admin_can_create_faq(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $category = FaqCategory::firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.faqs.store'), [
                'faq_category_id' => $category->id,
                'question' => 'How can I update my membership details?',
                'answer' => 'Contact the nearest PLASCHEMA office with valid identification.',
                'sort_order' => 20,
                'is_published' => 1,
            ])
            ->assertRedirect(route('admin.faqs.index'));

        $this->assertDatabaseHas('faqs', [
            'question' => 'How can I update my membership details?',
            'is_published' => true,
        ]);
    }

    public function test_admin_can_update_faq(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $faq = Faq::firstOrFail();

        $this->actingAs($admin)
            ->put(route('admin.faqs.update', $faq), [
                'faq_category_id' => $faq->faq_category_id,
                'question' => 'Updated FAQ question?',
                'answer' => 'Updated FAQ answer.',
                'sort_order' => 2,
            ])
            ->assertRedirect(route('admin.faqs.index'));

        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'question' => 'Updated FAQ question?',
            'is_published' => false,
        ]);
    }

    public function test_admin_can_delete_faq(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $faq = Faq::firstOrFail();

        $this->actingAs($admin)
            ->delete(route('admin.faqs.destroy', $faq))
            ->assertRedirect(route('admin.faqs.index'));

        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
