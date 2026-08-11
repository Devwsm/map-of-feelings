//
import Swal from "sweetalert2";

// Expose ke window supaya bisa dipanggil langsung sebagai Swal.fire(...)
// dari inline <script> di blade (lihat resources/views/components/errors/alert.blade.php),
// tanpa perlu bikin file JS terpisah cuma buat satu alert.
window.Swal = Swal;
