<?php

namespace App\Support;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\HealthPlan;

class AssistantKnowledge
{
    /**
     * Build a client-safe knowledge payload for the front-end assistant.
     *
     * Returns an array that can be safely JSON-encoded. No request-specific or
     * user-identifiable data enters this payload.
     */
    public static function build(): array
    {
        return [
            'faqs' => self::faqs(),
            'plans' => self::plans(),
            'services' => DigitalServices::all(),
            'providerSearchUrl' => route('providers'),
            'plansUrl' => route('health-plans'),
            'faqsUrl' => route('faqs'),
            'contactUrl' => route('contact'),
            'siteName' => config('app.name', 'PLASCHEMA'),
        ];
    }

    /**
     * Published FAQs grouped by category, each with category label and question.
     */
    private static function faqs(): array
    {
        $groups = Faq::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn ($faq) => $faq->faq_category_id);

        if ($groups->isEmpty()) {
            return [];
        }

        $categories = FaqCategory::query()
            ->whereIn('id', $groups->keys())
            ->get()
            ->keyBy('id');

        return $groups->map(function ($faqs, $categoryId) use ($categories) {
            $category = $categories->get($categoryId);

            return [
                'category' => $category?->name ?? 'General',
                'questions' => $faqs->map(fn ($f) => [
                    'question' => $f->question,
                    'answer' => $f->answer,
                ])->values()->all(),
            ];
        })->values()->all();
    }

    /**
     * Published health plans with name and a concise description.
     */
    private static function plans(): array
    {
        return HealthPlan::query()
            ->orderBy('sort_order')
            ->get(['name', 'description', 'price_amount', 'price_label', 'slug'])
            ->toArray();
    }
}
