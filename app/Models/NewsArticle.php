<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'image', 'author', 'excerpt', 'content', 'published_at',
        'sort_order', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Str::startsWith($this->image, ['http://', 'https://'])
            ? $this->image
            : Storage::url($this->image);
    }

    public function getShortExcerptAttribute(): string
    {
        return Str::limit(strip_tags((string) ($this->excerpt ?: $this->content)), 145);
    }
}
