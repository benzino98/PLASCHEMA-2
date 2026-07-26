<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.services', [
            'enrollment_url' => SiteSetting::get('services', 'enrollment_url', config('plaschema.services.enrollment')),
            'verification_url' => SiteSetting::get('services', 'verification_url', config('plaschema.services.verification')),
            'payment_url' => SiteSetting::get('services', 'payment_url', config('plaschema.services.payment')),
            'support_url' => SiteSetting::get('services', 'support_url', config('plaschema.services.support')),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'enrollment_url' => ['required', 'url', 'max:2048'],
            'verification_url' => ['required', 'url', 'max:2048'],
            'payment_url' => ['required', 'url', 'max:2048'],
            'support_url' => ['required', 'url', 'max:2048'],
        ]);

        SiteSetting::set('services', 'enrollment_url', $validated['enrollment_url']);
        SiteSetting::set('services', 'verification_url', $validated['verification_url']);
        SiteSetting::set('services', 'payment_url', $validated['payment_url']);
        SiteSetting::set('services', 'support_url', $validated['support_url']);

        return redirect()->route('admin.settings.services')->with('success', 'Service URLs updated successfully.');
    }
}
