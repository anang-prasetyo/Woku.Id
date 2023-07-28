-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jul 2023 pada 19.40
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectweb`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(10) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `pass` varchar(70) NOT NULL,
  `bagian` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `uname`, `pass`, `bagian`) VALUES
(1, 'ADMIN', 'admin123', 'ADMIN'),
(2, 'KARYAWAN', 'karyawan123', 'KARYAWAN'),
(3, 'KARYAWAN SATU', 'karyawan456', 'KARYAWAN'),
(15, 'KARYAWAN DUA', 'kk222', 'KARYAWAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_akses`
--

CREATE TABLE `admin_akses` (
  `bagian` varchar(15) NOT NULL,
  `akses_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `jenis` text NOT NULL,
  `suplier` text NOT NULL,
  `modal` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sisa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama`, `jenis`, `suplier`, `modal`, `harga`, `jumlah`, `sisa`) VALUES
(14, 'ROTI UNIBIS', 'MAKANAN RINGAN', 'PT. MAKMUR JAYA', 5000, 6500, 50, 45),
(17, 'TIM TAM', 'MAKANAN RINGAN', 'PT. SURYA KENCANA', 2000, 6000, 50, 48),
(19, 'TIC TAC', 'MAKANAN RINGAN', 'PT. SIDO URIP', 2000, 4000, 50, 48),
(20, 'AQUA', 'MINUMAN', 'PT. DANONE', 1000, 3000, 50, 46),
(21, 'CHITATO', 'MAKANAN RINGAN', 'PT. SURYA', 2000, 4000, 50, 45),
(23, 'DJARUM', 'ROKOK', 'PT. DRAJUM FOUNDATION', 12000, 13000, 50, 40),
(24, 'INDOMIE', 'MAKANAN INSTAN', 'PT. INDOFOOD', 2000, 4000, 50, 47),
(33, 'TARO', 'MAKANAN RINGAN', 'PT. INDOFOOD', 2000, 5000, 50, 45),
(34, 'MIE SEDAP', 'MAKANAN INSTAN', 'PT. MIE SEDAP', 1500, 2500, 50, 50),
(35, 'ROTI AOKA', 'MAKANAN RINGAN', 'PT. AOKA', 1000, 2000, 50, 50),
(36, 'BENG BENG', 'MAKANAN RINGAN', 'PT. INDOFOOD', 1500, 3000, 50, 50),
(55, 'AICE STROBERI', 'ES KRIM', 'PT. INDOFOOD', 2500, 3000, 11, 0),
(56, 'AICE MANGGA', 'ES KRIM', 'PT. INDOFOOD', 2500, 3000, 9, 7),
(66, 'AICE APEL', 'ES KRIM', 'PT. INDOFOOD', 3000, 4000, 11, 2),
(67, 'AICE ANGGUR', 'ES KRIM', 'PT. INDOFOOD', 2500, 3000, 11, 5),
(77, 'AICE JAGUNG', 'ES KRIM', 'PT. INDOFOOD', 2500, 3000, 11, 8),
(81, 'AICE PISANG', 'ES KRIM', 'PT. INDOFOOD', 2500, 3000, 11, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_laku`
--

CREATE TABLE `barang_laku` (
  `id_transaksi` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `nama` text NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `total_harga` int(20) NOT NULL,
  `laba` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_laku`
--

INSERT INTO `barang_laku` (`id_transaksi`, `tanggal`, `nama`, `jumlah`, `harga`, `total_harga`, `laba`, `id`) VALUES
('T01092021-132011', '2021-01-09', 'TIC TAC', 2, 4000, 8000, 4000, 1),
('T01092021-132111', '2021-01-09', 'TARO', 5, 5000, 25000, 15000, 2),
('T01102021-132111', '2021-01-10', 'TIM TAM', 2, 6000, 12000, 8000, 3),
('T01122021-132111', '2021-01-12', 'ROTI UNIBIS', 5, 6500, 32500, 7500, 4),
('T01132021-132111', '2021-01-13', 'TARO', 3, 5000, 15000, 9000, 5),
('T05012023-132111', '2023-05-01', 'CHITATO', 5, 4000, 20000, 10000, 6),
('T05022023-132011', '2023-05-02', 'INDOMIE', 3, 5000, 15000, 9000, 7),
('T05022023-132111', '2023-05-02', 'DJARUM', 10, 13000, 130000, 10000, 8),
('T06252023-132111', '2023-06-25', 'AQUA', 4, 3000, 12000, 8000, 9),
('T06262023-132011', '2023-06-26', 'AICE APEL', 5, 3500, 17500, 2500, 10),
('T06262023-132111', '2023-06-26', 'AICE STROBERI', 2, 3000, 6000, 1000, 11),
('T06292023-131811', '2023-06-29', 'AICE MANGGA', 4, 3000, 12000, 2000, 12),
('T06292023-131911', '2023-06-29', 'AICE MANGGA', 7, 3000, 21000, 2000, 13),
('T06292023-132011', '2023-06-29', 'AICE APEL', 4, 3500, 14000, 2000, 14),
('T06292023-132111', '2023-06-29', 'AICE STROBERI', 3, 3000, 9000, 1500, 15),
('T07102023-132111', '2023-07-10', 'AICE STROBERI', 2, 3000, 6000, 1000, 16),
('T07122023-131925', '2023-07-12', 'AICE JAGUNG', 2, 3000, 6000, 1000, 17),
('T07122023-132111', '2023-07-12', 'AICE STROBERI', 3, 3000, 9000, 1500, 18),
('T07122023-133557', '2023-07-12', 'AICE STROBERI', 1, 3000, 3000, 500, 19),
('T07122023-145831', '2023-07-12', 'AICE MANGGA', 1, 3000, 3000, 500, 20),
('T07122023-145948', '2023-07-12', 'AICE MANGGA', 2, 3000, 6000, 1000, 21),
('T07122023-153650', '2023-07-12', 'AICE MANGGA', 1, 3000, 3000, 500, 22),
('T07292023-000013', '2023-07-29', 'AICE ANGGUR', 2, 3000, 6000, 1000, 1001),
('T07292023-000918', '2023-07-29', 'AICE ANGGUR', 1, 3000, 3000, 500, 1002),
('T07292023-003253', '2023-07-29', 'AICE JAGUNG', 1, 3000, 3000, 500, 1003),
('T07292023-003253', '2023-07-29', 'AICE ANGGUR', 1, 3000, 3000, 500, 1004),
('T07292023-003821', '2023-07-29', 'AICE ANGGUR', 1, 3000, 3000, 500, 1005),
('T07292023-003854', '2023-07-29', 'AICE PISANG', 2, 3000, 6000, 1000, 1006),
('T07292023-003854', '2023-07-29', 'AICE ANGGUR', 1, 3000, 3000, 500, 1007);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_akses`
--

CREATE TABLE `master_akses` (
  `akses_id` varchar(10) NOT NULL,
  `nama` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `master_akses`
--

INSERT INTO `master_akses` (`akses_id`, `nama`) VALUES
('admin', 'admin'),
('karyawan', 'karyawan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keperluan` text NOT NULL,
  `nama` text NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `tanggal`, `keperluan`, `nama`, `jumlah`) VALUES
(1, '2015-02-06', 'de', 'diki', 1234);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `admin_akses`
--
ALTER TABLE `admin_akses`
  ADD KEY `akses_id` (`akses_id`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_laku`
--
ALTER TABLE `barang_laku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_akses`
--
ALTER TABLE `master_akses`
  ADD PRIMARY KEY (`akses_id`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT untuk tabel `barang_laku`
--
ALTER TABLE `barang_laku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin_akses`
--
ALTER TABLE `admin_akses`
  ADD CONSTRAINT `admin_akses_ibfk_1` FOREIGN KEY (`akses_id`) REFERENCES `master_akses` (`akses_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
