<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanBenefit extends Model
{
    protected $fillable = [
        'health_plan_id', 'benefit_key', 'benefit_label', 'is_included', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_included' => 'boolean'];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(HealthPlan::class, 'health_plan_id');
    }
}
