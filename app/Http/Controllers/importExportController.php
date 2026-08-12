<?php

namespace App\Http\Controllers;

use App\Exports\GuestCheckinExport;
use App\Exports\GuestImportTemplateExport;
use App\Exports\MoodSubmissionsExport;
use App\Imports\GuestImport;
use App\Models\mood_submissions;
use App\Models\pressconGuest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\RedirectResponse;

/**
 * Route: prefix /dashboard/export & /dashboard/import (role:admin)
 * Export dikerjakan dulu; Import nyusul.
 */
class importExportController extends Controller
{
    /**
     * GET /dashboard/export
     */
    public function index(): View
    {
        return view('pages.dashboard.export.index', [
            'active' => 'export-import',
            'totalSubmissions' => mood_submissions::count(),
            'totalCheckedIn' => pressconGuest::where('checked_in', true)->count(),
        ]);
    }

    /**
     * GET /dashboard/export/database
     * Dump full database jadi file .sql, murni PHP (gak butuh binary mysqldump)
     * karena hosting-nya shared cPanel tanpa akses terminal.
     */
    public function exportDatabase(): Response
    {
        $filename = 'mof_backup_' . now()->format('Y-m-d_His') . '.sql';
        $sql = $this->generateSqlDump();

        return response($sql, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * GET /dashboard/export/mood-submissions/excel
     */
    public function exportMoodSubmissionsExcel()
    {
        return Excel::download(new MoodSubmissionsExport, 'mof_data_lagu_' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * GET /dashboard/export/mood-submissions/pdf
     */
    public function exportMoodSubmissionsPdf()
    {
        $submissions = mood_submissions::with('mood')->latest('created_at')->get();
        $pdf = Pdf::loadView('exports.pdf.mood-submissions', ['submissions' => $submissions])
            ->setPaper('a4', 'landscape');

        return $pdf->download('mof_data_lagu_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * GET /dashboard/export/guest-checkin/excel
     */
    public function exportGuestCheckinExcel()
    {
        return Excel::download(new GuestCheckinExport, 'mof_tamu_checkin_' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * GET /dashboard/export/guest-checkin/pdf
     */
    public function exportGuestCheckinPdf()
    {
        $guests = pressconGuest::with('checkedInBy')
            ->where('checked_in', true)
            ->orderBy('arrival_time')
            ->get();

        $pdf = Pdf::loadView('exports.pdf.guest-checkin', ['guests' => $guests])
            ->setPaper('a4', 'landscape');

        return $pdf->download('mof_tamu_checkin_' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * GET /dashboard/export/database/preview
     * Ringkasan tabel + jumlah baris, karena preview mentah file .sql
     * kurang enak dibaca manual.
     */
    public function previewDatabase(): View
    {
        $tables = collect(DB::select('SHOW TABLES'))->map(function ($row) {
            $table = array_values((array) $row)[0];
            return [
                'name' => $table,
                'rows' => DB::table($table)->count(),
            ];
        });

        return view('pages.dashboard.export.preview-database', [
            'tables' => $tables,
            'active' => 'export-import',
        ]);
    }

    /**
     * GET /dashboard/export/mood-submissions/preview
     * Render view PDF yang sama tapi sebagai HTML biasa (bukan di-convert
     * dompdf), dibuka di tab baru.
     */
    public function previewMoodSubmissions(): View
    {
        $submissions = mood_submissions::with('mood')->latest('created_at')->get();

        return view('exports.pdf.mood-submissions', ['submissions' => $submissions]);
    }

    /**
     * GET /dashboard/export/guest-checkin/preview
     */
    public function previewGuestCheckin(): View
    {
        $guests = pressconGuest::with('checkedInBy')
            ->where('checked_in', true)
            ->orderBy('arrival_time')
            ->get();

        return view('exports.pdf.guest-checkin', ['guests' => $guests]);
    }

    public function importIndex(): View
    {
        return view('pages.dashboard.import.index', [
            'active' => 'export-import',
            'totalGuests' => pressconGuest::count(),
            'categories' => GuestImport::CATEGORIES,
        ]);
    }

    public function downloadGuestTemplate()
    {
        return Excel::download(new GuestImportTemplateExport, 'template_import_tamu.xlsx');
    }

    public function importGuests(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);
        $import = new GuestImport();
        Excel::import($import, $request->file('file'));
        return redirect()
            ->route('dashboard.import')
            ->with('status', "{$import->imported} tamu berhasil diimport.")
            ->with('importErrors', $import->errors);
    }

    /**
     * Generate isi file .sql untuk semua tabel di database aktif.
     * Struktur (CREATE TABLE) diambil dari SHOW CREATE TABLE, isi (INSERT)
     * diambil langsung tanpa chunk (data campaign site ini kecil, aman).
     */
    private function generateSqlDump(): string
    {
        $tables = collect(DB::select('SHOW TABLES'))
            ->map(fn($row) => array_values((array) $row)[0]);

        $output = "-- Map of Feelings full database backup\n";
        $output .= "-- Generated at " . now()->toDateTimeString() . "\n\n";
        $output .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            // Struktur tabel
            $createStmt = DB::select("SHOW CREATE TABLE `{$table}`")[0];
            $createSql = $createStmt->{'Create Table'};

            $output .= "-- --------------------------------------------------------\n";
            $output .= "-- Table: {$table}\n";
            $output .= "-- --------------------------------------------------------\n\n";
            $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $output .= $createSql . ";\n\n";

            // Isi tabel. Data campaign site ini kecil, jadi ambil langsung tanpa
            // chunking (aman untuk mood_submissions, presscon_guests, dll).
            $rows = DB::table($table)->get();

            if ($rows->isNotEmpty()) {
                $columns = collect((array) $rows->first())
                    ->keys()
                    ->map(fn($col) => "`{$col}`")
                    ->implode(', ');

                $values = $rows->map(function ($row) {
                    $escaped = array_map(function ($value) {
                        if (is_null($value)) {
                            return 'NULL';
                        }
                        return DB::getPdo()->quote((string) $value);
                    }, (array) $row);
                    return '(' . implode(', ', $escaped) . ')';
                })->implode(",\n");

                $output .= "INSERT INTO `{$table}` ({$columns}) VALUES\n{$values};\n\n";
            }

            $output .= "\n";
        }

        $output .= "SET FOREIGN_KEY_CHECKS=1;\n";

        return $output;
    }
}