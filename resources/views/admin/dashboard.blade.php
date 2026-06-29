@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_heading', 'Dashboard')

@section('content')
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card">
            <p class="text-sm text-slate-500">News Articles</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">0</p>
        </div>
        <div class="card">
            <p class="text-sm text-slate-500">Providers</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">0</p>
        </div>
        <div class="card">
            <p class="text-sm text-slate-500">FAQs</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">0</p>
        </div>
        <div class="card">
            <p class="text-sm text-slate-500">Messages</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">0</p>
        </div>
    </div>

    <div class="mt-8 card">
        <h2 class="text-lg font-semibold text-slate-900">Admin Panel</h2>
        <p class="mt-2 text-sm text-slate-600">
            CMS modules will be connected in Phase 4. This shell provides the layout, sidebar navigation, and responsive structure.
        </p>
        <div class="mt-6 flex flex-wrap gap-3">
            <span class="rounded-full bg-primary-50 px-3 py-1 text-xs font-medium text-primary">Phase 1 Complete</span>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">Auth in Phase 4</span>
        </div>
    </div>
@endsection
