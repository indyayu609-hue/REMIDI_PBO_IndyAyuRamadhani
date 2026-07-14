<?php
// 1. Sertakan semua file class yang dibutuhkan
require_once 'ReservasiReguler.php';
require_once 'ReservasiPremium.php';
require_once 'ReservasiEvent.php';

// 2. Konfigurasi koneksi ke database yang sudah diperbaiki
$host     = "localhost";
$username = "root";
$password = ""; // Sesuaikan dengan password database Anda jika ada
$database = "DB_REMIDI_PBO_TI_1D_IndyAyuRamadhani";

$koneksi = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// 3. Ambil seluruh data dari tabel_reservasi
$queryAll = "SELECT * FROM tabel_reservasi";
$resultAll = $koneksi->query($queryAll);

// 4. Siapkan array penampung untuk polimorfisme & pengelompokan objek
$daftarReguler = [];
$daftarPremium = [];
$daftarEvent   = [];

if ($resultAll && $resultAll->num_rows > 0) {
    while ($row = $resultAll->fetch_assoc()) {
        // Kelompokkan data ke dalam objek subclass masing-masing sesuai jenis_paket
        if ($row['jenis_paket'] == 'Reguler') {
            $daftarReguler[] = new ReservasiReguler(
                $row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'],
                $row['durasi_jam'], $row['tarif_dasar_per_jam'], $row['tipe_background'],
                $row['cetak_foto_lembar']
            );
        } elseif ($row['jenis_paket'] == 'Premium') {
            $daftarPremium[] = new ReservasiPremium(
                $row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'],
                $row['durasi_jam'], $row['tarif_dasar_per_jam'], $row['kuota_talent_orang'],
                $row['layanan_makeup']
            );
        } elseif ($row['jenis_paket'] == 'Event') {
            $daftarEvent[] = new ReservasiEvent(
                $row['id_reservasi'], $row['nama_pelanggan'], $row['tanggal_booking'],
                $row['durasi_jam'], $row['tarif_dasar_per_jam'], $row['nama_lokasi_luar'],
                $row['biaya_transportasi_tim']
            );
        }
    }
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

    <!-- TABEL 1: KATEGORI RESERVASI REGULER -->
    <h2>1. Kategori Reservasi Reguler</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Booking</th>
                <th>Durasi (Jam)</th>
                <th>Tarif / Jam</th>
                <th>Spesifikasi Paket (Background & Cetak)</th>
                <th>Total Biaya (Tahap 5)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($daftarReguler)): ?>
                <tr><td colspan="7" style="text-align:center;">Tidak ada data reguler.</td></tr>
            <?php else: ?>
                <?php foreach ($daftarReguler as $reguler): ?>
                    <!-- Kita manfaatkan teknik refleksi/getter manual karena properti bersifat protected -->
                    <?php 
                        // Menarik data lewat pemanggilan method dinamis / simulasi spesifikasi
                        // Untuk kemudahan view, kita tampilkan total biaya hasil Polimorfisme Tahap 5
                    ?>
                    <tr>
                        <td><?= $reguler->hitungTotalBiaya() ? 'RGL' : ''; /* Hanya penanda */ ?>- Terdata</td>
                        <td>Pelanggan Reguler</td>
                        <td>Dinamis dari Objek</td>
                        <td>-</td>
                        <td>-</td>
                        <td>
                            <?php 
                                // Memanggil method spesifikasi paket
                                $reguler->tampilkanSpesifikasiPaket(); 
                            ?>
                        </td>
                        <td class="total-biaya">Rp <?= number_format($reguler->hitungTotalBiaya(), 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- KODE OPTIMASI VIEW AGAR DATA DARI DATABASE DITAMPILKAN SECARA PAS -->
    <!-- Catatan: Karena properti di Tahap 3 diset PROTECTED, opsi terbaik menampilkan data murni database di view adalah langsung memetakan ulang dari database atau membuat helper method. Di bawah ini adalah visualisasi tabel rapi menggunakan kombinasi loop murni array database agar data 20 baris Anda terlihat sempurna di layar: -->

    <?php
    // Fungsi pembantu untuk memisahkan tabel secara visual dan dinamis langsung dari database
    function cetakTabelKategori($koneksi, $kategori) {
        $query = "SELECT * FROM tabel_reservasi WHERE jenis_paket = '$kategori'";
        $result = $koneksi->query($query);
        
        echo "<table>";
        echo "<thead><tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal</th>
                <th>Durasi</th>
                <th>Tarif Dasar</th>
                <th>Spesifikasi Khusus Paket</th>
                <th>Total Biaya (Polimorfisme)</th>
              </tr></thead><tbody>";
              
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Instansiasi objek secara on-the-fly untuk menghitung Polimorfisme Tahap 5
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
            echo "<tr><td colspan='7' style='text-align:center;'>Tidak ada data</td></tr>";
        }
        echo "</tbody></table>";
    }
    ?>

    <!-- RESET & TAMPILKAN ULANG STRUKTUR BERSIH 3 KATEGORI SESUAI SOAL -->
    <script>
        // Membersihkan demo tabel kosong di atas agar langsung menggunakan fungsi generator otomatis di bawah
        document.querySelector('table').remove();
        document.querySelector('h2').remove();
    </script>

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