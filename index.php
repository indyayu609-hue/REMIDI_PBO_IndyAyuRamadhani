<?php
// 1. Sertakan semua file class yang dibutuhkan (Tahap 3 & 4)
require_once 'ReservasiReguler.php';
require_once 'ReservasiPremium.php';
require_once 'ReservasiEvent.php';

// 2. Konfigurasi koneksi ke database (Sudah disesuaikan dengan database aktif Anda)
$host     = "localhost";
$username = "root";
$password = ""; 
$database = "db_remidi_pbo_indyayuramadhani"; 

$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// 3. Fungsi pembantu untuk memisahkan tabel secara terkelompok sesuai KETENTUAN TAHAP 6
function cetakTabelKategori($koneksi, $kategori) {
    // Menggunakan query SELECT-WHERE sesuai konsep subclass
    $query = "SELECT * FROM tabel_reservasi WHERE jenis_paket = '$kategori'";
    $result = $koneksi->query($query);
    
    echo "<table>";
    echo "<thead><tr>
            <th style='width: 5%;'>ID</th>
            <th style='width: 20%;'>Nama Pelanggan</th>
            <th style='width: 15%;'>Tanggal Booking</th>
            <th style='width: 10%;'>Durasi</th>
            <th style='width: 15%;'>Tarif Dasar / Jam</th>
            <th style='width: 20%;'>Spesifikasi Khusus Paket</th>
            <th style='width: 15%;'>Total Biaya (Polimorfisme)</th>
          </tr></thead><tbody>";
          
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Implementasi Polimorfisme: Menginstansiasi objek sesuai kategori untuk menghitung total biaya (Tahap 5)
            if ($kategori == 'Reguler') {
                $obj = new ReservasiReguler($row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'], $row['durasi_jam'], $row['tarif_dasar_per_jam'], $row['tipe_background'], $row['cetak_foto_lembar']);
                $spesifikasi = "Background: " . $row['tipe_background'] . "<br>Cetak: " . $row['cetak_foto_lembar'] . " Lembar";
            } elseif ($kategori == 'Premium') {
                $obj = new ReservasiPremium($row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'], $row['durasi_jam'], $row['tarif_dasar_per_jam'], $row['kuota_talent_orang'], $row['layanan_makeup']);
                $spesifikasi = "Kuota Talent: " . $row['kuota_talent_orang'] . " Orang<br>Makeup: " . $row['layanan_makeup'];
            } else {
                $obj = new ReservasiEvent($row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'], $row['durasi_jam'], $row['tarif_dasar_per_jam'], $row['nama_lokasi_luar'], $row['biaya_transportasi_tim']);
                $spesifikasi = "Lokasi: " . $row['nama_lokasi_luar'] . "<br>Akomodasi Tim: Rp " . number_format($row['biaya_transportasi_tim'], 0, ',', '.');
            }
            
            echo "<tr>
                    <td>{$row['id_reservasi']}</td>
                    <td>{$row['nama_pelanggan']}</td>
                    <td>{$row['tanggal_booking']}</td>
                    <td>{$row['durasi_jam']} Jam</td>
                    <td>Rp " . number_format($row['tarif_dasar_per_jam'], 0, ',', '.') . "</td>
                    <td>{$spesifikasi}</td>
                    <td class='total-biaya'>Rp " . number_format($obj->hitungTotalBiaya(), 0, ',', '.') . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada data transaksi untuk kategori ini.</td></tr>";
    }
    echo "</tbody></table>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Transaksi Reservasi Studio Foto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
        h1 { text-align: center; color: #333; }
        h2 { color: #2c3e50; margin-top: 40px; border-bottom: 2px solid #2c3e50; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #2c3e50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .total-biaya { font-weight: bold; color: #e74c3c; }
    </style>
</head>
<body>

    <h1>DAFTAR TRANSAKSI RESERVASI STUDIO FOTO</h1>
    <p style="text-align: center; font-style: italic;">Sistem Informasi Manajemen Studio Foto - IndyAyuRamadhani (TI-1D)</p>

    <h2>1. Kelompok Kategori: Reservasi Reguler</h2>
    <?php cetakTabelKategori($koneksi, 'Reguler'); ?>

    <h2>2. Kelompok Kategori: Reservasi Premium</h2>
    <?php cetakTabelKategori($koneksi, 'Premium'); ?>

    <h2>3. Kelompok Kategori: Reservasi Event</h2>
    <?php cetakTabelKategori($koneksi, 'Event'); ?>

</body>
</html>
<?php
$koneksi->close();
?>