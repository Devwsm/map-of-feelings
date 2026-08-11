<?php

namespace App\Exports;

use App\Models\pressconGuest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * Export daftar tamu yang sudah check-in beserta staff yang meng-check-in-kan.
 * Dipakai dari importExportController@exportGuestCheckinExcel.
 */
class GuestCheckinExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return pressconGuest::with('checkedInBy')
            ->where('checked_in', true)
            ->orderBy('arrival_time')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Tamu',
            'Kategori',
            'Grup',
            'Waktu Kedatangan',
            'Di-check-in Oleh',
        ];
    }

    public function map($guest): array
    {
        return [
            $guest->submitted_name ?: $guest->name,
            $guest->category,
            $guest->group ?: '-',
            optional($guest->arrival_time)->format('d M Y H:i') ?: '-',
            $guest->checkedInBy->name ?? '-',
        ];
    }
}