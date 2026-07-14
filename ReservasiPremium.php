<?php
require_once 'Reservasi.php';

class ReservasiPremium extends Reservasi {
    // Properti tambahan spesifik
    private $kuotaTalentOrang;
    private $layananMakeup;

    public function __construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam, $kuotaTalentOrang, $layananMakeup) {
        parent::__construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam);
        $this->kuotaTalentOrang = $kuotaTalentOrang;
        $this->layananMakeup = $layananMakeup;
    }

    // TAHAP 5: Method Overriding dengan logika bisnis baru (Surcharge Layanan 20%)
    public function hitungTotalBiaya() {
        $totalDurasi = $this->durasiJam * $this->tarifDasarPerJam;
        $surcharge = 1.20; 
        return $totalDurasi * $surcharge;
    }

    public function tampilkanSpesifikasiPaket() {
        echo "Paket: Premium\n";
        echo "Kuota Talent: " . $this->kuotaTalentOrang . " Orang\n";
        echo "Layanan Makeup: " . $this->layananMakeup . "\n";
    }

    // Method query SELECT-WHERE
    public function dapatkanDataPremiumDariDB($koneksi, $id) {
        $query = "SELECT id_reservasi, nama_pelanggan, tanggal_booking, durasi_jam, tarif_dasar_per_jam, kuota_talent_orang, layanan_makeup 
                  FROM tabel_reservasi 
                  WHERE id_reservasi = $id AND jenis_paket = 'Premium'";
        return $koneksi->query($query);
    }
}