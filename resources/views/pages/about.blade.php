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

    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-20 text-white sm:py-24 lg:py-28">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="text-sm text-white/60">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">About</span>
            </nav>
            <div class="mt-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-emerald-200 backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>Established 2018
                </div>
                <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Building a healthier<br>
                    <span class="bg-gradient-to-r from-emerald-300 to-cyan-300 bg-clip-text text-transparent">Plateau State.</span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">{{ $page->meta_description }}</p>
            </div>
        </div>
    </section>

    {{-- Mission, Vision, Objectives --}}
    <x-section class="bg-white" padding="lg">
        <div class="mx-auto max-w-3xl text-center mb-12">
            <p class="text-sm font-semibold uppercase tracking-wider text-primary">What Drives Us</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Our Foundation</h2>
        </div>
        <div class="grid gap-8 lg:grid-cols-3">
            @if ($mission)
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-8 transition hover:shadow-lg hover:shadow-primary/5">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-primary/5 transition group-hover:scale-150"></div>
                    <div class="relative">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-primary to-emerald-600 text-white shadow-lg shadow-primary/20">
                            <i data-lucide="target" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $mission->title }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $mission->content }}</p>
                    </div>
                </div>
            @endif
            @if ($vision)
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-8 transition hover:shadow-lg hover:shadow-secondary/5">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-secondary/5 transition group-hover:scale-150"></div>
                    <div class="relative">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-secondary to-blue-600 text-white shadow-lg shadow-secondary/20">
                            <i data-lucide="eye" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $vision->title }}</h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $vision->content }}</p>
                    </div>
                </div>
            @endif
            @if ($objectives)
                <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-8 transition hover:shadow-lg hover:shadow-accent/5">
                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-accent/5 transition group-hover:scale-150"></div>
                    <div class="relative">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-accent to-orange-600 text-white shadow-lg shadow-accent/20">
                            <i data-lucide="list-checks" class="h-6 w-6"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $objectives->title }}</h3>
                        <ul class="mt-3 space-y-2.5">
                            @foreach ($objectivesList as $objective)
                                <li class="flex items-start gap-2.5 text-sm text-slate-600">
                                    <span class="mt-1 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                        <i data-lucide="check" class="h-2.5 w-2.5 text-primary"></i>
                                    </span>
                                    {{ $objective }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </x-section>

    {{-- Director General --}}
    @if ($dg)
        <section class="bg-slate-50 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center mb-12">
                    <p class="text-sm font-semibold uppercase tracking-wider text-primary">Leadership</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Director General</h2>
                </div>
                <div class="mx-auto max-w-4xl">
                    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-br from-primary/10 via-secondary/5 to-transparent"></div>
                        <div class="relative flex flex-col items-center px-8 py-10 text-center sm:flex-row sm:items-start sm:text-left sm:gap-8">
                            @if (!empty($dgData['photo']))
                                <img
                                    src="{{ asset('storage/' . $dgData['photo']) }}"
                                    alt="{{ $dgData['name'] ?? 'Director General' }}"
                                    class="h-36 w-36 shrink-0 rounded-2xl object-cover shadow-lg ring-4 ring-white"
                                    loading="lazy"
                                >
                            @else
                                <div class="flex h-36 w-36 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-primary to-secondary text-4xl font-bold text-white shadow-lg ring-4 ring-white">
                                    {{ strtoupper(substr($dgData['name'] ?? 'DG', 0, 2)) }}
                                </div>
                            @endif
                            <div class="mt-6 sm:mt-2">
                                <h3 class="text-2xl font-bold text-slate-900">{{ $dgData['name'] ?? 'Director General' }}</h3>
                                <p class="mt-1 text-sm font-semibold text-primary">{{ $dgData['title'] ?? 'Director General, PLASCHEMA' }}</p>
                                <div class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                                    <i data-lucide="award" class="h-3 w-3"></i>
                                    Director General
                                </div>
                                <p class="mt-5 text-sm leading-relaxed text-slate-600">{{ $dgData['bio'] ?? 'Biography will be updated shortly.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Organogram --}}
    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center mb-12">
                <p class="text-sm font-semibold uppercase tracking-wider text-primary">Structure</p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Organizational Structure</h2>
                <p class="mt-4 text-slate-500">How PLASCHEMA is organized to serve you better.</p>
            </div>
            <div class="mx-auto max-w-5xl">
                <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-8 sm:p-12">
                    {{-- Top level --}}
                    <div class="flex flex-col items-center gap-6">
                        <div class="rounded-xl bg-gradient-to-r from-primary to-emerald-600 px-8 py-4 text-center text-white shadow-lg shadow-primary/20">
                            <p class="text-xs font-semibold uppercase tracking-wider text-white/70">Office of the</p>
                            <p class="mt-1 text-lg font-bold">Director General</p>
                        </div>
                        <div class="h-8 w-px bg-slate-300"></div>

                        {{-- Second tier --}}
                        <div class="grid w-full grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach (['Director of Operations' => 'clipboard-list', 'Director of Finance & Admin' => 'wallet'] as $role => $icon)
                                <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-secondary/10">
                                        <i data-lucide="{{ $icon }}" class="h-4 w-4 text-secondary"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $role }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="h-6 w-px bg-slate-300"></div>

                        {{-- Department tier --}}
                        <div class="grid w-full grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                            @foreach ([
                                'ICT & Data' => 'monitor',
                                'Provider Relations' => 'handshake',
                                'M & E' => 'bar-chart-3',
                                'Enrollment' => 'users',
                                'Public Affairs' => 'megaphone',
                            ] as $dept => $icon)
                                <div class="flex flex-col items-center gap-2 rounded-xl border border-slate-200 bg-white p-4 text-center transition hover:border-primary/30 hover:shadow-sm">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/5">
                                        <i data-lucide="{{ $icon }}" class="h-4 w-4 text-primary/70"></i>
                                    </div>
                                    <p class="text-xs font-medium text-slate-700">{{ $dept }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <p class="mt-8 text-center text-xs text-slate-400">This organogram is a simplified representation. Contact us for the full organizational chart.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- History Timeline --}}
    @if (count($historyItems))
        <section class="bg-slate-50 py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center mb-12">
                    <p class="text-sm font-semibold uppercase tracking-wider text-primary">Our Journey</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">History & Milestones</h2>
                </div>
                <div class="mx-auto max-w-3xl">
                    <div class="relative">
                        {{-- Timeline line --}}
                        <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary/40 via-primary/20 to-transparent sm:left-1/2 sm:-translate-x-px"></div>

                        <div class="space-y-10">
                            @foreach ($historyItems as $item)
                                <div class="relative flex flex-col sm:flex-row sm:items-start {{ $loop->even ? 'sm:flex-row-reverse' : '' }}">
                                    {{-- Dot --}}
                                    <div class="absolute left-5 -translate-x-1/2 sm:left-1/2">
                                        <div class="flex h-4 w-4 items-center justify-center rounded-full border-2 border-primary bg-white shadow-sm">
                                            <div class="h-1.5 w-1.5 rounded-full bg-primary"></div>
                                        </div>
                                    </div>

                                    {{-- Content --}}
                                    <div class="w-full sm:w-1/2 {{ $loop->even ? 'sm:pl-12 sm:text-left' : 'sm:pr-12 sm:text-right' }} pl-12 sm:pl-0">
                                        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-primary/10 px-3 py-1 text-xs font-bold text-primary">
                                                <i data-lucide="calendar" class="h-3 w-3"></i>
                                                {{ $item['year'] }}
                                            </span>
                                            <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $item['event'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery --}}
    @if (count($galleryItems))
        <section class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center mb-12">
                    <p class="text-sm font-semibold uppercase tracking-wider text-primary">In Pictures</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Gallery</h2>
                    <p class="mt-4 text-slate-500">Key moments and activities from PLASCHEMA.</p>
                </div>
                <div id="gallery" class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:gap-4">
                    @foreach ($galleryItems as $item)
                        <a href="{{ $item['src'] }}" class="group relative overflow-hidden rounded-2xl" data-sub-html="<h4>{{ $item['caption'] }}</h4>">
                            <img
                                src="{{ $item['src'] }}"
                                alt="{{ $item['caption'] }}"
                                class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-110"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-slate-900/20 to-transparent opacity-0 transition-all duration-300 group-hover:opacity-100"></div>
                            <div class="absolute inset-x-0 bottom-0 translate-y-full p-4 transition-all duration-300 group-hover:translate-y-0">
                                <span class="text-sm font-medium text-white drop-shadow">{{ $item['caption'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <x-cta
        title="Join PLASCHEMA Today"
        description="Become part of Plateau State's growing healthcare family. Quality, affordable health insurance for you and your loved ones."
        primary-label="Enroll Now"
        :primary-url="config('plaschema.services.enrollment')"
        :primary-external="true"
        secondary-label="Contact Us"
        :secondary-url="route('contact')"
        variant="gradient"
    />
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
