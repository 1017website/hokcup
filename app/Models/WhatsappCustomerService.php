<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappCustomerService extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_customer_services';

    protected $fillable = [
        'name',
        'phone_number',
        'display_number',
        'greeting_message',
        'sort_order',
        'total_clicks',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'total_clicks' => 'integer',
    ];

    public function clickLogs(): HasMany
    {
        return $this->hasMany(WhatsappClickLog::class, 'whatsapp_customer_service_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function setPhoneNumberAttribute($value): void
    {
        $this->attributes['phone_number'] = self::normalizePhone((string) $value);
    }

    public static function normalizePhone(string $value): string
    {
        $number = preg_replace('/\D+/', '', $value) ?: '';

        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }

    public static function formatDisplayNumber(?string $number): string
    {
        $number = self::normalizePhone((string) $number);

        return $number ? '+' . $number : '';
    }
}
