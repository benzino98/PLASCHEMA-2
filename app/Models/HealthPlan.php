<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HealthPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'sector', 'description', 'price_label',
        'price_amount', 'is_featured', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_amount' => 'decimal:2',
            'is_featured' => 'boolean',
        ];
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(PlanBenefit::class)->orderBy('sort_order');
    }
}
