<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthcareProviderPhoto extends Model
{
    protected $fillable = [
        'healthcare_provider_id', 'path', 'caption', 'sort_order',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(HealthcareProvider::class, 'healthcare_provider_id');
    }
}
