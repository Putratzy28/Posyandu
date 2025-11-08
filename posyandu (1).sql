-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 15 Jul 2025 pada 13.22
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posyandu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anak`
--

CREATE TABLE `anak` (
  `id` int NOT NULL,
  `id_orangtua` int DEFAULT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_general_ci NOT NULL,
  `nama_ortu` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `anak`
--

INSERT INTO `anak` (`id`, `id_orangtua`, `nama`, `nik`, `tanggal_lahir`, `jenis_kelamin`, `nama_ortu`, `alamat`) VALUES
(10, NULL, 'Irul', '3254546', '2022-02-10', 'Laki-laki', 'Saputra', 'Solo'),
(11, NULL, 'anas', '187279', '2021-12-27', 'Laki-laki', 'Waluyo', 'Banjar'),
(12, NULL, 'Shiva', '778578', '2022-07-09', 'Perempuan', 'Mulyanto', 'Sukarjo'),
(13, NULL, 'Putra', '3311112905199722', '2023-07-23', 'Perempuan', 'Mulyanto', 'Sukarjo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `imunisasi`
--

CREATE TABLE `imunisasi` (
  `id` int NOT NULL,
  `anak_id` int NOT NULL,
  `jenis_imunisasi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `berat` decimal(5,2) DEFAULT NULL,
  `tinggi` decimal(5,2) DEFAULT NULL,
  `petugas` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `imunisasi`
--

INSERT INTO `imunisasi` (`id`, `anak_id`, `jenis_imunisasi`, `tanggal`, `berat`, `tinggi`, `petugas`, `keterangan`) VALUES
(5, 10, 'Flu', '2025-06-11', 17.00, 98.00, 'Rahmat', 'Sehat'),
(7, 12, 'Campak', '2025-06-14', 21.00, 99.00, 'Rahmat', 'Sehat'),
(8, 11, 'Stunting', '2025-06-16', 17.00, 100.00, 'Rahmat', 'Sehat'),
(9, 13, 'Flu', '2025-07-16', 79.00, 334.00, 'Rahmat', 'Sehat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jenis_imunisasi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `lokasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `tanggal`, `jenis_imunisasi`, `lokasi`) VALUES
(1, '2025-06-07', 'flu', 'mbarkasi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int NOT NULL,
  `id_imunisasi` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('admin','orangtua') COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'amri', '$2y$10$fOBS7NTRU6kpEnPJjsZv.O47Tn7PMI.xM1a/M73GhsRum5AuzJJY2', 'admin'),
(2, 'dori', '$2y$10$AK51uYVyJNlsY1pBFERtBO9k8tR3ICv6LOGVqxUfAMhOxm0xcxEBK', 'admin'),
(7, 'Eka', '$2y$10$okobuENT6CGqnq3YcU9MNeL4xiuRRTVdfI5e8/BVn4kaZ/DcSE0aG', 'admin'),
(8, 'putra', '$2y$10$EdS8byIcvBnHZvqe/z05nOU1LVZn9w5ijM8rfnQYp9ARxLSeXxhUG', 'admin'),
(9, 'shiva', '$2y$10$2tCdxLJvzc9zTk0Bj.qEIuZg65QadeqZE3sR8.xehDElEpvTHsWkG', 'admin'),
(10, 'dorihengker', '$2y$10$lZOUZiEDhwvdR0wXClzbnereN7l8Oc0UN4SyaBp6RtuaYh4apYDhi', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anak`
--
ALTER TABLE `anak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_orangtua` (`id_orangtua`);

--
-- Indeks untuk tabel `imunisasi`
--
ALTER TABLE `imunisasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anak_id` (`anak_id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anak`
--
ALTER TABLE `anak`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `imunisasi`
--
ALTER TABLE `imunisasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anak`
--
ALTER TABLE `anak`
  ADD CONSTRAINT `anak_ibfk_1` FOREIGN KEY (`id_orangtua`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `imunisasi`
--
ALTER TABLE `imunisasi`
  ADD CONSTRAINT `imunisasi_ibfk_1` FOREIGN KEY (`anak_id`) REFERENCES `anak` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
