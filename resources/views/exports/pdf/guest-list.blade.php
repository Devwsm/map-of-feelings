<!--
    Path: resources/views/exports/pdf/guest-list.blade.php
    Dipakai buat preview (dibuka di tab baru sebagai HTML biasa) via
    importExportController@previewGuestList. Bukan buat di-download jadi PDF
    (beda sama guest-checkin.blade.php yang juga dipakai dompdf) karena kolom
    Link Undangan lebih enak diklik langsung dari browser.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Tamu & Link Undangan - Map of Feelings</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #111;
            margin: 24px;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 2px;
        }

        p.subtitle {
            font-size: 11px;
            color: #666;
            margin-top: 0;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 7px 9px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        a {
            color: #1757ff;
            word-break: break-all;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-hadir {
            background: #dcfce7;
            color: #166534;
        }

        .badge-tidak_hadir {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-pending {
            background: #f3f4f6;
            color: #4b5563;
        }
    </style>
</head>

<body>
    <h1>Data Tamu &amp; Link Undangan - Map of Feelings</h1>
    <p class="subtitle">Diexport pada {{ now()->format('d M Y H:i') }} &middot; Total {{ $guests->count() }} tamu</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Grup</th>
                <th>Status RSVP</th>
                <th>Check-in</th>
                <th>Link Undangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($guests as $i => $guest)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $guest->submitted_name ?: $guest->name }}</td>
                    <td>{{ $guest->category }}</td>
                    <td>{{ $guest->group ?: '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $guest->rsvp_status }}">
                            @if ($guest->rsvp_status === 'hadir')
                                Hadir
                            @elseif ($guest->rsvp_status === 'tidak_hadir')
                                Tidak Hadir
                            @else
                                Belum RSVP
                            @endif
                        </span>
                    </td>
                    <td>{{ $guest->checked_in ? 'Ya' : 'Belum' }}</td>
                    <td><a href="{{ route('presscon-inv.guest', $guest->slug) }}"
                            target="_blank">{{ route('presscon-inv.guest', $guest->slug) }}</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada tamu yang ditambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
