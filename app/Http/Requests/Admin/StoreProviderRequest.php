<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProviderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return $this->baseRules();
    }

    protected function baseRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('healthcare_providers', 'slug')],
            'lga' => ['required', 'string', Rule::in(config('providers.lgas'))],
            'specialty' => ['nullable', 'string', Rule::in(config('providers.specialties'))],
            'ownership' => ['nullable', 'string', Rule::in(config('providers.ownership_types'))],
            'services' => ['nullable', 'array'],
            'services.*' => ['string', Rule::in(config('providers.service_types'))],
            'address' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'working_hours' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'accreditation_status' => ['required', Rule::in(['accredited', 'pending', 'suspended'])],
            'is_published' => ['boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
