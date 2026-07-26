<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'slug' => $this->slug, 'title' => $this->title, 'excerpt' => $this->excerpt, 'body' => $this->body, 'category' => $this->category, 'category_label' => $this->categoryLabel(), 'featured_image' => $this->featured_image ? asset('storage/'.$this->featured_image) : null, 'published_at' => $this->published_at?->toIso8601String(), 'url' => route('news.show', $this->slug)];
    }
}
