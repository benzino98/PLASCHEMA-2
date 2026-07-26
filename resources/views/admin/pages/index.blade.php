@extends('layouts.admin')

@section('title', 'Pages')
@section('page_heading', 'Pages')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Website Pages</h2>
        <p class="mt-1 text-sm text-slate-600">Manage page metadata and structured public content.</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($pages as $page)
            <article class="card flex flex-col">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary-50">
                        <i data-lucide="file-text" class="h-5 w-5 text-primary"></i>
                    </div>
                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                        {{ $page->sections_count }} sections
                    </span>
                </div>
                <h3 class="text-lg font-semibold text-slate-900">{{ $page->title }}</h3>
                <p class="mt-2 flex-1 text-sm leading-6 text-slate-600">{{ $page->meta_description }}</p>
                <div class="mt-6 flex items-center justify-between border-t border-slate-100 pt-4">
                    <a href="{{ url('/'.$page->slug) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 hover:text-primary">
                        <i data-lucide="external-link" class="h-4 w-4"></i>
                        Preview
                    </a>
                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn-primary px-4 py-2">
                        <i data-lucide="pencil" class="h-4 w-4"></i>
                        Edit content
                    </a>
                </div>
            </article>
        @empty
            <div class="card md:col-span-2 xl:col-span-3 text-center">
                <i data-lucide="file-x" class="mx-auto h-10 w-10 text-slate-400"></i>
                <p class="mt-3 text-sm font-semibold text-slate-900">No pages found</p>
            </div>
        @endforelse
    </div>
@endsection
