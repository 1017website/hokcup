<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','short_name','icon','description','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function toFrontendArray(int $count = 0): array
    {
        return [
            'id' => $this->slug,
            'name' => $this->name,
            'short' => $this->short_name,
            'icon' => $this->icon,
            'desc' => $this->description,
            'count' => $count,
        ];
    }
}
