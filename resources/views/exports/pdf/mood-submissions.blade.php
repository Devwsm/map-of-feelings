<!--
    Path: resources/views/exports/pdf/mood-submissions.blade.php
    Dirender via barryvdh/laravel-dompdf, dipanggil dari
    importExportController@exportMoodSubmissionsPdf.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Lagu - Map of Feelings</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #111;
        }

        h1 {
            font-size: 16px;
            margin-bottom: 2px;
        }

        p.subtitle {
            font-size: 10px;
            color: #666;
            margin-top: 0;
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }
    </style>
</head>

<body>
    <h1>Data Lagu Didownload - Map of Feelings</h1>
    <p class="subtitle">Diexport pada {{ now()->format('d M Y H:i') }} &middot; Total {{ $submissions->count() }} data
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pengunjung</th>
                <th>Instagram</th>
                <th>Mood</th>
                <th>Lagu</th>
                <th>Jawaban Dipilih</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($submissions as $i => $submission)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $submission->visitor_name ?: '-' }}</td>
                    <td>{{ $submission->visitor_instagram ?: '-' }}</td>
                    <td>{{ $submission->mood->feeling ?? '-' }}</td>
                    <td>{{ $submission->mood->song ?? '-' }}</td>
                    <td>{{ $submission->selected_answer ?: '-' }}</td>
                    <td>{{ optional($submission->created_at)->format('d M Y H:i') ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
