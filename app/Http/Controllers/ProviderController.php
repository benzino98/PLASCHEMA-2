<?php

namespace App\Http\Controllers;

use App\Models\HealthcareProvider;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProviderController extends Controller
{
    public function index(Request $request): View
    {
        $view = $request->string('view', 'list')->toString();
        if (! in_array($view, ['list', 'map'])) {
            $view = 'list';
        }

        $providers = HealthcareProvider::query()
            ->published()
            ->filter($request)
            ->orderBy('name')
            ->get();

        $markers = $providers
            ->filter(fn (HealthcareProvider $p) => $p->hasCoordinates())
            ->map(fn (HealthcareProvider $p) => $p->toMapMarker())
            ->values();

        return view('pages.providers.index', [
            'providers' => $providers,
            'markers' => $markers,
            'view' => $view,
            'filters' => $request->only(['q', 'lga', 'specialty', 'ownership', 'service']),
            'lgas' => config('providers.lgas'),
            'specialties' => config('providers.specialties'),
            'ownershipTypes' => config('providers.ownership_types'),
            'serviceTypes' => config('providers.service_types'),
            'mapsApiKey' => config('plaschema.google_maps_api_key'),
        ]);
    }

    public function show(HealthcareProvider $provider): View
    {
        abort_unless($provider->is_published, 404);

        $provider->load('photos');

        $related = HealthcareProvider::query()
            ->published()
            ->where('id', '!=', $provider->id)
            ->where('lga', $provider->lga)
            ->take(3)
            ->get();

        return view('pages.providers.show', compact('provider', 'related'));
    }
}
