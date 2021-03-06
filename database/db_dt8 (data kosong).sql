-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2021 at 07:05 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dt8`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_akses`
--

CREATE TABLE `tb_akses` (
  `id_akses` int(11) NOT NULL,
  `nama_akses` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_akses`
--

INSERT INTO `tb_akses` (`id_akses`, `nama_akses`) VALUES
(1, 'Admin'),
(2, 'Kasir');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` char(7) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `harga_masuk` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang_masuk`
--

CREATE TABLE `tb_barang_masuk` (
  `id_barang_masuk` char(10) NOT NULL,
  `tanggal` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang_masuk_detail`
--

CREATE TABLE `tb_barang_masuk_detail` (
  `barang_masuk_id` char(10) CHARACTER SET utf8 NOT NULL,
  `barang_id` char(8) CHARACTER SET utf8 NOT NULL,
  `harga_masuk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `tb_barang_masuk_detail`
--
DELIMITER $$
CREATE TRIGGER `update_harga_masuk` AFTER INSERT ON `tb_barang_masuk_detail` FOR EACH ROW UPDATE tb_barang SET tb_barang.harga_masuk = NEW.harga_masuk WHERE tb_barang.id_barang = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama_jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_jenis`
--

INSERT INTO `tb_jenis` (`id_jenis`, `nama_jenis`) VALUES
(1, 'Rokok'),
(2, 'Sabun Mandi'),
(3, 'Beras'),
(4, 'Snacks'),
(6, 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `tb_keranjang`
--

CREATE TABLE `tb_keranjang` (
  `id_item` int(11) NOT NULL,
  `barang_id` char(7) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `tb_keranjang`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `tb_keranjang` FOR EACH ROW UPDATE tb_barang SET stok = stok - NEW.qty WHERE tb_barang.id_barang = NEW.barang_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reset_stok` BEFORE DELETE ON `tb_keranjang` FOR EACH ROW UPDATE tb_barang SET stok = stok + OLD.qty WHERE tb_barang.id_barang = OLD.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_keranjang_masuk`
--

CREATE TABLE `tb_keranjang_masuk` (
  `id_item` int(11) NOT NULL,
  `barang_id` char(7) CHARACTER SET utf8 NOT NULL,
  `user_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `tb_keranjang_masuk`
--
DELIMITER $$
CREATE TRIGGER `reset_tambah_stok` BEFORE DELETE ON `tb_keranjang_masuk` FOR EACH ROW UPDATE tb_barang SET stok = stok - OLD.qty WHERE tb_barang.id_barang = OLD.barang_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_stok` AFTER INSERT ON `tb_keranjang_masuk` FOR EACH ROW UPDATE tb_barang SET stok = stok + NEW.qty WHERE tb_barang.id_barang = NEW.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_satuan`
--

CREATE TABLE `tb_satuan` (
  `id_satuan` int(11) NOT NULL,
  `nama_satuan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_satuan`
--

INSERT INTO `tb_satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'Pcs'),
(2, 'Pack'),
(3, 'Slop'),
(4, 'Bal'),
(5, 'Sak');

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `nama_supplier`, `no_telp`, `alamat`) VALUES
(1, 'Taufan Candra', '082234827200', 'Jl. Kreongan No.24 Kec. Gebang'),
(2, 'Aris Telur', '082234827201', 'Jl. Semeru No. 29');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` char(10) NOT NULL,
  `tanggal` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `ppn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_detail`
--

CREATE TABLE `tb_transaksi_detail` (
  `transaksi_id` char(10) NOT NULL,
  `barang_id` char(8) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `total_keranjang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `date_created` int(11) NOT NULL,
  `id_akses` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `alamat`, `no_telp`, `email`, `username`, `password`, `foto`, `date_created`, `id_akses`) VALUES
(1, 'Mokhamad Syuhada', 'Jl. Danau Toba 22 Lingk Panji, Kec. Sumbersari', '085100251134', 'mokhamadsyuhada@gmail.com', 'admin', '$2y$10$PPDmJnzjcA99ljAPaskhoeVBvG.8TEdKkpoauU0RCnXG7qAz0D10O', '90a6c4b6f180d0971addaec9ff1899b0.png', 1626621196, 1),
(2, 'Sri Hartini', 'Jl. Danau Toba 22 Lingk Panji, Kec. Sumbersari', '081332117640', 'srihartini@gmail.com', 'kasir', '$2y$10$ftN9fKi7JNeu9wKM3RqTw.aSaCf/.bHbVgCbCATxAc3X6b66sFlkS', 'default.png', 1626635551, 2),
(3, 'Agung Herlambang', 'Perum Graha Citra Mas', '082234827000', 'agungh098@gmail.com', 'admin2', '$2y$10$F0rG5mFWCj/1QBcTz76qs.kr6qZ/gYdZzbvd3RigUchfj.ETe5mda', '004805281ec7062ff41ed2ce76b88d53.png', 1630303732, 1),
(6, 'Bunayya Maulana', 'Jl. Danau Toba 22 Lingk Panji', '082234827204', 'aldorizkayaa@gmail.com', 'admin3', '$2y$10$WzVJX0i8DNJzkS9lR.BTCOVrvS7M1ZXa/jzt7bYdc9sYmfQzq5Mwm', 'default.png', 1630909486, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_akses`
--
ALTER TABLE `tb_akses`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `kategori_id` (`jenis_id`) USING BTREE,
  ADD KEY `satuan_id` (`satuan_id`) USING BTREE;

--
-- Indexes for table `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`) USING BTREE,
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `tb_barang_masuk_detail`
--
ALTER TABLE `tb_barang_masuk_detail`
  ADD KEY `barang_masuk_id` (`barang_masuk_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `tb_keranjang_masuk`
--
ALTER TABLE `tb_keranjang_masuk`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `tb_satuan`
--
ALTER TABLE `tb_satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `tb_transaksi_detail`
--
ALTER TABLE `tb_transaksi_detail`
  ADD KEY `barang_id` (`barang_id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_akses`
--
ALTER TABLE `tb_akses`
  MODIFY `id_akses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `id_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_satuan`
--
ALTER TABLE `tb_satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`satuan_id`) REFERENCES `tb_satuan` (`id_satuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_ibfk_2` FOREIGN KEY (`jenis_id`) REFERENCES `tb_jenis` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_barang_masuk`
--
ALTER TABLE `tb_barang_masuk`
  ADD CONSTRAINT `barang_masuk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `tb_supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_barang_masuk_detail`
--
ALTER TABLE `tb_barang_masuk_detail`
  ADD CONSTRAINT `barang_masuk_detail_ibfk_1` FOREIGN KEY (`barang_masuk_id`) REFERENCES `tb_barang_masuk` (`id_barang_masuk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `barang_masuk_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_keranjang`
--
ALTER TABLE `tb_keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_keranjang_masuk`
--
ALTER TABLE `tb_keranjang_masuk`
  ADD CONSTRAINT `keranjang_masuk_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_transaksi_detail`
--
ALTER TABLE `tb_transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `tb_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
