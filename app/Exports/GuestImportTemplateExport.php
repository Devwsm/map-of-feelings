<?php

namespace App\Exports;

use App\Imports\GuestImport;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Template import tamu, terdiri dari 2 sheet:
 *  - "Data Tamu"  : sheet yang dipakai App\Imports\GuestImport, sudah dilengkapi
 *                   dropdown validasi Kategori & Wajib Isi Nama biar admin gak
 *                   bisa asal ketik / typo, plus beberapa contoh baris yang
 *                   mewakili skenario berbeda.
 *  - "Petunjuk"   : penjelasan tiap kolom + daftar kategori resmi, biar admin
 *                   ngerti sebelum isi, bukan cuma nebak dari contoh.
 *
 * Header di sheet "Data Tamu" WAJIB sama persis dengan yang dibaca
 * App\Imports\GuestImport (case-insensitive, tapi nama kolomnya harus sama).
 */
class GuestImportTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new GuestTemplateDataSheet(),
            new GuestTemplateInstructionSheet(),
        ];
    }
}

class GuestTemplateDataSheet implements FromArray, WithHeadings, WithTitle, WithColumnWidths, WithEvents
{
    public function array(): array
    {
        return [
            ['Bang Kimo', 'Colleague', 'Rombongan A', 2, 'Tidak', 'Contoh catatan internal (opsional)'],
            ['Media A', 'Media', 'Media Partner Grup 1', 1, 'Ya', 'Nama masih slot, tamu isi nama sendiri saat RSVP'],
            ['Jane Doe', 'Inner Circle', '', 1, 'Tidak', ''],
            ['Crew Sound System', 'Crew', 'Vendor Sound', 3, 'Ya', 'Kolom Grup, Catatan boleh dikosongkan'],
        ];
    }

    public function headings(): array
    {
        return ['Nama', 'Kategori', 'Grup', 'Maks Pax', 'Wajib Isi Nama', 'Catatan'];
    }

    public function title(): string
    {
        return 'Data Tamu';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 26, // Nama
            'B' => 22, // Kategori
            'C' => 22, // Grup
            'D' => 12, // Maks Pax
            'E' => 16, // Wajib Isi Nama
            'F' => 40, // Catatan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Header: bold + background biar kelihatan beda dari data.
                $sheet->getStyle('A1:F1')->getFont()->setBold(true);
                $sheet->getStyle('A1:F1')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D9E1F2');
                $sheet->getStyle('A1:F1')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Sampai baris ke berapa dropdown perlu disediakan (contoh + buffer 200 baris kosong).
                $lastRow = 205;

                // Dropdown Kategori (kolom B) — cegah typo, cuma bisa pilih dari 8 kategori resmi.
                $categoryList = '"' . implode(',', GuestImport::CATEGORIES) . '"';
                for ($row = 2; $row <= $lastRow; $row++) {
                    $validation = $sheet->getCell("B{$row}")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(true);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setPromptTitle('Pilih Kategori');
                    $validation->setPrompt('Pilih salah satu kategori resmi dari daftar dropdown.');
                    $validation->setErrorTitle('Kategori tidak valid');
                    $validation->setError('Kategori harus salah satu dari daftar resmi. Cek sheet "Petunjuk" untuk daftar lengkapnya.');
                    $validation->setFormula1($categoryList);

                    // Dropdown Wajib Isi Nama (kolom E) — cuma Ya / Tidak.
                    $requiresName = $sheet->getCell("E{$row}")->getDataValidation();
                    $requiresName->setType(DataValidation::TYPE_LIST);
                    $requiresName->setErrorStyle(DataValidation::STYLE_STOP);
                    $requiresName->setAllowBlank(true);
                    $requiresName->setShowInputMessage(true);
                    $requiresName->setShowErrorMessage(true);
                    $requiresName->setShowDropDown(true);
                    $requiresName->setPromptTitle('Wajib Isi Nama?');
                    $requiresName->setPrompt('"Ya" = nama masih slot tim, tamu akan diminta ganti nama saat RSVP. "Tidak" = nama sudah final.');
                    $requiresName->setErrorTitle('Nilai tidak valid');
                    $requiresName->setError('Isi "Ya" atau "Tidak" saja.');
                    $requiresName->setFormula1('"Ya,Tidak"');
                }

                $sheet->freezePane('A2');
            },
        ];
    }
}

class GuestTemplateInstructionSheet implements FromArray, WithTitle, WithColumnWidths, WithEvents
{
    public function array(): array
    {
        $categories = GuestImport::CATEGORIES;

        return [
            ['PETUNJUK PENGISIAN TEMPLATE IMPORT TAMU', ''],
            ['', ''],
            ['Kolom', 'Keterangan'],
            ['Nama', 'Wajib diisi. Nama tamu, atau nama slot rombongan (mis. "Media A") kalau belum tahu nama orangnya. Baris dengan Nama kosong akan dilewati saat import.'],
            ['Kategori', 'Wajib diisi. Harus salah satu dari 8 kategori resmi di daftar bawah (pilih lewat dropdown di sheet "Data Tamu"). Kalau tidak cocok / typo, baris akan dilewati.'],
            ['Grup', 'Opsional. Nama rombongan/tim, bebas teks. Boleh dikosongkan.'],
            ['Maks Pax', 'Opsional. Jumlah maksimal orang untuk satu slot tamu ini. Kalau dikosongkan atau diisi angka < 1, otomatis dianggap 1.'],
            ['Wajib Isi Nama', 'Opsional (default: Tidak). Isi "Ya" kalau Nama di atas masih nama slot tim dan tamu perlu mengisi nama aslinya sendiri saat buka undangan. Isi "Tidak" kalau Nama sudah nama final, tamu tinggal konfirmasi ejaan.'],
            ['Catatan', 'Opsional. Catatan internal untuk admin, tidak akan terlihat oleh tamu.'],
            ['', ''],
            ['DAFTAR KATEGORI RESMI', ''],
        ];
    }

    public function title(): string
    {
        return 'Petunjuk';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 26,
            'B' => 90,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->mergeCells('A1:B1');

                $sheet->getStyle('A3:B3')->getFont()->setBold(true);
                $sheet->getStyle('A3:B3')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D9E1F2');

                $sheet->getStyle('A11')->getFont()->setBold(true);
                $sheet->mergeCells('A11:B11');

                foreach ($sheet->getRowIterator(4, 9) as $row) {
                    $sheet->getStyle('B' . $row->getRowIndex())
                        ->getAlignment()->setWrapText(true)->setVertical(Alignment::VERTICAL_TOP);
                }

                // Tulis daftar kategori resmi bernomor, mulai baris 12.
                $categories = GuestImport::CATEGORIES;
                $startRow = 12;
                foreach ($categories as $i => $category) {
                    $sheet->setCellValue('A' . ($startRow + $i), $i + 1);
                    $sheet->setCellValue('B' . ($startRow + $i), $category);
                }

                $sheet->getStyle('A1:B' . ($startRow + count($categories)))
                    ->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            },
        ];
    }
}