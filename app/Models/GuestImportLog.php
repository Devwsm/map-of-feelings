<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestImportLog extends Model
{
    protected $fillable = [
        'user_id',
        'original_filename',
        'total_rows',
        'imported_count',
        'skipped_count',
        'errors',
    ];

    protected $casts = [
        'errors' => 'array',
    ];

    /**
     * Admin/staff yang mengeksekusi import ini. Nullable — kalau user-nya
     * dihapus, log tetap ada tapi relasi ini null (lihat nullOnDelete di migration).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}