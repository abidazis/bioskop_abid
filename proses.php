<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pemesanan Tiket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Hasil Pemesanan Tiket</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan input dari form
    $jenis_tiket = $_POST['jenis_tiket'];
    $jumlah_tiket = $_POST['jumlah_tiket'];
    $hari = $_POST['hari'];

    // Harga dasar tiket
    if ($jenis_tiket == 'dewasa') {
        $harga_tiket = 50000;
        $jenis_tiket_str = "Dewasa";
    } else {
        $harga_tiket = 30000;
        $jenis_tiket_str = "Anak-anak";
    }

    // Tambahan biaya untuk weekend
    $biaya_tambahan = ($hari == 'weekend') ? 10000 : 0;
    $hari_str = ($hari == 'weekend') ? "Weekend" : "Weekday";

    // Menghitung total harga
    $total_harga = ($harga_tiket + $biaya_tambahan) * $jumlah_tiket;

    // Memproses diskon jika total harga lebih dari Rp150.000
    $diskon = 0;
    if ($total_harga > 150000) {
        $diskon = 0.1 * $total_harga;
        $total_harga_setelah_diskon = $total_harga - $diskon;
    } else {
        $total_harga_setelah_diskon = $total_harga;
    }

    // Output pesanannya
    echo "<h3>Detail Pemesanan Tiket:</h3>";
    echo "Jenis Tiket: $jenis_tiket_str<br>";
    echo "Jumlah Tiket: $jumlah_tiket<br>";
    echo "Hari Pemesanan: $hari_str<br>";
    echo "Harga per Tiket: Rp" . number_format($harga_tiket, 0, ',', '.') . "<br>";
    echo "Biaya Tambahan per Tiket: Rp" . number_format($biaya_tambahan, 0, ',', '.') . "<br>";
    echo "Total Harga Sebelum Diskon: Rp" . number_format($total_harga, 0, ',', '.') . "<br>";
    
    if ($diskon > 0) {
        echo "Diskon: Rp" . number_format($diskon, 0, ',', '.') . "<br>";
        echo "<h3>Total Harga Setelah Diskon: Rp" . number_format($total_harga_setelah_diskon, 0, ',', '.') . "</h3>";
    } else {
        echo "<h3>Total Harga: Rp" . number_format($total_harga_setelah_diskon, 0, ',', '.') . "</h3>";
    }
}
?>

<a href="index.html">Kembali ke Form</a>

</body>
</html>
