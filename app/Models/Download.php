<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Download extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'description', 'file_path',
        'file_size', 'mime_type', 'published_at', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'form' => 'Form',
            'policy' => 'Policy',
            'guideline' => 'Guideline',
            'report' => 'Report',
            'circular' => 'Circular',
            default => ucfirst($this->category),
        };
    }

    public function formattedSize(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1).' MB';
        }
        if ($bytes >= 1024) {
            return round($bytes / 1024, 1).' KB';
        }

        return $bytes.' B';
    }

    public function fileExists(): bool
    {
        return Storage::disk('public')->exists($this->file_path);
    }
}
