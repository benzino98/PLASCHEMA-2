@extends('layouts.app')

@section('title', $title)
@section('meta_description', $description)

@section('content')
    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[['label' => $title]]" />
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $title }}</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">{{ $description }}</p>
        </div>
    </div>

    <x-section>
        <div class="mx-auto max-w-2xl text-center">
            <div class="card">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-primary-50">
                    <i data-lucide="construction" class="h-7 w-7 text-primary"></i>
                </div>
                <h2 class="text-xl font-semibold text-slate-900">Coming in Phase 2</h2>
                <p class="mt-2 text-slate-600">
                    This page will be built out with full content in the next phase. The layout, navigation, and design system are ready.
                </p>
                <a href="{{ route('home') }}" class="btn-primary mt-6 inline-flex">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </x-section>
@endsection
