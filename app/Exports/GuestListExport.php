<?php

namespace App\Exports;

use App\Models\pressconGuest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * Export daftar SEMUA tamu press con (bukan cuma yang sudah check-in kayak
 * GuestCheckinExport) beserta link undangan pribadi masing-masing
 * (/presscon-inv/{slug}), biar gampang di-copy-paste buat dikirim manual
 * lewat WhatsApp/email tanpa harus buka satu-satu dari dashboard.
 * Dipakai dari importExportController@exportGuestListExcel.
 */
class GuestListExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return pressconGuest::orderBy('category')->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Kategori',
            'Grup',
            'Maks Pax',
            'Status RSVP',
            'Nama Dikonfirmasi Tamu',
            'Pax Dikonfirmasi',
            'Sudah Check-in',
            'Link Undangan',
        ];
    }

    public function map($guest): array
    {
        return [
            $guest->name,
            $guest->category,
            $guest->group ?: '-',
            $guest->max_pax,
            match ($guest->rsvp_status) {
                'hadir' => 'Hadir',
                'tidak_hadir' => 'Tidak Hadir',
                default => 'Belum RSVP',
            },
            $guest->submitted_name ?: '-',
            $guest->confirmed_pax ?? '-',
            $guest->checked_in ? 'Ya' : 'Belum',
            route('presscon-inv.guest', $guest->slug),
        ];
    }
}