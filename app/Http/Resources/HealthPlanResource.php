<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HealthPlanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'slug' => $this->slug, 'name' => $this->name, 'sector' => $this->sector, 'description' => $this->description, 'price' => ['amount' => $this->price_amount !== null ? (float) $this->price_amount : null, 'label' => $this->price_label], 'featured' => $this->is_featured, 'benefits' => $this->whenLoaded('benefits', fn () => PlanBenefitResource::collection($this->benefits))];
    }
}
