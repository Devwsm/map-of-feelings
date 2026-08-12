<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * Template kosong (1 baris contoh) buat admin isi sebelum upload lewat
 * importExportController@importGuests. Header di sini WAJIB sama persis
 * sama yang dibaca App\Imports\GuestImport (case-insensitive, tapi nama
 * kolomnya harus sama).
 */
class GuestImportTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['Bang Kimo', 'Colleague', 'Rombongan A', 2, 'Tidak', 'Contoh catatan internal (opsional)'],
        ];
    }

    public function headings(): array
    {
        return ['Nama', 'Kategori', 'Grup', 'Maks Pax', 'Wajib Isi Nama', 'Catatan'];
    }
}