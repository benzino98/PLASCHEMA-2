<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class HealthcareProvider extends Model
{
    protected $fillable = [
        'name', 'slug', 'lga', 'specialty', 'ownership', 'services',
        'address', 'phone', 'email', 'working_hours',
        'latitude', 'longitude', 'accreditation_status', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'services' => 'array',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'is_published' => 'boolean',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(HealthcareProviderPhoto::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return $query
            ->when($request->filled('q'), function (Builder $q) use ($request) {
                $term = '%'.$request->string('q').'%';
                $q->where(function (Builder $inner) use ($term) {
                    $inner->where('name', 'like', $term)
                        ->orWhere('address', 'like', $term);
                });
            })
            ->when($request->filled('lga'), fn (Builder $q) => $q->where('lga', $request->string('lga')))
            ->when($request->filled('specialty'), fn (Builder $q) => $q->where('specialty', $request->string('specialty')))
            ->when($request->filled('ownership'), fn (Builder $q) => $q->where('ownership', $request->string('ownership')))
            ->when($request->filled('service'), function (Builder $q) use ($request) {
                $q->whereJsonContains('services', $request->string('service'));
            });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function accreditationLabel(): string
    {
        return match ($this->accreditation_status) {
            'accredited' => 'Accredited',
            'pending' => 'Pending Accreditation',
            'suspended' => 'Suspended',
            default => ucfirst($this->accreditation_status),
        };
    }

    public function accreditationColor(): string
    {
        return match ($this->accreditation_status) {
            'accredited' => 'bg-primary-50 text-primary',
            'pending' => 'bg-accent-50 text-accent-600',
            'suspended' => 'bg-red-50 text-red-600',
            default => 'bg-slate-100 text-slate-600',
        };
    }

    public function hasCoordinates(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    public function mapEmbedUrl(): string
    {
        if ($this->hasCoordinates()) {
            return 'https://maps.google.com/maps?q='.$this->latitude.','.$this->longitude.'&output=embed';
        }

        return 'https://maps.google.com/maps?q='.urlencode($this->address).'&output=embed';
    }

    public function toMapMarker(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'lga' => $this->lga,
            'specialty' => $this->specialty,
            'accreditation' => $this->accreditation_status,
            'lat' => (float) $this->latitude,
            'lng' => (float) $this->longitude,
            'url' => route('providers.show', $this),
        ];
    }
}
