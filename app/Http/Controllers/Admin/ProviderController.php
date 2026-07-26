<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProviderRequest;
use App\Http\Requests\Admin\UpdateProviderRequest;
use App\Models\HealthcareProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProviderController extends Controller
{
    public function index(): View
    {
        $providers = HealthcareProvider::query()->orderBy('name')->paginate(15);

        return view('admin.providers.index', compact('providers'));
    }

    public function create(): View
    {
        return view('admin.providers.create', $this->formData());
    }

    public function store(StoreProviderRequest $request): RedirectResponse
    {
        HealthcareProvider::create($this->mappedAttributes($request));

        return redirect()->route('admin.providers.index')
            ->with('success', 'Provider created successfully.');
    }

    public function edit(HealthcareProvider $provider): View
    {
        return view('admin.providers.edit', array_merge($this->formData(), compact('provider')));
    }

    public function update(UpdateProviderRequest $request, HealthcareProvider $provider): RedirectResponse
    {
        $provider->update($this->mappedAttributes($request));

        return redirect()->route('admin.providers.index')
            ->with('success', 'Provider updated successfully.');
    }

    public function destroy(HealthcareProvider $provider): RedirectResponse
    {
        $provider->delete();

        return redirect()->route('admin.providers.index')
            ->with('success', 'Provider deleted successfully.');
    }

    private function formData(): array
    {
        return [
            'lgas' => config('providers.lgas'),
            'specialties' => config('providers.specialties'),
            'ownershipTypes' => config('providers.ownership_types'),
            'serviceTypes' => config('providers.service_types'),
        ];
    }

    private function mappedAttributes(StoreProviderRequest $request): array
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['services'] = $data['services'] ?? [];

        return $data;
    }
}
