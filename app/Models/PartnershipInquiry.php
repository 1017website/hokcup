<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnershipInquiry extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_CONTACTED = 'contacted';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'name',
        'business_name',
        'phone',
        'city',
        'partner_type',
        'estimated_need',
        'message',
        'status',
        'contacted_at',
        'source_url',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_NEW => 'Baru',
            self::STATUS_CONTACTED => 'Sudah Dihubungi',
            self::STATUS_CLOSED => 'Selesai',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statuses()[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getWhatsappUrlAttribute(): string
    {
        $phone = preg_replace('/\D+/', '', (string) $this->phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        if ($phone && !str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone ? 'https://wa.me/' . $phone : '#';
    }
}
