@extends('layouts.app')

@section('title', $provider->name)
@section('meta_description', $provider->name.' — '.$provider->lga.', Plateau State. '.$provider->specialty.' provider.')

@section('content')
    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-12 text-white sm:py-16">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Providers', 'route' => 'providers'],
                ['label' => $provider->name],
            ]" class="text-white/60 mb-6" />
            
            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                <div class="max-w-3xl">
                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-wider {{ $provider->accreditationColor() }} shadow-sm">
                        {{ $provider->accreditationLabel() }}
                    </span>
                    <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl">{{ $provider->name }}</h1>
                    <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-slate-300 sm:text-base">
                        <span class="inline-flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-lg backdrop-blur">
                            <i data-lucide="map-pin" class="h-4 w-4"></i> {{ $provider->lga }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-lg backdrop-blur">
                            <i data-lucide="stethoscope" class="h-4 w-4"></i> {{ $provider->specialty ?: 'General Practice' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-white/10 px-3 py-1.5 rounded-lg backdrop-blur">
                            <i data-lucide="building-2" class="h-4 w-4"></i> {{ $provider->ownership }}
                        </span>
                    </div>
                </div>
                
                <a href="{{ route('providers') }}" class="btn-outline !bg-white/10 !text-white !border-white/20 hover:!bg-white/20 shrink-0">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to search
                </a>
            </div>
        </div>
    </section>

    <x-section class="bg-slate-50" padding="sm">
        <div class="grid gap-8 lg:grid-cols-3 xl:gap-12">
            <div class="lg:col-span-2 space-y-8">
                {{-- About / Contact Info --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4 mb-6">Contact & Location</h2>
                    
                    <div class="grid sm:grid-cols-2 gap-8">
                        <ul class="space-y-5 text-sm text-slate-600">
                            <li class="flex items-start gap-4">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                                    <i data-lucide="map-pin" class="h-5 w-5"></i>
                                </div>
                                <div class="mt-0.5">
                                    <strong class="block text-slate-900 mb-1">Address</strong>
                                    {{ $provider->address }}
                                </div>
                            </li>
                            @if ($provider->phone)
                                <li class="flex items-start gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-secondary/10 text-secondary">
                                        <i data-lucide="phone" class="h-5 w-5"></i>
                                    </div>
                                    <div class="mt-0.5">
                                        <strong class="block text-slate-900 mb-1">Phone Number</strong>
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $provider->phone) }}" class="hover:text-primary transition font-medium">{{ $provider->phone }}</a>
                                    </div>
                                </li>
                            @endif
                            @if ($provider->email)
                                <li class="flex items-start gap-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600">
                                        <i data-lucide="mail" class="h-5 w-5"></i>
                                    </div>
                                    <div class="mt-0.5">
                                        <strong class="block text-slate-900 mb-1">Email Address</strong>
                                        <a href="mailto:{{ $provider->email }}" class="hover:text-primary transition font-medium">{{ $provider->email }}</a>
                                    </div>
                                </li>
                            @endif
                        </ul>

                        @if ($provider->working_hours)
                            <div>
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-500/10 text-rose-500">
                                        <i data-lucide="clock" class="h-5 w-5"></i>
                                    </div>
                                    <div class="mt-0.5">
                                        <strong class="block text-slate-900 mb-1">Working Hours</strong>
                                    </div>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-4 border border-slate-100 text-sm text-slate-600 whitespace-pre-line leading-relaxed">
                                    {{ $provider->working_hours }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Map --}}
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden flex flex-col">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
                        <i data-lucide="map" class="h-5 w-5 text-slate-400"></i>
                        <h2 class="text-lg font-bold text-slate-900">Map & Directions</h2>
                    </div>
                    <div class="relative bg-slate-100 flex-1 min-h-[350px]">
                        <iframe
                            title="Map showing {{ $provider->name }}"
                            src="{{ $provider->mapEmbedUrl() }}"
                            class="absolute inset-0 h-full w-full border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                        ></iframe>
                    </div>
                    <div class="p-4 bg-white border-t border-slate-100 flex justify-end">
                        <a href="https://maps.google.com/?q={{ urlencode($provider->name . ' ' . $provider->address . ' Plateau State Nigeria') }}" target="_blank" rel="noopener noreferrer" class="btn-outline !text-xs !px-4 !py-2">
                            Open in Google Maps <i data-lucide="external-link" class="h-3 w-3 ml-1"></i>
                        </a>
                    </div>
                </div>

                {{-- Services --}}
                @if ($provider->services)
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4 mb-6">Services Offered</h2>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach ($provider->services as $service)
                                <div class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3.5 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-primary/30 hover:shadow-primary/5">
                                    <i data-lucide="check-circle-2" class="h-4 w-4 text-primary"></i>
                                    {{ $service }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Photos --}}
                @if ($provider->photos->isNotEmpty())
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                        <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4 mb-6">Facility Photos</h2>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3" id="provider-gallery">
                            @foreach ($provider->photos as $photo)
                                <a href="{{ asset('storage/'.$photo->path) }}" class="group block overflow-hidden rounded-xl bg-slate-100" data-sub-html="<h4>{{ $photo->caption ?? $provider->name }}</h4>">
                                    <img src="{{ asset('storage/'.$photo->path) }}" alt="{{ $photo->caption ?? $provider->name }}" class="aspect-square w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Accreditation Status --}}
                <div class="rounded-2xl border-2 {{ $provider->accreditation === 'accredited' ? 'border-primary/20 bg-primary/5' : 'border-amber-500/20 bg-amber-50' }} p-6 shadow-sm">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full {{ $provider->accreditation === 'accredited' ? 'bg-primary text-white shadow-primary/30' : 'bg-amber-500 text-white shadow-amber-500/30' }} shadow-lg">
                            <i data-lucide="{{ $provider->accreditation === 'accredited' ? 'shield-check' : 'shield-alert' }}" class="h-6 w-6"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Status</p>
                            <h3 class="text-lg font-bold text-slate-900">{{ $provider->accreditationLabel() }}</h3>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        @if($provider->accreditation === 'accredited')
                            This facility is fully accredited by PLASCHEMA and meets all quality standards for providing healthcare services to our enrollees.
                        @else
                            This facility is temporarily suspended from providing services under the PLASCHEMA scheme. Please choose an alternative accredited provider.
                        @endif
                    </p>
                </div>

                {{-- CTA Box --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-primary/5"></div>
                    <div class="relative">
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Need care here?</h3>
                        <p class="text-sm text-slate-600 mb-6 leading-relaxed">Ensure your PLASCHEMA membership is active and this facility is selected as your primary provider before visiting.</p>
                        <div class="space-y-3">
                            <a href="{{ \App\Support\DigitalServices::url('verification') }}" class="btn-primary w-full text-center justify-center" target="_blank" rel="noopener noreferrer">
                                <i data-lucide="shield-check" class="h-4 w-4"></i> Verify Membership
                            </a>
                            <a href="{{ \App\Support\DigitalServices::url('enrollment') }}" class="btn-outline w-full text-center justify-center" target="_blank" rel="noopener noreferrer">
                                <i data-lucide="user-plus" class="h-4 w-4"></i> Enroll Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-section>

    @if ($related->isNotEmpty())
        <x-section title="Other Providers in {{ $provider->lga }}" subtitle="Nearby Facilities" class="bg-white" padding="lg">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($related as $item)
                    <x-provider-card :provider="$item" />
                @endforeach
            </div>
            
            <div class="mt-10 text-center">
                <a href="{{ route('providers', ['lga' => $provider->lga]) }}" class="btn-outline">
                    View all in {{ $provider->lga }} <i data-lucide="arrow-right" class="h-4 w-4 ml-1"></i>
                </a>
            </div>
        </x-section>
    @endif
@endsection

@if ($provider->photos->isNotEmpty())
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.8.3/css/lightgallery-bundle.min.css">
    @endpush

    @push('scripts')
        <script type="module">
            import lightGallery from 'lightgallery';
            import lgThumbnail from 'lightgallery/plugins/thumbnail';
            import lgZoom from 'lightgallery/plugins/zoom';

            document.addEventListener('DOMContentLoaded', () => {
                const el = document.getElementById('provider-gallery');
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
@endif
