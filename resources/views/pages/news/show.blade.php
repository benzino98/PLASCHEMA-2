@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->excerpt)

@section('content')
    <article>
        <div class="page-hero border-b border-slate-200/60">
            <div class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
                <x-breadcrumbs :items="[
                    ['label' => 'News', 'route' => 'news'],
                    ['label' => $article->title],
                ]" />
                <span class="text-xs font-semibold uppercase tracking-wider text-primary">{{ $article->categoryLabel() }}</span>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $article->title }}</h1>
                <p class="mt-4 text-sm text-slate-500">Published {{ $article->published_at->format('F j, Y') }}</p>
            </div>
        </div>

        <x-section padding="sm" class="bg-white">
            <div class="prose prose-slate mx-auto max-w-3xl prose-headings:text-slate-900 prose-a:text-primary">
                {!! $article->body !!}
            </div>
        </x-section>
    </article>

    @if ($related->isNotEmpty())
        <x-section title="Related Articles" class="bg-surface" padding="sm">
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($related as $item)
                    <x-news-card :article="$item" />
                @endforeach
            </div>
        </x-section>
    @endif
@endsection

@push('head')
    <style>
        .prose p { margin-bottom: 1rem; line-height: 1.75; color: #475569; }
        .prose p:last-child { margin-bottom: 0; }
    </style>
@endpush
