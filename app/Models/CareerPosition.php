<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CareerPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'department', 'location', 'employment_type', 'work_type',
        'salary_range', 'summary', 'description', 'requirements', 'apply_url',
        'apply_email', 'closes_at', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'closes_at' => 'date',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getShortSummaryAttribute(): string
    {
        return Str::limit(strip_tags((string) ($this->summary ?: $this->description)), 150);
    }

    public function getApplyLinkAttribute(): ?string
    {
        if ($this->apply_url) {
            return $this->apply_url;
        }

        if ($this->apply_email) {
            return 'mailto:' . $this->apply_email . '?subject=' . rawurlencode('Lamaran: ' . $this->title);
        }

        return null;
    }
}
