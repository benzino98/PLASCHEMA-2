@extends('layouts.app')

@section('title', 'Find Healthcare Provider')
@section('meta_description', 'Search accredited hospitals and clinics across Plateau State by LGA, specialty, and services.')

@section('content')
    {{-- Premium Hero --}}
    <section class="relative isolate overflow-hidden bg-slate-950 py-16 text-white sm:py-20 lg:py-24">
        <div class="absolute inset-0 -z-20 bg-[radial-gradient(circle_at_20%_30%,rgba(11,143,77,.4),transparent_40%),radial-gradient(circle_at_80%_70%,rgba(30,136,229,.3),transparent_35%)]"></div>
        <div class="absolute inset-0 -z-10 opacity-[.06]" style="background-image:linear-gradient(rgba(255,255,255,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.8) 1px,transparent 1px);background-size:48px 48px"></div>
        
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Breadcrumb" class="text-sm text-white/60 mb-8">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Providers</span>
            </nav>
            
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Find your<br>
                    <span class="bg-gradient-to-r from-emerald-300 to-cyan-300 bg-clip-text text-transparent">Healthcare Provider.</span>
                </h1>
                <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-300">
                    Search accredited hospitals and clinics across all 17 LGAs in Plateau State. Our network ensures you get the care you need, when you need it.
                </p>
            </div>
        </div>
    </section>

    <x-section class="bg-slate-50/50" padding="sm">
        {{-- Premium Filter Form --}}
        <div class="relative -mt-24 mb-10 z-10 mx-auto max-w-7xl">
            <form method="GET" action="{{ route('providers') }}" class="rounded-2xl bg-white p-6 shadow-xl shadow-slate-200/50 ring-1 ring-slate-200">
                <input type="hidden" name="view" value="{{ $view }}">
                
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label for="q" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Hospital Name</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <i data-lucide="search" class="h-4 w-4 text-slate-400"></i>
                            </div>
                            <input type="search" name="q" id="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search by name..."
                                class="block w-full rounded-xl border-0 py-2.5 pl-10 pr-3 text-slate-900 ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                        </div>
                    </div>
                    
                    <div class="w-full md:w-48">
                        <label for="lga" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">LGA</label>
                        <select name="lga" id="lga" data-tom-select placeholder="All LGAs">
                            <option value="">All LGAs</option>
                            @foreach ($lgas as $lga)
                                <option value="{{ $lga }}" @selected(($filters['lga'] ?? '') === $lga)>{{ $lga }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="w-full md:w-56">
                        <label for="specialty" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Specialty</label>
                        <select name="specialty" id="specialty" data-tom-select placeholder="All Specialties">
                            <option value="">All Specialties</option>
                            @foreach ($specialties as $specialty)
                                <option value="{{ $specialty }}" @selected(($filters['specialty'] ?? '') === $specialty)>{{ $specialty }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="w-full md:w-auto flex shrink-0 gap-3 mt-4 md:mt-0">
                        <button type="submit" class="btn-primary flex-1 md:flex-none py-2.5">
                            Search
                        </button>
                        <button type="button" 
                                class="rounded-xl border border-slate-200 bg-slate-50 p-2.5 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 md:hidden"
                                onclick="document.getElementById('advanced-filters').classList.toggle('hidden')">
                            <i data-lucide="sliders-horizontal" class="h-5 w-5"></i>
                        </button>
                    </div>
                </div>

                {{-- Advanced Filters (Collapsible on mobile) --}}
                <div id="advanced-filters" class="hidden md:flex flex-col md:flex-row gap-4 mt-4 pt-4 border-t border-slate-100">
                    <div class="w-full md:w-1/3">
                        <label for="ownership" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Ownership</label>
                        <select name="ownership" id="ownership" data-tom-select placeholder="All Types">
                            <option value="">All Types</option>
                            @foreach ($ownershipTypes as $type)
                                <option value="{{ $type }}" @selected(($filters['ownership'] ?? '') === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="w-full md:w-1/3">
                        <label for="service" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Service</label>
                        <select name="service" id="service" data-tom-select placeholder="All Services">
                            <option value="">All Services</option>
                            @foreach ($serviceTypes as $service)
                                <option value="{{ $service }}" @selected(($filters['service'] ?? '') === $service)>{{ $service }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/3 flex items-end justify-end">
                        <a href="{{ route('providers', ['view' => $view]) }}" class="text-sm font-medium text-slate-500 hover:text-primary transition underline-offset-4 hover:underline">
                            Clear all filters
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Results Header & View Toggle --}}
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900">
                    @if(collect($filters)->filter()->isNotEmpty())
                        Search Results
                    @else
                        All Accredited Providers
                    @endif
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Showing <span class="font-semibold text-slate-900">{{ $providers->count() }}</span> {{ Str::plural('provider', $providers->count()) }}
                </p>
            </div>
            
            <div class="flex rounded-lg border border-slate-200 bg-white p-1 shadow-sm shrink-0">
                <a href="{{ route('providers', array_merge($filters, ['view' => 'list'])) }}"
                    class="rounded-md px-4 py-1.5 text-sm font-semibold transition {{ $view === 'list' ? 'bg-primary text-white shadow' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <i data-lucide="list" class="mr-1.5 inline h-4 w-4"></i> List
                </a>
                <a href="{{ route('providers', array_merge($filters, ['view' => 'map'])) }}"
                    class="rounded-md px-4 py-1.5 text-sm font-semibold transition {{ $view === 'map' ? 'bg-primary text-white shadow' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                    <i data-lucide="map" class="mr-1.5 inline h-4 w-4"></i> Map
                </a>
            </div>
        </div>

        {{-- Results Content --}}
        @if ($providers->isEmpty())
            <div class="rounded-2xl border-2 border-dashed border-slate-200 bg-white p-12 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50">
                    <i data-lucide="search-x" class="h-8 w-8 text-slate-400"></i>
                </div>
                <h3 class="mt-4 text-lg font-bold text-slate-900">No providers found</h3>
                <p class="mt-2 text-sm text-slate-500 max-w-sm mx-auto">We couldn't find any healthcare providers matching your current filters. Try adjusting or clearing them.</p>
                <div class="mt-6">
                    <a href="{{ route('providers', ['view' => $view]) }}" class="btn-outline">
                        Clear all filters
                    </a>
                </div>
            </div>
        @elseif ($view === 'map')
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm ring-1 ring-black ring-opacity-5">
                <div id="providers-map" class="h-[600px] w-full bg-slate-100 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-pulse flex flex-col items-center">
                            <i data-lucide="map" class="h-8 w-8 text-slate-300 mb-2"></i>
                            <span class="text-sm text-slate-500 font-medium">Loading map...</span>
                        </div>
                    </div>
                </div>
                @unless ($mapsApiKey)
                    <div class="border-t border-slate-200 bg-amber-50 px-4 py-3 flex gap-3">
                        <i data-lucide="alert-triangle" class="h-5 w-5 text-amber-600 shrink-0"></i>
                        <div class="text-sm text-amber-700">
                            <strong>Map API Key Missing.</strong> Add <code class="rounded bg-white/60 px-1 font-mono text-xs">GOOGLE_MAPS_API_KEY</code> to your <code class="rounded bg-white/60 px-1 font-mono text-xs">.env</code> file to enable the interactive map. Showing fallback list below.
                        </div>
                    </div>
                @endunless
            </div>
            
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($providers as $provider)
                    <x-provider-card :provider="$provider" />
                @endforeach
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($providers as $provider)
                    <x-provider-card :provider="$provider" />
                @endforeach
            </div>
        @endif
    </x-section>
@endsection

@if ($view === 'map' && $mapsApiKey && $markers->isNotEmpty())
    @push('scripts')
        <script>
            const markers = @json($markers);
            const mapsApiKey = @json($mapsApiKey);

            function initProvidersMap() {
                const center = { lat: 9.8965, lng: 8.8583 }; // Center of Plateau State
                const map = new google.maps.Map(document.getElementById('providers-map'), {
                    zoom: 8,
                    center,
                    mapTypeControl: false,
                    streetViewControl: false,
                    fullscreenControl: true,
                    styles: [
                        { featureType: 'poi.business', stylers: [{ visibility: 'off' }] },
                        { featureType: 'transit', elementType: 'labels.icon', stylers: [{ visibility: 'off' }] }
                    ],
                });

                const bounds = new google.maps.LatLngBounds();
                const infoWindow = new google.maps.InfoWindow({
                    maxWidth: 300
                });

                markers.forEach((marker) => {
                    const position = { lat: marker.lat, lng: marker.lng };
                    
                    const pinColor = marker.accreditation === 'accredited' ? '#0B8F4D' : '#F59E0B';
                    
                    const pin = new google.maps.Marker({
                        position,
                        map,
                        title: marker.name,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 10,
                            fillColor: pinColor,
                            fillOpacity: 1,
                            strokeColor: '#ffffff',
                            strokeWeight: 2.5,
                        },
                    });

                    pin.addListener('click', () => {
                        const servicesHtml = marker.services && marker.services.length 
                            ? `<div style="margin-top:8px;display:flex;gap:4px;flex-wrap:wrap">
                                ${marker.services.slice(0,2).map(s => `<span style="background:#f1f5f9;border:1px solid #e2e8f0;padding:2px 6px;border-radius:4px;font-size:10px;color:#475569">${s}</span>`).join('')}
                                ${marker.services.length > 2 ? `<span style="background:#f1f5f9;border:1px solid #e2e8f0;padding:2px 6px;border-radius:4px;font-size:10px;color:#475569">+${marker.services.length-2}</span>` : ''}
                               </div>` 
                            : '';
                            
                        infoWindow.setContent(`
                            <div style="font-family:Inter,sans-serif;padding:8px 4px 4px;">
                                <div style="display:flex;align-items:center;gap:6px;margin-bottom:6px">
                                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background-color:${pinColor}"></span>
                                    <span style="font-size:10px;font-weight:600;text-transform:uppercase;color:${pinColor};letter-spacing:0.5px">${marker.accreditation}</span>
                                </div>
                                <strong style="font-size:15px;color:#0f172a;line-height:1.2;display:block;margin-bottom:4px">${marker.name}</strong>
                                <p style="margin:0;font-size:12px;color:#64748b;display:flex;align-items:center;gap:4px">
                                    ${marker.lga} &middot; ${marker.specialty || 'General'}
                                </p>
                                ${servicesHtml}
                                <a href="${marker.url}" style="display:inline-block;margin-top:12px;font-size:13px;color:#0B8F4D;font-weight:600;text-decoration:none">View provider details →</a>
                            </div>
                        `);
                        infoWindow.open(map, pin);
                    });

                    bounds.extend(position);
                });

                if (markers.length > 0) {
                    map.fitBounds(bounds, { padding: 40 });
                }
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ $mapsApiKey }}&callback=initProvidersMap" async defer></script>
    @endpush
@elseif ($view === 'map' && (!$mapsApiKey || $markers->isEmpty()))
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const el = document.getElementById('providers-map');
                if (el && !@json((bool) $mapsApiKey)) {
                    el.innerHTML = '<div class="w-full h-full p-4 flex flex-col items-center justify-center text-center"><i data-lucide="map" class="h-12 w-12 text-slate-300 mb-4"></i><h3 class="text-lg font-bold text-slate-900">Interactive Map Disabled</h3><p class="text-sm text-slate-500 max-w-sm mt-2">The Google Maps API key is not configured. Please use the list view or configure the API key to view provider locations.</p></div>';
                    if (window.refreshIcons) window.refreshIcons();
                }
            });
        </script>
    @endpush
@endif
