@extends('layouts.app')

@section('title', 'Resources & Downloads')
@section('meta_description', 'Download PLASCHEMA forms, policies, guidelines, reports, and circulars.')

@section('content')
    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-16 text-white sm:py-20 lg:py-24">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="text-sm text-white/60 mb-8">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Resources</span>
            </nav>
            
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Resources &<br>
                    <span class="bg-gradient-to-r from-emerald-300 to-cyan-300 bg-clip-text text-transparent">Downloads.</span>
                </h1>
                <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-300">
                    Access official forms, policies, operational guidelines, annual reports, and circulars to stay compliant and informed.
                </p>
            </div>
        </div>
    </section>

    <x-section class="bg-slate-50/50" padding="sm">
        <div class="relative -mt-24 mb-12 z-10 mx-auto max-w-7xl">
            <div class="rounded-2xl bg-white p-4 shadow-xl shadow-slate-200/50 ring-1 ring-slate-200 overflow-x-auto hide-scrollbar">
                <div class="flex gap-2 w-max mx-auto sm:mx-0">
                    @foreach ($categories as $key => $label)
                        <a
                            href="{{ route('resources', $key ? ['category' => $key] : []) }}"
                            class="rounded-xl px-5 py-2.5 text-sm font-semibold transition flex items-center gap-2 {{ ($category ?? '') === $key ? 'bg-primary text-white shadow-md shadow-primary/20 ring-1 ring-primary' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-900 border border-slate-200' }}"
                        >
                            @php
                                $icon = match($key) {
                                    'form' => 'file-text',
                                    'policy' => 'shield',
                                    'guideline' => 'book-open',
                                    'report' => 'bar-chart-2',
                                    'circular' => 'bell',
                                    default => 'layers'
                                };
                            @endphp
                            <i data-lucide="{{ $icon }}" class="h-4 w-4 {{ ($category ?? '') === $key ? 'text-white' : 'text-slate-400' }}"></i>
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        @if ($allDownloads->isEmpty())
            <div class="mx-auto max-w-3xl rounded-2xl border-2 border-dashed border-slate-200 bg-white p-12 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50">
                    <i data-lucide="file-x" class="h-8 w-8 text-slate-400"></i>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">No resources available</h3>
                <p class="mt-2 text-sm text-slate-500 max-w-sm mx-auto">There are currently no downloads available in this category. Please check back later.</p>
                @if ($category)
                    <div class="mt-6">
                        <a href="{{ route('resources') }}" class="btn-outline">View all categories</a>
                    </div>
                @endif
            </div>
        @else
            <div class="mx-auto max-w-5xl space-y-12">
                @if ($category)
                    <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                        @include('pages.resources._list', ['items' => $allDownloads])
                    </div>
                @else
                    @foreach ($downloads as $cat => $items)
                        <div class="animate-in fade-in slide-in-from-bottom-4 duration-500" style="animation-delay: {{ $loop->index * 100 }}ms; animation-fill-mode: both;">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                    <i data-lucide="{{ match($cat) { 'form' => 'file-text', 'policy' => 'shield', 'guideline' => 'book-open', 'report' => 'bar-chart-2', 'circular' => 'bell', default => 'folder' } }}" class="h-5 w-5"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-900">
                                    {{ match($cat) {
                                        'form' => 'Forms',
                                        'policy' => 'Policies',
                                        'guideline' => 'Guidelines',
                                        'report' => 'Reports',
                                        'circular' => 'Circulars',
                                        default => ucfirst($cat),
                                    } }}
                                </h2>
                                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-600">{{ $items->count() }}</span>
                            </div>
                            @include('pages.resources._list', ['items' => $items])
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    </x-section>
@endsection
