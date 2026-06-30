<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleMapSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'eyebrow_icon', 'eyebrow_text', 'title', 'description', 'address',
        'embed_code', 'button_text', 'button_url', 'is_active',
    ];
}
