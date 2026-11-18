@extends('layouts.app')

@section('title', 'Contact Us')
@section('meta_description', 'Contact PLASCHEMA — office address, hotlines, email, and contact form.')

@section('content')
    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-16 text-white sm:py-20 lg:py-24">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <nav aria-label="Breadcrumb" class="text-sm text-white/60 mb-6 justify-center flex">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Contact</span>
            </nav>
            
            <div class="mx-auto max-w-2xl">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Get in <span class="bg-gradient-to-r from-emerald-300 to-cyan-300 bg-clip-text text-transparent">touch.</span>
                </h1>
                <p class="mt-4 text-lg leading-8 text-slate-300">
                    We're here to help. Reach out via the form below, call our hotlines, or visit our office.
                </p>
            </div>
        </div>
    </section>

    <x-section class="bg-slate-50 relative" padding="none">
        <div class="absolute inset-0 h-1/2 bg-slate-950/5"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-16 pb-20">
            
            <div class="grid gap-8 lg:grid-cols-5 items-start">
                
                {{-- Contact Info Cards (Left Side) --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Office Card --}}
                    <div class="rounded-2xl bg-white p-8 shadow-xl shadow-slate-200/50 ring-1 ring-slate-200 relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-primary/5 transition-transform duration-500 group-hover:scale-150"></div>
                        <div class="relative">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-white shadow-lg shadow-primary/30 mb-6">
                                <i data-lucide="map-pin" class="h-6 w-6"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900 mb-2">Head Office</h2>
                            <p class="text-slate-600 leading-relaxed mb-4">
                                {{ config('plaschema.contact.address') }}
                            </p>
                            <a href="https://maps.google.com/?q={{ urlencode(config('plaschema.contact.address')) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm font-semibold text-primary hover:text-primary-700">
                                Get Directions <i data-lucide="arrow-right" class="h-4 w-4 ml-1"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Contact Methods Card --}}
                    <div class="rounded-2xl bg-white p-8 shadow-xl shadow-slate-200/50 ring-1 ring-slate-200 relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-secondary/5 transition-transform duration-500 group-hover:scale-150"></div>
                        <div class="relative space-y-8">
                            <div>
                                <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Email Us</h2>
                                <div class="flex items-center gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-secondary/10 text-secondary">
                                        <i data-lucide="mail" class="h-5 w-5"></i>
                                    </div>
                                    <a href="mailto:{{ config('plaschema.contact.email') }}" class="text-lg font-semibold text-slate-900 hover:text-secondary transition">
                                        {{ config('plaschema.contact.email') }}
                                    </a>
                                </div>
                            </div>
                            
                            @if (config('plaschema.contact.phone'))
                                <div>
                                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4">Call Us</h2>
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-600">
                                            <i data-lucide="phone" class="h-5 w-5"></i>
                                        </div>
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('plaschema.contact.phone')) }}" class="text-lg font-semibold text-slate-900 hover:text-emerald-600 transition">
                                            {{ config('plaschema.contact.phone') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Emergency Numbers --}}
                    <div class="rounded-2xl bg-amber-50 p-8 shadow-xl shadow-slate-200/50 ring-1 ring-amber-500/20">
                        <div class="flex items-center gap-3 mb-6">
                            <i data-lucide="alert-triangle" class="h-6 w-6 text-amber-600"></i>
                            <h2 class="text-xl font-bold text-slate-900">Emergency Hotlines</h2>
                        </div>
                        <ul class="space-y-4">
                            @foreach (config('navigation.emergency_numbers') as $emergency)
                                <li class="flex flex-col">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-amber-700/70 mb-1">{{ $emergency['label'] }}</span>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $emergency['number']) }}" class="text-lg font-bold text-amber-900 hover:text-amber-700 transition flex items-center gap-2">
                                        <i data-lucide="phone-call" class="h-4 w-4"></i> {{ $emergency['number'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Social Links --}}
                    <div class="flex items-center gap-4 pt-2">
                        <span class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Connect:</span>
                        <div class="flex gap-2">
                            @foreach (config('navigation.social') as $social)
                                <a href="{{ $social['url'] }}" class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm ring-1 ring-slate-200 transition hover:bg-primary hover:text-white hover:ring-primary" aria-label="{{ $social['label'] }}" target="_blank" rel="noopener noreferrer">
                                    <div class="h-4 w-4">{!! $social['svg'] !!}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Contact Form (Right Side) --}}
                <div class="lg:col-span-3">
                    <div class="rounded-2xl bg-white p-8 sm:p-12 shadow-xl shadow-slate-200/50 ring-1 ring-slate-200">
                        <div class="mb-8 border-b border-slate-100 pb-8">
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">Send us a message</h2>
                            <p class="text-slate-500">Fill out the form below and our support team will respond to you within 24-48 hours.</p>
                        </div>

                        @if (session('success'))
                            <div class="mb-8 rounded-xl bg-emerald-50 p-4 border border-emerald-200 flex items-start gap-3">
                                <i data-lucide="check-circle-2" class="h-5 w-5 text-emerald-600 shrink-0 mt-0.5"></i>
                                <div>
                                    <h3 class="text-sm font-bold text-emerald-900">Message sent successfully</h3>
                                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="block w-full rounded-xl border-0 py-3 px-4 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 @error('name') ring-red-300 focus:ring-red-500 @enderror"
                                        placeholder="John Doe">
                                    @error('name')<p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        class="block w-full rounded-xl border-0 py-3 px-4 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 @error('email') ring-red-300 focus:ring-red-500 @enderror"
                                        placeholder="john@example.com">
                                    @error('email')<p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-semibold text-slate-700 mb-2">Subject</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                    class="block w-full rounded-xl border-0 py-3 px-4 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 @error('subject') ring-red-300 focus:ring-red-500 @enderror"
                                    placeholder="How can we help you?">
                                @error('subject')<p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-semibold text-slate-700 mb-2">Message</label>
                                <textarea name="message" id="message" rows="6" required
                                    class="block w-full rounded-xl border-0 py-3 px-4 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 @error('message') ring-red-300 focus:ring-red-500 @enderror"
                                    placeholder="Please describe your inquiry in detail...">{{ old('message') }}</textarea>
                                @error('message')<p class="mt-2 text-xs font-medium text-red-500">{{ $message }}</p>@enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn-primary w-full sm:w-auto px-8 py-3.5 text-base">
                                    Send Message <i data-lucide="send" class="h-4 w-4 ml-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </x-section>
@endsection
