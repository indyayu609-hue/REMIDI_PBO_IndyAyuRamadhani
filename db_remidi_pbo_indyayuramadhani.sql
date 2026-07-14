-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 14, 2026 at 01:55 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_remidi_pbo_indyayuramadhani`
--

-- --------------------------------------------------------

--
-- Table structure for table `tabel_reservasi`
--

CREATE TABLE `tabel_reservasi` (
  `id_reservasi` int NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `tanggal_booking` date NOT NULL,
  `durasi_jam` int NOT NULL,
  `tarif_dasar_per_jam` decimal(10,2) NOT NULL,
  `jenis_paket` enum('Reguler','Premium','Event') NOT NULL,
  `tipe_background` varchar(50) DEFAULT NULL,
  `cetak_foto_lembar` int DEFAULT NULL,
  `kuota_talent_orang` int DEFAULT NULL,
  `layanan_makeup` varchar(50) DEFAULT NULL,
  `nama_lokasi_luar` varchar(150) DEFAULT NULL,
  `biaya_transportasi_tim` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_reservasi`
--

INSERT INTO `tabel_reservasi` (`id_reservasi`, `nama_pelanggan`, `tanggal_booking`, `durasi_jam`, `tarif_dasar_per_jam`, `jenis_paket`, `tipe_background`, `cetak_foto_lembar`, `kuota_talent_orang`, `layanan_makeup`, `nama_lokasi_luar`, `biaya_transportasi_tim`) VALUES
(1, 'Ahmad Fauzi', '2026-07-01', 2, 150000.00, 'Reguler', 'Minimalis Putih', 5, NULL, NULL, NULL, NULL),
(2, 'Siti Aminah', '2026-07-02', 1, 150000.00, 'Reguler', 'Klasik Abu-Abu', 3, NULL, NULL, NULL, NULL),
(3, 'Budi Santoso', '2026-07-03', 2, 150000.00, 'Reguler', 'Rustic Kayu', 10, NULL, NULL, NULL, NULL),
(4, 'Dewi Lestari', '2026-07-05', 1, 150000.00, 'Reguler', 'Minimalis Putih', 5, NULL, NULL, NULL, NULL),
(5, 'Eko Prasetyo', '2026-07-06', 3, 150000.00, 'Reguler', 'Warna Pastel', 12, NULL, NULL, NULL, NULL),
(6, 'Fitriani', '2026-07-08', 2, 150000.00, 'Reguler', 'Klasik Abu-Abu', 8, NULL, NULL, NULL, NULL),
(7, 'Gilang Dirga', '2026-07-10', 1, 150000.00, 'Reguler', 'Minimalis Putih', 3, NULL, NULL, NULL, NULL),
(8, 'Hendra Wijaya', '2026-07-01', 3, 300000.00, 'Premium', 'Modern Luxury', 20, 2, 'Flawless Makeup', NULL, NULL),
(9, 'Indah Permata', '2026-07-04', 4, 300000.00, 'Premium', 'Vintage Garden', 30, 3, 'Glowy Bridal', NULL, NULL),
(10, 'Joko Widodo', '2026-07-05', 2, 300000.00, 'Premium', 'Modern Luxury', 15, 1, 'Natural Look', NULL, NULL),
(11, 'Kartika Sari', '2026-07-07', 3, 300000.00, 'Premium', 'Vintage Garden', 25, 2, 'Bold Elegant', NULL, NULL),
(12, 'Lukman Hakim', '2026-07-09', 5, 300000.00, 'Premium', 'Modern Luxury', 40, 4, 'Flawless Makeup', NULL, NULL),
(13, 'Mega Utami', '2026-07-11', 3, 300000.00, 'Premium', 'Warna Pastel', 20, 2, 'Natural Look', NULL, NULL),
(14, 'Naufal Abdi', '2026-07-12', 2, 300000.00, 'Premium', 'Klasik Abu-Abu', 15, 1, 'Natural Look', NULL, NULL),
(15, 'Oki Setiana', '2026-07-02', 6, 500000.00, 'Event', NULL, NULL, 5, 'Traditional Wedding', 'Gedung Serbaguna ID', 350000.00),
(16, 'Putri Kencana', '2026-07-04', 8, 500000.00, 'Event', NULL, NULL, 10, 'Modern Wedding', 'Hotel Aston Ballroom', 500000.00),
(17, 'Rian Jombang', '2026-07-06', 5, 500000.00, 'Event', NULL, NULL, 4, 'Engagement Look', 'Waroeng Kopi Kebon', 200000.00),
(18, 'Sinta Bella', '2026-07-09', 7, 500000.00, 'Event', NULL, NULL, 6, 'Glowy Glam', 'Pantai Marina', 450000.00),
(19, 'Taufik Hidayat', '2026-07-11', 6, 500000.00, 'Event', NULL, NULL, 8, 'Formal Corporate', 'Aula Kampus Merdeka', 300000.00),
(20, 'Vina Panduwinata', '2026-07-13', 10, 500000.00, 'Event', NULL, NULL, 12, 'Traditional Wedding', 'Gedung Graha Saba', 600000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tabel_reservasi`
--
ALTER TABLE `tabel_reservasi`
  ADD PRIMARY KEY (`id_reservasi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tabel_reservasi`
--
ALTER TABLE `tabel_reservasi`
  MODIFY `id_reservasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
