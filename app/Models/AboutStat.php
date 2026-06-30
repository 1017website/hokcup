<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutStat extends Model
{
    use HasFactory;

    protected $fillable = ['number','label','sort_order','is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
