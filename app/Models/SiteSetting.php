<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name', 'brand_tagline', 'logo', 'whatsapp_number', 'email', 'operational_hours',
        'meta_title', 'meta_description', 'meta_keywords', 'seo_robots', 'canonical_url',
        'twitter_title', 'twitter_description', 'twitter_image', 'schema_json_ld', 'og_image',
        'google_analytics_id', 'google_tag_manager_id', 'meta_pixel_id', 'google_ads_id',
        'google_ads_conversion_label', 'head_scripts', 'body_start_scripts', 'body_end_scripts',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        return $this->assetUrl($this->logo);
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->assetUrl($this->og_image);
    }

    public function getTwitterImageUrlAttribute(): ?string
    {
        return $this->assetUrl($this->twitter_image);
    }

    public function hasTrackingSetup(): bool
    {
        return filled($this->google_analytics_id)
            || filled($this->google_tag_manager_id)
            || filled($this->meta_pixel_id)
            || filled($this->google_ads_id)
            || filled($this->head_scripts)
            || filled($this->body_start_scripts)
            || filled($this->body_end_scripts);
    }

    protected function assetUrl(?string $value): ?string
    {
        if (!$value) return null;
        return Str::startsWith($value, ['http://', 'https://']) ? $value : Storage::url($value);
    }
}
