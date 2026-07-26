<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactMessageResource;
use App\Http\Resources\DownloadResource;
use App\Http\Resources\FaqCategoryResource;
use App\Http\Resources\HealthPlanResource;
use App\Http\Resources\NewsArticleResource;
use App\Http\Resources\ProviderResource;
use App\Models\ContactMessage;
use App\Models\Download;
use App\Models\FaqCategory;
use App\Models\HealthcareProvider;
use App\Models\HealthPlan;
use App\Models\NewsArticle;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PublicController extends Controller
{
    /* ------------------------------------------------------------------
     * Health Plans
     * --------------------------------------------------------------- */
    public function plans(Request $request): AnonymousResourceCollection
    {
        $request->validate(['featured' => 'boolean', 'sector' => 'string', 'per_page' => 'integer|min:1|max:50']);

        return HealthPlanResource::collection(
            HealthPlan::query()
                ->when($request->filled('sector'), fn ($q) => $q->where('sector', $request->sector))
                ->when($request->filled('featured'), fn ($q) => $q->where('is_featured', $request->boolean('featured')))
                ->orderBy('sort_order')
                ->with('benefits')
                ->paginate(min($request->integer('per_page', 15), 50))
        );
    }

    public function plan(string $slug): HealthPlanResource
    {
        $plan = HealthPlan::query()->where('slug', $slug)->with('benefits')->firstOrFail();

        return new HealthPlanResource($plan);
    }

    /* ------------------------------------------------------------------
     * Providers
     * --------------------------------------------------------------- */
    public function providers(Request $request): AnonymousResourceCollection
    {
        $request->validate(['q' => 'string|max:200', 'lga' => 'string|max:100', 'specialty' => 'string|max:100', 'ownership' => 'string|max:50', 'service' => 'string|max:100', 'per_page' => 'integer|min:1|max:50']);

        return ProviderResource::collection(
            HealthcareProvider::query()
                ->published()
                ->filter($request)
                ->orderBy('name')
                ->paginate(min($request->integer('per_page', 15), 50))
        );
    }

    public function provider(string $slug): ProviderResource
    {
        return new ProviderResource(
            HealthcareProvider::query()->published()->where('slug', $slug)->firstOrFail()
        );
    }

    /* ------------------------------------------------------------------
     * News
     * --------------------------------------------------------------- */
    public function news(Request $request): AnonymousResourceCollection
    {
        $request->validate(['q' => 'string|max:200', 'category' => 'string|max:50', 'per_page' => 'integer|min:1|max:50']);

        return NewsArticleResource::collection(
            NewsArticle::query()
                ->published()
                ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
                ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
                ->latest('published_at')
                ->paginate(min($request->integer('per_page', 15), 50))
        );
    }

    public function article(string $slug): NewsArticleResource
    {
        return new NewsArticleResource(
            NewsArticle::query()->published()->where('slug', $slug)->firstOrFail()
        );
    }

    /* ------------------------------------------------------------------
     * FAQs
     * --------------------------------------------------------------- */
    public function faqs(Request $request): AnonymousResourceCollection
    {
        $request->validate(['category' => 'string|max:100']);

        return FaqCategoryResource::collection(
            FaqCategory::query()
                ->when($request->filled('category'), fn ($q) => $q->where('slug', $request->category))
                ->with('publishedFaqs')
                ->orderBy('sort_order')
                ->get()
        );
    }

    /* ------------------------------------------------------------------
     * Downloads
     * --------------------------------------------------------------- */
    public function downloads(Request $request): AnonymousResourceCollection
    {
        $request->validate(['q' => 'string|max:200', 'category' => 'string|max:50', 'per_page' => 'integer|min:1|max:50']);

        return DownloadResource::collection(
            Download::query()
                ->published()
                ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%'.$request->string('q').'%'))
                ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
                ->latest('published_at')
                ->paginate(min($request->integer('per_page', 15), 50))
        );
    }

    /* ------------------------------------------------------------------
     * Contact (throttled separately)
     * --------------------------------------------------------------- */
    public function contact(StoreContactRequest $request): JsonResponse
    {
        $message = ContactMessage::create($request->validated());

        return ApiResponse::created(new ContactMessageResource($message));
    }
}
