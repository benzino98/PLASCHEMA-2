<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DownloadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'slug' => $this->slug, 'title' => $this->title, 'description' => $this->description, 'category' => $this->category, 'file_size' => $this->file_size, 'mime_type' => $this->mime_type, 'published_at' => $this->published_at?->toIso8601String(), 'download_url' => route('downloads.download', $this->resource)];
    }
}
