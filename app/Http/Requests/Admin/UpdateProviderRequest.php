<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class UpdateProviderRequest extends StoreProviderRequest
{
    public function rules(): array
    {
        $rules = $this->baseRules();
        $rules['slug'] = [
            'nullable', 'string', 'max:255',
            Rule::unique('healthcare_providers', 'slug')->ignore($this->route('provider')),
        ];

        return $rules;
    }
}
