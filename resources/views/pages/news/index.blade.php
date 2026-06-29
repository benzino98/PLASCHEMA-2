@extends('layouts.app')

@section('title', 'News & Updates')
@section('meta_description', 'Latest news, health campaigns, activities, and press releases from PLASCHEMA.')

@section('content')
    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[['label' => 'News']]" />
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">News &amp; Updates</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">Stay informed about PLASCHEMA activities, health campaigns, and announcements.</p>
        </div>
    </div>

    <x-section class="bg-white">
        {{-- Category filters --}}
        <div class="mb-8 flex flex-wrap gap-2">
            @foreach ($categories as $key => $label)
                <a
                    href="{{ route('news', $key ? ['category' => $key] : []) }}"
                    class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ ($category ?? '') === $key ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($articles->isEmpty())
            <div class="card text-center">
                <p class="text-slate-500">No articles found in this category.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-news-card :article="$article" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $articles->links() }}
            </div>
        @endif
    </x-section>
@endsection
