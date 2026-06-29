@extends('layouts.app')

@section('title', 'Contact Us')
@section('meta_description', 'Contact PLASCHEMA — office address, hotlines, email, and contact form.')

@section('content')
    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[['label' => 'Contact']]" />
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Contact Us</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">We're here to help. Reach out via the form below or use our contact details.</p>
        </div>
    </div>

    <x-section class="bg-white">
        <div class="grid gap-10 lg:grid-cols-2">
            {{-- Contact form --}}
            <div class="card">
                <h2 class="text-lg font-semibold text-slate-900">Send a Message</h2>
                <p class="mt-1 text-sm text-slate-500">Fill out the form and we'll respond as soon as possible.</p>

                <form action="{{ route('contact.store') }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-4 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary @error('name') border-red-400 @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-4 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary @error('email') border-red-400 @enderror">
                        @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-medium text-slate-700">Subject</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-4 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary @error('subject') border-red-400 @enderror">
                        @error('subject')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-slate-700">Message</label>
                        <textarea name="message" id="message" rows="5" required
                            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-4 py-2.5 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn-primary w-full sm:w-auto">
                        <i data-lucide="send" class="h-4 w-4"></i>
                        Send Message
                    </button>
                </form>
            </div>

            {{-- Contact info --}}
            <div class="space-y-6">
                <div class="card">
                    <h2 class="text-lg font-semibold text-slate-900">Office Address</h2>
                    <ul class="mt-4 space-y-4 text-sm text-slate-600">
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="mt-0.5 h-5 w-5 shrink-0 text-primary"></i>
                            <span>{{ config('plaschema.contact.address') }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i data-lucide="mail" class="h-5 w-5 shrink-0 text-primary"></i>
                            <a href="mailto:{{ config('plaschema.contact.email') }}" class="hover:text-primary">{{ config('plaschema.contact.email') }}</a>
                        </li>
                        @if (config('plaschema.contact.phone'))
                            <li class="flex items-center gap-3">
                                <i data-lucide="phone" class="h-5 w-5 shrink-0 text-primary"></i>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('plaschema.contact.phone')) }}" class="hover:text-primary">{{ config('plaschema.contact.phone') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="card">
                    <h2 class="text-lg font-semibold text-slate-900">Hotlines</h2>
                    <ul class="mt-4 space-y-3">
                        @foreach (config('navigation.emergency_numbers') as $emergency)
                            <li class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">{{ $emergency['label'] }}</span>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $emergency['number']) }}" class="font-semibold text-primary">{{ $emergency['number'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card">
                    <h2 class="text-lg font-semibold text-slate-900">Follow Us</h2>
                    <div class="mt-4 flex gap-3">
                        @foreach (config('navigation.social') as $social)
                            <a href="{{ $social['url'] }}" class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition hover:bg-primary hover:text-white" aria-label="{{ $social['label'] }}" target="_blank" rel="noopener noreferrer">
                                <i data-lucide="{{ $social['icon'] }}" class="h-4 w-4"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-section>

    {{-- Google Map --}}
    <section class="bg-surface">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <h2 class="mb-6 text-lg font-semibold text-slate-900">Find Us on the Map</h2>
            <div class="overflow-hidden rounded-[var(--radius-card)] border border-slate-200 shadow-sm">
                <iframe
                    title="PLASCHEMA Office Location"
                    src="https://maps.google.com/maps?q=Jos,+Plateau+State,+Nigeria&output=embed"
                    class="h-80 w-full border-0 sm:h-96"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </section>
@endsection
