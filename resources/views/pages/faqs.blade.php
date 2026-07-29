@extends('layouts.app')

@section('title', 'FAQs')
@section('meta_description', 'Frequently asked questions about PLASCHEMA enrollment, coverage, providers, and payments.')

@section('content')
    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-16 text-white sm:py-20 lg:py-24">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <nav aria-label="Breadcrumb" class="text-sm text-white/60 mb-6 justify-center flex">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">FAQs</span>
            </nav>
            
            <div class="mx-auto max-w-2xl">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    How can we <span class="bg-gradient-to-r from-emerald-300 to-cyan-300 bg-clip-text text-transparent">help you?</span>
                </h1>
                <p class="mt-4 text-lg leading-8 text-slate-300">
                    Find answers about enrollment, coverage, providers, and payments.
                </p>
            </div>
        </div>
    </section>

    <x-section class="bg-slate-50" padding="lg">
        <div
            class="mx-auto max-w-4xl"
            x-data="{
                search: '',
                activeCategory: 'all',
                matches(text) {
                    return this.search === '' || text.toLowerCase().includes(this.search.toLowerCase());
                }
            }"
        >
            {{-- Search Bar --}}
            <div class="relative -mt-24 mb-12 z-10">
                <div class="relative flex items-center bg-white rounded-2xl shadow-xl shadow-slate-200/50 ring-1 ring-slate-200 p-2">
                    <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center">
                        <i data-lucide="search" class="h-6 w-6 text-slate-400"></i>
                    </div>
                    <label for="faq-search" class="sr-only">Search FAQs</label>
                    <input
                        id="faq-search"
                        type="search"
                        x-model="search"
                        placeholder="Search for answers (e.g., 'How to enroll', 'Lost ID card')"
                        class="block w-full rounded-xl border-0 py-4 pl-14 pr-4 text-slate-900 placeholder:text-slate-400 focus:ring-0 sm:text-lg sm:leading-6"
                    >
                    <button type="button" class="hidden sm:block btn-primary px-8" @click="search = ''" x-show="search !== ''" x-cloak>
                        Clear
                    </button>
                </div>
            </div>
            
            <div class="flex flex-col lg:flex-row gap-10 lg:items-start relative">
                
                {{-- Sticky Categories Sidebar --}}
                <div class="lg:w-1/4 shrink-0 lg:sticky lg:top-24 hidden lg:block">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-500 mb-4">Categories</h3>
                    <nav class="flex flex-col space-y-1">
                        <button type="button" @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-left text-sm font-semibold transition-all">
                            All Questions
                        </button>
                        @foreach ($categories as $category)
                            @if($category->publishedFaqs->isNotEmpty())
                                <button type="button" @click="activeCategory = '{{ $category->slug ?? $category->id }}'" :class="activeCategory === '{{ $category->slug ?? $category->id }}' ? 'bg-primary text-white shadow-md' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2.5 rounded-xl text-left text-sm font-semibold transition-all">
                                    {{ $category->name }}
                                </button>
                            @endif
                        @endforeach
                    </nav>
                </div>

                {{-- FAQs Accordion --}}
                <div class="lg:w-3/4 flex-1">
                    <div class="space-y-12">
                        @foreach ($categories as $category)
                            <div 
                                x-show="(activeCategory === 'all' || activeCategory === '{{ $category->slug ?? $category->id }}') && {{ $category->publishedFaqs->isNotEmpty() ? 'true' : 'false' }}"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                            >
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                        <i data-lucide="help-circle" class="h-4 w-4"></i>
                                    </div>
                                    <h2 class="text-xl font-bold text-slate-900">{{ $category->name }}</h2>
                                </div>
                                <div class="space-y-3">
                                    @foreach ($category->publishedFaqs as $faq)
                                        <div
                                            x-show="matches({{ Js::from($faq->question) }}) || matches({{ Js::from($faq->answer) }})"
                                            x-data="{ open: false }"
                                            class="overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all shadow-sm hover:shadow-md"
                                            :class="open ? 'ring-1 ring-primary/20' : ''"
                                        >
                                            <button
                                                type="button"
                                                class="flex w-full items-center justify-between gap-6 px-6 py-5 text-left transition hover:bg-slate-50 group"
                                                @click="open = !open"
                                                :aria-expanded="open"
                                            >
                                                <span class="font-bold text-slate-900 group-hover:text-primary transition pr-8 text-base">{{ $faq->question }}</span>
                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-100 group-hover:bg-primary/10 group-hover:text-primary transition" :class="open ? 'bg-primary/10 text-primary' : 'text-slate-400'">
                                                    <i data-lucide="chevron-down" class="h-5 w-5 transition-transform duration-300" :class="open && 'rotate-180'"></i>
                                                </div>
                                            </button>
                                            <div
                                                x-show="open"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 -translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 translate-y-0"
                                                x-transition:leave-end="opacity-0 -translate-y-2"
                                                x-cloak
                                            >
                                                <div class="px-6 pb-6 pt-2 text-base leading-relaxed text-slate-600 prose prose-slate max-w-none">
                                                    {{ $faq->answer }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div x-show="search !== ''" class="mt-12 rounded-2xl border-2 border-dashed border-slate-200 bg-white p-10 text-center" x-cloak>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-primary/10 text-primary mb-4">
                            <i data-lucide="message-square" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Can't find what you're looking for?</h3>
                        <p class="mt-2 text-slate-500 max-w-sm mx-auto mb-6">Our support team is always ready to help you with any specific questions.</p>
                        <a href="{{ route('contact') }}" class="btn-primary">
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-section>
@endsection
