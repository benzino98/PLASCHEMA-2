@extends('layouts.app')

@section('title', 'Resources & Downloads')
@section('meta_description', 'Download PLASCHEMA forms, policies, guidelines, reports, and circulars.')

@section('content')
    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[['label' => 'Resources']]" />
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Resources &amp; Downloads</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">Forms, policies, guidelines, reports, and official circulars.</p>
        </div>
    </div>

    <x-section class="bg-white">
        <div class="mb-8 flex flex-wrap gap-2">
            @foreach ($categories as $key => $label)
                <a
                    href="{{ route('resources', $key ? ['category' => $key] : []) }}"
                    class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ ($category ?? '') === $key ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if ($allDownloads->isEmpty())
            <div class="card text-center">
                <p class="text-slate-500">No downloads available in this category.</p>
            </div>
        @else
            <div class="space-y-8">
                @if ($category)
                    @include('pages.resources._list', ['items' => $allDownloads])
                @else
                    @foreach ($downloads as $cat => $items)
                        <div>
                            <h2 class="mb-4 text-lg font-semibold text-slate-900">
                                {{ match($cat) {
                                    'form' => 'Forms',
                                    'policy' => 'Policies',
                                    'guideline' => 'Guidelines',
                                    'report' => 'Reports',
                                    'circular' => 'Circulars',
                                    default => ucfirst($cat),
                                } }}
                            </h2>
                            @include('pages.resources._list', ['items' => $items])
                        </div>
                    @endforeach
                @endif
            </div>
        @endif
    </x-section>
@endsection
