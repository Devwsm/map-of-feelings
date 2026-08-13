<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class visitorLog extends Model
{
    //
    protected $table = 'visitor_logs';
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'device_type',
        'url',
        'referer',
    ];

    /**
     * Dianggap "sedang mengakses" kalau last_seen (updated_at) dalam N menit terakhir.
     */
    public static function onlineThresholdMinutes(): int
    {
        return 5;
    }

    public function scopeOnlineNow($query)
    {
        return $query->where('updated_at', '>=', now()->subMinutes(self::onlineThresholdMinutes()));
    }
}