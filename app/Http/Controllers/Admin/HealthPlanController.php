<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthPlan;
use App\Models\PlanBenefit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HealthPlanController extends Controller
{
    public function index(Request $request): View
    {
        $plans = HealthPlan::query()
            ->withCount('benefits')
            ->when($request->filled('sector'), fn ($q) => $q->where('sector', $request->sector))
            ->orderBy('sort_order')
            ->paginate(20);

        $sectors = HealthPlan::query()->select('sector')->distinct()->pluck('sector')->filter();

        return view('admin.health-plans.index', [
            'plans' => $plans,
            'sectors' => $sectors,
            'filters' => $request->only(['sector']),
        ]);
    }

    public function create(): View
    {
        return view('admin.health-plans.create', [
            'plan' => new HealthPlan,
            'benefits' => [],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sector' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price_label' => ['required', 'string', 'max:255'],
            'price_amount' => ['required', 'numeric', 'min:0'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'benefits' => ['nullable', 'array'],
            'benefits.*.benefit_key' => ['required', 'string', 'max:255'],
            'benefits.*.benefit_label' => ['required', 'string', 'max:500'],
            'benefits.*.is_included' => ['boolean'],
        ]);

        $isFeatured = $request->boolean('is_featured');

        DB::transaction(function () use ($validated, $isFeatured): void {
            $plan = HealthPlan::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'sector' => $validated['sector'],
                'description' => $validated['description'],
                'price_label' => $validated['price_label'],
                'price_amount' => $validated['price_amount'],
                'is_featured' => $isFeatured,
                'sort_order' => $validated['sort_order'] ?? 999,
            ]);

            foreach (array_values($validated['benefits'] ?? []) as $i => $b) {
                $plan->benefits()->create([
                    'benefit_key' => $b['benefit_key'],
                    'benefit_label' => $b['benefit_label'],
                    'is_included' => $b['is_included'] ?? false,
                    'sort_order' => $i + 1,
                ]);
            }
        });

        return redirect()->route('admin.health-plans.index')->with('success', 'Health plan created successfully.');
    }

    public function edit(HealthPlan $healthPlan): View
    {
        $healthPlan->load('benefits');

        return view('admin.health-plans.edit', [
            'plan' => $healthPlan,
            'benefits' => $healthPlan->benefits,
        ]);
    }

    public function update(Request $request, HealthPlan $healthPlan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sector' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price_label' => ['required', 'string', 'max:255'],
            'price_amount' => ['required', 'numeric', 'min:0'],
            'is_featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'benefits' => ['nullable', 'array'],
            'benefits.*.id' => ['nullable', 'exists:plan_benefits,id'],
            'benefits.*.benefit_key' => ['required', 'string', 'max:255'],
            'benefits.*.benefit_label' => ['required', 'string', 'max:500'],
            'benefits.*.is_included' => ['boolean'],
        ]);

        DB::transaction(function () use ($healthPlan, $validated, $request): void {
            $healthPlan->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'sector' => $validated['sector'],
                'description' => $validated['description'],
                'price_label' => $validated['price_label'],
                'price_amount' => $validated['price_amount'],
                'is_featured' => $request->has('is_featured'),
                'sort_order' => $validated['sort_order'] ?? $healthPlan->sort_order,
            ]);

            $kept = [];
            foreach (array_values($validated['benefits'] ?? []) as $i => $b) {
                $data = [
                    'benefit_key' => $b['benefit_key'],
                    'benefit_label' => $b['benefit_label'],
                    'is_included' => $b['is_included'] ?? false,
                    'sort_order' => $i + 1,
                ];
                if (! empty($b['id'])) {
                    $benefit = PlanBenefit::where('id', $b['id'])->where('health_plan_id', $healthPlan->id)->firstOrFail();
                    $benefit->update($data);
                    $kept[] = $benefit->id;
                } else {
                    $benefit = $healthPlan->benefits()->create($data);
                    $kept[] = $benefit->id;
                }
            }
            $healthPlan->benefits()->whereNotIn('id', $kept)->delete();
        });

        return redirect()->route('admin.health-plans.index')->with('success', 'Health plan updated successfully.');
    }

    public function destroy(HealthPlan $healthPlan): RedirectResponse
    {
        DB::transaction(function () use ($healthPlan): void {
            $healthPlan->benefits()->delete();
            $healthPlan->delete();
        });

        return redirect()->route('admin.health-plans.index')->with('success', 'Health plan deleted successfully.');
    }
}
