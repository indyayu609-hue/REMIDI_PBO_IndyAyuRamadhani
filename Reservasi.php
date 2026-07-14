<?php

abstract class Reservasi {
    // Properti terenkapsulasi (protected) dengan format camelCase
    protected $idReservasi;
    protected $namaPelanggan;
    protected $tanggalBooking;
    protected $durasiJam;
    protected $tarifDasarPerJam;

    // Constructor untuk menginisialisasi atribut global (induk)
    public function __construct($idReservasi, $namaPelanggan, $tanggalBooking, $durasiJam, $tarifDasarPerJam) {
        $this->idReservasi = $idReservasi;
        $this->namaPelanggan = $namaPelanggan;
        $this->tanggalBooking = $tanggalBooking;
        $this->durasiJam = $durasiJam;
        $this->tarifDasarPerJam = $tarifDasarPerJam;
    }

    // Metode Abstrak Wajib (tanpa body/implementasi)
    abstract public function hitungTotalBiaya();
    abstract public function tampilkanSpesifikasiPaket();
}