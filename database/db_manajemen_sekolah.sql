-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 15 Jan 2026 pada 10.24
-- Versi server: 8.4.5
-- Versi PHP: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_manajemen_sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int NOT NULL,
  `a_id_guru` int NOT NULL,
  `a_id_kelas` int NOT NULL,
  `a_id_siswa` int NOT NULL,
  `status_absensi` enum('Hadir','Alpha','Izin') NOT NULL,
  `tanggal_absensi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `a_id_guru`, `a_id_kelas`, `a_id_siswa`, `status_absensi`, `tanggal_absensi`) VALUES
(47, 2, 10, 2, 'Alpha', '2023-10-10 00:00:00'),
(48, 2, 10, 7, 'Hadir', '2023-10-10 00:00:00'),
(49, 2, 9, 5, 'Alpha', '2023-10-10 00:00:00'),
(50, 2, 9, 12, 'Hadir', '2023-10-10 00:00:00'),
(52, 2, 10, 2, 'Hadir', '2023-10-10 00:00:00'),
(56, 2, 5, 15, 'Hadir', '2023-10-10 00:00:00'),
(57, 2, 5, 16, 'Hadir', '2023-10-10 00:00:00'),
(61, 7, 10, 1, 'Hadir', '2023-10-04 00:00:00'),
(62, 3, 10, 1, 'Hadir', '2023-10-06 00:00:00'),
(63, 2, 10, 1, 'Hadir', '2023-10-07 00:00:00'),
(64, 2, 10, 1, 'Hadir', '2023-10-08 00:00:00'),
(65, 2, 10, 1, 'Hadir', '2023-10-10 00:00:00'),
(66, 2, 10, 1, 'Hadir', '2023-11-16 00:00:00'),
(67, 2, 10, 2, 'Alpha', '2023-11-16 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `password_admin` varchar(200) NOT NULL,
  `telepon_admin` int NOT NULL,
  `alamat_admin` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `email_admin`, `password_admin`, `telepon_admin`, `alamat_admin`, `created_at`) VALUES
(1, 'Admin', 'admin@email.com', 'admin', 12345, 'address admin', '2023-09-03 21:37:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `biaya`
--

CREATE TABLE `biaya` (
  `biaya_uang_sekolah` int NOT NULL,
  `biaya_perpustakaan` int NOT NULL,
  `biaya_olahraga` int NOT NULL,
  `id_biaya` int NOT NULL,
  `jumlah_biaya` int NOT NULL,
  `bulan_biaya` int NOT NULL,
  `jatuh_tempo_biaya` date NOT NULL,
  `akhir_biaya` date NOT NULL,
  `b_id_siswa` int NOT NULL,
  `b_id_kelas` int NOT NULL,
  `id_transaksi` varchar(50) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL DEFAULT '0',
  `tanggal_bayar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_biaya` enum('Lunas','Belum Lunas','Proses') NOT NULL DEFAULT 'Belum Lunas',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `biaya`
--

INSERT INTO `biaya` (`biaya_uang_sekolah`, `biaya_perpustakaan`, `biaya_olahraga`, `id_biaya`, `jumlah_biaya`, `bulan_biaya`, `jatuh_tempo_biaya`, `akhir_biaya`, `b_id_siswa`, `b_id_kelas`, `id_transaksi`, `metode_pembayaran`, `tanggal_bayar`, `status_biaya`, `created_at`) VALUES
(3000, 1000, 1000, 12, 5000, 10, '2023-10-11', '2023-10-18', 4, 2, 'SPTAUHHV697AU4L3CDX6', '0', '2023-10-11 00:12:09', 'Belum Lunas', '2023-10-11 00:12:09'),
(2000, 500, 500, 13, 3000, 10, '2023-10-11', '2023-10-11', 1, 10, '9XV8JB4R344D0603GCWN', '1', '2023-11-16 11:51:26', 'Proses', '2023-10-11 00:13:21'),
(3000, 1000, 1000, 14, 5000, 9, '2023-10-11', '2023-09-27', 1, 10, '0GRIN4NLBZYQYL8AUWTC', '5', '2023-11-17 00:48:34', 'Proses', '2023-10-11 00:13:50'),
(4000, 500, 500, 15, 5000, 8, '2023-10-11', '2023-08-18', 1, 10, '6J1YOGFTSY3HA9ITK63J', '3', '2023-10-11 00:33:43', 'Lunas', '2023-10-11 00:14:19'),
(5000, 1000, 500, 19, 6500, 5, '2023-05-09', '2023-05-12', 1, 10, 'FROYAHQ4ZREMZRH3HZ0W', '2', '2023-10-11 00:32:38', 'Lunas', '2023-10-11 00:28:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan_siswa`
--

CREATE TABLE `catatan_siswa` (
  `id_catatan` int NOT NULL,
  `c_id_guru` int NOT NULL,
  `c_id_kelas` int NOT NULL,
  `c_id_siswa` int NOT NULL,
  `catatan` varchar(500) NOT NULL,
  `status` enum('Positif','Negatif') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `catatan_siswa`
--

INSERT INTO `catatan_siswa` (`id_catatan`, `c_id_guru`, `c_id_kelas`, `c_id_siswa`, `catatan`, `status`, `created_at`) VALUES
(1, 2, 10, 1, 'Always comes late in Class', 'Negatif', '2023-09-12 21:35:49'),
(3, 2, 10, 2, ' Good Student', 'Positif', '2023-09-12 21:36:52'),
(4, 2, 10, 1, '  a good feedback for student is always refreshing and we always want that we should take a very good remarks from our teachers', 'Positif', '2023-09-12 21:51:53'),
(5, 2, 10, 1, '      always late and make noice in class', 'Negatif', '2023-09-12 22:30:34'),
(6, 2, 10, 2, '  late nhi hota', 'Positif', '2023-09-12 22:47:51'),
(7, 2, 10, 1, 'GoodDiscipline in Class', 'Positif', '2023-11-17 00:47:20'),
(8, 2, 10, 1, 'Comes late in class', 'Positif', '2023-11-17 00:47:36'),
(9, 2, 10, 1, 'Bagus Anak Muda', 'Positif', '2026-01-15 00:23:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `email_guru` varchar(100) NOT NULL,
  `password_guru` varchar(200) NOT NULL,
  `tanggal_lahir_guru` date NOT NULL,
  `foto_guru` varchar(300) NOT NULL,
  `mapel_guru` varchar(50) NOT NULL,
  `telepon_guru` varchar(30) NOT NULL,
  `alamat_guru` varchar(100) NOT NULL,
  `umur_guru` int NOT NULL,
  `jekel_guru` enum('Laki_Laki','Perempuan') NOT NULL,
  `status_guru` enum('Aktif','Disable') NOT NULL DEFAULT 'Aktif',
  `tanggal_regis_guru` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `email_guru`, `password_guru`, `tanggal_lahir_guru`, `foto_guru`, `mapel_guru`, `telepon_guru`, `alamat_guru`, `umur_guru`, `jekel_guru`, `status_guru`, `tanggal_regis_guru`) VALUES
(2, 'Atif Iqball', 'atif@gmail.com', '123', '1995-07-18', '1697107461_atif.jpg', '14', '0300-1234567', 'Lahore', 28, 'Laki_Laki', 'Aktif', '2023-08-29 16:30:55'),
(3, 'Sadaqat Ali', 'sadaqat@gmail.com', 'sadaqat', '2023-06-08', '1694973251_sadaqat.jpg', '14', '12345', 'adres', 35, 'Laki_Laki', 'Aktif', '2023-09-17 22:53:51'),
(4, 'Shahbaz Ali Shad', 'shahbaz@gmail.com', 'shahbaz', '2023-07-05', '1694973661_shahbaz.jpg', '9', '12345', 'address', 36, 'Laki_Laki', 'Aktif', '2023-09-17 23:01:01'),
(6, 'Tariq Ali', 'tariq@gmail.com', 'tariq', '2023-09-07', '1694973966_tariq.jpg', '10', '12345', 'addres', 35, 'Laki_Laki', 'Aktif', '2023-09-17 23:06:06'),
(7, 'Zahid Ali', 'zahid@gmail.com', 'zahid', '2023-09-15', '1694974157_zahid.jpg', '8', '12345', 'address', 40, 'Laki_Laki', 'Aktif', '2023-09-17 23:09:17'),
(9, 'Agus Sriyono S.Pd M.Pd', 'agus@gmail.com', '123', '1997-02-14', '1768466948_dummy.jpeg', '14', '08212121', 'Surakarta', 32, 'Laki_Laki', 'Aktif', '2026-01-15 15:49:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int NOT NULL,
  `j_id_guru` int NOT NULL,
  `j_id_kelas` int NOT NULL,
  `j_id_seksi` int DEFAULT NULL,
  `j_id_sesi` int NOT NULL,
  `j_mapel_id` int NOT NULL,
  `j_id_ruangan` int NOT NULL,
  `hari_jadwal` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `j_id_guru`, `j_id_kelas`, `j_id_seksi`, `j_id_sesi`, `j_mapel_id`, `j_id_ruangan`, `hari_jadwal`, `created_at`) VALUES
(18, 2, 11, 41, 8, 5, 16, 'Kamis', '2023-09-13 22:25:30'),
(19, 2, 11, 41, 4, 11, 16, 'Senin', '2023-09-13 22:25:11'),
(20, 2, 11, 41, 2, 11, 16, 'Wednesday', '2023-09-05 12:11:54'),
(24, 6, 5, 41, 2, 11, 16, 'Selasa', '2023-11-16 11:48:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `nama_mapel` varchar(300) NOT NULL,
  `nama_seksi` varchar(50) NOT NULL,
  `k_id_guru` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `nama_mapel`, `nama_seksi`, `k_id_guru`, `created_at`) VALUES
(1, '1', '1,5,6', '41,42,50', 2, '2023-09-17 23:16:41'),
(2, '2', '1,5,6', '41,42', 2, '2023-09-17 23:12:23'),
(3, '3', '1,5,6', '', 6, '2023-09-17 23:17:04'),
(5, '5', '1,5,6,14', '41', 7, '2023-09-17 23:19:25'),
(6, '6', '1,5,6,7,8,14', '', 2, '2023-09-17 23:19:45'),
(7, '7', '1,5,6,7,8,14', '', 6, '2023-09-17 23:19:53'),
(9, '9', '1,5,6,7,10,11,12,14', '', 4, '2023-09-17 23:21:03'),
(10, '10', '12,11,14,1,8,6,10,5', '50', 3, '2023-09-17 23:20:43'),
(11, 'KG', '14,13,6', '41', 4, '2023-09-17 23:16:23'),
(113, 'RPL B', '14,1,8,6,10', '41', 9, '2026-01-15 16:19:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int NOT NULL,
  `nama_kontak` varchar(50) NOT NULL,
  `email_kontak` varchar(50) NOT NULL,
  `subjek_kontak` varchar(100) NOT NULL,
  `pesan_kontak` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int NOT NULL,
  `kode_mapel` varchar(20) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `kode_mapel`, `nama_mapel`, `created_at`) VALUES
(1, 'ENG', 'English', '2023-08-30 22:56:09'),
(5, 'UD', 'Urdu', '2023-08-30 22:55:59'),
(6, 'MATHS', 'Mathematics', '2023-08-30 22:56:25'),
(7, 'PS', 'Pak Studies', '2023-08-30 22:56:57'),
(8, 'ISL', 'Islamiat', '2023-08-30 22:56:47'),
(9, 'SCI', 'Science', '2023-08-30 22:56:37'),
(10, 'PHY', 'Physics', '2023-08-30 22:54:05'),
(11, 'CHEM', 'Chemistry', '2023-08-30 22:54:17'),
(12, 'BIO', 'Biology', '2023-08-30 22:54:45'),
(13, 'DRW', 'Drawing', '2023-08-30 22:55:01'),
(14, 'COMP', 'Computer', '2023-08-30 22:55:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int NOT NULL,
  `nama_nilai` varchar(50) NOT NULL,
  `tipe_nilai` enum('MID','UAS','Tugas','Ulangan') NOT NULL,
  `total_nilai` int NOT NULL,
  `capaian_nilai` int NOT NULL,
  `n_id_kelas` int NOT NULL,
  `n_id_siswa` int NOT NULL,
  `n_id_guru` int NOT NULL,
  `n_id_mapel` int NOT NULL,
  `nilai_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `nilai`
--

INSERT INTO `nilai` (`id_nilai`, `nama_nilai`, `tipe_nilai`, `total_nilai`, `capaian_nilai`, `n_id_kelas`, `n_id_siswa`, `n_id_guru`, `n_id_mapel`, `nilai_date`) VALUES
(13, 'Test', 'Ulangan', 20, 16, 11, 1, 2, 10, '2023-09-04'),
(14, 'Test 1', 'Ulangan', 10, 8, 11, 1, 2, 5, '2023-09-02'),
(15, 'Mid Term', 'Ulangan', 15, 15, 11, 1, 2, 5, '2023-09-04'),
(17, 'Final', 'UAS', 50, 39, 11, 1, 2, 5, '2023-09-04'),
(18, 'Mid Term', 'MID', 50, 23, 11, 1, 2, 1, '2023-09-04'),
(19, 'Test 1', 'Ulangan', 40, 33, 11, 1, 2, 6, '2023-09-04'),
(20, 'Mid Term', 'MID', 50, 40, 11, 1, 2, 7, '2023-09-04'),
(21, 'Mid Term', 'MID', 50, 43, 11, 1, 2, 1, '2023-09-04'),
(22, 'Mid Term', 'MID', 50, 33, 11, 1, 2, 8, '2023-09-04'),
(24, 'Mid Term', 'MID', 50, 30, 11, 1, 2, 5, '2023-09-04'),
(25, 'Test 1', 'Ulangan', 15, 10, 11, 1, 2, 5, '2023-09-04'),
(26, 'Mid Term', 'UAS', 30, 30, 11, 1, 2, 1, '2023-09-04'),
(29, 'Mid Term', 'MID', 20, 10, 11, 1, 2, 6, '2023-09-04'),
(31, 'Final Term', 'UAS', 50, 40, 10, 1, 2, 6, '2023-10-11'),
(32, 'Assignment 1', 'Tugas', 15, 12, 10, 1, 2, 6, '2023-10-11'),
(33, 'Test', 'Ulangan', 15, 12, 10, 1, 2, 14, '2023-11-17'),
(34, 'Mid', 'MID', 20, 18, 10, 1, 2, 14, '2023-11-17'),
(35, 'Assignment', 'Tugas', 15, 15, 10, 1, 2, 14, '2023-11-17'),
(36, 'Final', 'UAS', 50, 49, 10, 1, 2, 14, '2023-11-17'),
(37, 'Mid', 'MID', 20, 16, 10, 1, 2, 10, '2023-11-17'),
(38, 'Final', 'UAS', 50, 38, 10, 1, 2, 10, '2023-11-17'),
(39, 'Test', 'Ulangan', 15, 12, 10, 1, 2, 8, '2023-11-17'),
(40, 'Assignment', 'Tugas', 15, 15, 10, 1, 2, 8, '2023-11-17'),
(41, 'Assignment', 'Tugas', 15, 13, 10, 1, 2, 1, '2023-11-17'),
(42, 'Final Term', 'UAS', 100, 88, 10, 2, 2, 8, '2023-11-17'),
(43, 'Tugas Praktikum', 'Tugas', 100, 90, 10, 7, 2, 14, '2026-01-14'),
(44, 'Tugas Praktikum', 'Tugas', 100, 77, 10, 1, 2, 14, '2026-01-14'),
(45, 'Tugas Praktikum', 'Tugas', 100, 98, 10, 2, 2, 14, '2026-01-14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orang_tua`
--

CREATE TABLE `orang_tua` (
  `id_ortu` int NOT NULL,
  `nama_ortu` varchar(50) NOT NULL,
  `email_ortu` varchar(50) NOT NULL,
  `password_ortu` varchar(100) NOT NULL,
  `anak` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nik` varchar(20) NOT NULL,
  `foto_ortu` varchar(300) NOT NULL,
  `status_ortu` enum('Aktif','Disable') NOT NULL DEFAULT 'Aktif',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `orang_tua`
--

INSERT INTO `orang_tua` (`id_ortu`, `nama_ortu`, `email_ortu`, `password_ortu`, `anak`, `nik`, `foto_ortu`, `status_ortu`, `created_at`) VALUES
(1, 'Rafaqat Ali Shahid', 'rafaqat@gmail.com', '123', '1,2', '0123412312311', '1768413857PXL_20251202_170204881.jpg', 'Aktif', '2023-09-15 23:05:37'),
(2, 'Fayyaz Hussain', 'fayyaz@gmail.com', 'fayyaz', '6,13', '5432176543218', '1694927114_fayyaz.jpg', 'Aktif', '2023-09-17 10:05:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int NOT NULL,
  `judul_pengumuman` varchar(50) NOT NULL,
  `ket_pengumuman` varchar(300) NOT NULL,
  `p_id_kelas` int DEFAULT NULL,
  `p_id_kirim` int NOT NULL,
  `pengirim` varchar(50) NOT NULL,
  `tanggal_pengumuman` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `judul_pengumuman`, `ket_pengumuman`, `p_id_kelas`, `p_id_kirim`, `pengirim`, `tanggal_pengumuman`) VALUES
(22, 'New', 'class', 11, 1888, 'Admin', '2023-09-08 12:45:58'),
(23, 'without', 'wo', NULL, 1888, 'Admin', '2023-09-08 12:46:37'),
(24, 'without', 'wo', NULL, 1888, 'Admin', '2023-09-08 12:47:39'),
(29, 'New entry', 'all', NULL, 2555, 'Sir Hameed', '2023-09-08 12:54:55'),
(30, 'ok', 'ok', NULL, 2555, 'Sir Hameed', '2023-09-08 14:07:24'),
(31, 'New entry', 'ok', NULL, 2555, 'Sir Hameed', '2023-09-08 14:22:05'),
(32, 'New entry', 'ok', NULL, 2555, 'Sir Hameed', '2023-09-08 14:22:14'),
(36, 'New entry', 'dummy', NULL, 2555, 'Sir Hameed', '2023-09-08 14:39:40'),
(44, 'ok class', '  new', 10, 1888, 'Admin', '2023-09-08 14:48:57'),
(45, 'New entry', '  class', 10, 2555, 'Sir Hameed', '2023-09-08 14:49:40'),
(46, 'new', '      all i know', 9, 2555, 'Sir Hameed', '2023-09-08 14:49:52'),
(47, 'holidsay', ' htddsfg', 7, 1888, 'Admin', '2023-09-08 20:04:29'),
(48, 'new', ' rfv', 9, 2555, 'Sir Hameed', '2023-09-08 20:07:35'),
(49, 'Holiday', 'Tomorrow School is Off because of Independence  Day. Pakistan Zindabad!!!!', 10, 1888, 'Admin', '2023-09-09 10:16:31'),
(50, 'Holiday', 'Tomorrow is Holiday', NULL, 2555, 'Sir Atif Iqbal', '2023-11-17 00:46:03'),
(51, 'Libor Anak Anak', 'libur', 10, 2555, 'Atif Iqball', '2026-01-14 23:19:41'),
(52, 'Pembayaran Uang Sewa', 'Bayar', NULL, 1888, 'Admin', '2026-01-15 17:06:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL,
  `kapasitas_ruangan` int NOT NULL,
  `r_id_kelas` int NOT NULL,
  `r_id_seksi` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `kapasitas_ruangan`, `r_id_kelas`, `r_id_seksi`, `created_at`) VALUES
(16, 'Room 1', 12, 11, 41, '2023-08-31 12:11:10'),
(17, 'Lab Komputer 1', 21, 10, 50, '2026-01-15 16:29:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seksi`
--

CREATE TABLE `seksi` (
  `id_seksi` int NOT NULL,
  `judul_seksi` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `seksi`
--

INSERT INTO `seksi` (`id_seksi`, `judul_seksi`, `created_at`) VALUES
(41, 'Section A', '2023-08-22 15:59:40'),
(42, 'Section B', '2023-08-22 15:59:49'),
(50, 'Section C', '2023-08-26 15:17:14'),
(53, 'Section D', '2023-11-17 00:43:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sesi`
--

CREATE TABLE `sesi` (
  `id_sesi` int NOT NULL,
  `nama_sesi` varchar(50) NOT NULL,
  `jam_mulai_sesi` time NOT NULL,
  `jam_berakhir_sesi` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sesi`
--

INSERT INTO `sesi` (`id_sesi`, `nama_sesi`, `jam_mulai_sesi`, `jam_berakhir_sesi`, `created_at`) VALUES
(2, 'Pelajaran Pertama', '08:00:00', '08:45:00', '2023-09-13 21:17:17'),
(3, 'Second Period', '08:45:00', '09:30:00', '2023-09-13 21:17:53'),
(4, 'Third Period', '09:30:00', '10:15:00', '2023-09-13 21:23:28'),
(5, 'Lunch Break', '10:15:00', '10:45:00', '2023-09-13 21:27:56'),
(6, 'Fourth Period', '10:45:00', '11:30:00', '2023-09-13 21:28:32'),
(7, 'FifthPeriod', '11:30:00', '12:15:00', '2023-09-13 21:29:00'),
(8, 'Sixth Period', '12:15:00', '13:00:00', '2023-09-13 21:29:33'),
(9, 'Jumatan', '11:20:00', '13:30:00', '2026-01-15 16:29:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int NOT NULL,
  `id_sims` varchar(20) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `email_siswa` varchar(30) NOT NULL,
  `password_siswa` varchar(200) NOT NULL,
  `kelas_siswa` int NOT NULL,
  `seksi_siswa` int NOT NULL,
  `tanggal_lahir_siswa` date NOT NULL,
  `foto_siswa` varchar(300) NOT NULL,
  `telepon_siswa` varchar(30) NOT NULL,
  `alamat_siswa` varchar(200) NOT NULL,
  `umur_siswa` int NOT NULL,
  `jekel_siswa` enum('Laki_Laki','Perempuan') NOT NULL,
  `status_siswa` enum('Aktif','Disable') NOT NULL DEFAULT 'Aktif',
  `tanggal_regis_siswa` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nik_ortu` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_sims`, `nama_siswa`, `email_siswa`, `password_siswa`, `kelas_siswa`, `seksi_siswa`, `tanggal_lahir_siswa`, `foto_siswa`, `telepon_siswa`, `alamat_siswa`, `umur_siswa`, `jekel_siswa`, `status_siswa`, `tanggal_regis_siswa`, `nik_ortu`) VALUES
(1, '0001-SMS-10', 'Danish Aliwek wek', 'danish@gmail.com', '123', 10, 0, '2000-10-24', '1694343750_danish.jpg', '0300-12993923', 'Indonesia', 20, 'Laki_Laki', 'Aktif', '2023-08-31 11:53:49', '0123412312311'),
(2, '0002-SMS-10', 'Haider Ali', 'haider@gmail.com', 'haider', 10, 0, '2023-08-03', '1694343717_haider.jpg', '12345', 'addr', 4, 'Laki_Laki', 'Aktif', '2023-08-31 11:54:52', '0123412312311'),
(4, '0004-SMHS-02', 'Ahmad Baba', 'ahmad@gmail.com', 'ahmad', 2, 42, '2023-09-08', '1694343600_ahmed.jpg', '2313', 'address', 15, 'Laki_Laki', 'Aktif', '2023-09-10 16:00:00', '12121-1212121-1'),
(5, '0005-SMHS-09', 'Adil Iqbal', 'adil@gmail.com', 'adil', 9, 0, '2023-09-13', '1694343688_adil.jpg', '12241', 'adil addr', 19, 'Laki_Laki', 'Aktif', '2023-09-10 16:01:28', '5432176543218'),
(6, '0006-SMHS-07', 'Salman Iqbal', 'salman@gmail.com', 'salman', 7, 50, '2023-09-20', '1694343845_salman.jpg', '1313', 'mani address', 17, 'Laki_Laki', 'Aktif', '2023-09-10 16:04:05', '5432176543218'),
(7, '0007-SMHS-10', 'Aqib Ali', 'aqib@gmail.com', 'aqib', 10, 0, '2023-09-12', '1694343955_aqib.jpg', '123213', 'addr Aqib', 18, 'Laki_Laki', 'Aktif', '2023-09-10 16:05:55', '5432176543218'),
(12, '0008-SMHS-09', 'Saqib Iqbal', 'saqib@gmail.com', 'saqib', 9, 0, '2023-09-05', '1694972656_saqib.jpg', '1234', 'address', 4, 'Laki_Laki', 'Aktif', '2023-09-17 22:44:16', '12121-1212121-1'),
(13, '0009-SMHS -07', 'Amir Majeed', 'amir@gmail.com', 'amir', 7, 0, '2023-09-17', '1694975559_amir.jpg', '12345', 'amir address', 19, 'Laki_Laki', 'Aktif', '2023-09-17 23:32:39', '5432176543218'),
(14, '0010-SMHS -05', 'Javaid Ali', 'javaid@gmail.com', 'javaid', 5, 41, '2023-09-17', '1694975772_javaid.jpg', '12345', 'jadi address', 20, 'Laki_Laki', 'Aktif', '2023-09-17 23:36:12', '0123412312311'),
(15, '0011-SMHS -05', 'Hafiz Hamza', 'hamza@gmail.com', 'hamza', 5, 0, '2023-09-17', '1694976281_hamza.jpg', '12345', 'hamza addr', 15, 'Laki_Laki', 'Aktif', '2023-09-17 23:44:41', '12121-1212121-1'),
(16, '0012-SMHS -05', 'Asim Ali', 'asim@gmail.com', 'asim', 5, 0, '2023-09-17', '1694976368_asim.jpg', '0', 'asim address', 12, 'Laki_Laki', 'Aktif', '2023-09-17 23:46:08', '12121-1212121-1'),
(17, '2026-SMHS-3634', 'Budi Alow', 'budi@gmail.com', '123', 5, 41, '2026-01-16', '1768463904_PXL_20251202_164317615.jpg', '32323232', 'Jawa Tengah josjisssss', 1, 'Laki_Laki', 'Aktif', '2026-01-15 14:58:24', '5432176543218'),
(18, '2026-SMHS-8216', 'Putri Praweswari', 'test@gmail.com', '123', 2, 42, '2013-03-21', '1768463946_IMG-20251130-WA0112.jpg', '32323232', 'dssda', 15, 'Perempuan', 'Aktif', '2026-01-15 14:59:06', '0123412312311');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `relation with class in attendance` (`a_id_kelas`),
  ADD KEY `relation with student in attendance` (`a_id_siswa`),
  ADD KEY `relation with teacher in attendance` (`a_id_guru`);

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id_biaya`),
  ADD KEY `relation with student in fee` (`b_id_siswa`),
  ADD KEY `relation with class in fee` (`b_id_kelas`);

--
-- Indeks untuk tabel `catatan_siswa`
--
ALTER TABLE `catatan_siswa`
  ADD PRIMARY KEY (`id_catatan`),
  ADD KEY `relation with class in feedback` (`c_id_kelas`),
  ADD KEY `relation with student in feedback` (`c_id_siswa`),
  ADD KEY `relation with teacher in feedback` (`c_id_guru`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `relation with section` (`j_id_seksi`),
  ADD KEY `relation with class` (`j_id_kelas`),
  ADD KEY `relation with teacher` (`j_id_guru`),
  ADD KEY `relation with period` (`j_id_sesi`),
  ADD KEY `relation with room` (`j_id_ruangan`),
  ADD KEY `relation with subject` (`j_mapel_id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `relation with section` (`nama_seksi`),
  ADD KEY `relation with teaacher in class` (`k_id_guru`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `relation with student in exam` (`n_id_siswa`),
  ADD KEY `relation with subject in exam` (`n_id_mapel`),
  ADD KEY `relation with class in exam` (`n_id_kelas`);

--
-- Indeks untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD PRIMARY KEY (`id_ortu`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `relation with class in notice` (`p_id_kelas`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD KEY `relation with class in room` (`r_id_kelas`);

--
-- Indeks untuk tabel `seksi`
--
ALTER TABLE `seksi`
  ADD PRIMARY KEY (`id_seksi`);

--
-- Indeks untuk tabel `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`id_sesi`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `relation with class in student` (`kelas_siswa`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `biaya`
--
ALTER TABLE `biaya`
  MODIFY `id_biaya` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `catatan_siswa`
--
ALTER TABLE `catatan_siswa`
  MODIFY `id_catatan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  MODIFY `id_ortu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `seksi`
--
ALTER TABLE `seksi`
  MODIFY `id_seksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `sesi`
--
ALTER TABLE `sesi`
  MODIFY `id_sesi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `relation with class in attendance` FOREIGN KEY (`a_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in attendance` FOREIGN KEY (`a_id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher in attendance` FOREIGN KEY (`a_id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `biaya`
--
ALTER TABLE `biaya`
  ADD CONSTRAINT `relation with class in fee` FOREIGN KEY (`b_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `catatan_siswa`
--
ALTER TABLE `catatan_siswa`
  ADD CONSTRAINT `relation with class in feedback` FOREIGN KEY (`c_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in feedback` FOREIGN KEY (`c_id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher in feedback` FOREIGN KEY (`c_id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `relation with class` FOREIGN KEY (`j_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with period` FOREIGN KEY (`j_id_sesi`) REFERENCES `sesi` (`id_sesi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with room` FOREIGN KEY (`j_id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with section` FOREIGN KEY (`j_id_seksi`) REFERENCES `seksi` (`id_seksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with subject` FOREIGN KEY (`j_mapel_id`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher` FOREIGN KEY (`j_id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `relation with teaacher in class` FOREIGN KEY (`k_id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `relation with class in exam` FOREIGN KEY (`n_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in exam` FOREIGN KEY (`n_id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with subject in exam` FOREIGN KEY (`n_id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `relation with class in notice` FOREIGN KEY (`p_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD CONSTRAINT `relation with class in room` FOREIGN KEY (`r_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `relation with class in student` FOREIGN KEY (`kelas_siswa`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
