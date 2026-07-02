<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappClickLog extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_click_logs';

    protected $fillable = [
        'whatsapp_customer_service_id',
        'product_name',
        'message',
        'ip_hash',
        'user_agent',
        'referer',
        'source_url',
    ];

    public function customerService(): BelongsTo
    {
        return $this->belongsTo(WhatsappCustomerService::class, 'whatsapp_customer_service_id');
    }
}
