-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2024 at 12:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_reservasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id` int(11) NOT NULL,
  `jenis_kamar` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `kasur` int(11) NOT NULL,
  `kamar_mandi` int(11) NOT NULL,
  `orang` int(11) NOT NULL,
  `harga` decimal(15,0) NOT NULL,
  `jumlah_kamar` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id`, `jenis_kamar`, `deskripsi`, `kasur`, `kamar_mandi`, `orang`, `harga`, `jumlah_kamar`, `foto`) VALUES
(2, 'Deluxe Room', 'Deluxe Room kami memberikan kenyamanan ekstra. Tempat tidur empuk dan detail mewah di setiap sudut, sempurna untuk anda.', 2, 2, 4, 2000000, 46, '2024-11-06 11.26.35.jpg'),
(7, 'Family Room', 'Liburan keluarga menjadi lebih menyenangkan dengan ruang yang lega dan tempat tidur ekstra, siap memberikan kenyamanan terbaik.', 2, 2, 2, 2500000, 16, '2024-11-07 22.43.40.jpg'),
(8, 'Single Room', 'Kenyamanan pribadi dalam kamar single kami sempurna untuk anda yang suka menyendiri. Nikmati suasana tenang dengan fasilitas yang modern.', 1, 1, 1, 1000000, 20, '2024-11-08 17.10.11.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `user_pemesan` varchar(20) NOT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tanggal_checkin` date NOT NULL,
  `tanggal_checkout` date NOT NULL,
  `id_kamar` int(11) NOT NULL,
  `jml_kamar` int(11) NOT NULL,
  `total_harga` decimal(25,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `user_pemesan`, `tanggal_pesan`, `tanggal_checkin`, `tanggal_checkout`, `id_kamar`, `jml_kamar`, `total_harga`) VALUES
(21, 'rizal', '2024-11-08 10:41:58', '2024-11-08', '2024-11-09', 2, 2, 4000000);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `username` varchar(20) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `pasword` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`username`, `nama_lengkap`, `email`, `telepon`, `pasword`, `foto`) VALUES
('rizal', 'Afrizal Kesuma', 'rizal@gmail.com', '082158425223', '$2y$10$q9MVyO8ZqUC9k7NydtSFH.pZw26IJfrjG/e9N.d39aUtR9hdRtQJu', '2024-11-08 18.39.31.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_pemesan` (`user_pemesan`),
  ADD KEY `fk_id_kamar` (`id_kamar`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `fk_id_kamar` FOREIGN KEY (`id_kamar`) REFERENCES `kamar` (`id`),
  ADD CONSTRAINT `fk_id_pemesan` FOREIGN KEY (`user_pemesan`) REFERENCES `pengguna` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
