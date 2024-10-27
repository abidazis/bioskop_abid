<?php
// Ambil data input dari form
$movie_title = $_POST['movie_title'];
$showtime = $_POST['showtime'];
$ticket_type = $_POST['ticket_type'];
$ticket_quantity = $_POST['ticket_quantity'];
$day_type = $_POST['day_type'];

// Atur harga berdasarkan jenis tiket
if (trim($ticket_type) == 'Dewasa') {
    $price_per_ticket = 50000;
} else {
    $price_per_ticket = 30000;
}

// Tambahan biaya untuk weekend
if ($day_type == 'weekend') {
    $price_per_ticket += 10000;  // Tambahan Rp10.000
}

// Hitung total harga
$total_price = $price_per_ticket * $ticket_quantity;

// Diskon 10% jika total harga lebih dari Rp150.000
if ($total_price > 150000) {
    $discount = 0.1 * $total_price;
    $total_price -= $discount;
} else {
    $discount = 0;
}

// Buat kode pembayaran dan tiket
$payment_code = "PAY_" . strtoupper(uniqid());
$ticket_code = "TKT_" . strtoupper(uniqid());

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/styleTiket.css">
</head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg fixed-top">
            <div class="container">
            <a class="navbar-brand" href="#">Biokop Abid</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="https://index.html">Beranda</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="kontak">Kontak</a>
                    </li>
                </ul>
                <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            </div>
        </nav>
        <div style="display: flex; justify-content: space-between;">
                <!-- Bagian kiri: Informasi Pembayaran -->
                <div class="ticket-info col-md-6 mt-5">
                    <h2>Hasil Pemesanan Tiket Anda</h2>
                    <p><strong>Judul Film:</strong> <?php echo $movie_title; ?></p>
                    <p><strong>Waktu Tayang:</strong> <?php echo $showtime; ?></p>
                    <p><strong>Jenis Tiket:</strong> <?php echo ucfirst($ticket_type); ?></p>
                    <p><strong>Jumlah Tiket:</strong> <?php echo $ticket_quantity; ?></p>
                    <p><strong>Hari Pemesanan:</strong> <?php echo $day_type; ?></p>
                    <p><strong>Harga per Tiket:</strong> Rp<?php echo number_format($price_per_ticket); ?></p>
                    <p><strong>Total Harga:</strong> Rp<?php echo number_format($total_price); ?></p>
                    <p><strong>Diskon:</strong> Rp<?php echo number_format($discount); ?></p>
                    <p><strong>Status:</strong> Belum Dibayar</p>
                    <p><strong>Kode Pembayaran:</strong> <?php echo $payment_code; ?></p>
                    <button class="btn btn-success" id="pay-button">Bayar Sekarang</button>
                </div>
                <!-- Bagian kanan: E-Tiket -->
                <div class="e-ticket col-md-6 mt-5" id="e-ticket" style="border-left: 1px solid #ccc; padding-left: 20px; display: none;">
                    <h2>E-Tiket Bioskop</h2>
                    <p><strong>Judul Film:</strong> <?php echo $movie_title; ?></p>
                    <p><strong>Waktu Tayang:</strong> <?php echo $showtime; ?></p>
                    <p><strong>Jumlah Tiket:</strong> <?php echo $ticket_quantity; ?> <?php echo ucfirst($ticket_type); ?></p>
                    <p><strong>Kode Tiket:</strong> <?php echo $ticket_code; ?></p>
                    <img src="asset/contohBarcode.png" alt="Barcode" style="width: 200px; height: auto; margin-top: 15px;">
                    <p>Tunjukkan e-tiket ini di pintu masuk bioskop.</p>
                    <button class="btn btn-primary" onclick="printTicket()">Cetak Tiket</button>
                </div>
            </div>

            <script>
                document.getElementById('pay-button').addEventListener('click', function() {
                    // Temukan elemen yang menunjukkan status pembayaran
                    const statusElement = document.querySelector('.ticket-info p:nth-child(10)');
                    
                    // Perbarui teks pada elemen status pembayaran
                    if (statusElement) {
                        statusElement.innerHTML = '<strong>Status:</strong> Sudah Dibayar';
                    }
                    
                    // Tampilkan e-tiket
                    document.getElementById('e-ticket').style.display = 'block';
                });
                function printTicket() {
                    var eTicketElement = document.getElementById('e-ticket').outerHTML;
                    
                    // Membuka jendela baru untuk mencetak
                    var printWindow = window.open('', '_blank');
                    printWindow.document.open();
                    printWindow.document.write(`
                        <html>
                        <head>
                            <title>Cetak E-Tiket</title>
                            <style>
                                /* Style untuk tampilan cetak */
                                #e-ticket {
                                    max-width: 320px;
                                    padding: 20px;
                                    margin: auto;
                                    text-align: center;
                                    border: 1px solid #ddd;
                                    border-radius: 8px;
                                    background-color: #f9f9f9;
                                    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
                                }
                                #e-ticket h2 {
                                    font-size: 24px;
                                    margin-bottom: 10px;
                                }
                                .ticket-details p {
                                    margin: 8px 0;
                                    font-size: 16px;
                                }
                                /* Sembunyikan tombol cetak di mode print */
                                button {
                                    display: none;
                                }
                            </style>
                        </head>
                        <body onload="window.print(); window.close();">
                            ${eTicketElement}
                        </body>
                        </html>
                    `);
                    printWindow.document.close();
                }
            </script>
        </body>
        <script>

        </script>
</html>
