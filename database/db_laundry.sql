-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 07:56 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `harga_layanan`
--

CREATE TABLE `harga_layanan` (
  `id_layanan` int(11) NOT NULL,
  `nama_layanan` varchar(255) NOT NULL,
  `harga` decimal(12,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `harga_layanan`
--

INSERT INTO `harga_layanan` (`id_layanan`, `nama_layanan`, `harga`) VALUES
(2, 'Cuci lipat', '13000'),
(3, 'Satuan', '10000'),
(4, 'Cuci setrika', '15000'),
(5, 'Dry Clean', '18000'),
(6, 'Cuci Cepat 6 Jam', '30000'),
(7, 'Tas ransel ', '25000'),
(10, 'Sepatu suede/kulit', '45000'),
(12, 'Selimut ', '20000'),
(13, 'Boneka ', '25000'),
(14, 'Sepatu kanvas/sneakers', '35000'),
(15, 'Jaket kulit', '40000'),
(16, 'Jaket parasut ', '22000'),
(17, 'Gorden ', '23000'),
(18, 'Vitrass', '20000'),
(19, 'Helm half face', '35000'),
(20, 'Helm full face', '40000');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `alamat_pelanggan` text DEFAULT NULL,
  `telepon_pelanggan` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat_pelanggan`, `telepon_pelanggan`) VALUES
(7, 'Tiana', 'Bandung', '62986982322'),
(8, 'Hebert', 'Bekasi', '65287287687'),
(9, 'Ferdian', 'Cilengsi', '62986987656'),
(10, 'Rizky', 'Sektor', '62986982322'),
(11, 'Farhan', 'Bekasi', '62986987656'),
(12, 'Yusuf', 'Cilengsi', '62986987656'),
(13, 'Febi', 'Bintara', '081513658572');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_layanan` int(11) DEFAULT NULL,
  `tanggal_ambil` date DEFAULT NULL,
  `jumlah_pcs` text DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `status` enum('Belum Selesai','Selesai') DEFAULT 'Belum Selesai',
  `jumlah_kilogram` decimal(12,0) DEFAULT NULL,
  `total_harga` decimal(12,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `id_layanan`, `tanggal_ambil`, `jumlah_pcs`, `harga`, `status`, `jumlah_kilogram`, `total_harga`) VALUES
(20, 9, 3, '2023-12-19', '120', NULL, 'Selesai', '12', '120000'),
(21, 8, 2, '2023-12-21', '12', NULL, 'Selesai', '1', '13000'),
(22, 7, 3, '2023-12-20', '23', NULL, 'Belum Selesai', '11', '110000'),
(23, 9, 3, '2023-12-20', '14', NULL, 'Belum Selesai', '10', '100000'),
(24, 11, 5, '2023-12-20', '12', 18000, 'Belum Selesai', '1', '18000'),
(25, 10, 4, '2023-12-20', '100', NULL, 'Belum Selesai', '6', '300000'),
(26, 12, 5, '2023-12-19', '12', 18000, 'Belum Selesai', '1', '18000'),
(27, 10, 6, '2023-12-18', '45', NULL, 'Belum Selesai', '12', '360000'),
(28, 8, 5, '2023-12-27', '10', NULL, 'Belum Selesai', '2', '36000'),
(29, 9, 6, '2023-12-20', '32', NULL, 'Belum Selesai', '3', '90000'),
(30, 9, 2, '2023-12-18', '14', NULL, 'Belum Selesai', '10', '130000'),
(31, 13, 2, '2024-01-10', '20', 13000, 'Belum Selesai', '4', '52000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga_layanan`
--
ALTER TABLE `harga_layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_layanan` (`id_layanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `harga_layanan`
--
ALTER TABLE `harga_layanan`
  MODIFY `id_layanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_layanan`) REFERENCES `harga_layanan` (`id_layanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
