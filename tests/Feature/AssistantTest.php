<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\HealthPlan;
use App\Support\AssistantKnowledge;
use Database\Seeders\ContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssistantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(ContentSeeder::class);
    }

    public function test_assistant_appears_on_public_pages_but_not_admin_login(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('id="plaschema-assistant"', false)
            ->assertSee('Scripted help only');

        $this->get(route('admin.login'))
            ->assertOk()
            ->assertDontSee('id="plaschema-assistant"', false);
    }

    public function test_only_published_faqs_enter_the_knowledge_payload(): void
    {
        $category = FaqCategory::query()->firstOrFail();
        Faq::create([
            'faq_category_id' => $category->id,
            'question' => 'Visible assistant question?',
            'answer' => 'Visible assistant answer.',
            'sort_order' => 900,
            'is_published' => true,
        ]);
        Faq::create([
            'faq_category_id' => $category->id,
            'question' => 'Secret draft question?',
            'answer' => 'Secret draft answer.',
            'sort_order' => 901,
            'is_published' => false,
        ]);

        $knowledge = AssistantKnowledge::build();
        $encoded = json_encode($knowledge);

        $this->assertStringContainsString('Visible assistant question?', $encoded);
        $this->assertStringNotContainsString('Secret draft question?', $encoded);
    }

    public function test_plan_and_action_urls_are_included_in_payload(): void
    {
        $plan = HealthPlan::query()->firstOrFail();
        $knowledge = AssistantKnowledge::build();

        $this->assertSame(route('providers'), $knowledge['providerSearchUrl']);
        $this->assertSame(route('health-plans'), $knowledge['plansUrl']);
        $this->assertSame(route('faqs'), $knowledge['faqsUrl']);
        $this->assertContains($plan->name, array_column($knowledge['plans'], 'name'));
        $this->assertCount(4, $knowledge['services']);
    }

    public function test_faq_payload_is_safely_serialized_in_html(): void
    {
        $category = FaqCategory::query()->firstOrFail();
        Faq::create([
            'faq_category_id' => $category->id,
            'question' => '</script><script>alert("xss")</script>',
            'answer' => '<img src=x onerror=alert(1)>',
            'sort_order' => 999,
            'is_published' => true,
        ]);

        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertDontSee('</script><script>alert("xss")</script>', false);
        $response->assertDontSee('<img src=x onerror=alert(1)>', false);
    }
}
