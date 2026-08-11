<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mood_submissions extends Model
{
    //
    protected $table = 'mood_submissions';
    public $timestamps = false; // cuma created_at, diisi manual di controller
    protected $fillable = [
        'mood_id',
        'visitor_name',
        'visitor_instagram',
        'selected_answer',
        'ip_address',
        'created_at',
    ];

    // $timestamps = false bikin Eloquent gak auto-cast created_at ke Carbon,
    // jadi harus dipaksa manual di sini biar ->format() dkk gak silently null.
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function mood()
    {
        return $this->belongsTo(mood::class);
    }
}