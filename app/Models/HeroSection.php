<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = ['eyebrow_icon','eyebrow_text','title_before','pill_word','title_after','description','primary_button_text','primary_button_icon','secondary_button_text','secondary_button_icon','image','card_a_number','card_a_text','card_a_icon','card_b_number','card_b_text','card_b_icon','card_c_number','card_c_text','card_c_icon'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        return Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : Storage::url($this->image);
    }
}
