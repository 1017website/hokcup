<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id','name','slug','size','image','label','description','is_featured','is_active','sort_order'];
    protected $casts = ['is_featured' => 'boolean', 'is_active' => 'boolean', 'size' => 'integer'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specs()
    {
        return $this->hasMany(ProductSpec::class)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        return Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : Storage::url($this->image);
    }

    public function toFrontendArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category?->slug,
            'size' => $this->size ?: 0,
            'image' => $this->image_url,
            'label' => $this->label,
            'desc' => $this->description,
            'specs' => $this->specs->pluck('spec_value', 'spec_key')->toArray(),
        ];
    }
}
