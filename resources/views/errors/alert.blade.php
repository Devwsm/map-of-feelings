{{--
    Path: resources/views/components/errors/alert.blade.php
    Komponen SweetAlert reusable, dipanggil lewat <x-errors.alert /> di layout.

    Otomatis nge-detect 3 sumber pesan (urutan prioritas kalau lebih dari satu ada
    bersamaan: validation error > flash 'error' > flash 'status'):
    - $errors (validation bag bawaan Laravel, otomatis keisi kalau ->withErrors())
    - session('error')  -> flash pesan gagal custom dari controller
    - session('status') -> flash pesan sukses (dipakai di tamu, panel, dll)

    Kalau gak ada salah satu dari 3 itu, komponen ini gak render apa-apa
    (gak nambah beban SweetAlert script di halaman yang gak butuh).
--}}
@php
    $hasErrors = $errors->any();
    $flashError = session('error');
    $flashStatus = session('status');
@endphp

@if ($hasErrors || $flashError || $flashStatus)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($hasErrors)
                Swal.fire({
                    icon: 'error',
                    title: 'Ups, ada yang perlu diperbaiki',
                    html: `@foreach ($errors->all() as $message)<p class="text-sm">{{ $message }}</p>@endforeach`,
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#0a0a0b',
                });
            @elseif ($flashError)
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: @json($flashError),
                    confirmButtonText: 'Mengerti',
                    confirmButtonColor: '#0a0a0b',
                });
            @elseif ($flashStatus)
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: @json($flashStatus),
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#0a0a0b',
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        });
    </script>
@endif
