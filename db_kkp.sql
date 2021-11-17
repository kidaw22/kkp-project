-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2021 at 05:35 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kkp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bantuan`
--

CREATE TABLE `bantuan` (
  `id` bigint(20) NOT NULL,
  `Nama_Bantuan` varchar(50) NOT NULL,
  `Periode_Dari` date NOT NULL,
  `Periode_Sampai` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bantuan`
--

INSERT INTO `bantuan` (`id`, `Nama_Bantuan`, `Periode_Dari`, `Periode_Sampai`) VALUES
(1, 'KJP', '2021-11-01', '2021-11-30'),
(3, 'Lansia', '2021-11-01', '2021-12-31');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` bigint(20) NOT NULL,
  `Judul_Kegiatan` bigint(50) NOT NULL,
  `Deskripsi_Kegiatan` text DEFAULT NULL,
  `Tanggal_Mulai` timestamp NULL DEFAULT NULL,
  `Tanggal_Akhir` timestamp NULL DEFAULT NULL,
  `Lokasi` varchar(50) NOT NULL,
  `Deskripsi_Lokasi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `Judul_Kegiatan`, `Deskripsi_Kegiatan`, `Tanggal_Mulai`, `Tanggal_Akhir`, `Lokasi`, `Deskripsi_Lokasi`) VALUES
(1, 1, 'testingn untuk data sample', '2021-11-01 03:00:00', '2021-11-01 05:00:00', 'HO', 'sample lokai');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan_peserta`
--

CREATE TABLE `kegiatan_peserta` (
  `id` int(11) NOT NULL,
  `Kegiatan_id` bigint(20) NOT NULL,
  `Warga_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegiatan_peserta`
--

INSERT INTO `kegiatan_peserta` (`id`, `Kegiatan_id`, `Warga_id`) VALUES
(7, 1, 1),
(8, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `id` bigint(20) NOT NULL,
  `NIK` bigint(16) NOT NULL,
  `Nama` varchar(50) NOT NULL,
  `Alamat_KTP` text NOT NULL,
  `No_Telp` varchar(15) NOT NULL,
  `No_BPJS` varchar(30) NOT NULL,
  `No_NPWP` varchar(30) NOT NULL,
  `Tanggal_Lahir` date NOT NULL,
  `Alamat_Domisili` text NOT NULL,
  `No_KK` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`id`, `NIK`, `Nama`, `Alamat_KTP`, `No_Telp`, `No_BPJS`, `No_NPWP`, `Tanggal_Lahir`, `Alamat_Domisili`, `No_KK`) VALUES
(1, 3274069878020001, 'Kidaws', 'Mutiara Gading No.2 Jakarta Utara', '089653129447', '3123489298392', '94.103.1274.565', '2021-06-01', 'Mutiara Gading No.2 Jakarta Utara', 3172638273923),
(3, 3275069844820, 'Fadhli yulyanto', 'Jln turi v no', '08421361233', '234234125675', '232354', '2019-01-07', 'yaa alamat domisili lah ya', 3275604492231),
(4, 3172046010980002, 'Duwi', 'rumah duwi', '081313345', '234342323232', '2323.23232323', '2021-11-04', 'yaa alamat domisili lah ya', 3275604492231),
(7, 3172046010980002, 'RIZKY ADAWIYAH', 'bekaseh', '08121213', '3212121', '121212.121.21', '2021-11-16', 'gading', 3275604492231);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bantuan`
--
ALTER TABLE `bantuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Judul_Kegiatan` (`Judul_Kegiatan`) USING BTREE;

--
-- Indexes for table `kegiatan_peserta`
--
ALTER TABLE `kegiatan_peserta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Peserta_id` (`Kegiatan_id`),
  ADD KEY `Warga_id` (`Warga_id`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bantuan`
--
ALTER TABLE `bantuan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kegiatan_peserta`
--
ALTER TABLE `kegiatan_peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`Judul_Kegiatan`) REFERENCES `bantuan` (`id`);

--
-- Constraints for table `kegiatan_peserta`
--
ALTER TABLE `kegiatan_peserta`
  ADD CONSTRAINT `kegiatan_peserta_ibfk_1` FOREIGN KEY (`Kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `kegiatan_peserta_ibfk_2` FOREIGN KEY (`Warga_id`) REFERENCES `warga` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
