<?php
require_once 'Reservasi.php';

class ReservasiEvent extends Reservasi {
    // Properti tambahan spesifik
    private $namaLokasiLuar;
    private $biayaTransportasiTim;

    public function __construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam, $namaLokasiLuar, $biayaTransportasiTim) {
        parent::__construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam);
        $this->namaLokasiLuar = $namaLokasiLuar;
        $this->biayaTransportasiTim = $biayaTransportasiTim;
    }

    // Implementasi metode abstrak
    public function hitungTotalBiaya() {
        // Biaya dasar ditambah biaya transportasi tim ke lokasi luar
        return ($this->durasiJam * $this->tarifDasarPerJam) + $this->biayaTransportasiTim;
    }

    public function tampilkanSpesifikasiPaket() {
        echo "Paket: Event (Luar Ruangan)\n";
        echo "Lokasi: " . $this->namaLokasiLuar . "\n";
        echo "Biaya Transportasi: Rp " . number_format($this->biayaTransportasiTim, 2, ',', '.') . "\n";
    }

    // Method query SELECT-WHERE
    public function dapatkanDataEventDariDB($koneksi, $id) {
        $query = "SELECT id_reservasi, nama_pelanggan, tanggal_booking, durasi_jam, tarif_dasar_per_jam, nama_lokasi_luar, biaya_transportasi_tim 
                  FROM tabel_reservasi 
                  WHERE id_reservasi = $id AND jenis_paket = 'Event'";
        return $koneksi->query($query);
    }
}