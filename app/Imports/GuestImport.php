<?php

namespace App\Imports;

use App\Models\pressconGuest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Import bulk data tamu dari file Excel/CSV.
 * Header kolom yang dipakai (urutan bebas, dicocokkan by nama kolom):
 * Nama | Kategori | Grup | Maks Pax | Wajib Isi Nama | Catatan
 *
 * Baris yang gagal validasi (nama kosong / kategori gak dikenali) dilewati,
 * bukan bikin seluruh import gagal — errornya dikumpulin di $errors buat
 * ditampilin ke admin setelah proses selesai.
 */
class GuestImport implements ToCollection, WithHeadingRow
{
    public const CATEGORIES = [
        'Crew',
        'Media',
        'Partner',
        'Venue',
        'Colleague',
        'DJ/Musician Colleague',
        'Artist/Production Team',
        'Inner Circle',
    ];

    /** @var string[] */
    public array $errors = [];

    public int $imported = 0;

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            // +1 buat baris header, +1 lagi biar penomoran sama kayak yang keliatan di Excel
            $rowNumber = $index + 2;

            $name = trim((string) ($row['nama'] ?? ''));
            $categoryInput = trim((string) ($row['kategori'] ?? ''));

            if ($name === '') {
                $this->errors[] = "Baris {$rowNumber}: kolom Nama kosong, dilewati.";
                continue;
            }

            $category = $this->matchCategory($categoryInput);
            if (!$category) {
                $this->errors[] = "Baris {$rowNumber}: kategori \"{$categoryInput}\" gak dikenali (cek ejaan sesuai template), dilewati.";
                continue;
            }

            $maxPax = (int) ($row['maks_pax'] ?? 1);
            if ($maxPax < 1) {
                $maxPax = 1;
            }

            $requiresNameRaw = Str::lower(trim((string) ($row['wajib_isi_nama'] ?? '')));
            $requiresName = in_array($requiresNameRaw, ['ya', 'yes', '1', 'true'], true);

            pressconGuest::create([
                'name' => $name,
                'category' => $category,
                'group' => trim((string) ($row['grup'] ?? '')) ?: null,
                'max_pax' => $maxPax,
                'requires_name' => $requiresName,
                'details' => trim((string) ($row['catatan'] ?? '')) ?: null,
                'slug' => pressconGuest::generateSlug($name, $category),
            ]);

            $this->imported++;
        }
    }

    /**
     * Cocokin input kategori dari Excel (case-insensitive) ke salah satu
     * kategori resmi. Return null kalau gak ketemu sama sekali.
     */
    private function matchCategory(string $input): ?string
    {
        foreach (self::CATEGORIES as $category) {
            if (Str::lower($category) === Str::lower($input)) {
                return $category;
            }
        }

        return null;
    }
}