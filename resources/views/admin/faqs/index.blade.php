@extends('layouts.admin')

@section('title', 'FAQs')
@section('page_heading', 'FAQs')

@section('content')
    {{-- Header with Actions --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-slate-600">{{ $faqs->total() }} total FAQs</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="btn-primary">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Add New FAQ
        </a>
    </div>

    {{-- Filters --}}
    <div class="card mb-6">
        <form method="GET" action="{{ route('admin.faqs.index') }}" class="flex flex-col gap-4 sm:flex-row">
            <div class="flex-1">
                <label for="search" class="sr-only">Search FAQs</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="search" class="h-5 w-5 text-slate-400"></i>
                    </div>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Search questions and answers..."
                        class="block w-full rounded-lg border border-slate-200 py-2 pl-10 pr-3 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    >
                </div>
            </div>
            <div class="flex gap-2">
                <select
                    name="category"
                    class="rounded-lg border border-slate-200 px-4 py-2 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ ($filters['category'] ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary">
                    <i data-lucide="filter" class="h-4 w-4"></i>
                    Filter
                </button>
                @if(!empty($filters['search']) || !empty($filters['category']))
                    <a href="{{ route('admin.faqs.index') }}" class="btn-outline">
                        <i data-lucide="x" class="h-4 w-4"></i>
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- FAQs Table --}}
    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Question
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Answer
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Order
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-600">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($faqs as $faq)
                        <tr class="transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center gap-1 rounded-full bg-primary-50 px-2.5 py-1 text-xs font-medium text-primary">
                                    {{ $faq->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ Str::limit($faq->question, 80) }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600">
                                    {{ Str::limit($faq->answer, 100) }}
                                </p>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center text-sm text-slate-500">
                                {{ $faq->sort_order }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                @if($faq->is_published)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                        <i data-lucide="check-circle" class="h-3 w-3"></i>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                        <i data-lucide="circle" class="h-3 w-3"></i>
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.faqs.edit', $faq) }}"
                                        class="inline-flex items-center gap-1 rounded-lg bg-primary px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-primary-700"
                                    >
                                        <i data-lucide="pencil" class="h-3 w-3"></i>
                                        Edit
                                    </a>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.faqs.destroy', $faq) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this FAQ?')"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1 rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-700"
                                        >
                                            <i data-lucide="trash-2" class="h-3 w-3"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                                        <i data-lucide="help-circle" class="h-8 w-8 text-slate-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">No FAQs found</p>
                                        <p class="text-xs text-slate-500">Create your first FAQ to get started</p>
                                    </div>
                                    <a href="{{ route('admin.faqs.create') }}" class="btn-primary mt-2">
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                        Add New FAQ
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($faqs->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
@endsection
