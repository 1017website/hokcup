<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $fillable = ['group','label','url','onclick','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
