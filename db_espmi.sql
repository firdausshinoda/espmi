-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2020 at 03:10 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_espmi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_tb_admin` int(10) NOT NULL,
  `nipy` varchar(20) DEFAULT NULL,
  `nama_admin` varchar(30) DEFAULT NULL,
  `password` varchar(42) DEFAULT NULL,
  `id_tb_unit` int(10) DEFAULT NULL,
  `jenis_unit` enum('PENGENDALI','UNIT BIASA') DEFAULT NULL,
  `jenis_admin` enum('SUPERADMIN','ADMIN','','') DEFAULT 'ADMIN',
  `foto_admin` varchar(20) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_tb_admin`, `nipy`, `nama_admin`, `password`, `id_tb_unit`, `jenis_unit`, `jenis_admin`, `foto_admin`, `cdate`, `mdate`, `ddate`, `del_flage`) VALUES
(1, '1.1.1.1', 'p2m (1)', 'e10adc3949ba59abbe56e057f20f883e', 11, 'PENGENDALI', 'SUPERADMIN', '20200603211139.png', '2020-04-27 00:13:53', '2020-06-03 21:14:51', NULL, 1),
(2, '2.2.2.2', 'wadir2', 'e10adc3949ba59abbe56e057f20f883e', 6, 'PENGENDALI', 'ADMIN', '20200509202332.png', '2020-04-27 00:32:39', '2020-05-09 20:23:32', NULL, 1),
(3, '3.3.3.3', 'bakeu', 'e10adc3949ba59abbe56e057f20f883e', 8, 'UNIT BIASA', 'ADMIN', '20200603212655.png', '2020-04-27 00:32:39', '2020-06-03 22:14:32', NULL, 1),
(4, '4.4.4.4', 'baa', 'e10adc3949ba59abbe56e057f20f883e', 9, 'PENGENDALI', 'ADMIN', NULL, '2020-04-27 00:32:39', '2020-04-27 00:33:29', NULL, 1),
(5, '5.5.5.5', 'p3m', 'e10adc3949ba59abbe56e057f20f883e', 12, 'PENGENDALI', 'ADMIN', NULL, '2020-06-03 11:25:27', '2020-06-03 11:26:40', '2020-06-03 11:31:01', 1),
(6, '7.7.7.7', 'humas', 'e10adc3949ba59abbe56e057f20f883e', 14, 'PENGENDALI', 'ADMIN', NULL, '2020-06-25 09:42:44', NULL, NULL, 1),
(7, '8.8.8.8', 'p2m (2)', 'e10adc3949ba59abbe56e057f20f883e', 11, 'PENGENDALI', 'SUPERADMIN', NULL, '2020-06-25 09:47:47', '2020-06-25 09:53:54', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumen`
--

CREATE TABLE `tb_dokumen` (
  `id_tb_dokumen` int(11) NOT NULL,
  `id_tb_admin` int(10) DEFAULT NULL,
  `id_tb_dokumen_kode` int(10) DEFAULT NULL,
  `id_tb_unit` int(10) DEFAULT NULL,
  `id_tb_jenis_dokumen` int(10) DEFAULT NULL,
  `nama_dokumen` varchar(50) DEFAULT NULL,
  `deskripsi_dokumen` mediumtext,
  `file` varchar(20) DEFAULT NULL,
  `file_nama` varchar(50) DEFAULT NULL,
  `file_size` varchar(10) DEFAULT NULL,
  `bln_dokumen` varchar(10) DEFAULT NULL,
  `thn_dokumen` int(2) DEFAULT NULL,
  `revisi` int(11) DEFAULT '0',
  `jml_halaman` int(11) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumen_kode`
--

CREATE TABLE `tb_dokumen_kode` (
  `id_tb_dokumen_kode` int(10) NOT NULL,
  `id_tb_jenis_dokumen` int(10) DEFAULT NULL,
  `nomor_dokumen` varchar(50) DEFAULT NULL,
  `perihal_dokumen` mediumtext,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_dokumen_kode`
--

INSERT INTO `tb_dokumen_kode` (`id_tb_dokumen_kode`, `id_tb_jenis_dokumen`, `nomor_dokumen`, `perihal_dokumen`, `cdate`, `mdate`, `ddate`, `del_flage`) VALUES
(1, 1, 'SA.P2M.PHB.01', 'Standar SPMI Kompetensi Kelulusan', '2020-04-20 20:12:22', NULL, NULL, 1),
(2, 1, 'SA.P2M.PHB.02', 'Standar Isi Pembelajaran', '2020-04-20 20:14:50', NULL, NULL, 1),
(3, 1, 'SA.P2M.PHB.03', 'Standar Proses Pembelajaran', '2020-04-20 20:12:22', NULL, NULL, 1),
(4, 1, 'SA.P2M.PHB.04', 'Standar Penilaian Pembelajaran', '2020-04-20 20:14:50', NULL, NULL, 1),
(5, 1, 'SA.P2M.PHB.05', 'Standar Dosen dan Tenaga Pendidikan', '2020-04-20 20:12:22', NULL, NULL, 1),
(6, 1, 'SA.P2M.PHB.05a', 'Standar Pengelolaan Sumber Daya Manusia', '2020-04-20 20:14:50', NULL, NULL, 1),
(7, 1, 'SA.P2M.PHB.06', 'Standar Sarana dan Prasarana Pembelajaran', '2020-04-20 20:12:22', NULL, NULL, 1),
(8, 1, 'SA.P2M.PHB.07', 'Standar Pengelolaan Pembelajaran', '2020-04-20 20:14:50', NULL, NULL, 1),
(9, 1, 'SA.P2M.PHB.07c', 'Standar Pembimbing dan Penguji Tugas Akhir', '2020-04-20 20:12:22', NULL, NULL, 1),
(10, 1, 'SA.P2M.PHB.08', 'Standar Pembiayaan Pembelajaran', '2020-04-20 20:14:50', NULL, NULL, 1),
(11, 1, 'SA.P2M.PHB.09', 'Standar Hasil Penelitian', '2020-04-20 20:12:22', NULL, NULL, 1),
(12, 1, 'SA.P2M.PHB.10', 'Standar Isi Penelitian', '2020-04-20 20:14:50', NULL, NULL, 1),
(13, 1, 'SA.P2M.PHB.11', 'Standar Proses Penelitian', '2020-04-20 20:12:22', NULL, NULL, 1),
(14, 1, 'SA.P2M.PHB.12', 'Standar Penilaian Penelitian', '2020-04-20 20:14:50', NULL, NULL, 1),
(15, 1, 'SA.P2M.PHB.13', 'Standar Peneliti', '2020-04-20 20:12:22', NULL, NULL, 1),
(16, 1, 'SA.P2M.PHB.14', 'Standar Sarana dan Sarana Penelitian', '2020-04-20 20:14:50', NULL, NULL, 1),
(17, 1, 'SA.P2M.PHB.16', 'Standar Pendanaan dan Pembiayaan Penelitian', '2020-04-20 20:12:22', NULL, NULL, 1),
(18, 1, 'SA.P2M.PHB.17', 'Standar Hasil Pengabdian Masyarakat', '2020-04-20 20:14:50', NULL, NULL, 1),
(19, 1, 'SA.P2M.PHB.18', 'Standar Isi Pengabdian Masyarakat', '2020-04-20 20:12:22', NULL, NULL, 1),
(20, 1, 'SA.P2M.PHB.19', 'Standar Proses Pengabdian Masyarakat', '2020-04-20 20:14:50', NULL, NULL, 1),
(21, 1, 'SA.P2M.PHB.20', 'Standar Penilaian Pengabdian Masyarakat', '2020-04-20 20:12:22', NULL, NULL, 1),
(22, 1, 'SA.P2M.PHB.21', 'Standar Pelaksanaan Pengabdian Masyarakat', '2020-04-20 20:14:50', NULL, NULL, 1),
(23, 1, 'SA.P2M.PHB.22', 'Standar Sarana dan Prasarana Pengabdian Masyarakat', '2020-04-20 20:12:22', NULL, NULL, 1),
(24, 1, 'SA.P2M.PHB.23', 'Standar Pengelolaan Pengabdian Masyarakat', '2020-04-20 20:14:50', NULL, NULL, 1),
(25, 1, 'SA.P2M.PHB.24', 'Standar Pendanaan dan Pembiayaan Pengabdian Masyarakat', '2020-04-20 20:12:22', NULL, NULL, 1),
(26, 1, 'SA.P2M.PHB.25', 'Standar Kerja Sama', '2020-04-20 20:14:50', '2020-06-03 20:44:24', '2020-04-20 22:41:40', 1),
(27, 3, 'PM.LPM.PHB.02.01.A.1', 'Prosedur Mutu Penyusunan Kurikulum', '2020-04-21 00:30:36', NULL, NULL, 1),
(28, 3, 'PM.LPM.PHB.02.01.A.2', 'Prosedur Mutu Peninjauan Kurikulum', '2020-04-21 00:30:36', NULL, NULL, 1),
(29, 3, 'PM.LPM.PHB.02.02.A', 'Prosedur Mutu Perencanaan Proses Pembelajaran', '2020-04-21 00:30:36', NULL, NULL, 1),
(30, 3, 'PM.LPM.PHB.02.02.B', 'Prosedur Mutu Pelaksanaan Proses Pembelajaran', '2020-04-21 00:30:36', NULL, NULL, 1),
(31, 3, 'PM.LPM.PHB.02.02.C', 'Prosedur Mutu Evaluasi/Penilaian Proses Pembelajaran', '2020-04-21 00:30:36', NULL, NULL, 1),
(32, 3, 'PM.LPM.PHB.02.02.D', 'Prosedur Mutu Pengawasan Proses Pembelajaran', '2020-04-21 00:30:36', NULL, NULL, 1),
(33, 3, 'PM.LPM.PHB.02.03.B.2', 'PM Penerimaan Mahasiswa Baru (PMB)', '2020-04-21 00:30:36', NULL, NULL, 1),
(34, 3, 'PM.LPM.PHB.02.06.A', 'Prosedur Pengajuan Visi, Misi dan Tujuan', '2020-04-21 00:30:36', NULL, NULL, 1),
(35, 3, 'PM.LPM.PHB.02.06.A', 'Prosedur Mutu Peninjauan VIsi, Misi, Renstra dan Renop', '2020-04-21 00:30:36', NULL, NULL, 1),
(36, 3, 'PM.P2M.PHB.02.10.A.1', 'PM Proses Pelaporan Hasil Pengabdian', '2020-04-21 00:30:36', NULL, NULL, 1),
(37, 3, 'PM.P2M.PHB.02.10.A.2', 'PM Tindak Lanjut Hasil Pengabdian Masyarakat', '2020-04-21 00:30:36', NULL, NULL, 1),
(38, 3, 'PM.P2M.PHB.02.10.A.3', 'PM Penyelenggaraan Kegiatan Seminar atau Pameran Hasil PPM', '2020-04-21 00:30:36', NULL, NULL, 1),
(39, 3, 'PM.P2M.PHB.02.10.C.1', 'Kontrak Pelaksanaan Pengabdian Masyarakat', '2020-04-21 00:30:36', NULL, NULL, 1),
(40, 3, 'PM.P2M.PHB.02.10.C.2', 'Seminar Proposal Pengabdian Masyarakat', '2020-04-21 00:30:36', NULL, NULL, 1),
(41, 3, 'PM.LPM.PHB.02.10.', 'PM Kerjasama', '2020-04-21 00:30:36', NULL, NULL, 1),
(42, 3, 'PM.P2M.PHB.02.06.G.2.c.11', 'PM Pengajuan Cuti Studi dan Pengaktifan Kembali', '2020-04-21 00:30:36', '2020-04-21 00:50:20', '2020-04-21 00:50:28', 1),
(43, 7, 'PM.LPM.PHB.02.02.A.1', 'Daftar Hadir Rapat Koordinasi DIII . . .  Tahun Akademik . . . . / . . . .', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(44, 7, 'PM.LPM.PHB.02.02.C.5.6', 'Evaluasi Mahasiswa Terhadap Penyelenggaraan Perkuliahan Program Studi DIII ... Tahun Akademik ... / ... Politeknik Harapan Bersama', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(45, 7, 'PM.LPM.PHB.02.02.C.5.7', 'Evaluasi Dosen Terhadap Penyelenggaraan Perkuliahan Program Studi DIII ... Tahun Akademik ... / ... Poliktenik Harapan Bersama', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(46, 7, 'PM.LPM.PHB.02.02.C.5.8', 'Evaluasi Alumni Terhadap Penyelenggaraan Perkuliahan Program Studi DIII ... Tahun Akademik ... / ...', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(47, 7, 'PM.LPM.PHB.02.02.C.5.9', 'Evaluasi Keputusan Tenaga Kependidikan, Pustakawan, Laboran, Teknisi Terhadap Pengelolaan Sumber Daya Manusia', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(48, 7, 'PM.LPM.PHB.02.02.C.5.10', 'Evaluasi Keputusan Tenaga Pendidikan/Dosen Terhadap Pengelolaan Sumber Daya Manusia', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(49, 7, 'SA.P2M.PHB.03.02.C.14.d', 'Format Evaluasi Terhadap Pembimbingan Tugas Akhir (TA)/Karya Tulis Ilmiyah (KTI)', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(50, 7, 'PM.P2M.PHB.02.02.C.5.11', 'Formulir Supervisi Kegiatan Praktek Lapangan/Magang', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(51, 7, 'PM.P2M.PHB.02.03.A.1.a', 'Form Kuesioner Tracer Studi Politeknik Harapan Bersama', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(52, 7, 'PM.P2M.PHB.02.03.A.2', 'Formulir Survei Kompetensi Lulusan Politeknik Harapan Bersama', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(53, 7, 'PM.LPM.PHB.02.04.A.8.a.1', 'Formulir Sasaran Kerja Pegawai', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(54, 7, 'PM.LPM.PHB.02.04.A', 'Formulir Penilaian Kinerja Akademik Dosen/Bebean Kerja Dosen (BKD)', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(55, 7, 'PM.LPM.PHB.02.04.A.8.a.2 Refisi 1', 'Formulir Penilaian Sasaran Kerja Pegawai (SKP)', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(56, 7, 'PM.LPM.PHB.02.06.1.c.2', 'Surat Pernyataan Dosen Tetap', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(57, 7, 'PM.LPM.PHB.02.06.1.c.2', 'Surat Pernyataan Dosen Tidak Tetap', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(58, 7, 'PM.P2M.PHB.02.04.A.8.a.2', 'Form Sasaran Kerja Pegawai', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(59, 7, 'SA.P2M.PHB.03.05.B.4', 'Form Peminjaman Alat Laboratorium', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(60, 7, 'SA.P2M.PHB.02.06.A.1.A', 'Lembar Survei Pemahaman Civitas Akademik dan Karyawan Mengenai Visi dan Misi', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(61, 7, 'PM.LPM.PHB.02.06.C.1', 'Daftar Penilaian Pelaksanaan Pekerjaan (DP3) Karyawan dan Dosen Politeknik Harapan Bersama', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(62, 7, 'PM.P2M.PHB.02.06.C.1 Revisi 1', 'Formulir Penilaian Kinerja Pegawai', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(63, 7, 'PM.P2M.PHB.02.06.C.2', 'Formulir Penilaian Kinerja Dosen', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(64, 7, 'PM.LPM.PHB.02.06.G.2.1', 'Formulir Pengajuan Cuti', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(65, 7, 'PM.LPM.PHB.02.06.G.2.1', 'Formulir Pengajuan Cuti Studi', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(66, 7, 'PM.LPM.PHB.02.06.G.2.3', 'Formulir Pengajuan Aktif Studi', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(67, 7, 'PM.LPM.PHB.02.06.H.3.1', 'Formulir Revisi Dokumen', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(68, 7, 'PM.P2M.PHB.02.06.H.3.b', 'Formulir Pengaduan/Kasus Temuan', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(69, 7, 'PM.LPM.PHB.02.06.1.3', 'Surat Ijin/Berhalangan Hadir', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(70, 7, 'PM.LPM.PHB.02.09.A.2', 'Form Saran Kelayakan Proposal Penelitian', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(71, 7, 'PM.LPM.PHB.02.09.A.2', 'Form Saran Perbaikan Laporan Penelitian', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(72, 7, 'PM.P2M.PHB.02.09.A.3', 'Form Penliaian Proposal Penelitian', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(73, 7, 'PM.LPM.PHB.02.09.9.3', 'Form Prosedur Mutu Penelitian dan Pengabdian Masyarakat Tahun Akademik ... /...', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(74, 7, 'PM.P2M.PHB.02.09.B.2', 'Form Penilaian Proposal Pengabdian Masyarakat', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(75, 7, 'PM.P2M.PHB.02.09.C.3', 'Hasil Validasi Karya Ilmiah', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(76, 8, 'PM.P2M.PHB.02.09.C.3', 'Hasil Validasi Karya Ilmiah', '2020-04-21 00:54:33', '2020-04-21 00:55:35', NULL, 1),
(90, 2, '0.120.12d', 'eafefe', '2020-07-02 22:31:09', NULL, NULL, 1),
(91, 4, 'a.12.a12.121sa', 'dsssdsddds', '2020-07-02 22:36:55', NULL, NULL, 1),
(92, 5, '31.asa.12.asa.s', 'Dokumen Manual Mutu Pengendalian', '2020-07-02 22:38:18', NULL, NULL, 1),
(93, 6, '113a.as1.a1', 'Dokumen Manual Mutu Peningkatan', '2020-07-02 22:39:52', NULL, NULL, 1),
(94, 9, 'umum.012.1', 'Dokumen Institusi Umum', '2020-07-02 22:51:44', NULL, NULL, 1),
(95, 9, '0.12u.01w8', 'aasasasasas', '2020-07-03 01:36:39', '2020-07-30 02:07:38', '2020-07-03 01:37:20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumen_unit_terkait`
--

CREATE TABLE `tb_dokumen_unit_terkait` (
  `id_tb_dokumen_unit_terkait` int(10) NOT NULL,
  `id_tb_dokumen` int(10) DEFAULT NULL,
  `id_tb_unit` int(10) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_dokumen`
--

CREATE TABLE `tb_jenis_dokumen` (
  `id_tb_jenis_dokumen` int(10) NOT NULL,
  `jenis_dokumen` varchar(50) DEFAULT NULL,
  `keterangan` mediumtext,
  `tipe_dokumen` enum('STANDAR SPMI','MANUAL MUTU','FORMULIR','KEBIJAKAN','DOKUMEN INSTITUSI') DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jenis_dokumen`
--

INSERT INTO `tb_jenis_dokumen` (`id_tb_jenis_dokumen`, `jenis_dokumen`, `keterangan`, `tipe_dokumen`, `cdate`, `mdate`, `ddate`, `del_flage`) VALUES
(1, 'Standar SPMI', NULL, 'STANDAR SPMI', '2020-07-01 00:00:00', NULL, NULL, 1),
(2, 'Manual Mutu Penetapan', NULL, 'MANUAL MUTU', '2020-07-01 00:00:00', NULL, NULL, 1),
(3, 'Manual Mutu Pelaksanaan', NULL, 'MANUAL MUTU', '2020-07-01 00:00:00', NULL, NULL, 1),
(4, 'Manual Mutu Evaluasi', NULL, 'MANUAL MUTU', '2020-07-01 00:00:00', NULL, NULL, 1),
(5, 'Manual Mutu Pengendalian', NULL, 'MANUAL MUTU', '2020-07-01 00:00:00', NULL, NULL, 1),
(6, 'Manual Mutu Peningkatan', NULL, 'MANUAL MUTU', '2020-07-01 00:00:00', NULL, NULL, 1),
(7, 'Formulir', NULL, 'FORMULIR', '2020-07-01 00:00:00', NULL, NULL, 1),
(8, 'Kebijakan', NULL, 'KEBIJAKAN', '2020-07-01 00:00:00', NULL, NULL, 1),
(9, 'Umum', NULL, 'DOKUMEN INSTITUSI', '2020-07-01 00:00:00', NULL, NULL, 1),
(10, 'SK 1', 'Dokumen SK', 'DOKUMEN INSTITUSI', '2020-07-03 01:08:23', '2020-07-03 01:15:32', '2020-07-03 01:14:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_konsultasi`
--

CREATE TABLE `tb_konsultasi` (
  `id_tb_konsultasi` int(11) NOT NULL,
  `id_tb_admin` int(10) DEFAULT NULL,
  `id_tb_dokumen_kode` int(10) DEFAULT NULL,
  `id_tb_unit` int(10) DEFAULT NULL,
  `id_tb_jenis_dokumen` int(10) DEFAULT NULL,
  `nama_dokumen` varchar(50) DEFAULT NULL,
  `deskripsi_dokumen` mediumtext,
  `file` varchar(20) DEFAULT NULL,
  `file_nama` mediumtext,
  `file_size` varchar(10) DEFAULT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `bln_dokumen` varchar(10) DEFAULT NULL,
  `thn_dokumen` int(2) DEFAULT NULL,
  `revisi` int(11) DEFAULT '0',
  `jml_halaman` int(11) DEFAULT NULL,
  `stt_dokumen` enum('MENUNGGU','PUBLIS') DEFAULT 'MENUNGGU',
  `stt_upload_revisi` int(1) DEFAULT '0',
  `publis_date` datetime DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_konsultasi_revisi_admin`
--

CREATE TABLE `tb_konsultasi_revisi_admin` (
  `id_tb_konsultasi_revisi_admin` int(10) NOT NULL,
  `id_tb_konsultasi` int(10) DEFAULT NULL,
  `id_tb_admin` int(10) DEFAULT NULL,
  `keterangan` longtext,
  `unit_terkait` mediumtext,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_konsultasi_revisi_unit`
--

CREATE TABLE `tb_konsultasi_revisi_unit` (
  `id_tb_konsultasi_revisi_unit` int(10) NOT NULL,
  `id_tb_konsultasi_unit_terkait` int(10) DEFAULT NULL,
  `id_tb_admin` int(10) DEFAULT NULL,
  `keterangan` longtext,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(10) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_konsultasi_unit_terkait`
--

CREATE TABLE `tb_konsultasi_unit_terkait` (
  `id_tb_konsultasi_unit_terkait` int(10) NOT NULL,
  `id_tb_konsultasi` int(10) DEFAULT NULL,
  `id_tb_unit` int(10) DEFAULT NULL,
  `stt_revisi_unit` enum('MENUNGGU','REVISI','ACC') DEFAULT 'MENUNGGU',
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit`
--

CREATE TABLE `tb_unit` (
  `id_tb_unit` int(10) NOT NULL,
  `nama_unit` varchar(50) DEFAULT NULL,
  `keterangan` mediumtext,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_unit`
--

INSERT INTO `tb_unit` (`id_tb_unit`, `nama_unit`, `keterangan`, `cdate`, `mdate`, `ddate`, `del_flage`) VALUES
(1, 'Operator/Frontliner/PMB', '', '2020-04-21 13:46:57', '2020-04-21 13:55:37', NULL, 1),
(2, 'Pembina', '', '2020-04-26 23:28:13', NULL, NULL, 1),
(3, 'Yayasan', '', '2020-04-26 23:28:22', NULL, NULL, 1),
(4, 'Direktur', '', '2020-04-26 23:28:30', NULL, NULL, 1),
(5, 'Wadir 1', '', '2020-04-26 23:28:37', NULL, NULL, 1),
(6, 'Wadir 2', '', '2020-04-26 23:28:44', NULL, NULL, 1),
(7, 'Wadir 3', '', '2020-04-26 23:28:51', NULL, NULL, 1),
(8, 'BAKEU', '', '2020-04-26 23:28:59', NULL, NULL, 1),
(9, 'BAA', '', '2020-04-26 23:29:07', NULL, NULL, 1),
(10, 'BAU', '', '2020-04-26 23:29:18', NULL, NULL, 1),
(11, 'P2M', '', '2020-04-26 23:29:27', NULL, NULL, 1),
(12, 'P3M', '', '2020-04-26 23:29:33', NULL, NULL, 1),
(13, 'Kepegawaian', NULL, NULL, NULL, NULL, 1),
(14, 'Humas', NULL, NULL, NULL, NULL, 1),
(15, 'Sistem Informasi/IT Gebung A dan B', NULL, NULL, NULL, NULL, 1),
(16, 'Perpustakaan', NULL, NULL, NULL, NULL, 1),
(17, 'Sektretaris PMB', NULL, NULL, NULL, NULL, 1),
(18, 'Logistik', NULL, NULL, NULL, NULL, 1),
(19, 'Pos Security', NULL, NULL, NULL, NULL, 1),
(20, 'IT Gebung D', NULL, NULL, NULL, NULL, 1),
(21, 'BKK', NULL, NULL, NULL, NULL, 1),
(22, 'IT Lab. Komputer', NULL, NULL, NULL, NULL, 1),
(23, 'Koperasi', NULL, NULL, NULL, NULL, 1),
(24, 'Kemahasiswaan dan Alumni', NULL, NULL, NULL, NULL, 1),
(25, 'Ka. UPT Sistem Informasi', NULL, NULL, NULL, NULL, 1),
(26, 'Klinik Pratama PHB', NULL, NULL, NULL, NULL, 1),
(27, 'Bagian Kerjasama', NULL, NULL, NULL, NULL, 1),
(28, 'Koordinator Keamanan', NULL, NULL, NULL, NULL, 1),
(29, 'D3 Komputer - Ka. Prodi', NULL, NULL, NULL, NULL, 1),
(30, 'D3 Komputer - TU', NULL, NULL, NULL, NULL, 1),
(31, 'D3 Komputer - Lab. Hardware', NULL, NULL, NULL, NULL, 1),
(32, 'D4 Informatika - Ka. Prodi', NULL, NULL, NULL, NULL, 1),
(33, 'D4 Informatika - TU', NULL, NULL, NULL, NULL, 1),
(34, 'D3 Akuntansi -Ka. Prodi', NULL, NULL, NULL, NULL, 1),
(35, 'D3 Akuntansi - TU', NULL, NULL, NULL, NULL, 1),
(36, 'D3 Farmasi - Ka. Prodi', NULL, NULL, NULL, NULL, 1),
(37, 'D3 Farmasi - TU', NULL, NULL, NULL, NULL, 1),
(38, 'D3 Farmasi - Lab', NULL, NULL, NULL, NULL, 1),
(39, 'D3 Kebidanan - Ka. Prodi', NULL, NULL, NULL, NULL, 1),
(40, 'D3 Kebidanan - TU', NULL, NULL, NULL, NULL, 1),
(41, 'D3 Kebidanan - Lab', NULL, NULL, NULL, NULL, 1),
(42, 'D3 Perhotelan - Ka. Prodi', '', NULL, '2020-06-03 20:53:12', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_tb_user` int(10) NOT NULL,
  `nipy` varchar(20) DEFAULT NULL,
  `nama_user` varchar(30) DEFAULT NULL,
  `password` varchar(42) DEFAULT NULL,
  `foto_user` varchar(20) DEFAULT NULL,
  `cdate` datetime DEFAULT NULL,
  `mdate` datetime DEFAULT NULL,
  `ddate` datetime DEFAULT NULL,
  `del_flage` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_tb_admin`);

--
-- Indexes for table `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  ADD PRIMARY KEY (`id_tb_dokumen`);

--
-- Indexes for table `tb_dokumen_kode`
--
ALTER TABLE `tb_dokumen_kode`
  ADD PRIMARY KEY (`id_tb_dokumen_kode`);

--
-- Indexes for table `tb_dokumen_unit_terkait`
--
ALTER TABLE `tb_dokumen_unit_terkait`
  ADD PRIMARY KEY (`id_tb_dokumen_unit_terkait`);

--
-- Indexes for table `tb_jenis_dokumen`
--
ALTER TABLE `tb_jenis_dokumen`
  ADD PRIMARY KEY (`id_tb_jenis_dokumen`);

--
-- Indexes for table `tb_konsultasi`
--
ALTER TABLE `tb_konsultasi`
  ADD PRIMARY KEY (`id_tb_konsultasi`);

--
-- Indexes for table `tb_konsultasi_revisi_admin`
--
ALTER TABLE `tb_konsultasi_revisi_admin`
  ADD PRIMARY KEY (`id_tb_konsultasi_revisi_admin`);

--
-- Indexes for table `tb_konsultasi_revisi_unit`
--
ALTER TABLE `tb_konsultasi_revisi_unit`
  ADD PRIMARY KEY (`id_tb_konsultasi_revisi_unit`);

--
-- Indexes for table `tb_konsultasi_unit_terkait`
--
ALTER TABLE `tb_konsultasi_unit_terkait`
  ADD PRIMARY KEY (`id_tb_konsultasi_unit_terkait`);

--
-- Indexes for table `tb_unit`
--
ALTER TABLE `tb_unit`
  ADD PRIMARY KEY (`id_tb_unit`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_tb_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_tb_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_dokumen`
--
ALTER TABLE `tb_dokumen`
  MODIFY `id_tb_dokumen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_dokumen_kode`
--
ALTER TABLE `tb_dokumen_kode`
  MODIFY `id_tb_dokumen_kode` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tb_dokumen_unit_terkait`
--
ALTER TABLE `tb_dokumen_unit_terkait`
  MODIFY `id_tb_dokumen_unit_terkait` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jenis_dokumen`
--
ALTER TABLE `tb_jenis_dokumen`
  MODIFY `id_tb_jenis_dokumen` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_konsultasi`
--
ALTER TABLE `tb_konsultasi`
  MODIFY `id_tb_konsultasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_konsultasi_revisi_admin`
--
ALTER TABLE `tb_konsultasi_revisi_admin`
  MODIFY `id_tb_konsultasi_revisi_admin` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_konsultasi_revisi_unit`
--
ALTER TABLE `tb_konsultasi_revisi_unit`
  MODIFY `id_tb_konsultasi_revisi_unit` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_konsultasi_unit_terkait`
--
ALTER TABLE `tb_konsultasi_unit_terkait`
  MODIFY `id_tb_konsultasi_unit_terkait` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `id_tb_unit` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_tb_user` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
