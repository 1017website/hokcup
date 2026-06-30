<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroTrustItem extends Model
{
    use HasFactory;

    protected $fillable = ['icon','text','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
