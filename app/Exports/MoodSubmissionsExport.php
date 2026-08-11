<?php

namespace App\Exports;

use App\Models\mood_submissions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * Export daftar mood_submissions (histori "Save Coordinate" pengunjung) ke Excel.
 * Dipakai dari importExportController@exportMoodSubmissionsExcel.
 */
class MoodSubmissionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return mood_submissions::with('mood')->latest('created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Pengunjung',
            'Instagram',
            'Mood',
            'Lagu',
            'Jawaban Dipilih',
            'IP Address',
            'Tanggal',
        ];
    }

    public function map($submission): array
    {
        return [
            $submission->visitor_name ?: '-',
            $submission->visitor_instagram ?: '-',
            $submission->mood->feeling ?? '-',
            $submission->mood->song ?? '-',
            $submission->selected_answer ?: '-',
            $submission->ip_address ?: '-',
            optional($submission->created_at)->format('d M Y H:i') ?: '-',
        ];
    }
}