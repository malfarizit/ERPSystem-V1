-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2017 at 12:36 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pembelianbuku`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `kode_buku` varchar(8) NOT NULL DEFAULT '',
  `judul` varchar(100) NOT NULL,
  `noisbn` varchar(20) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun` int(4) NOT NULL,
  `stok` varchar(200) NOT NULL,
  `harga_jual` double NOT NULL,
  `harga_beli` double NOT NULL,
  `ppn` varchar(200) NOT NULL,
  `diskon` varchar(200) NOT NULL,
  `gambar` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`kode_buku`, `judul`, `noisbn`, `penulis`, `penerbit`, `tahun`, `stok`, `harga_jual`, `harga_beli`, `ppn`, `diskon`, `gambar`) VALUES
('BUK-0001', 'KAMBING JANTAN', '111', 'BANY', 'ERLANGGA', 2011, '100', 50000, 40000, '10', '10', 'gbr/imgGEN(1).jpg'),
('BUK-0002', 'MARMUT MERAH JAMBU', '111', 'BANY', 'ERLANGGA', 2011, '100', 50000, 40000, '10', '10', 'gbr/imgGEN(1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `kode_distributor` varchar(10) NOT NULL,
  `nama_distributor` varchar(25) NOT NULL,
  `alamatdistri` varchar(20) NOT NULL,
  `telpondistri` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`kode_distributor`, `nama_distributor`, `alamatdistri`, `telpondistri`) VALUES
('KDS-0003', 'rtret', 'dstgrt56456456', '02854'),
('KDS-0004', '11', '1', '11'),
('KDS-0005', 'gfgf', 'dfgdf', '0'),
('KDS-0006', 'fdgf', 'dfgdfg', '87897987'),
('KDS-0007', 'dgfgdf', 'dfgdfg', '5545'),
('KDS-0008', 'kgkgjkg', 'jgjhgkjgkj', '0856412'),
('KDS-0009', 'lhlk', 'klhklh', '54545');

-- --------------------------------------------------------

--
-- Table structure for table `kasir`
--

CREATE TABLE `kasir` (
  `kode_kasir` varchar(10) NOT NULL,
  `no_ktp` varchar(19) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `telpon` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `akses` varchar(100) NOT NULL,
  `pass` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kasir`
--

INSERT INTO `kasir` (`kode_kasir`, `no_ktp`, `nama`, `alamat`, `telpon`, `status`, `akses`, `pass`) VALUES
('KSR-0002', '887654466', '', 'bintang', '08467576', 'rtyrtyr', 'hgfhgfhg', '123456'),
('KSR-0003', '887654466', '', 'bintang', '', '', '', '789456'),
('KSR-0004', '', 'mau mati kalian', 'kuburan', '085464', '6464', '464', ''),
('KSR-0005', '', '4654654', '65464', '015645646', 'kjh', 'sdf', ''),
('KSR-0006', '456465465', '4654654', '65464', '', '', '', ''),
('KSR-0007', '887654466', '4654654', '65464', '000000', '00000', '', ''),
('KSR-0008', '456465465', '4654654', 'jgjkgkj', '88888', 'jhhjkhjk', 'kkkkkk', '');

-- --------------------------------------------------------

--
-- Table structure for table `pasok`
--

CREATE TABLE `pasok` (
  `kode_pasok` varchar(10) NOT NULL,
  `kode_distributor` char(10) NOT NULL,
  `kode_buku` char(10) NOT NULL,
  `jumlah` int(10) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasok`
--

INSERT INTO `pasok` (`kode_pasok`, `kode_distributor`, `kode_buku`, `jumlah`, `tanggal`) VALUES
('PSK-0001', 'KDS-0001', 'BUK-0001', 786768, '0000-00-00'),
('PSK-0002', 'Agus', 'jkhjkhk', 76, '0000-00-00'),
('PSK-0003', 'Agus', 'jkhjkhk', 4545, '0000-00-00'),
('PSK-0009', 'Agus', 'jkhjkhk', 777, '0000-00-00'),
('PSK-0010', 'Agus', 'jkhjkhk', 46546456, '0000-00-00'),
('PSK-0011', 'Agus', 'jkhjkhk', 2432, '2017-01-26'),
('PSK-0012', 'fdgf', 'jkhjkhk', 555, '2017-02-11'),
('PSK-0013', '11', 'ERLANGGA', 0, '2017-02-14');

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `no_ktp` varchar(17) NOT NULL,
  `nama_pembeli` varchar(20) NOT NULL,
  `alamat_pembeli` varchar(200) NOT NULL,
  `telp_pembeli` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`no_ktp`, `nama_pembeli`, `alamat_pembeli`, `telp_pembeli`) VALUES
('1252174962545', 'mau mati kalian', 'kuburan', '08556614132452148421'),
('456465465', '4654654', '65464', '646'),
('54564565646', 'pukimak', '654654', '64654646'),
('55555', 'jkhjhjk', 'jgjkgkj', '64564153415');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `kode_pembelian` varchar(17) NOT NULL,
  `kode_buku` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` varchar(20000) NOT NULL,
  `harga_satuan` varchar(20000) NOT NULL,
  `total_harga` varchar(20000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`kode_pembelian`, `kode_buku`, `tanggal`, `jumlah`, `harga_satuan`, `total_harga`) VALUES
('PBL-0001', 'JGJHGJH', '2017-02-11', '10', '50000', '500000'),
('PBL-0002', 'JGJHGJH', '2017-02-11', '100', '90000', '9000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` varchar(45) NOT NULL,
  `pass` varchar(45) NOT NULL,
  `level` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `pass`, `level`) VALUES
(1, 'admin', '1234', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`kode_buku`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`kode_distributor`);

--
-- Indexes for table `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`kode_kasir`);

--
-- Indexes for table `pasok`
--
ALTER TABLE `pasok`
  ADD PRIMARY KEY (`kode_pasok`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`no_ktp`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`kode_pembelian`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
