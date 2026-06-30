<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutSection extends Model
{
    use HasFactory;

    protected $fillable = ['eyebrow_icon','eyebrow_text','title','description','image'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        return Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : Storage::url($this->image);
    }
}
