@extends('layouts.app')

@section('title', 'FAQs')
@section('meta_description', 'Frequently asked questions about PLASCHEMA enrollment, coverage, providers, and payments.')

@section('content')
    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[['label' => 'FAQs']]" />
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Frequently Asked Questions</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">Find answers about enrollment, coverage, providers, and payments.</p>
        </div>
    </div>

    <x-section class="bg-white">
        <div
            class="mx-auto max-w-3xl"
            x-data="{
                search: '',
                matches(text) {
                    return this.search === '' || text.toLowerCase().includes(this.search.toLowerCase());
                }
            }"
        >
            <div class="relative mb-8">
                <i data-lucide="search" class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"></i>
                <label for="faq-search" class="sr-only">Search FAQs</label>
                <input
                    id="faq-search"
                    type="search"
                    x-model="search"
                    placeholder="Search questions..."
                    class="w-full rounded-[var(--radius-card)] border border-slate-200 bg-white py-3 pl-12 pr-4 text-sm shadow-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                >
            </div>

            <div class="space-y-10">
                @foreach ($categories as $category)
                    <div x-show="{{ $category->publishedFaqs->isNotEmpty() ? 'true' : 'false' }}">
                        <h2 class="mb-4 text-lg font-semibold text-slate-900">{{ $category->name }}</h2>
                        <div class="space-y-3">
                            @foreach ($category->publishedFaqs as $faq)
                                <div
                                    x-show="matches({{ Js::from($faq->question) }}) || matches({{ Js::from($faq->answer) }})"
                                    x-data="{ open: false }"
                                    class="overflow-hidden rounded-[var(--radius-card)] border border-slate-200 bg-white"
                                >
                                    <button
                                        type="button"
                                        class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-slate-50"
                                        @click="open = !open"
                                        :aria-expanded="open"
                                    >
                                        <span class="font-medium text-slate-900">{{ $faq->question }}</span>
                                        <i data-lucide="chevron-down" class="h-5 w-5 shrink-0 text-slate-400 transition-transform" :class="open && 'rotate-180'"></i>
                                    </button>
                                    <div
                                        x-show="open"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        x-cloak
                                    >
                                        <div class="border-t border-slate-100 px-5 py-4 text-sm leading-relaxed text-slate-600">
                                            {{ $faq->answer }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <p x-show="search !== ''" class="mt-6 text-center text-sm text-slate-500" x-cloak>
                Can't find your answer? <a href="{{ route('contact') }}" class="font-semibold text-primary hover:text-primary-700">Contact us</a>.
            </p>
        </div>
    </x-section>
@endsection
