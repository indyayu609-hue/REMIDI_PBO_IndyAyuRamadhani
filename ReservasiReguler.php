<?php
require_once 'Reservasi.php';

class ReservasiReguler extends Reservasi {
    // Properti tambahan spesifik
    private $tipeBackground;
    private $cetakFotoLembar;

    public function __construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam, $tipeBackground, $cetakFotoLembar) {
        parent::__construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam);
        $this->tipeBackground = $tipeBackground;
        $this->cetakFotoLembar = $cetakFotoLembar;
    }

    // Implementasi metode abstrak
    public function hitungTotalBiaya() {
        // Misal: biaya dasar ditambah biaya cetak foto (Rp 5.000 per lembar)
        return ($this->durasiJam * $this->tarifDasarPerJam) + ($this->cetakFotoLembar * 5000);
    }

    public function tampilkanSpesifikasiPaket() {
        echo "Paket: Reguler\n";
        echo "Background: " . $this->tipeBackground . "\n";
        echo "Cetak Foto: " . $this->cetakFotoLembar . " Lembar\n";
    }

    // Method query SELECT-WHERE
    public function dapatkanDataReguler DariDB($koneksi, $id) {
        $query = "SELECT id_reservasi, nama_pelanggan, tanggal_booking, durasi_jam, tarif_dasar_per_jam, tipe_background, cetak_foto_lembar 
                  FROM tabel_reservasi 
                  WHERE id_reservasi = $id AND jenis_paket = 'Reguler'";
        return $koneksi->query($query);
    }
}