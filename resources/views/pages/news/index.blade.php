@extends('layouts.app')

@section('title', 'News & Updates')
@section('meta_description', 'Latest news, health campaigns, activities, and press releases from PLASCHEMA.')

@section('content')
    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-16 text-white sm:py-20 lg:py-24">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="text-sm text-white/60 mb-8">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">News</span>
            </nav>
            
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Latest from<br>
                    <span class="bg-gradient-to-r from-emerald-300 to-cyan-300 bg-clip-text text-transparent">PLASCHEMA.</span>
                </h1>
                <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-300">
                    Stay informed about our activities, health campaigns, press releases, and announcements.
                </p>
            </div>
        </div>
    </section>

    <x-section class="bg-slate-50/50" padding="sm">
        {{-- Search and Categories --}}
        <div class="relative -mt-24 mb-10 z-10 mx-auto max-w-7xl">
            <div class="rounded-2xl bg-white p-4 sm:p-6 shadow-xl shadow-slate-200/50 ring-1 ring-slate-200 flex flex-col md:flex-row gap-4 items-center justify-between">
                {{-- Categories --}}
                <div class="flex-1 w-full overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
                    <div class="flex gap-2 w-max">
                        @foreach ($categories as $key => $label)
                            <a
                                href="{{ route('news', array_merge(request()->query(), ['category' => $key ?: null, 'page' => null])) }}"
                                class="rounded-full px-4 py-2 text-sm font-semibold transition {{ ($category ?? '') === $key ? 'bg-primary text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-900' }}"
                            >
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                {{-- Search --}}
                <form method="GET" action="{{ route('news') }}" class="w-full md:w-80 shrink-0 relative flex">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i data-lucide="search" class="h-4 w-4 text-slate-400"></i>
                    </div>
                    <input type="search" name="q" value="{{ $search ?? '' }}" placeholder="Search articles..."
                        class="block w-full rounded-l-xl border-0 py-2.5 pl-10 pr-3 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                    <button type="submit" class="bg-primary hover:bg-primary-700 text-white px-4 py-2.5 rounded-r-xl transition text-sm font-semibold">
                        Search
                    </button>
                </form>
            </div>
        </div>

        @if ($search || $category)
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Search Results</h2>
                    <p class="text-sm text-slate-500 mt-1">
                        @if($search) Showing results for "<span class="font-semibold text-slate-900">{{ $search }}</span>" @endif
                        @if($category) in category "<span class="font-semibold text-slate-900">{{ $categories[$category] ?? $category }}</span>" @endif
                    </p>
                </div>
                <a href="{{ route('news') }}" class="text-sm font-medium text-primary hover:underline underline-offset-4">Clear filters</a>
            </div>
        @endif

        @if (!$search && !$category && $featured)
            {{-- Featured Article --}}
            <div class="mb-12">
                <a href="{{ route('news.show', $featured->slug) }}" class="group block overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                    <div class="grid md:grid-cols-2">
                        <div class="relative aspect-[4/3] md:aspect-auto h-full w-full overflow-hidden bg-slate-100">
                            @if ($featured->featured_image)
                                <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-secondary-50 flex items-center justify-center transition duration-500 group-hover:scale-105">
                                    <i data-lucide="newspaper" class="h-16 w-16 text-primary/20"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-center p-6 sm:p-10">
                            <div class="mb-4 flex items-center gap-3">
                                <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-primary">
                                    Featured
                                </span>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">{{ $featured->categoryLabel() }}</span>
                            </div>
                            <h2 class="mb-4 text-2xl font-bold text-slate-900 transition group-hover:text-primary sm:text-3xl lg:text-4xl leading-tight">
                                {{ $featured->title }}
                            </h2>
                            <p class="mb-6 text-base text-slate-600 line-clamp-3 leading-relaxed">{{ $featured->excerpt }}</p>
                            <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-6">
                                <div class="flex items-center gap-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    <span class="flex items-center gap-1.5"><i data-lucide="calendar" class="h-4 w-4"></i> {{ $featured->published_at->format('M j, Y') }}</span>
                                    <span class="flex items-center gap-1.5"><i data-lucide="clock" class="h-4 w-4"></i> {{ $featured->reading_time }} min read</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            <h3 class="text-xl font-bold text-slate-900 mb-6">Latest Articles</h3>
        @endif

        {{-- Results --}}
        @if ($articles->isEmpty() && !$featured)
            <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-white p-12 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50">
                    <i data-lucide="newspaper" class="h-8 w-8 text-slate-400"></i>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">No articles found</h3>
                <p class="mt-2 text-sm text-slate-500 max-w-sm mx-auto">We couldn't find any articles matching your search or filter criteria.</p>
                @if ($search || $category)
                    <div class="mt-6">
                        <a href="{{ route('news') }}" class="btn-outline">Clear filters</a>
                    </div>
                @endif
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-news-card :article="$article" />
                @endforeach
            </div>

            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        @endif
    </x-section>
@endsection
