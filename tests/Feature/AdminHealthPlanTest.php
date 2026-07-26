<?php

namespace Tests\Feature;

use App\Models\HealthPlan;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHealthPlanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_admin_can_create_plan_with_benefits(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.health-plans.store'), [
            'name' => 'Community Care Plus',
            'sector' => 'Informal',
            'description' => 'Affordable community health coverage.',
            'price_label' => 'per person / year',
            'price_amount' => 15000,
            'is_featured' => 1,
            'sort_order' => 4,
            'benefits' => [
                ['benefit_key' => 'outpatient', 'benefit_label' => 'Outpatient care', 'is_included' => 1],
                ['benefit_key' => 'dental', 'benefit_label' => 'Dental care'],
            ],
        ])->assertRedirect(route('admin.health-plans.index'));

        $plan = HealthPlan::where('slug', 'community-care-plus')->firstOrFail();
        $this->assertTrue($plan->is_featured);
        $this->assertCount(2, $plan->benefits);
        $this->assertFalse($plan->benefits->firstWhere('benefit_key', 'dental')->is_included);
    }

    public function test_admin_can_update_plan_and_replace_benefits(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $plan = HealthPlan::with('benefits')->firstOrFail();
        $existing = $plan->benefits->first();

        $this->actingAs($admin)->put(route('admin.health-plans.update', $plan), [
            'name' => 'Updated Plan',
            'sector' => $plan->sector,
            'description' => 'Updated plan description.',
            'price_label' => 'per household / year',
            'price_amount' => 25000,
            'sort_order' => 1,
            'benefits' => [[
                'id' => $existing?->id,
                'benefit_key' => 'updated_benefit',
                'benefit_label' => 'Updated benefit',
                'is_included' => 1,
            ]],
        ])->assertRedirect(route('admin.health-plans.index'));

        $plan->refresh();
        $this->assertSame('Updated Plan', $plan->name);
        $this->assertSame(1, $plan->benefits()->count());
        $this->assertDatabaseHas('plan_benefits', ['health_plan_id' => $plan->id, 'benefit_key' => 'updated_benefit']);
    }

    public function test_admin_can_delete_plan_and_benefits(): void
    {
        $admin = User::where('role', 'admin')->firstOrFail();
        $plan = HealthPlan::firstOrFail();

        $this->actingAs($admin)
            ->delete(route('admin.health-plans.destroy', $plan))
            ->assertRedirect(route('admin.health-plans.index'));

        $this->assertDatabaseMissing('health_plans', ['id' => $plan->id]);
        $this->assertDatabaseMissing('plan_benefits', ['health_plan_id' => $plan->id]);
    }
}
