@extends('layouts.app')

@section('title', 'Find Healthcare Provider')
@section('meta_description', 'Search accredited hospitals and clinics across Plateau State by LGA, specialty, and services.')

@section('content')
    <div class="page-hero border-b border-slate-200/60">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[['label' => 'Providers']]" />
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Find Healthcare Provider</h1>
            <p class="mt-4 max-w-2xl text-lg text-slate-600">
                Search accredited hospitals and clinics across all 17 LGAs in Plateau State.
            </p>
        </div>
    </div>

    <x-section class="bg-white" padding="sm">
        {{-- Filters --}}
        <form method="GET" action="{{ route('providers') }}" class="card mb-8">
            <input type="hidden" name="view" value="{{ $view }}">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
                <div class="xl:col-span-2">
                    <label for="q" class="block text-xs font-medium text-slate-500">Hospital Name</label>
                    <input type="search" name="q" id="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search by name..."
                        class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                </div>
                <div>
                    <label for="lga" class="block text-xs font-medium text-slate-500">LGA</label>
                    <select name="lga" id="lga" class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="">All LGAs</option>
                        @foreach ($lgas as $lga)
                            <option value="{{ $lga }}" @selected(($filters['lga'] ?? '') === $lga)>{{ $lga }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="specialty" class="block text-xs font-medium text-slate-500">Specialty</label>
                    <select name="specialty" id="specialty" class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="">All Specialties</option>
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty }}" @selected(($filters['specialty'] ?? '') === $specialty)>{{ $specialty }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="ownership" class="block text-xs font-medium text-slate-500">Ownership</label>
                    <select name="ownership" id="ownership" class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="">All Types</option>
                        @foreach ($ownershipTypes as $type)
                            <option value="{{ $type }}" @selected(($filters['ownership'] ?? '') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="service" class="block text-xs font-medium text-slate-500">Service</label>
                    <select name="service" id="service" class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="">All Services</option>
                        @foreach ($serviceTypes as $service)
                            <option value="{{ $service }}" @selected(($filters['service'] ?? '') === $service)>{{ $service }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 flex flex-wrap gap-3">
                <button type="submit" class="btn-primary !px-4 !py-2 text-xs">
                    <i data-lucide="search" class="h-4 w-4"></i> Search
                </button>
                <a href="{{ route('providers', ['view' => $view]) }}" class="btn-outline !px-4 !py-2 text-xs">Clear filters</a>
            </div>
        </form>

        {{-- View toggle + results count --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <p class="text-sm text-slate-500">
                <span class="font-semibold text-slate-900">{{ $providers->count() }}</span>
                {{ Str::plural('provider', $providers->count()) }} found
            </p>
            <div class="flex rounded-lg border border-slate-200 bg-slate-50 p-1">
                <a href="{{ route('providers', array_merge($filters, ['view' => 'list'])) }}"
                    class="rounded-md px-4 py-1.5 text-sm font-medium transition {{ $view === 'list' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    <i data-lucide="list" class="mr-1 inline h-4 w-4"></i> List
                </a>
                <a href="{{ route('providers', array_merge($filters, ['view' => 'map'])) }}"
                    class="rounded-md px-4 py-1.5 text-sm font-medium transition {{ $view === 'map' ? 'bg-white text-primary shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                    <i data-lucide="map" class="mr-1 inline h-4 w-4"></i> Map
                </a>
            </div>
        </div>

        @if ($providers->isEmpty())
            <div class="card text-center py-12">
                <i data-lucide="search-x" class="mx-auto h-12 w-12 text-slate-300"></i>
                <p class="mt-4 font-medium text-slate-900">No providers found</p>
                <p class="mt-1 text-sm text-slate-500">Try adjusting your search filters.</p>
            </div>
        @elseif ($view === 'map')
            <div class="overflow-hidden rounded-[var(--radius-card)] border border-slate-200 bg-white" style="box-shadow: var(--shadow-card)">
                <div id="providers-map" class="h-[500px] w-full bg-slate-100"></div>
                @unless ($mapsApiKey)
                    <div class="border-t border-slate-200 bg-accent-50 px-4 py-3 text-sm text-accent-600">
                        Add <code class="rounded bg-white px-1">GOOGLE_MAPS_API_KEY</code> to your <code class="rounded bg-white px-1">.env</code> for the interactive map. Showing list below.
                    </div>
                @endunless
            </div>
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($providers as $provider)
                    <x-provider-card :provider="$provider" />
                @endforeach
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
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
                const center = { lat: 9.8965, lng: 8.8583 };
                const map = new google.maps.Map(document.getElementById('providers-map'), {
                    zoom: 8,
                    center,
                    mapTypeControl: false,
                    streetViewControl: false,
                    styles: [{ featureType: 'poi', stylers: [{ visibility: 'off' }] }],
                });

                const bounds = new google.maps.LatLngBounds();
                const infoWindow = new google.maps.InfoWindow();

                markers.forEach((marker) => {
                    const position = { lat: marker.lat, lng: marker.lng };
                    const pin = new google.maps.Marker({
                        position,
                        map,
                        title: marker.name,
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 10,
                            fillColor: marker.accreditation === 'accredited' ? '#0B8F4D' : '#F59E0B',
                            fillOpacity: 1,
                            strokeColor: '#ffffff',
                            strokeWeight: 2,
                        },
                    });

                    pin.addListener('click', () => {
                        infoWindow.setContent(`
                            <div style="font-family:Inter,sans-serif;max-width:220px;padding:4px">
                                <strong style="font-size:14px">${marker.name}</strong>
                                <p style="margin:4px 0 0;font-size:12px;color:#64748b">${marker.lga} · ${marker.specialty || 'General'}</p>
                                <a href="${marker.url}" style="display:inline-block;margin-top:8px;font-size:12px;color:#0B8F4D;font-weight:600">View details →</a>
                            </div>
                        `);
                        infoWindow.open(map, pin);
                    });

                    bounds.extend(position);
                });

                if (markers.length > 0) {
                    map.fitBounds(bounds, 60);
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
                    el.innerHTML = '<iframe title="Plateau State map" src="https://maps.google.com/maps?q=Jos,+Plateau+State,+Nigeria&z=8&output=embed" class="h-full w-full border-0"></iframe>';
                }
            });
        </script>
    @endpush
@endif
