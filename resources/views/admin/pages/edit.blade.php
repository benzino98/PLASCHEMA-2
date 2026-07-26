@extends('layouts.admin')

@section('title', 'Edit '.$page->title)
@section('page_heading', 'Edit Page')

@section('content')
    @php
        $mission = $page->section('mission');
        $vision = $page->section('vision');
        $objectivesData = old('objectives', $objectives);
        $historyData = old('history', $history);
        $galleryData = old('gallery', $gallery);
    @endphp

    <form method="POST" action="{{ route('admin.pages.update', $page) }}" class="space-y-6">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold">Please correct the highlighted fields.</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <h2 class="text-lg font-semibold text-slate-900">Page metadata</h2>
            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700">Page title</label>
                    <input id="title" name="title" value="{{ old('title', $page->title) }}" required class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-semibold text-slate-700">Meta description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" maxlength="320" required class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            @foreach ([['mission', $mission, 'Our Mission'], ['vision', $vision, 'Our Vision']] as [$key, $section, $fallback])
                <section class="card">
                    <h2 class="text-lg font-semibold text-slate-900">{{ $fallback }}</h2>
                    <div class="mt-5 space-y-4">
                        <div>
                            <label for="{{ $key }}_title" class="block text-sm font-semibold text-slate-700">Heading</label>
                            <input id="{{ $key }}_title" name="{{ $key }}_title" value="{{ old($key.'_title', $section?->title ?? $fallback) }}" required class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                        </div>
                        <div>
                            <label for="{{ $key }}_content" class="block text-sm font-semibold text-slate-700">Content</label>
                            <textarea id="{{ $key }}_content" name="{{ $key }}_content" rows="6" required class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old($key.'_content', $section?->content) }}</textarea>
                        </div>
                    </div>
                </section>
            @endforeach
        </div>

        <section class="card" x-data='{ items: @json(array_values($objectivesData ?: [''])) }'>
            <div class="flex items-center justify-between gap-4">
                <h2 class="text-lg font-semibold text-slate-900">Objectives</h2>
                <button type="button" class="btn-outline px-4 py-2" @click="items.push('')"><i data-lucide="plus" class="h-4 w-4"></i>Add objective</button>
            </div>
            <label for="objectives_title" class="mt-5 block text-sm font-semibold text-slate-700">Section heading</label>
            <input id="objectives_title" name="objectives_title" value="{{ old('objectives_title', $page->section('objectives')?->title ?? 'Our Objectives') }}" required class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm">
            <div class="mt-4 space-y-3">
                <template x-for="(item, index) in items" :key="index">
                    <div class="flex gap-3">
                        <label class="sr-only" :for="`objective-${index}`">Objective</label>
                        <input :id="`objective-${index}`" :name="`objectives[${index}]`" x-model="items[index]" required class="block flex-1 rounded-lg border border-slate-300 px-4 py-3 text-sm">
                        <button type="button" class="rounded-lg border border-red-200 px-3 text-red-600" @click="items.splice(index, 1)" :disabled="items.length === 1" aria-label="Remove objective"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                    </div>
                </template>
            </div>
        </section>

        <section class="card">
            <h2 class="text-lg font-semibold text-slate-900">Director General</h2>
            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div><label for="dg_name" class="block text-sm font-semibold text-slate-700">Name</label><input id="dg_name" name="dg_name" value="{{ old('dg_name', $dg['name'] ?? '') }}" required class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
                <div><label for="dg_title" class="block text-sm font-semibold text-slate-700">Position</label><input id="dg_title" name="dg_title" value="{{ old('dg_title', $dg['title'] ?? '') }}" required class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
                <div class="md:col-span-2"><label for="dg_bio" class="block text-sm font-semibold text-slate-700">Biography</label><textarea id="dg_bio" name="dg_bio" rows="6" required class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm">{{ old('dg_bio', $dg['bio'] ?? '') }}</textarea></div>
                <div class="md:col-span-2"><label for="dg_image" class="block text-sm font-semibold text-slate-700">Image URL (optional)</label><input id="dg_image" name="dg_image" type="url" value="{{ old('dg_image', $dg['image'] ?? '') }}" class="mt-2 block w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
            </div>
        </section>

        <section class="card" x-data='{ items: @json(array_values($historyData ?: [['year' => '', 'event' => '']])) }'>
            <div class="flex items-center justify-between gap-4"><h2 class="text-lg font-semibold text-slate-900">History timeline</h2><button type="button" class="btn-outline px-4 py-2" @click="items.push({year:'', event:''})"><i data-lucide="plus" class="h-4 w-4"></i>Add milestone</button></div>
            <div class="mt-5 space-y-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="grid gap-3 rounded-xl border border-slate-200 p-4 md:grid-cols-[8rem_1fr_auto]">
                        <input :name="`history[${index}][year]`" x-model="item.year" placeholder="Year" required class="rounded-lg border border-slate-300 px-4 py-3 text-sm" aria-label="Milestone year">
                        <input :name="`history[${index}][event]`" x-model="item.event" placeholder="Milestone description" required class="rounded-lg border border-slate-300 px-4 py-3 text-sm" aria-label="Milestone description">
                        <button type="button" class="rounded-lg border border-red-200 px-3 text-red-600" @click="items.splice(index, 1)" :disabled="items.length === 1" aria-label="Remove milestone"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                    </div>
                </template>
            </div>
        </section>

        <section class="card" x-data='{ items: @json(array_values($galleryData ?: [])) }'>
            <div class="flex items-center justify-between gap-4"><div><h2 class="text-lg font-semibold text-slate-900">Gallery</h2><p class="mt-1 text-sm text-slate-500">Use secure public image URLs.</p></div><button type="button" class="btn-outline px-4 py-2" @click="items.push({src:'', caption:''})"><i data-lucide="plus" class="h-4 w-4"></i>Add image</button></div>
            <div class="mt-5 space-y-4">
                <template x-for="(item, index) in items" :key="index">
                    <div class="grid gap-3 rounded-xl border border-slate-200 p-4 md:grid-cols-[1fr_1fr_auto]">
                        <input type="url" :name="`gallery[${index}][src]`" x-model="item.src" placeholder="https://…" required class="rounded-lg border border-slate-300 px-4 py-3 text-sm" aria-label="Gallery image URL">
                        <input :name="`gallery[${index}][caption]`" x-model="item.caption" placeholder="Accessible caption" required class="rounded-lg border border-slate-300 px-4 py-3 text-sm" aria-label="Gallery image caption">
                        <button type="button" class="rounded-lg border border-red-200 px-3 text-red-600" @click="items.splice(index, 1)" aria-label="Remove image"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                    </div>
                </template>
            </div>
        </section>

        <div class="sticky bottom-4 flex items-center justify-between rounded-2xl border border-slate-200 bg-white/95 p-4 shadow-lg backdrop-blur">
            <a href="{{ route('admin.pages.index') }}" class="btn-outline"><i data-lucide="arrow-left" class="h-4 w-4"></i>Cancel</a>
            <button type="submit" class="btn-primary"><i data-lucide="save" class="h-4 w-4"></i>Save page</button>
        </div>
    </form>
@endsection
