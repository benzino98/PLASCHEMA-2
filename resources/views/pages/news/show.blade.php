@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->excerpt)

@push('head')
    <meta property="og:title" content="{{ $article->title }}" />
    <meta property="og:description" content="{{ $article->excerpt }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ request()->url() }}" />
    @if($article->featured_image)
        <meta property="og:image" content="{{ asset('storage/' . $article->featured_image) }}" />
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ asset('storage/' . $article->featured_image) }}">
    @endif
    <style>
        .prose p { margin-bottom: 1.25rem; line-height: 1.8; color: #334155; }
        .prose p:last-child { margin-bottom: 0; }
        .prose h2 { margin-top: 2rem; margin-bottom: 1rem; color: #0f172a; font-weight: 700; font-size: 1.5rem; }
        .prose h3 { margin-top: 1.5rem; margin-bottom: 0.75rem; color: #0f172a; font-weight: 600; font-size: 1.25rem; }
        .prose ul { margin-bottom: 1.25rem; padding-left: 1.5rem; list-style-type: disc; color: #334155; }
        .prose li { margin-bottom: 0.5rem; }
        .prose a { color: #0B8F4D; text-decoration: underline; text-underline-offset: 2px; font-weight: 500; }
        .prose blockquote { border-left: 4px solid #0B8F4D; padding-left: 1rem; font-style: italic; color: #475569; margin: 1.5rem 0; }
        .prose img { border-radius: 0.75rem; margin: 2rem auto; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
    </style>
@endpush

@section('content')
    <article class="bg-white pb-16 sm:pb-24">
        {{-- Hero Header --}}
        <div class="relative pt-8 pb-12 sm:pt-12 border-b border-slate-100 bg-slate-50/50">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <x-breadcrumbs :items="[
                    ['label' => 'News', 'route' => 'news'],
                    ['label' => $article->categoryLabel(), 'route' => 'news', 'params' => ['category' => $article->category]],
                    ['label' => Str::limit($article->title, 40)],
                ]" class="mb-8" />
                
                <div class="text-center max-w-3xl mx-auto">
                    <span class="inline-flex items-center rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-primary mb-6">
                        {{ $article->categoryLabel() }}
                    </span>
                    
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl md:text-5xl lg:leading-tight mb-8">
                        {{ $article->title }}
                    </h1>
                    
                    <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-slate-500 font-medium">
                        <span class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-600">
                                <i data-lucide="user" class="h-4 w-4"></i>
                            </div>
                            PLASCHEMA Media
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="calendar" class="h-4 w-4 text-slate-400"></i> 
                            {{ $article->published_at->format('F j, Y') }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <i data-lucide="clock" class="h-4 w-4 text-slate-400"></i> 
                            {{ $article->reading_time }} min read
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Featured Image --}}
        @if ($article->featured_image)
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
                <div class="aspect-[16/9] w-full overflow-hidden rounded-2xl bg-slate-100 shadow-xl shadow-slate-200/50 ring-1 ring-slate-900/5">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="h-full w-full object-cover">
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 mt-12 sm:mt-16 flex flex-col lg:flex-row gap-12">
            
            {{-- Social Share Sidebar --}}
            <div class="hidden lg:block w-16 shrink-0 relative">
                <div class="sticky top-24 flex flex-col items-center gap-4 border-r border-slate-100 pr-6">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 writing-vertical-rl rotate-180">Share</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 text-slate-500 transition hover:bg-[#1DA1F2] hover:text-white" title="Share on Twitter">
                        <i data-lucide="twitter" class="h-4 w-4"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 text-slate-500 transition hover:bg-[#4267B2] hover:text-white" title="Share on Facebook">
                        <i data-lucide="facebook" class="h-4 w-4"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 text-slate-500 transition hover:bg-[#0A66C2] hover:text-white" title="Share on LinkedIn">
                        <i data-lucide="linkedin" class="h-4 w-4"></i>
                    </a>
                    <button type="button" onclick="navigator.clipboard.writeText('{{ request()->url() }}'); window.notyf.success('Link copied to clipboard');" class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-50 text-slate-500 transition hover:bg-slate-200 hover:text-slate-900 mt-4" title="Copy Link">
                        <i data-lucide="link-2" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>

            {{-- Article Body --}}
            <div class="flex-1 min-w-0">
                @if($article->excerpt)
                    <p class="text-xl text-slate-500 leading-relaxed font-medium mb-10 pb-10 border-b border-slate-100">
                        {{ $article->excerpt }}
                    </p>
                @endif
                
                <div class="prose max-w-none">
                    {!! $article->body !!}
                </div>
                
                {{-- Mobile Share --}}
                <div class="mt-12 pt-8 border-t border-slate-100 lg:hidden flex items-center justify-center gap-4">
                    <span class="text-sm font-semibold text-slate-500 uppercase tracking-wider mr-2">Share:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}" target="_blank" rel="noopener noreferrer" class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-50 text-slate-600 transition hover:bg-[#1DA1F2] hover:text-white">
                        <i data-lucide="twitter" class="h-5 w-5"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener noreferrer" class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-50 text-slate-600 transition hover:bg-[#4267B2] hover:text-white">
                        <i data-lucide="facebook" class="h-5 w-5"></i>
                    </a>
                    <button type="button" onclick="navigator.clipboard.writeText('{{ request()->url() }}'); window.notyf.success('Link copied to clipboard');" class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-50 text-slate-600 transition hover:bg-slate-200 hover:text-slate-900">
                        <i data-lucide="link-2" class="h-5 w-5"></i>
                    </button>
                </div>
            </div>
            
        </div>
    </article>

    @if ($related->isNotEmpty())
        <x-section title="More {{ $article->categoryLabel() }}s" class="bg-slate-50 border-t border-slate-200/60" padding="sm">
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($related as $item)
                    <x-news-card :article="$item" />
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="{{ route('news', ['category' => $article->category]) }}" class="btn-outline">
                    View all {{ strtolower($article->categoryLabel()) }}s <i data-lucide="arrow-right" class="h-4 w-4 ml-1"></i>
                </a>
            </div>
        </x-section>
    @endif
@endsection
