<?php
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

// Inisialisasi objek dompdf
$dompdf = new Dompdf();

// Dapatkan data dari form atau sesi (pastikan sesuai dengan data pemesanan)
$movie_title = isset($_POST['movie_title']) ? $_POST['movie_title'] : 'Unknown';
$showtime = isset($_POST['showtime']) ? $_POST['showtime'] : 'Unknown';
$ticket_quantity = isset($_POST['ticket_quantity']) ? intval($_POST['ticket_quantity']) : 0;
$payment_code = isset($_POST['payment_code']) ? $_POST['payment_code'] : 'Unknown';
$ticket_code = strtoupper(uniqid('TKT_')); // Kode tiket unik

// Buat konten HTML untuk PDF
$html = '
    <h1 style="text-align:center;">E-Tiket Bioskop</h1>
    <p><strong>Judul Film:</strong> ' . $movie_title . '</p>
    <p><strong>Waktu Tayang:</strong> ' . $showtime . '</p>
    <p><strong>Jumlah Tiket:</strong> ' . $ticket_quantity . '</p>
    <p><strong>Kode Pembayaran:</strong> ' . $payment_code . '</p>
    <p><strong>Kode Tiket:</strong> ' . $ticket_code . '</p>
    <p style="text-align:center; font-style:italic;">Tunjukkan e-tiket ini di pintu masuk bioskop.</p>
';

// Muat HTML ke dompdf
$dompdf->loadHtml($html);

// (Opsional) Atur ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Unduh PDF
$dompdf->stream('E-Tiket_' . $ticket_code . '.pdf', array("Attachment" => 1));
?>
