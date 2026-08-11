<!--
    Path: resources/views/exports/pdf/guest-checkin.blade.php
    Dirender via barryvdh/laravel-dompdf, dipanggil dari
    importExportController@exportGuestCheckinPdf.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Tamu Check-in - Map of Feelings</title>
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
    <h1>Data Tamu Check-in - Map of Feelings</h1>
    <p class="subtitle">Diexport pada {{ now()->format('d M Y H:i') }} &middot; Total {{ $guests->count() }} tamu
        checked-in</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Tamu</th>
                <th>Kategori</th>
                <th>Grup</th>
                <th>Waktu Kedatangan</th>
                <th>Di-check-in Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($guests as $i => $guest)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $guest->submitted_name ?: $guest->name }}</td>
                    <td>{{ $guest->category }}</td>
                    <td>{{ $guest->group ?: '-' }}</td>
                    <td>{{ optional($guest->arrival_time)->format('d M Y H:i') ?: '-' }}</td>
                    <td>{{ $guest->checkedInBy->name ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada tamu yang check-in.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
