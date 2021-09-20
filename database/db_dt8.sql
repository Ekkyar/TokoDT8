-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2021 at 06:57 AM
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

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `nama_barang`, `stok`, `harga`, `harga_masuk`, `satuan_id`, `jenis_id`) VALUES
('B000001', 'Surya 12', 24, 19500, 19000, 2, 1),
('B000002', 'Surya 16', 18, 24000, 18500, 2, 1),
('B000003', 'Surya Pro 16', 9, 20241, 25000, 2, 1),
('B000004', 'Surya Pro Mild 16', 0, 20410, 20000, 2, 1),
('B000005', 'Sampoerna Mild 12', 7, 17500, 16500, 2, 1),
('B000006', 'Sampoerna MILD 16', 0, 24000, 24500, 2, 1),
('B000007', 'Macan 5KG', 0, 55000, 50000, 1, 3),
('B000008', 'Nutrisari', 100, 0, 5000, 1, 6);

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

--
-- Dumping data for table `tb_barang_masuk`
--

INSERT INTO `tb_barang_masuk` (`id_barang_masuk`, `tanggal`, `user_id`, `supplier_id`, `total`) VALUES
('B210830001', '2021-08-30', 3, 1, 2625000),
('B210906001', '2021-09-06', 1, 1, 6250000),
('B210906002', '2021-09-06', 1, 1, 500000),
('B210906003', '2021-09-06', 1, 1, 1000000),
('BM21072300', '2021-07-23', 1, 1, 975000),
('BM21072330', '2021-07-23', 1, 1, 950000),
('BM21072400', '2021-07-24', 1, 1, 600000),
('BM21072440', '2021-07-24', 1, 1, 600000),
('BM21072444', '2021-07-24', 1, 1, 185000),
('BM21080200', '2021-08-02', 1, 1, 635000),
('BM21082500', '2021-08-25', 1, 1, 2000000);

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
-- Dumping data for table `tb_barang_masuk_detail`
--

INSERT INTO `tb_barang_masuk_detail` (`barang_masuk_id`, `barang_id`, `harga_masuk`, `qty`, `subtotal`) VALUES
('BM21072300', 'B000001', 19500, 50, 975000),
('BM21072330', 'B000001', 19000, 50, 950000),
('BM21072400', 'B000003', 25000, 10, 250000),
('BM21072400', 'B000005', 17500, 20, 350000),
('BM21072440', 'B000004', 24000, 25, 600000),
('BM21072444', 'B000002', 18500, 10, 185000),
('BM21080200', 'B000006', 23500, 20, 470000),
('BM21080200', 'B000005', 16500, 10, 165000),
('BM21082500', 'B000004', 20000, 100, 2000000),
('B210830001', 'B000007', 52500, 50, 2625000),
('B210906001', 'B000006', 24500, 100, 2450000),
('B210906001', 'B000001', 19000, 200, 3800000),
('B210906002', 'B000008', 5000, 100, 500000),
('B210906003', 'B000007', 50000, 20, 1000000);

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

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_transaksi`, `tanggal`, `user_id`, `total`, `bayar`, `kembalian`, `ppn`) VALUES
('T210718001', '2021-07-18', 1, 925000, 950000, 25000, 0),
('T210722001', '2021-07-22', 1, 600000, 600000, 0, 0),
('T210723001', '2021-07-23', 1, 1200000, 1200000, 0, 0),
('T210723002', '2021-07-23', 1, 1200000, 1200000, 0, 0),
('T210724001', '2021-07-24', 1, 702500, 703500, 1000, 0),
('T210725001', '2021-07-25', 2, 630000, 650000, 20000, 0),
('T210802001', '2021-08-02', 2, 587500, 600000, 12500, 0),
('T210814001', '2021-08-14', 1, 510250, 520000, 9750, 0),
('T210825001', '2021-08-25', 2, 2041000, 2041000, 0, 0),
('T210830001', '2021-08-30', 3, 550000, 550000, 0, 0),
('T210901001', '2021-09-01', 2, 550000, 550000, 0, 0),
('T210906001', '2021-09-06', 2, 3900000, 3900000, 0, 0),
('T210906002', '2021-09-06', 2, 2880000, 2880000, 0, 0),
('T210906003', '2021-09-06', 2, 2100000, 2100000, 0, 0),
('T210906004', '2021-09-06', 2, 870000, 900000, 30000, 0),
('T210906005', '2021-09-06', 2, 2695000, 2695000, 0, 0),
('T210906006', '2021-09-06', 2, 975000, 975000, 0, 0),
('T210920001', '2021-09-20', 2, 624250, 624250, 0, 0),
('T210920002', '2021-09-20', 2, 264000, 264000, 0, 0),
('T210920003', '2021-09-20', 2, 264000, 264000, 0, 0),
('T210920004', '2021-09-20', 2, 60500, 60500, 0, 0),
('T210920005', '2021-09-20', 2, 38500, 38500, 0, 0),
('T210920006', '2021-09-20', 2, 47850, 47850, 0, 0),
('T210920007', '2021-09-20', 2, 41515, 41516, 1, 0),
('T210920008', '2021-09-20', 2, 19250, 19250, 0, 1750),
('T210920009', '2021-09-20', 2, 26400, 26400, 0, 2400),
('T210920010', '2021-09-20', 2, 40700, 40700, 0, 3700),
('T210920011', '2021-09-20', 2, 38500, 38500, 0, 3500),
('T210920012', '2021-09-20', 2, 42900, 42900, 0, 3900),
('T210920013', '2021-09-20', 2, 62150, 62150, 0, 5650);

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

--
-- Dumping data for table `tb_transaksi_detail`
--

INSERT INTO `tb_transaksi_detail` (`transaksi_id`, `barang_id`, `qty`, `subtotal`, `total_keranjang`) VALUES
('T210718001', 'B000001', 50, 925000, 0),
('T210722001', 'B000006', 25, 600000, 0),
('T210723001', 'B000002', 50, 1200000, 0),
('T210723002', 'B000002', 50, 1200000, 0),
('T210724001', 'B000001', 25, 462500, 0),
('T210724001', 'B000002', 10, 240000, 0),
('T210725001', 'B000001', 20, 390000, 0),
('T210725001', 'B000002', 10, 240000, 0),
('T210802001', 'B000001', 15, 292500, 0),
('T210802001', 'B000006', 5, 120000, 0),
('T210802001', 'B000005', 10, 175000, 0),
('T210814001', 'B000004', 25, 510250, 0),
('T210825001', 'B000004', 100, 2041000, 0),
('T210830001', 'B000007', 10, 550000, 0),
('T210901001', 'B000007', 10, 550000, 0),
('T210906001', 'B000001', 200, 3900000, 0),
('T210906002', 'B000006', 120, 2880000, 0),
('T210906003', 'B000001', 40, 780000, 0),
('T210906003', 'B000002', 40, 960000, 0),
('T210906003', 'B000006', 15, 360000, 0),
('T210906004', 'B000006', 20, 480000, 0),
('T210906004', 'B000001', 20, 390000, 0),
('T210906005', 'B000007', 49, 2695000, 0),
('T210906006', 'B000001', 50, 975000, 0),
('T210920001', 'B000002', 20, 480000, 0),
('T210920001', 'B000005', 5, 87500, 0),
('T210920002', 'B000006', 10, 240000, 264000),
('T210920003', 'B000002', 10, 264000, 240000),
('T210920004', 'B000007', 1, 60500, 55000),
('T210920005', 'B000005', 1, 19250, 17500),
('T210920005', 'B000005', 1, 19250, 17500),
('T210920006', 'B000002', 1, 26400, 24000),
('T210920006', 'B000001', 1, 21450, 19500),
('T210920007', 'B000003', 1, 22265, 20241),
('T210920007', 'B000005', 1, 19250, 17500),
('T210920008', 'B000005', 1, 19250, 17500),
('T210920009', 'B000002', 1, 24000, 26400),
('T210920010', 'B000005', 1, 17500, 19250),
('T210920010', 'B000001', 1, 19500, 21450),
('T210920011', 'B000005', 2, 35000, 38500),
('T210920012', 'B000001', 2, 39000, 42900),
('T210920013', 'B000005', 1, 17500, 19250),
('T210920013', 'B000001', 2, 39000, 42900);

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
