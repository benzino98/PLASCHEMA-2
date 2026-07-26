@extends('layouts.admin')
@section('title', 'Health Plans')
@section('page_heading', 'Health Plans')
@section('content')
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div><h2 class="text-2xl font-bold text-slate-900">Health Plans</h2><p class="mt-1 text-sm text-slate-600">Manage plan pricing, sectors, and covered benefits.</p></div>
    <a href="{{ route('admin.health-plans.create') }}" class="btn-primary"><i data-lucide="plus" class="h-4 w-4"></i>Add plan</a>
</div>
<div class="card mb-6">
    <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end">
        <div class="flex-1"><label for="sector" class="block text-sm font-semibold text-slate-700">Sector</label><select id="sector" name="sector" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm"><option value="">All sectors</option>@foreach($sectors as $sector)<option value="{{ $sector }}" @selected(($filters['sector'] ?? '') === $sector)>{{ $sector }}</option>@endforeach</select></div>
        <button class="btn-primary" type="submit"><i data-lucide="filter" class="h-4 w-4"></i>Filter</button>
    </form>
</div>
<div class="card overflow-hidden p-0">
    <div class="overflow-x-auto" data-gridjs-table><table class="w-full"><thead class="bg-slate-50"><tr><th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-600">Plan</th><th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-600">Sector</th><th class="px-6 py-3 text-left text-xs font-semibold uppercase text-slate-600">Price</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase text-slate-600">Benefits</th><th class="px-6 py-3 text-center text-xs font-semibold uppercase text-slate-600">Featured</th><th class="px-6 py-3 text-right text-xs font-semibold uppercase text-slate-600">Actions</th></tr></thead>
    <tbody class="divide-y divide-slate-100">@forelse($plans as $plan)<tr class="hover:bg-slate-50"><td class="px-6 py-4"><p class="font-semibold text-slate-900">{{ $plan->name }}</p><p class="mt-1 max-w-md text-xs text-slate-500">{{ Str::limit($plan->description, 80) }}</p></td><td class="px-6 py-4 text-sm text-slate-600">{{ $plan->sector }}</td><td class="px-6 py-4"><p class="font-semibold text-slate-900">₦{{ number_format((float)$plan->price_amount, 2) }}</p><p class="text-xs text-slate-500">{{ $plan->price_label }}</p></td><td class="px-6 py-4 text-center text-sm text-slate-600">{{ $plan->benefits_count }}</td><td class="px-6 py-4 text-center">@if($plan->is_featured)<span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-700">Featured</span>@else<span class="text-xs text-slate-400">Standard</span>@endif</td><td class="px-6 py-4"><div class="flex justify-end gap-2"><a href="{{ route('admin.health-plans.edit', $plan) }}" class="rounded-lg bg-primary px-3 py-2 text-xs font-semibold text-white">Edit</a><form method="POST" action="{{ route('admin.health-plans.destroy', $plan) }}" onsubmit="return confirm('Delete this health plan and all benefits?')">@csrf @method('DELETE')<button class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white">Delete</button></form></div></td></tr>@empty<tr><td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">No health plans found.</td></tr>@endforelse</tbody></table></div>
    @if($plans->hasPages())<div class="border-t border-slate-200 px-6 py-4">{{ $plans->links() }}</div>@endif
</div>
@endsection
