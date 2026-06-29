<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'category',
        'featured_image', 'published_at', 'is_published',
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
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'campaign' => 'Health Campaign',
            'activity' => 'PLASCHEMA Activity',
            'press' => 'Press Release',
            default => 'Article',
        };
    }
}
