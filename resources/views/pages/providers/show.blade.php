@extends('layouts.app')

@section('title', $provider->name)
@section('meta_description', $provider->name.' — '.$provider->lga.', Plateau State. '.$provider->specialty.' provider.')

@section('content')
    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Providers', 'route' => 'providers'],
                ['label' => $provider->name],
            ]" />
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $provider->accreditationColor() }}">
                        {{ $provider->accreditationLabel() }}
                    </span>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">{{ $provider->name }}</h1>
                    <p class="mt-2 text-lg text-slate-600">{{ $provider->lga }} &middot; {{ $provider->specialty }} &middot; {{ $provider->ownership }}</p>
                </div>
                <a href="{{ route('providers') }}" class="btn-outline !px-4 !py-2 text-xs">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to search
                </a>
            </div>
        </div>
    </div>

    <x-section class="bg-white">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-8">
                {{-- Contact details --}}
                <div class="card">
                    <h2 class="text-lg font-semibold text-slate-900">Contact Information</h2>
                    <ul class="mt-4 space-y-4 text-sm text-slate-600">
                        <li class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="mt-0.5 h-5 w-5 shrink-0 text-primary"></i>
                            <span>{{ $provider->address }}</span>
                        </li>
                        @if ($provider->phone)
                            <li class="flex items-center gap-3">
                                <i data-lucide="phone" class="h-5 w-5 shrink-0 text-primary"></i>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $provider->phone) }}" class="hover:text-primary">{{ $provider->phone }}</a>
                            </li>
                        @endif
                        @if ($provider->email)
                            <li class="flex items-center gap-3">
                                <i data-lucide="mail" class="h-5 w-5 shrink-0 text-primary"></i>
                                <a href="mailto:{{ $provider->email }}" class="hover:text-primary">{{ $provider->email }}</a>
                            </li>
                        @endif
                        @if ($provider->working_hours)
                            <li class="flex items-start gap-3">
                                <i data-lucide="clock" class="mt-0.5 h-5 w-5 shrink-0 text-primary"></i>
                                <span class="whitespace-pre-line">{{ $provider->working_hours }}</span>
                            </li>
                        @endif
                    </ul>
                </div>

                {{-- Services --}}
                @if ($provider->services)
                    <div class="card">
                        <h2 class="text-lg font-semibold text-slate-900">Services Offered</h2>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($provider->services as $service)
                                <span class="rounded-full bg-primary-50 px-3 py-1 text-sm font-medium text-primary">{{ $service }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Photos --}}
                @if ($provider->photos->isNotEmpty())
                    <div class="card">
                        <h2 class="text-lg font-semibold text-slate-900">Photos</h2>
                        <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            @foreach ($provider->photos as $photo)
                                <img src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->caption ?? $provider->name }}" class="aspect-[4/3] rounded-lg object-cover" loading="lazy">
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Map --}}
                <div class="card overflow-hidden !p-0">
                    <div class="px-6 py-4">
                        <h2 class="text-lg font-semibold text-slate-900">Location</h2>
                    </div>
                    <iframe
                        title="Map showing {{ $provider->name }}"
                        src="{{ $provider->mapEmbedUrl() }}"
                        class="h-72 w-full border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="card">
                    <h3 class="font-semibold text-slate-900">Accreditation</h3>
                    <p class="mt-2 text-sm text-slate-600">
                        This facility is <strong>{{ strtolower($provider->accreditationLabel()) }}</strong> by PLASCHEMA.
                    </p>
                </div>
                <div class="card">
                    <h3 class="font-semibold text-slate-900">Need care here?</h3>
                    <p class="mt-2 text-sm text-slate-600">Ensure your PLASCHEMA membership is active before visiting.</p>
                    <div class="mt-4 space-y-2">
                        <a href="{{ config('plaschema.services.verification') }}" class="btn-primary w-full text-xs" target="_blank" rel="noopener noreferrer">Verify Membership</a>
                        <a href="{{ config('plaschema.services.enrollment') }}" class="btn-outline w-full text-xs" target="_blank" rel="noopener noreferrer">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
    </x-section>

    @if ($related->isNotEmpty())
        <x-section title="Other Providers in {{ $provider->lga }}" class="bg-surface" padding="sm">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $item)
                    <x-provider-card :provider="$item" />
                @endforeach
            </div>
        </x-section>
    @endif
@endsection
