<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactMessageResource;
use App\Http\Resources\DownloadResource;
use App\Http\Resources\FaqResource;
use App\Http\Resources\HealthPlanResource;
use App\Http\Resources\NewsArticleResource;
use App\Http\Resources\ProviderResource;
use App\Models\ContactMessage;
use App\Models\Download;
use App\Models\Faq;
use App\Models\HealthcareProvider;
use App\Models\HealthPlan;
use App\Models\NewsArticle;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /* Providers ------------------------------------------------------ */
    public function providers(Request $request)
    {
        return ProviderResource::collection(HealthcareProvider::query()->filter($request)->orderBy('name')->paginate(min($request->integer('per_page', 15), 50)));
    }

    public function storeProvider(Request $request): JsonResponse
    {
        $data = $this->providerData($request);
        $data['slug'] = $this->uniqueSlug(HealthcareProvider::class, $data['name']);

        return ApiResponse::resource(new ProviderResource(HealthcareProvider::create($data)), 201);
    }

    public function updateProvider(Request $request, HealthcareProvider $provider): ProviderResource
    {
        $data = $this->providerData($request);
        $data['slug'] = $this->uniqueSlug(HealthcareProvider::class, $data['name'], $provider->id);
        $provider->update($data);

        return new ProviderResource($provider->fresh());
    }

    public function deleteProvider(HealthcareProvider $provider): JsonResponse
    {
        $provider->delete();

        return ApiResponse::message('Provider deleted.');
    }

    private function providerData(Request $request): array
    {
        $v = $request->validate(['name' => 'required|string|max:255', 'lga' => 'required|string|max:100', 'specialty' => 'nullable|string|max:100', 'ownership' => 'required|string|max:50', 'services' => 'nullable|array', 'services.*' => 'string|max:100', 'address' => 'required|string|max:1000', 'phone' => 'nullable|string|max:50', 'email' => 'nullable|email|max:255', 'working_hours' => 'nullable|string|max:255', 'latitude' => 'nullable|numeric|between:-90,90', 'longitude' => 'nullable|numeric|between:-180,180', 'accreditation_status' => 'required|in:accredited,pending,suspended', 'is_published' => 'required|boolean']);

        return $v;
    }

    /* Health Plans -------------------------------------------------- */
    public function plans()
    {
        return HealthPlanResource::collection(HealthPlan::with('benefits')->orderBy('sort_order')->paginate(50));
    }

    public function storePlan(Request $request): JsonResponse
    {
        $v = $this->planData($request);
        $plan = DB::transaction(function () use ($v) {
            $benefits = $v['benefits'] ?? [];
            unset($v['benefits']);
            $v['slug'] = $this->uniqueSlug(HealthPlan::class, $v['name']);
            $p = HealthPlan::create($v);
            $this->syncBenefits($p, $benefits);

            return $p->load('benefits');
        });

        return ApiResponse::resource(new HealthPlanResource($plan), 201);
    }

    public function updatePlan(Request $request, HealthPlan $plan): HealthPlanResource
    {
        $v = $this->planData($request);
        DB::transaction(function () use ($v, $plan) {
            $benefits = $v['benefits'] ?? [];
            unset($v['benefits']);
            $v['slug'] = $this->uniqueSlug(HealthPlan::class, $v['name'], $plan->id);
            $plan->update($v);
            $plan->benefits()->delete();
            $this->syncBenefits($plan, $benefits);
        });

        return new HealthPlanResource($plan->fresh()->load('benefits'));
    }

    public function deletePlan(HealthPlan $plan): JsonResponse
    {
        DB::transaction(fn () => [$plan->benefits()->delete(), $plan->delete()]);

        return ApiResponse::message('Health plan deleted.');
    }

    private function planData(Request $request): array
    {
        return $request->validate(['name' => 'required|string|max:255', 'sector' => 'required|string|max:255', 'description' => 'required|string', 'price_label' => 'required|string|max:255', 'price_amount' => 'required|numeric|min:0', 'is_featured' => 'required|boolean', 'sort_order' => 'nullable|integer|min:0', 'benefits' => 'nullable|array', 'benefits.*.benefit_key' => 'required|string|max:255', 'benefits.*.benefit_label' => 'required|string|max:500', 'benefits.*.is_included' => 'required|boolean']);
    }

    private function syncBenefits(HealthPlan $plan, array $benefits): void
    {
        foreach (array_values($benefits) as $i => $b) {
            $plan->benefits()->create([...$b, 'sort_order' => $i + 1]);
        }
    }

    /* News ---------------------------------------------------------- */
    public function news()
    {
        return NewsArticleResource::collection(NewsArticle::latest()->paginate(20));
    }

    public function storeNews(Request $request): JsonResponse
    {
        $v = $this->newsData($request);
        $v['slug'] = $this->uniqueSlug(NewsArticle::class, $v['title']);

        return ApiResponse::resource(new NewsArticleResource(NewsArticle::create($v)), 201);
    }

    public function updateNews(Request $request, NewsArticle $article): NewsArticleResource
    {
        $v = $this->newsData($request);
        $v['slug'] = $this->uniqueSlug(NewsArticle::class, $v['title'], $article->id);
        $article->update($v);

        return new NewsArticleResource($article->fresh());
    }

    public function deleteNews(NewsArticle $article): JsonResponse
    {
        $article->delete();

        return ApiResponse::message('Article deleted.');
    }

    private function newsData(Request $request): array
    {
        return $request->validate(['title' => 'required|string|max:255', 'excerpt' => 'required|string|max:1000', 'body' => 'required|string', 'category' => 'required|in:campaign,activity,press', 'published_at' => 'nullable|date', 'is_published' => 'required|boolean']);
    }

    /* FAQs ---------------------------------------------------------- */
    public function faqs()
    {
        return FaqResource::collection(Faq::with('category')->orderBy('sort_order')->paginate(50));
    }

    public function storeFaq(Request $request): JsonResponse
    {
        $v = $this->faqData($request);

        return ApiResponse::resource(new FaqResource(Faq::create($v)), 201);
    }

    public function updateFaq(Request $request, Faq $faq): FaqResource
    {
        $faq->update($this->faqData($request));

        return new FaqResource($faq->fresh());
    }

    public function deleteFaq(Faq $faq): JsonResponse
    {
        $faq->delete();

        return ApiResponse::message('FAQ deleted.');
    }

    private function faqData(Request $request): array
    {
        return $request->validate(['faq_category_id' => 'required|exists:faq_categories,id', 'question' => 'required|string|max:500', 'answer' => 'required|string|max:5000', 'sort_order' => 'nullable|integer|min:0', 'is_published' => 'required|boolean']);
    }

    /* Downloads metadata ------------------------------------------ */
    public function downloads()
    {
        return DownloadResource::collection(Download::latest()->paginate(20));
    }

    public function updateDownload(Request $request, Download $download): DownloadResource
    {
        $v = $request->validate(['title' => 'sometimes|required|string|max:255', 'category' => 'sometimes|required|in:form,policy,guideline,report,circular', 'description' => 'sometimes|required|string|max:5000', 'published_at' => 'nullable|date', 'is_published' => 'sometimes|required|boolean']);
        if (isset($v['title'])) {
            $v['slug'] = $this->uniqueSlug(Download::class, $v['title'], $download->id);
        }$download->update($v);

        return new DownloadResource($download->fresh());
    }

    public function deleteDownload(Download $download): JsonResponse
    {
        $download->delete();

        return ApiResponse::message('Download record deleted.');
    }

    /* Contact inbox ------------------------------------------------ */
    public function messages(Request $request)
    {
        return ContactMessageResource::collection(ContactMessage::query()->when($request->filled('read'), fn ($q) => $q->where('is_read', $request->boolean('read')))->latest()->paginate(20));
    }

    public function message(ContactMessage $message): ContactMessageResource
    {
        return new ContactMessageResource($message);
    }

    public function readMessage(Request $request, ContactMessage $message): ContactMessageResource
    {
        $read = $request->boolean('is_read', true);
        $message->update(['is_read' => $read, 'read_at' => $read ? now() : null]);

        return new ContactMessageResource($message->fresh());
    }

    private function uniqueSlug(string $model, string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value);
        $slug = $base;
        $i = 2;
        while ($model::query()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$i++;
        }

return $slug;
    }
}
