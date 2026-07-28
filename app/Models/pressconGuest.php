<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class pressconGuest extends Model
{
    //
    protected $table = 'presscon_guests';
    protected $primaryKey = 'id_guest';
    protected $fillable = [
        'slug',
        'name',
        'category',
        'group',
        'max_pax',
        'requires_name',
        'details',
        'submitted_name',
        'rsvp_status',
        'note',
        'confirmed_pax',
        'checked_in',
        'arrival_time',
        'qr_generated',
        'qr_path',
    ];

    protected $casts = [
        'requires_name' => 'boolean',
        'checked_in' => 'boolean',
        'qr_generated' => 'boolean',
        'arrival_time' => 'datetime',
        'max_pax' => 'integer',
        'confirmed_pax' => 'integer',
    ];

    /**
     * Route model binding pakai slug, bukan id_guest.
     * Ini yang bikin route /presscon-inv/{guest} otomatis nyari via kolom slug.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Kode 3-huruf per kategori, dipakai buat generate slug.
     */
    public static function categoryCode(string $category): string
    {
        return match ($category) {
            'Crew' => 'CRE',
            'Media' => 'MED',
            'Partner' => 'PAR',
            'Venue' => 'VEN',
            'Colleague' => 'COL',
            'DJ/Musician Colleague' => 'DJM',
            'Artist/Production Team' => 'ART',
            'Inner Circle' => 'INN',
            default => 'GEN',
        };
    }

    /**
     * Warna aksen per kategori (dipakai di dashboard & nanti halaman Tamu).
     * Class Tailwind harus ditulis lengkap di sini (bukan digabung string) supaya
     * ke-scan sama Tailwind content scanner.
     */
    public static function categoryColor(string $category): string
    {
        return match ($category) {
            'Crew' => 'bg-sky-400',
            'Media' => 'bg-rose-400',
            'Partner' => 'bg-amber-400',
            'Venue' => 'bg-emerald-400',
            'Colleague' => 'bg-violet-400',
            'DJ/Musician Colleague' => 'bg-lime-400',
            'Artist/Production Team' => 'bg-cyan-400',
            'Inner Circle' => 'bg-yellow-300',
            default => 'bg-neutral-400',
        };
    }

    /**
     * Generate slug unik format WSM-{KODE}-{NAMA}. Kalau nama kembar (mis. 2 tamu
     * bernama "Bang Kimo"), otomatis nambahin angka di belakang: WSM-COL-BANG-KIMO-2.
     */
    public static function generateSlug(string $name, string $category): string
    {
        $code = self::categoryCode($category);
        $base = 'WSM-' . $code . '-' . Str::upper(Str::slug($name, '-'));
        $slug = $base;
        $suffix = 2;
        while (self::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $suffix;
            $suffix++;
        }
        return $slug;
    }
}