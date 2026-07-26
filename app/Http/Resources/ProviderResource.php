<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'slug' => $this->slug, 'name' => $this->name, 'lga' => $this->lga, 'specialty' => $this->specialty, 'ownership' => $this->ownership, 'services' => $this->services ?? [], 'address' => $this->address, 'phone' => $this->phone, 'email' => $this->email, 'working_hours' => $this->working_hours, 'coordinates' => $this->hasCoordinates() ? ['latitude' => (float) $this->latitude, 'longitude' => (float) $this->longitude] : null, 'accreditation' => $this->accreditation_status, 'url' => route('providers.show', $this->resource)];
    }
}
