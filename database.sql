-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 22, 2023 at 07:29 AM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `toko-emas-murni-a1`
--

-- --------------------------------------------------------

--
-- Table structure for table `ms_barang`
--

CREATE TABLE `ms_barang` (
  `Id` int(20) NOT NULL,
  `uuid` varchar(225) NOT NULL,
  `nama_barang` varchar(225) NOT NULL,
  `id_kadar` varchar(225) NOT NULL,
  `id_rak` int(20) NOT NULL,
  `keterangan` text NOT NULL,
  `usrid` varchar(225) NOT NULL,
  `tgl_input_real` date NOT NULL DEFAULT '1970-01-01',
  `stok` int(20) NOT NULL DEFAULT '0',
  `berat_jual` varchar(225) NOT NULL,
  `foto` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_dashboard_big_book`
--

CREATE TABLE `ms_dashboard_big_book` (
  `KdBukuBesar` bigint(20) NOT NULL,
  `TglBukuBesar` date NOT NULL,
  `JamBukaToko` int(10) NOT NULL,
  `JamTutupToko` int(10) NOT NULL,
  `UserBukaToko` text NOT NULL,
  `UserTutupToko` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_group_admin`
--

CREATE TABLE `ms_group_admin` (
  `GroupAdminID` int(20) NOT NULL,
  `NamaGroupAdmin` varchar(225) NOT NULL,
  `AksesModul` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_kadar`
--

CREATE TABLE `ms_kadar` (
  `id` int(20) NOT NULL,
  `nama_kadar` varchar(225) NOT NULL,
  `keterangan` text NOT NULL,
  `usrid` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_pengeluaran`
--

CREATE TABLE `ms_pengeluaran` (
  `KdPengeluaran` bigint(20) NOT NULL,
  `TglProses` int(20) NOT NULL,
  `usrid` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_pengembalian`
--

CREATE TABLE `ms_pengembalian` (
  `KdPengembalian` bigint(20) NOT NULL,
  `TglProses` int(20) NOT NULL,
  `usrid` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_penjualan`
--

CREATE TABLE `ms_penjualan` (
  `KdPenjualan` bigint(20) NOT NULL,
  `TglProses` int(20) NOT NULL,
  `usrid` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_rak`
--

CREATE TABLE `ms_rak` (
  `id` int(20) NOT NULL,
  `nama_rak` varchar(225) NOT NULL,
  `keterangan` text NOT NULL,
  `usrid` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ms_user`
--

CREATE TABLE `ms_user` (
  `id` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `salt` varchar(225) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `GroupAdminID` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ms_user`
--

INSERT INTO `ms_user` (`id`, `username`, `password`, `salt`, `nama`, `GroupAdminID`) VALUES
(1, 'ryan', '7a9c8f30b71cc3c71a4a448a8768f2b9937eacf7735d659fe26c4a765e1cdf4261b3c05102ee544aa76061ed0f227719fb323f3ab2d3365496244f0f84ddf362', 'FztZEgL1BIAVYjuW', 'Ryan Ananda Nolly', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tr_cek_barang`
--

CREATE TABLE `tr_cek_barang` (
  `id` int(20) NOT NULL,
  `tgl_mulai_cek` int(20) NOT NULL,
  `usrid_membuat` varchar(225) NOT NULL,
  `usrid_last_check` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tr_cek_barang_detail`
--

CREATE TABLE `tr_cek_barang_detail` (
  `id` int(20) NOT NULL,
  `id_cek_barang` varchar(225) NOT NULL,
  `id_barang` varchar(225) NOT NULL,
  `usrid` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tr_detail_dashboard_big_book`
--

CREATE TABLE `tr_detail_dashboard_big_book` (
  `Id` bigint(20) NOT NULL,
  `KdBukuBesar` bigint(20) NOT NULL,
  `id_rak` int(10) NOT NULL,
  `open` float NOT NULL,
  `masuk` float NOT NULL,
  `keluar` float NOT NULL,
  `jual` float NOT NULL,
  `tutup` float NOT NULL,
  `timbang` float NOT NULL,
  `open_qt` float NOT NULL,
  `masuk_qt` float NOT NULL,
  `keluar_qt` float NOT NULL,
  `jual_qt` float NOT NULL,
  `tutup_qt` float NOT NULL,
  `timbang_qt` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tr_detail_keluar_cucian_etalase`
--

CREATE TABLE `tr_detail_keluar_cucian_etalase` (
  `id` int(20) NOT NULL,
  `id_kadar` varchar(225) NOT NULL,
  `berat` float NOT NULL,
  `jumlah` int(20) NOT NULL DEFAULT '1',
  `id_rak` varchar(225) NOT NULL,
  `status` varchar(225) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_masuk` date NOT NULL DEFAULT '1970-01-01',
  `tgl_real_masuk` int(20) NOT NULL,
  `usrid` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tr_detail_masuk_cucian_etalase`
--

CREATE TABLE `tr_detail_masuk_cucian_etalase` (
  `id` int(20) NOT NULL,
  `id_kadar` varchar(225) NOT NULL,
  `berat` float NOT NULL,
  `jumlah` int(20) NOT NULL,
  `id_rak` varchar(225) NOT NULL,
  `status` varchar(225) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_masuk` date NOT NULL DEFAULT '1970-01-01',
  `tgl_real_masuk` int(20) NOT NULL,
  `usrid` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tr_pengeluaran`
--

CREATE TABLE `tr_pengeluaran` (
  `id` int(20) NOT NULL,
  `KdPengeluaran` bigint(20) NOT NULL,
  `id_barang` bigint(20) NOT NULL,
  `id_kadar` varchar(225) NOT NULL,
  `berat_terima` float NOT NULL,
  `Kategori` enum('lebur','AD') NOT NULL DEFAULT 'lebur',
  `uang` int(20) NOT NULL,
  `berat_asli` float NOT NULL,
  `selisih_berat` float NOT NULL,
  `usrid` varchar(225) NOT NULL,
  `tgl_penjualan` date NOT NULL DEFAULT '1970-01-01',
  `tgl_real_penjualan` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tr_pengembalian`
--

CREATE TABLE `tr_pengembalian` (
  `id` int(20) NOT NULL,
  `KdPengembalian` bigint(20) NOT NULL,
  `id_barang` bigint(20) NOT NULL,
  `id_kadar` varchar(225) NOT NULL,
  `berat_terima` float NOT NULL,
  `Kategori` enum('lebur','terima') NOT NULL DEFAULT 'terima',
  `uang` int(20) NOT NULL,
  `berat_asli` float NOT NULL,
  `selisih_berat` float NOT NULL,
  `usrid` varchar(225) NOT NULL,
  `tgl_penjualan` date NOT NULL DEFAULT '1970-01-01',
  `tgl_real_penjualan` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tr_penjualan`
--

CREATE TABLE `tr_penjualan` (
  `id` int(20) NOT NULL,
  `KdPenjualan` bigint(20) NOT NULL,
  `id_kadar` varchar(225) NOT NULL,
  `berat_jual` float NOT NULL,
  `berat_asli` float NOT NULL,
  `nilai_barang` int(20) NOT NULL,
  `DP_Pelunasan` int(20) NOT NULL,
  `JnPembayaran` enum('Bank','Cash') NOT NULL,
  `id_rak` varchar(225) NOT NULL,
  `id_barang` varchar(225) NOT NULL,
  `usrid` varchar(225) NOT NULL,
  `tgl_penjualan` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `tgl_real_penjualan` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ms_barang`
--
ALTER TABLE `ms_barang`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `id_kadar` (`id_kadar`),
  ADD KEY `id_rak` (`id_rak`);

--
-- Indexes for table `ms_dashboard_big_book`
--
ALTER TABLE `ms_dashboard_big_book`
  ADD PRIMARY KEY (`KdBukuBesar`);

--
-- Indexes for table `ms_group_admin`
--
ALTER TABLE `ms_group_admin`
  ADD PRIMARY KEY (`GroupAdminID`);

--
-- Indexes for table `ms_kadar`
--
ALTER TABLE `ms_kadar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama_kadar` (`nama_kadar`);

--
-- Indexes for table `ms_pengeluaran`
--
ALTER TABLE `ms_pengeluaran`
  ADD PRIMARY KEY (`KdPengeluaran`);

--
-- Indexes for table `ms_pengembalian`
--
ALTER TABLE `ms_pengembalian`
  ADD PRIMARY KEY (`KdPengembalian`);

--
-- Indexes for table `ms_penjualan`
--
ALTER TABLE `ms_penjualan`
  ADD PRIMARY KEY (`KdPenjualan`);

--
-- Indexes for table `ms_rak`
--
ALTER TABLE `ms_rak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama_rak` (`nama_rak`);

--
-- Indexes for table `ms_user`
--
ALTER TABLE `ms_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tr_cek_barang`
--
ALTER TABLE `tr_cek_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tr_cek_barang_detail`
--
ALTER TABLE `tr_cek_barang_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cek_barang` (`id_cek_barang`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `tr_detail_dashboard_big_book`
--
ALTER TABLE `tr_detail_dashboard_big_book`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `KdBukuBesar` (`KdBukuBesar`),
  ADD KEY `id_rak` (`id_rak`);

--
-- Indexes for table `tr_detail_keluar_cucian_etalase`
--
ALTER TABLE `tr_detail_keluar_cucian_etalase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kadar` (`id_kadar`),
  ADD KEY `id_rak` (`id_rak`);

--
-- Indexes for table `tr_detail_masuk_cucian_etalase`
--
ALTER TABLE `tr_detail_masuk_cucian_etalase`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kadar` (`id_kadar`),
  ADD KEY `id_rak` (`id_rak`);

--
-- Indexes for table `tr_pengeluaran`
--
ALTER TABLE `tr_pengeluaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kadar` (`id_kadar`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `KdPengeluaran` (`KdPengeluaran`);

--
-- Indexes for table `tr_pengembalian`
--
ALTER TABLE `tr_pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kadar` (`id_kadar`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `KdPengembalian` (`KdPengembalian`);

--
-- Indexes for table `tr_penjualan`
--
ALTER TABLE `tr_penjualan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kadar` (`id_kadar`),
  ADD KEY `id_rak` (`id_rak`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `KdPenjualan` (`KdPenjualan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ms_barang`
--
ALTER TABLE `ms_barang`
  MODIFY `Id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_dashboard_big_book`
--
ALTER TABLE `ms_dashboard_big_book`
  MODIFY `KdBukuBesar` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_group_admin`
--
ALTER TABLE `ms_group_admin`
  MODIFY `GroupAdminID` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_kadar`
--
ALTER TABLE `ms_kadar`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_pengeluaran`
--
ALTER TABLE `ms_pengeluaran`
  MODIFY `KdPengeluaran` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_pengembalian`
--
ALTER TABLE `ms_pengembalian`
  MODIFY `KdPengembalian` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_penjualan`
--
ALTER TABLE `ms_penjualan`
  MODIFY `KdPenjualan` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_rak`
--
ALTER TABLE `ms_rak`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_user`
--
ALTER TABLE `ms_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tr_cek_barang`
--
ALTER TABLE `tr_cek_barang`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_cek_barang_detail`
--
ALTER TABLE `tr_cek_barang_detail`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_detail_dashboard_big_book`
--
ALTER TABLE `tr_detail_dashboard_big_book`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_detail_keluar_cucian_etalase`
--
ALTER TABLE `tr_detail_keluar_cucian_etalase`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_detail_masuk_cucian_etalase`
--
ALTER TABLE `tr_detail_masuk_cucian_etalase`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_pengeluaran`
--
ALTER TABLE `tr_pengeluaran`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_pengembalian`
--
ALTER TABLE `tr_pengembalian`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_penjualan`
--
ALTER TABLE `tr_penjualan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
