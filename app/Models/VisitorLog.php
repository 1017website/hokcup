<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'session_id',
        'visitor_hash',
        'ip_hash',
        'user_agent',
        'url',
        'path',
        'referer',
        'source',
        'device',
        'browser',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
