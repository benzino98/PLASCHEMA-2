<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $fillable = ['page_id', 'key', 'title', 'content', 'sort_order'];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function jsonContent(): array
    {
        return json_decode($this->content, true) ?? [];
    }
}
