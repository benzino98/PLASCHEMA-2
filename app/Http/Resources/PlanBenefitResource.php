<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanBenefitResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['key' => $this->benefit_key, 'label' => $this->benefit_label, 'included' => $this->is_included];
    }
}
