@extends('layouts.app')

@section('title', 'About')
@section('meta_description', $page->meta_description)

@section('content')
    @php
        $mission = $page->section('mission');
        $vision = $page->section('vision');
        $objectives = $page->section('objectives');
        $dg = $page->section('dg_profile');
        $history = $page->section('history');
        $gallery = $page->section('gallery');
        $dgData = $dg?->jsonContent() ?? [];
        $objectivesList = $objectives?->jsonContent() ?? [];
        $historyItems = $history?->jsonContent() ?? [];
        $galleryItems = $gallery?->jsonContent() ?? [];
    @endphp

    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[['label' => 'About']]" />
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $page->title }}</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">{{ $page->meta_description }}</p>
        </div>
    </div>

    {{-- Mission, Vision, Objectives --}}
    <x-section class="bg-white">
        <div class="grid gap-8 lg:grid-cols-3">
            @if ($mission)
                <div class="card">
                    <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-primary-50">
                        <i data-lucide="target" class="h-5 w-5 text-primary"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ $mission->title }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $mission->content }}</p>
                </div>
            @endif
            @if ($vision)
                <div class="card">
                    <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-secondary-50">
                        <i data-lucide="eye" class="h-5 w-5 text-secondary"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ $vision->title }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $vision->content }}</p>
                </div>
            @endif
            @if ($objectives)
                <div class="card">
                    <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-accent-50">
                        <i data-lucide="list-checks" class="h-5 w-5 text-accent"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ $objectives->title }}</h2>
                    <ul class="mt-3 space-y-2">
                        @foreach ($objectivesList as $objective)
                            <li class="flex items-start gap-2 text-sm text-slate-600">
                                <i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-primary"></i>
                                {{ $objective }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </x-section>

    {{-- Director General --}}
    @if ($dg)
        <x-section title="Leadership" subtitle="Director General" class="bg-surface">
            <div class="mx-auto max-w-3xl">
                <div class="card flex flex-col items-center text-center sm:flex-row sm:text-left sm:items-start gap-6">
                    <div class="flex h-28 w-28 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-primary to-secondary text-3xl font-bold text-white">
                        {{ strtoupper(substr($dgData['name'] ?? 'DG', 4, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $dgData['name'] ?? 'Director General' }}</h3>
                        <p class="text-sm font-medium text-primary">{{ $dgData['title'] ?? '' }}</p>
                        <p class="mt-4 text-sm leading-relaxed text-slate-600">{{ $dgData['bio'] ?? '' }}</p>
                    </div>
                </div>
            </div>
        </x-section>
    @endif

    {{-- Organogram placeholder --}}
    <x-section title="Organizational Structure" subtitle="Organogram" centered class="bg-white">
        <div class="card mx-auto max-w-4xl text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                <i data-lucide="network" class="h-8 w-8 text-slate-400"></i>
            </div>
            <p class="text-sm text-slate-500">Organogram image will be added here. Replace with your official organizational chart.</p>
            <div class="mt-8 flex flex-col items-center gap-4">
                <div class="rounded-lg bg-primary px-6 py-3 text-sm font-semibold text-white">Director General</div>
                <div class="h-6 w-px bg-slate-300"></div>
                <div class="flex flex-wrap justify-center gap-4">
                    @foreach (['Operations', 'Finance', 'ICT', 'Provider Relations', 'Monitoring & Evaluation'] as $dept)
                        <div class="rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-medium text-slate-700">{{ $dept }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-section>

    {{-- History --}}
    @if (count($historyItems))
        <x-section title="Our History" subtitle="Timeline" class="bg-surface">
            <div class="mx-auto max-w-3xl">
                <div class="relative space-y-8 before:absolute before:left-4 before:top-2 before:h-[calc(100%-1rem)] before:w-0.5 before:bg-primary/20 sm:before:left-1/2">
                    @foreach ($historyItems as $item)
                        <div class="relative flex flex-col sm:flex-row sm:items-center {{ $loop->even ? 'sm:flex-row-reverse' : '' }}">
                            <div class="absolute left-4 h-3 w-3 -translate-x-1/2 rounded-full bg-primary sm:left-1/2"></div>
                            <div class="w-full sm:w-1/2 {{ $loop->even ? 'sm:pl-10 sm:text-left' : 'sm:pr-10 sm:text-right' }} pl-10 sm:pl-0">
                                <span class="text-sm font-bold text-primary">{{ $item['year'] }}</span>
                                <p class="mt-1 text-sm text-slate-600">{{ $item['event'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-section>
    @endif

    {{-- Gallery --}}
    @if (count($galleryItems))
        <x-section title="Gallery" subtitle="In Pictures" centered class="bg-white" padding="lg">
            <div id="gallery" class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:gap-4">
                @foreach ($galleryItems as $item)
                    <a href="{{ $item['src'] }}" class="group relative overflow-hidden rounded-[var(--radius-card)]" data-sub-html="<h4>{{ $item['caption'] }}</h4>">
                        <img src="{{ $item['src'] }}" alt="{{ $item['caption'] }}" class="aspect-[4/3] w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 flex items-end bg-gradient-to-t from-slate-900/60 to-transparent p-4 opacity-0 transition group-hover:opacity-100">
                            <span class="text-sm font-medium text-white">{{ $item['caption'] }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </x-section>
    @endif
@endsection

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.8.3/css/lightgallery-bundle.min.css">
@endpush

@push('scripts')
    <script type="module">
        import lightGallery from 'lightgallery';
        import lgThumbnail from 'lightgallery/plugins/thumbnail';
        import lgZoom from 'lightgallery/plugins/zoom';

        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('gallery');
            if (el) {
                lightGallery(el, {
                    plugins: [lgThumbnail, lgZoom],
                    speed: 400,
                    selector: 'a',
                });
            }
        });
    </script>
@endpush
