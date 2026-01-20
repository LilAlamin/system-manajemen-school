-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2023 at 03:08 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sms_indo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `password_admin` varchar(200) NOT NULL,
  `telepon_admin` int(15) NOT NULL,
  `alamat_admin` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `email_admin`, `password_admin`, `telepon_admin`, `alamat_admin`, `created_at`) VALUES
(1, 'Admin', 'admin@email.com', 'admin', 12345, 'address admin', '2023-09-03 21:37:09');

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `a_id_guru` int(11) NOT NULL,
  `a_id_kelas` int(11) NOT NULL,
  `a_id_siswa` int(11) NOT NULL,
  `status_absensi` enum('Hadir','Alpha','Izin','Sakit') NOT NULL,
  `tanggal_absensi` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `a_id_guru`, `a_id_kelas`, `a_id_siswa`, `status_absensi`, `tanggal_absensi`) VALUES
(46, 2, 10, 1, 'Hadir', '2023-09-29 09:00:00'),
(47, 2, 10, 2, 'Alpha', '2023-10-10 00:00:00'),
(48, 2, 10, 7, 'Hadir', '2023-10-10 00:00:00'),
(49, 2, 9, 5, 'Alpha', '2023-10-10 00:00:00'),
(50, 2, 9, 12, 'Hadir', '2023-10-10 00:00:00'),
(51, 2, 10, 1, 'Hadir', '2023-09-30 00:00:00'),
(52, 2, 10, 2, 'Hadir', '2023-10-10 00:00:00'),
(53, 2, 10, 7, 'Hadir', '2023-10-10 00:00:00'),
(54, 2, 2, 4, 'Hadir', '2023-10-10 00:00:00'),
(55, 2, 5, 14, 'Alpha', '2023-10-10 00:00:00'),
(56, 2, 5, 15, 'Hadir', '2023-10-10 00:00:00'),
(57, 2, 5, 16, 'Hadir', '2023-10-10 00:00:00'),
(61, 7, 10, 1, 'Hadir', '2023-10-04 00:00:00'),
(62, 3, 10, 1, 'Hadir', '2023-10-06 00:00:00'),
(63, 2, 10, 1, 'Hadir', '2023-10-07 00:00:00'),
(64, 2, 10, 1, 'Hadir', '2023-10-08 00:00:00'),
(65, 2, 10, 1, 'Hadir', '2023-10-10 00:00:00'),
(66, 2, 10, 1, 'Hadir', '2023-11-16 00:00:00'),
(67, 2, 10, 2, 'Alpha', '2023-11-16 00:00:00'),
(68, 2, 10, 7, 'Izin', '2023-11-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `nama_mapel` varchar(300) NOT NULL,
  `nama_seksi` varchar(50) NOT NULL,
  `k_id_guru` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `nama_mapel`, `nama_seksi`, `k_id_guru`, `created_at`) VALUES
(1, '1', '1,5,6', '41,42,50', 2, '2023-09-17 23:16:41'),
(2, '2', '1,5,6', '41,42', 2, '2023-09-17 23:12:23'),
(3, '3', '1,5,6', '', 6, '2023-09-17 23:17:04'),
(5, '5', '1,5,6,14', '41', 7, '2023-09-17 23:19:25'),
(6, '6', '1,5,6,7,8,14', '', 2, '2023-09-17 23:19:45'),
(7, '7', '1,5,6,7,8,14', '', 6, '2023-09-17 23:19:53'),
(9, '9', '1,5,6,7,10,11,12,14', '', 4, '2023-09-17 23:21:03'),
(10, '10', '1,5,6,8,10,11,12,14', '', 3, '2023-09-17 23:20:43'),
(11, 'KG', '6,13,14', '', 4, '2023-09-17 23:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `id_kontak` int(11) NOT NULL,
  `nama_kontak` varchar(50) NOT NULL,
  `email_kontak` varchar(50) NOT NULL,
  `subjek_kontak` varchar(100) NOT NULL,
  `pesan_kontak` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `nama_nilai` varchar(50) NOT NULL,
  `tipe_nilai` enum('MID','UAS','Tugas','Ulangan') NOT NULL,
  `total_nilai` int(11) NOT NULL,
  `capaian_nilai` int(11) NOT NULL,
  `n_id_kelas` int(11) NOT NULL,
  `n_id_siswa` int(11) NOT NULL,
  `n_id_guru` int(11) NOT NULL,
  `n_id_mapel` int(11) NOT NULL,
  `nilai_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nilai`
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
(42, 'Final Term', 'UAS', 50, 40, 10, 2, 2, 8, '2023-11-17');

-- --------------------------------------------------------

--
-- Table structure for table `biaya`
--

CREATE TABLE `biaya` (
  `biaya_uang_sekolah` int(11) NOT NULL,
  `biaya_perpustakaan` int(11) NOT NULL,
  `biaya_olahraga` int(11) NOT NULL,
  `id_biaya` int(11) NOT NULL,
  `jumlah_biaya` int(12) NOT NULL,
  `bulan_biaya` int(2) NOT NULL,
  `jatuh_tempo_biaya` date NOT NULL,
  `akhir_biaya` date NOT NULL,
  `b_id_siswa` int(11) NOT NULL,
  `b_id_kelas` int(11) NOT NULL,
  `id_transaksi` varchar(50) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL DEFAULT '0',
  `tanggal_bayar` datetime NOT NULL DEFAULT current_timestamp(),
  `status_biaya` enum('Lunas','Belum Lunas','Proses') NOT NULL DEFAULT 'Belum Lunas',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `biaya`
--

INSERT INTO `biaya` (`biaya_uang_sekolah`, `biaya_perpustakaan`, `biaya_olahraga`, `id_biaya`, `jumlah_biaya`, `bulan_biaya`, `jatuh_tempo_biaya`, `akhir_biaya`, `b_id_siswa`, `b_id_kelas`, `id_transaksi`, `metode_pembayaran`, `tanggal_bayar`, `status_biaya`, `created_at`) VALUES
(3000, 1000, 1000, 12, 5000, 10, '2023-10-11', '2023-10-18', 4, 2, 'SPTAUHHV697AU4L3CDX6', '0', '2023-10-11 00:12:09', 'Belum Lunas', '2023-10-11 00:12:09'),
(2000, 500, 500, 13, 3000, 10, '2023-10-11', '2023-10-11', 1, 10, '9XV8JB4R344D0603GCWN', '1', '2023-11-16 11:51:26', 'Proses', '2023-10-11 00:13:21'),
(3000, 1000, 1000, 14, 5000, 9, '2023-10-11', '2023-09-27', 1, 10, '0GRIN4NLBZYQYL8AUWTC', '5', '2023-11-17 00:48:34', 'Proses', '2023-10-11 00:13:50'),
(4000, 500, 500, 15, 5000, 8, '2023-10-11', '2023-08-18', 1, 10, '6J1YOGFTSY3HA9ITK63J', '3', '2023-10-11 00:33:43', 'Lunas', '2023-10-11 00:14:19'),
(5000, 1000, 500, 19, 6500, 5, '2023-05-09', '2023-05-12', 1, 10, 'FROYAHQ4ZREMZRH3HZ0W', '2', '2023-10-11 00:32:38', 'Lunas', '2023-10-11 00:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `catatan_siswa`
--

CREATE TABLE `catatan_siswa` (
  `id_catatan` int(11) NOT NULL,
  `c_id_guru` int(11) NOT NULL,
  `c_id_kelas` int(11) NOT NULL,
  `c_id_siswa` int(11) NOT NULL,
  `catatan` varchar(500) NOT NULL,
  `status` enum('Positif','Negatif') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `catatan_siswa`
--

INSERT INTO `catatan_siswa` (`id_catatan`, `c_id_guru`, `c_id_kelas`, `c_id_siswa`, `catatan`, `status`, `created_at`) VALUES
(1, 2, 10, 1, 'Always comes late in Class', 'Negatif', '2023-09-12 21:35:49'),
(3, 2, 10, 2, ' Good Student', 'Positif', '2023-09-12 21:36:52'),
(4, 2, 10, 1, '  a good feedback for student is always refreshing and we always want that we should take a very good remarks from our teachers', 'Positif', '2023-09-12 21:51:53'),
(5, 2, 10, 1, '      always late and make noice in class', 'Negatif', '2023-09-12 22:30:34'),
(6, 2, 10, 2, '  late nhi hota', 'Positif', '2023-09-12 22:47:51'),
(7, 2, 10, 1, 'GoodDiscipline in Class', 'Positif', '2023-11-17 00:47:20'),
(8, 2, 10, 1, 'Comes late in class', 'Positif', '2023-11-17 00:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul_pengumuman` varchar(50) NOT NULL,
  `ket_pengumuman` varchar(300) NOT NULL,
  `p_id_kelas` int(11) DEFAULT NULL,
  `p_id_kirim` int(11) NOT NULL,
  `pengirim` varchar(50) NOT NULL,
  `tanggal_pengumuman` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengumuman`
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
(50, 'Holiday', 'Tomorrow is Holiday', NULL, 2555, 'Sir Atif Iqbal', '2023-11-17 00:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `orang_tua`
--

CREATE TABLE `orang_tua` (
  `id_ortu` int(11) NOT NULL,
  `nama_ortu` varchar(50) NOT NULL,
  `email_ortu` varchar(50) NOT NULL,
  `password_ortu` varchar(100) NOT NULL,
  `anak` varchar(50) NULL,
  `nik` varchar(20) NOT NULL,
  `foto_ortu` varchar(300) NOT NULL,
  `status_ortu` enum('Aktif','Disable') NOT NULL DEFAULT 'Aktif',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orang_tua`
--

INSERT INTO `orang_tua` (`id_ortu`, `nama_ortu`, `email_ortu`, `password_ortu`, `anak`, `nik`, `foto_ortu`, `status_ortu`, `created_at`) VALUES
(1, 'Rafaqat Ali Shahid', 'rafaqat@gmail.com', 'rafaqat', '1,2', '01234-1231231-1', '1694882950_rafaqat.jpg', 'Aktif', '2023-09-15 23:05:37'),
(2, 'Fayyaz Hussain', 'fayyaz@gmail.com', 'fayyaz', '6,13', '54321-7654321-8', '1694927114_fayyaz.jpg', 'Aktif', '2023-09-17 10:05:14');

-- --------------------------------------------------------

--
-- Table structure for table `sesi`
--

CREATE TABLE `sesi` (
  `id_sesi` int(11) NOT NULL,
  `nama_sesi` varchar(50) NOT NULL,
  `jam_mulai_sesi` time NOT NULL,
  `jam_berakhir_sesi` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sesi`
--

INSERT INTO `sesi` (`id_sesi`, `nama_sesi`, `jam_mulai_sesi`, `jam_berakhir_sesi`, `created_at`) VALUES
(2, 'First Period', '08:00:00', '08:45:00', '2023-09-13 21:17:17'),
(3, 'Second Period', '08:45:00', '09:30:00', '2023-09-13 21:17:53'),
(4, 'Third Period', '09:30:00', '10:15:00', '2023-09-13 21:23:28'),
(5, 'Lunch Break', '10:15:00', '10:45:00', '2023-09-13 21:27:56'),
(6, 'Fourth Period', '10:45:00', '11:30:00', '2023-09-13 21:28:32'),
(7, 'FifthPeriod', '11:30:00', '12:15:00', '2023-09-13 21:29:00'),
(8, 'Sixth Period', '12:15:00', '13:00:00', '2023-09-13 21:29:33');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL,
  `kapasitas_ruangan` int(5) NOT NULL,
  `r_id_kelas` int(11) NOT NULL,
  `r_id_seksi` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruangan`, `kapasitas_ruangan`, `r_id_kelas`, `r_id_seksi`, `created_at`) VALUES
(16, 'Room 1', 12, 11, 41, '2023-08-31 12:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `seksi`
--

CREATE TABLE `seksi` (
  `id_seksi` int(11) NOT NULL,
  `judul_seksi` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seksi`
--

INSERT INTO `seksi` (`id_seksi`, `judul_seksi`, `created_at`) VALUES
(0, NULL, '2023-08-30 17:48:28'),
(41, 'Section A', '2023-08-22 15:59:40'),
(42, 'Section B', '2023-08-22 15:59:49'),
(50, 'Section C', '2023-08-26 15:17:14'),
(53, 'Section D', '2023-11-17 00:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_sims` varchar(20) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `email_siswa` varchar(30) NOT NULL,
  `password_siswa` varchar(200) NOT NULL,
  `kelas_siswa` int(11) NOT NULL,
  `seksi_siswa` int(11) NOT NULL,
  `tanggal_lahir_siswa` date NOT NULL,
  `foto_siswa` varchar(300) NOT NULL,
  `telepon_siswa` varchar(30) NOT NULL,
  `alamat_siswa` varchar(200) NOT NULL,
  `umur_siswa` int(2) NOT NULL,
  `jekel_siswa` enum('Laki_Laki','Perempuan') NOT NULL,
  `status_siswa` enum('Aktif','Disable') NOT NULL DEFAULT 'Aktif',
  `tanggal_regis_siswa` datetime NOT NULL DEFAULT current_timestamp(),
  `nik_ortu` varchar(20) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_sims`, `nama_siswa`, `email_siswa`, `password_siswa`, `kelas_siswa`, `seksi_siswa`, `tanggal_lahir_siswa`, `foto_siswa`, `telepon_siswa`, `alamat_siswa`, `umur_siswa`, `jekel_siswa`, `status_siswa`, `tanggal_regis_siswa`, `nik_ortu`) VALUES
(1, '0001-SMS-10', 'Danish Ali', 'danish@gmail.com', 'danish', 10, 0, '2000-10-20', '1694343750_danish.jpg', '0300-1234567', 'Lahore ', 23, 'Laki_Laki', 'Aktif', '2023-08-31 11:53:49', '01234-1231231-1'),
(2, '0002-SMS-10', 'Haider Ali', 'haider@gmail.com', 'haider', 10, 0, '2023-08-03', '1694343717_haider.jpg', '12345', 'addr', 4, 'Laki_Laki', 'Aktif', '2023-08-31 11:54:52', '01234-1231231-1'),
(4, '0004-SMHS-02', 'Ahmad Baba', 'ahmad@gmail.com', 'ahmad', 2, 42, '2023-09-08', '1694343600_ahmed.jpg', '2313', 'address', 15, 'Laki_Laki', 'Aktif', '2023-09-10 16:00:00', '12121-1212121-1'),
(5, '0005-SMHS-09', 'Adil Iqbal', 'adil@gmail.com', 'adil', 9, 0, '2023-09-13', '1694343688_adil.jpg', '12241', 'adil addr', 19, 'Laki_Laki', 'Aktif', '2023-09-10 16:01:28', '54321-7654321-8'),
(6, '0006-SMHS-07', 'Salman Iqbal', 'salman@gmail.com', 'salman', 7, 50, '2023-09-20', '1694343845_salman.jpg', '1313', 'mani address', 17, 'Laki_Laki', 'Aktif', '2023-09-10 16:04:05', '54321-7654321-8'),
(7, '0007-SMHS-10', 'Aqib Ali', 'aqib@gmail.com', 'aqib', 10, 0, '2023-09-12', '1694343955_aqib.jpg', '123213', 'addr Aqib', 18, 'Laki_Laki', 'Aktif', '2023-09-10 16:05:55', '54321-7654321-8'),
(12, '0008-SMHS-09', 'Saqib Iqbal', 'saqib@gmail.com', 'saqib', 9, 0, '2023-09-05', '1694972656_saqib.jpg', '1234', 'address', 4, 'Laki_Laki', 'Aktif', '2023-09-17 22:44:16', '12121-1212121-1'),
(13, '0009-SMHS -07', 'Amir Majeed', 'amir@gmail.com', 'amir', 7, 0, '2023-09-17', '1694975559_amir.jpg', '12345', 'amir address', 19, 'Laki_Laki', 'Aktif', '2023-09-17 23:32:39', '54321-7654321-8'),
(14, '0010-SMHS -05', 'Javaid Ali', 'javaid@gmail.com', 'javaid', 5, 41, '2023-09-17', '1694975772_javaid.jpg', '12345', 'jadi address', 20, 'Laki_Laki', 'Aktif', '2023-09-17 23:36:12', '54321-7654321-8'),
(15, '0011-SMHS -05', 'Hafiz Hamza', 'hamza@gmail.com', 'hamza', 5, 0, '2023-09-17', '1694976281_hamza.jpg', '12345', 'hamza addr', 15, 'Laki_Laki', 'Aktif', '2023-09-17 23:44:41', '12121-1212121-1'),
(16, '0012-SMHS -05', 'Asim Ali', 'asim@gmail.com', 'asim', 5, 0, '2023-09-17', '1694976368_asim.jpg', '0', 'asim address', 12, 'Laki_Laki', 'Aktif', '2023-09-17 23:46:08', '12121-1212121-1');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `kode_mapel` varchar(20) NOT NULL,
  `nama_mapel` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mapel`
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
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `email_guru` varchar(100) NOT NULL,
  `password_guru` varchar(200) NOT NULL,
  `tanggal_lahir_guru` date NOT NULL,
  `foto_guru` varchar(300) NOT NULL,
  `mapel_guru` varchar(50) NOT NULL,
  `telepon_guru` varchar(30) NOT NULL,
  `alamat_guru` varchar(100) NOT NULL,
  `umur_guru` int(2) NOT NULL,
  `jekel_guru` enum('Laki_Laki','Perempuan') NOT NULL,
  `status_guru` enum('Aktif','Disable') NOT NULL DEFAULT 'Aktif',
  `tanggal_regis_guru` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `email_guru`, `password_guru`, `tanggal_lahir_guru`, `foto_guru`, `mapel_guru`, `telepon_guru`, `alamat_guru`, `umur_guru`, `jekel_guru`, `status_guru`, `tanggal_regis_guru`) VALUES
(2, 'Atif Iqbal', 'atif@gmail.com', 'atif', '1995-07-18', '1697107461_atif.jpg', '14', '0300-1234567', 'Lahore', 28, 'Laki_Laki', 'Aktif', '2023-08-29 16:30:55'),
(3, 'Sadaqat Ali', 'sadaqat@gmail.com', 'sadaqat', '2023-06-08', '1694973251_sadaqat.jpg', '14', '12345', 'adres', 35, 'Laki_Laki', 'Aktif', '2023-09-17 22:53:51'),
(4, 'Shahbaz Ali Shad', 'shahbaz@gmail.com', 'shahbaz', '2023-07-05', '1694973661_shahbaz.jpg', '9', '12345', 'address', 36, 'Laki_Laki', 'Aktif', '2023-09-17 23:01:01'),
(6, 'Tariq Ali', 'tariq@gmail.com', 'tariq', '2023-09-07', '1694973966_tariq.jpg', '10', '12345', 'addres', 35, 'Laki_Laki', 'Aktif', '2023-09-17 23:06:06'),
(7, 'Zahid Ali', 'zahid@gmail.com', 'zahid', '2023-09-15', '1694974157_zahid.jpg', '8', '12345', 'address', 40, 'Laki_Laki', 'Aktif', '2023-09-17 23:09:17');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `j_id_guru` int(5) NOT NULL,
  `j_id_kelas` int(5) NOT NULL,
  `j_id_seksi` int(5) DEFAULT NULL,
  `j_id_sesi` int(5) NOT NULL,
  `j_mapel_id` int(5) NOT NULL,
  `j_id_ruangan` int(5) NOT NULL,
  `hari_jadwal` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `j_id_guru`, `j_id_kelas`, `j_id_seksi`, `j_id_sesi`, `j_mapel_id`, `j_id_ruangan`, `hari_jadwal`, `created_at`) VALUES
(18, 2, 11, 41, 8, 5, 16, 'Kamis', '2023-09-13 22:25:30'),
(19, 2, 11, 41, 4, 11, 16, 'Senin', '2023-09-13 22:25:11'),
(20, 2, 11, 41, 2, 11, 16, 'Jumat', '2023-09-05 12:11:54'),
(22, 2, 1, 0, 3, 10, 16, 'Sabtu', '2023-09-13 22:37:39'),
(23, 2, 1, 0, 4, 11, 16, 'Rabu', '2023-09-17 15:55:55'),
(24, 6, 5, 41, 2, 11, 16, 'Selasa', '2023-11-16 11:48:50'),
(25, 3, 3, 0, 2, 9, 16, 'Kamis', '2023-11-17 00:44:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `relation with class in attendance` (`a_id_kelas`),
  ADD KEY `relation with student in attendance` (`a_id_siswa`),
  ADD KEY `relation with teacher in attendance` (`a_id_guru`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `relation with section` (`nama_seksi`),
  ADD KEY `relation with teaacher in class` (`k_id_guru`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `relation with student in exam` (`n_id_siswa`),
  ADD KEY `relation with subject in exam` (`n_id_mapel`),
  ADD KEY `relation with class in exam` (`n_id_kelas`);

--
-- Indexes for table `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`id_biaya`),
  ADD KEY `relation with student in fee` (`b_id_siswa`),
  ADD KEY `relation with class in fee` (`b_id_kelas`);

--
-- Indexes for table `catatan_siswa`
--
ALTER TABLE `catatan_siswa`
  ADD PRIMARY KEY (`id_catatan`),
  ADD KEY `relation with class in feedback` (`c_id_kelas`),
  ADD KEY `relation with student in feedback` (`c_id_siswa`),
  ADD KEY `relation with teacher in feedback` (`c_id_guru`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `relation with class in notice` (`p_id_kelas`);

--
-- Indexes for table `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD PRIMARY KEY (`id_ortu`);

--
-- Indexes for table `sesi`
--
ALTER TABLE `sesi`
  ADD PRIMARY KEY (`id_sesi`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD KEY `relation with class in room` (`r_id_kelas`);

--
-- Indexes for table `seksi`
--
ALTER TABLE `seksi`
  ADD PRIMARY KEY (`id_seksi`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `relation with class in student` (`kelas_siswa`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `jadwal`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id_kontak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `biaya`
--
ALTER TABLE `biaya`
  MODIFY `id_biaya` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `catatan_siswa`
--
ALTER TABLE `catatan_siswa`
  MODIFY `id_catatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `orang_tua`
--
ALTER TABLE `orang_tua`
  MODIFY `id_ortu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sesi`
--
ALTER TABLE `sesi`
  MODIFY `id_sesi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `seksi`
--
ALTER TABLE `seksi`
  MODIFY `id_seksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `relation with class in attendance` FOREIGN KEY (`a_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in attendance` FOREIGN KEY (`a_id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher in attendance` FOREIGN KEY (`a_id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `relation with teaacher in class` FOREIGN KEY (`k_id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `relation with class in exam` FOREIGN KEY (`n_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in exam` FOREIGN KEY (`n_id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with subject in exam` FOREIGN KEY (`n_id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `biaya`
--
ALTER TABLE `biaya`
  ADD CONSTRAINT `relation with class in fee` FOREIGN KEY (`b_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `catatan_siswa`
--
ALTER TABLE `catatan_siswa`
  ADD CONSTRAINT `relation with class in feedback` FOREIGN KEY (`c_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with student in feedback` FOREIGN KEY (`c_id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher in feedback` FOREIGN KEY (`c_id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `relation with class in notice` FOREIGN KEY (`p_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD CONSTRAINT `relation with class in room` FOREIGN KEY (`r_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `relation with class in student` FOREIGN KEY (`kelas_siswa`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `relation with class` FOREIGN KEY (`j_id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with period` FOREIGN KEY (`j_id_sesi`) REFERENCES `sesi` (`id_sesi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with room` FOREIGN KEY (`j_id_ruangan`) REFERENCES `ruangan` (`id_ruangan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with section` FOREIGN KEY (`j_id_seksi`) REFERENCES `seksi` (`id_seksi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with subject` FOREIGN KEY (`j_mapel_id`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `relation with teacher` FOREIGN KEY (`j_id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
