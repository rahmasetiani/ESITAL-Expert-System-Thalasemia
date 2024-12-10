-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 09:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exsithal`
--

-- --------------------------------------------------------

--
-- Table structure for table `ambang_batas`
--

CREATE TABLE `ambang_batas` (
  `id` int(11) NOT NULL,
  `nilai` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ambang_batas`
--

INSERT INTO `ambang_batas` (`id`, `nilai`) VALUES
(1, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `basiskasus`
--

CREATE TABLE `basiskasus` (
  `kodebasiskasus` varchar(10) NOT NULL,
  `kodepenyakit` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `basiskasus`
--

INSERT INTO `basiskasus` (`kodebasiskasus`, `kodepenyakit`) VALUES
('BK001', 'P001'),
('BK002', 'P002'),
('BK003', 'P003'),
('BK004', 'P004'),
('BK005', 'P005'),
('BK006', 'P006'),
('BK007', 'P007'),
('BK008', 'P008'),
('BK009', 'P009');

-- --------------------------------------------------------

--
-- Table structure for table `basiskasus_gejala`
--

CREATE TABLE `basiskasus_gejala` (
  `kodebasiskasus` varchar(10) NOT NULL,
  `kodegejala` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `basiskasus_gejala`
--

INSERT INTO `basiskasus_gejala` (`kodebasiskasus`, `kodegejala`) VALUES
('BK001', 'G001'),
('BK001', 'G002'),
('BK001', 'G005'),
('BK001', 'G006'),
('BK001', 'G007'),
('BK001', 'G043'),
('BK002', 'G001'),
('BK002', 'G003'),
('BK002', 'G004'),
('BK002', 'G007'),
('BK002', 'G008'),
('BK002', 'G009'),
('BK002', 'G010'),
('BK002', 'G023'),
('BK003', 'G011'),
('BK003', 'G014'),
('BK003', 'G024'),
('BK003', 'G026'),
('BK003', 'G036'),
('BK003', 'G037'),
('BK004', 'G012'),
('BK004', 'G013'),
('BK004', 'G018'),
('BK004', 'G040'),
('BK004', 'G041'),
('BK005', 'G015'),
('BK005', 'G017'),
('BK005', 'G019'),
('BK005', 'G020'),
('BK005', 'G022'),
('BK005', 'G041'),
('BK006', 'G007'),
('BK006', 'G010'),
('BK006', 'G016'),
('BK006', 'G021'),
('BK006', 'G041'),
('BK007', 'G011'),
('BK007', 'G013'),
('BK007', 'G025'),
('BK007', 'G027'),
('BK007', 'G035'),
('BK007', 'G038'),
('BK007', 'G039'),
('BK007', 'G042'),
('BK008', 'G028'),
('BK008', 'G029'),
('BK008', 'G033'),
('BK008', 'G034'),
('BK008', 'G038'),
('BK009', 'G001'),
('BK009', 'G007'),
('BK009', 'G011'),
('BK009', 'G030'),
('BK009', 'G031'),
('BK009', 'G032');

-- --------------------------------------------------------

--
-- Table structure for table `gejala`
--

CREATE TABLE `gejala` (
  `kodegejala` varchar(5) NOT NULL,
  `namagejala` varchar(100) NOT NULL,
  `bobot` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gejala`
--

INSERT INTO `gejala` (`kodegejala`, `namagejala`, `bobot`) VALUES
('G001', 'Bau mulut', 1),
('G002', 'Gusi bengkak, merah dan berdarah', 3),
('G003', 'Gelisah', 1),
('G004', 'Kelelahan', 1),
('G005', 'Gingival berkaratin, gangguan luka di antara gigi dan gusi', 3),
('G006', 'Pembesaran limfoinoid dikepala, leher atau rahang', 5),
('G007', 'Demam', 3),
('G008', 'Gusi mudah berdarah', 3),
('G009', 'Kelenjar getah bening di bawah rahang sering kali membengkak', 3),
('G010', 'Mengunyah dan menelan makanan menyebabkan rasa nyeri', 5),
('G011', 'Kehilangan selera makan', 1),
('G012', 'Pembengkakan pada gusi', 3),
('G013', 'Sakit saat membuka mulut', 1),
('G014', 'Pecah-pecah dan kemerahan pada sudut mulut', 3),
('G015', 'Peradangan pada lidah', 5),
('G016', 'Pembekakan kelenjar getah bening leher', 5),
('G017', 'Permukaan lidah yang halus', 1),
('G018', 'Mengunyah akan menimbulkan rasa sakit', 1),
('G019', 'Lidah berwarna merah dan putih', 3),
('G020', 'Alergi pada pasta gigi dan obat kumur', 1),
('G021', 'Gigi terasa sakit', 3),
('G022', 'Kesulitan mengunyah, menelan dan berbicara', 3),
('G023', 'Ujung-ujung gusi yang terletak diantara dua gigi mengalami pengikisan', 5),
('G024', 'Muncul bintik kuning, putih atau krem di dalam mulut', 5),
('G025', 'Kulit terkelupas', 3),
('G026', 'Sedikit pendarahan apabila lesi tergores', 3),
('G027', 'Timbulnya kerak yang berlebihan', 3),
('G028', 'Merintis kecil', 1),
('G029', 'Bibir terasa kering', 1),
('G030', 'Luka kecil sekitar 1-5 milimeter diameter', 3),
('G031', 'Gusi berwarna merah', 1),
('G032', 'Banyak luka terbuka berwarna putih dan kuning', 5),
('G033', 'Perih sekitar luka', 3),
('G034', 'Fisur Eritemotosis Simetris pada kulit Commisura', 1),
('G035', 'Kesemutan pada wilayah bibir', 3),
('G036', 'Lesi menyerupai keju', 1),
('G037', 'Di dalam mulut seperti terdapat kapas', 3),
('G038', 'Rasa gatal dan iritasi pada daerah bibir dan mulut', 5),
('G039', 'Rasa sakit dan nyeri pada bibir dan mulut', 5),
('G040', 'Munculnya nanah', 5),
('G041', 'Susah mengunyah makanan', 3),
('G042', 'Luka kecil (lecet) pada bibir dan mulut', 3),
('G043', 'Nyeri gusi', 5);

--
-- Triggers `gejala`
--
DELIMITER $$
CREATE TRIGGER `kodegejala_otomatis` BEFORE INSERT ON `gejala` FOR EACH ROW BEGIN
    DECLARE maxKode VARCHAR(5);
    DECLARE nextKode INT;

    -- Ambil kode gejala tertinggi
    SELECT MAX(kodegejala) INTO maxKode FROM gejala;

    -- Ekstrak nomor urut dari kode gejala terakhir
    SET nextKode = IFNULL(CAST(SUBSTRING(maxKode, 2) AS UNSIGNED) + 1, 1);

    -- Generate kode gejala baru
    SET NEW.kodegejala = CONCAT('G', LPAD(nextKode, 3, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `hasil`
--

CREATE TABLE `hasil` (
  `idhasil` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `nama_pasien` varchar(100) DEFAULT NULL,
  `tanggallahir_pasien` date DEFAULT NULL,
  `alamat_pasien` text DEFAULT NULL,
  `jk_pasien` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `gejala_terpilih` text DEFAULT NULL,
  `hasil_diagnosa` text DEFAULT NULL,
  `hasil_similarity` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `keseluruhan_diagnosa` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`keseluruhan_diagnosa`)),
  `keseluruhan_similarity` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`keseluruhan_similarity`)),
  `status_revisi` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil`
--

INSERT INTO `hasil` (`idhasil`, `iduser`, `nama_pasien`, `tanggallahir_pasien`, `alamat_pasien`, `jk_pasien`, `gejala_terpilih`, `hasil_diagnosa`, `hasil_similarity`, `created_at`, `keseluruhan_diagnosa`, `keseluruhan_similarity`, `status_revisi`) VALUES
(536, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Bau mulut, Gusi bengkak, merah dan berdarah, Gelisah, Kelelahan, Rasa sakit dan nyeri pada bibir dan mulut, Munculnya nanah, Susah mengunyah makanan, Luka kecil (lecet) pada bibir dan mulut, Nyeri gusi', '4. Abses Periodental', 61.54, '2024-12-10 07:13:24', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[45,13.64,0,61.54,18.75,15.79,33.33,0,7.14]', 'pending'),
(542, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Bau mulut, Gusi bengkak, merah dan berdarah, Gelisah', 'Tidak Teridentifikasi Penyakit Thalassemia dan Penyakit Serupa', NULL, '2024-12-10 07:46:50', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[20,9.09,0,0,0,0,0,0,7.14]', 'rejected'),
(543, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Susah mengunyah makanan, Luka kecil (lecet) pada bibir dan mulut, Nyeri gusi', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2024-12-10 07:56:30', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[25,0,0,23.08,18.75,15.79,12.5,0,0]', 'rejected'),
(544, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Bau mulut, Gusi bengkak, merah dan berdarah, Gelisah, Kelelahan, Gingival berkaratin, gangguan luka di antara gigi dan gusi, Pembesaran limfoinoid dikepala, leher atau rahang, Demam, Rasa sakit dan nyeri pada bibir dan mulut, Munculnya nanah, Susah mengunyah makanan, Luka kecil (lecet) pada bibir dan mulut, Nyeri gusi', 'Gingivitis Ulseratif Nekrosisakut', 100.00, '2024-12-10 07:58:01', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[100,27.27,0,61.54,18.75,31.58,33.33,0,28.57]', 'pending'),
(545, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Merintis kecil, Bibir terasa kering, Luka kecil sekitar 1-5 milimeter diameter', '9. Gingivostomatitis', 21.43, '2024-12-10 07:58:42', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[0,0,0,0,0,0,0,18.18,21.43]', 'pending'),
(546, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Bau mulut, Gusi bengkak, merah dan berdarah, Rasa gatal dan iritasi pada daerah bibir dan mulut', '8. Stomatitis Angularis', 45.45, '2024-12-10 08:19:53', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[20,4.55,0,0,0,0,20.83,45.45,7.14]', 'pending'),
(547, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Bau mulut, Gusi bengkak, merah dan berdarah, Gelisah, Gingival berkaratin, gangguan luka di antara gigi dan gusi', 'Gingivitis Ulseratif Nekrosisakut', NULL, '2024-12-10 08:20:03', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[35,9.09,0,0,0,0,0,0,7.14]', 'pending'),
(548, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Bau mulut, Gusi bengkak, merah dan berdarah, Gelisah, Kelelahan, Gingival berkaratin, gangguan luka di antara gigi dan gusi', 'Gingivitis Ulseratif Nekrosisakut', 35.00, '2024-12-10 08:20:13', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[35,13.64,0,0,0,0,0,0,7.14]', 'pending'),
(549, 38, 'Mamad', '2024-11-19', 'Bandung Barat\r\n\r\n\r\n\r\n', 'Laki-laki', 'Gusi berwarna merah, Banyak luka terbuka berwarna putih dan kuning, Perih sekitar luka', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2024-12-10 08:20:20', '[\"Gingivitis Ulseratif Nekrosisakut\",\"2.  Trench Mouth\",\"Candidiasis Oral\",\"4. Abses Periodental\",\"5. Glosistis\",\"6. Abses Periapikal\",\"7. Herpes Labialis\",\"8. Stomatitis Angularis\",\"9. Gingivostomatitis\"]', '[0,0,0,0,0,0,0,27.27,42.86]', 'rejected');

-- --------------------------------------------------------

--
-- Table structure for table `pasien_gejala`
--

CREATE TABLE `pasien_gejala` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `gejala_terpilih` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien_gejala`
--

INSERT INTO `pasien_gejala` (`id`, `iduser`, `gejala_terpilih`) VALUES
(41, 38, 'G001,G002,G003,G004,G005'),
(42, 38, 'G001,G002,G003,G004,G005'),
(43, 38, 'G001,G002,G003,G004,G005,G040,G041,G042,G043'),
(44, 38, 'G001,G002,G003,G004,G005,G037,G038,G039,G040,G041,G042,G043'),
(45, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G037,G038,G039,G040,G041,G042,G043'),
(46, 38, 'G001,G040,G041,G042,G043'),
(47, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010'),
(48, 38, 'G001,G002,G003,G004,G005'),
(49, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010'),
(50, 38, 'G035,G036,G037,G038,G039,G040,G041,G042,G043'),
(51, 38, 'G001,G021,G022,G023,G024,G025,G026,G027,G028,G036,G037,G042'),
(52, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G042,G043'),
(53, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G043'),
(54, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G011'),
(55, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G038,G039,G040,G041'),
(56, 50, 'G001,G002,G003,G004,G005,G006'),
(57, 50, 'G039,G040,G041,G042,G043'),
(58, 50, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G011,G012,G013,G014,G015,G016,G017,G018,G019,G020'),
(59, 50, 'G001,G002,G003,G004,G005,G006'),
(60, 50, 'G001,G002,G003'),
(61, 50, 'G001,G002,G003,G004'),
(62, 50, 'G034,G035,G036,G037,G038,G039,G040,G041,G042,G043'),
(63, 50, 'G001,G002,G003,G004'),
(64, 50, 'G001,G002,G003,G004,G005'),
(65, 50, 'G001,G002,G003,G004'),
(66, 50, 'G001,G002,G003,G004,G006'),
(67, 50, 'G001,G002,G003,G004'),
(68, 50, 'G001,G002,G003,G004,G005'),
(69, 50, 'G001,G002,G003,G004,G005,G006'),
(70, 50, 'G001,G002,G003,G004'),
(71, 50, 'G001,G002,G003,G004,G005,G006,G007,G008,G009'),
(72, 50, 'G001,G002,G003,G004'),
(73, 50, 'G001,G002,G003,G004,G005,G006'),
(74, 50, 'G001,G002,G003,G004,G005'),
(75, 50, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G042,G043'),
(76, 50, 'G001,G002,G003,G004,G005,G006'),
(77, 50, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G039,G040,G041,G042,G043'),
(78, 50, 'G041,G042,G043'),
(79, 50, 'G001,G002,G003,G004'),
(80, 50, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G039,G040,G041,G042,G043'),
(81, 50, 'G001,G002,G003,G005'),
(82, 50, 'G001,G002,G003,G005,G006,G007'),
(83, 50, 'G001,G002,G003,G004,G005,G006,G007,G008'),
(84, 50, 'G001,G002,G003,G004,G005,G006,G007,G008'),
(85, 50, 'G001,G002,G003,G004,G005,G006,G007,G008,G042,G043'),
(86, 50, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010'),
(87, 50, 'G001,G002,G003,G004,G005'),
(88, 50, 'G001,G002,G003'),
(89, 50, 'G004,G005,G006,G007'),
(90, 50, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010'),
(91, 50, 'G001,G002,G003,G004'),
(92, 38, 'G001,G002,G003,G037,G038,G039,G040,G041,G042,G043'),
(93, 38, 'G039,G040,G041,G042,G043'),
(94, 38, 'G037,G038,G039,G040,G041'),
(95, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010'),
(96, 38, 'G001,G002,G003,G004,G005,G006,G007'),
(97, 38, 'G001,G002,G003,G004,G005,G006,G007'),
(98, 38, 'G001,G002,G003,G004,G005,G006'),
(99, 38, 'G001,G002,G003,G004,G005'),
(100, 38, 'G001,G002,G003,G004,G005,G036,G037,G038'),
(101, 38, 'G001,G002,G003'),
(102, 38, 'G001,G002,G003,G036,G037,G038'),
(103, 38, 'G001,G002,G004'),
(104, 38, 'G001,G002,G003,G004,G005,G006'),
(105, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G041,G042,G043'),
(106, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G041,G042,G043'),
(107, 38, 'G001,G002,G003,G004,G005,G006,G007,G008'),
(108, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G036,G037,G038'),
(109, 38, 'G032,G033,G034'),
(110, 38, 'G001,G002,G003,G004,G005,G032,G033,G034'),
(111, 38, 'G001,G002,G003,G004,G005,G007,G015,G016,G017,G032,G033,G034,G039,G040,G041,G042'),
(112, 38, 'G001,G002,G003,G004,G005,G007,G015,G016,G017,G032,G033,G034,G035,G037,G039,G040,G041,G042'),
(113, 38, 'G001,G002,G003,G004,G005,G007,G015,G016,G017,G032,G033,G034,G035,G036,G037,G038,G039,G040,G041,G042,G043'),
(114, 38, 'G001,G002,G003,G004,G005,G007,G015,G016,G017,G032,G033,G034,G035,G036,G037,G038,G039,G040,G041,G042,G043'),
(115, 38, 'G001,G002,G003,G004,G005,G006'),
(116, 38, 'G001,G002,G003,G004,G005,G006'),
(117, 38, 'G001,G002,G003,G004'),
(118, 38, 'G001,G002,G003,G004,G039,G040,G041,G042,G043'),
(119, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009'),
(120, 38, 'G001,G002,G003'),
(121, 38, 'G001,G002,G003,G004,G005,G006,G013,G014,G015,G016,G030,G031,G032,G033'),
(122, 38, 'G001,G002,G003,G004,G005,G006,G013,G014,G015,G016,G030,G031,G032,G033'),
(123, 38, 'G034,G035,G036,G037'),
(124, 38, 'G001,G002,G003,G004'),
(125, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009'),
(126, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009'),
(127, 38, 'G040,G041,G042,G043'),
(128, 38, 'G001,G002,G003'),
(129, 38, 'G002,G003,G039,G040,G041,G042,G043'),
(130, 38, 'G001,G002,G003,G004,G005,G006'),
(131, 38, 'G001,G002,G005,G006,G007,G043'),
(132, 38, 'G001,G002,G003,G004,G005,G006,G007'),
(133, 38, 'G001,G002,G005,G006,G007,G043'),
(134, 38, 'G011,G014,G024,G026,G036,G037'),
(135, 38, 'G001,G002,G003,G004,G005'),
(136, 38, 'G001,G002,G005,G006,G007,G043'),
(137, 38, 'G001,G002,G003'),
(138, 38, 'G038,G039,G040,G041,G042,G043'),
(139, 38, 'G040,G041,G042,G043'),
(140, 38, 'G041,G042,G043'),
(141, 38, 'G035,G036,G037,G038'),
(142, 38, 'G038,G039,G040,G041'),
(143, 38, 'G040,G041,G042,G043'),
(144, 38, 'G001,G002,G003,G004'),
(145, 38, 'G001,G002,G003'),
(146, 38, 'G001,G002,G003'),
(147, 38, 'G001,G002,G003,G004,G005,G006,G007,G042,G043'),
(148, 38, 'G001,G002,G003,G004,G005,G006,G007,G043'),
(149, 38, 'G001,G002,G003'),
(150, 38, 'G001,G002,G003,G004,G005,G006,G007'),
(151, 38, 'G001,G002,G003,G004'),
(152, 38, 'G001,G002,G003,G004,G005'),
(153, 38, 'G001,G002,G003'),
(154, 38, 'G038,G039,G040,G041,G042,G043'),
(155, 50, 'G041,G042,G043'),
(156, 51, 'G001,G002,G003'),
(157, 51, 'G001,G003,G004'),
(158, 51, 'G001,G002,G003'),
(159, 52, 'G001,G002,G003'),
(160, 53, 'G001,G002,G003,G004'),
(161, 38, 'G001,G002,G003'),
(162, 54, 'G001,G002,G003'),
(163, 54, 'G001,G002,G003,G004'),
(164, 54, 'G001,G002,G003,G004,G005'),
(165, 54, 'G001,G002,G003'),
(166, 54, 'G001,G002,G003'),
(167, 54, 'G001,G002,G003'),
(168, 54, 'G001,G002,G003'),
(169, 54, 'G001,G002,G003'),
(170, 54, 'G001,G002,G042,G043'),
(171, 54, 'G001,G002,G038,G039,G040'),
(172, 54, 'G001,G002,G003'),
(173, 54, 'G001,G002,G003'),
(174, 54, 'G001,G040,G041,G042,G043'),
(175, 54, 'G001,G002,G003'),
(176, 54, 'G001,G002,G003'),
(177, 38, 'G001,G002,G003'),
(178, 38, 'G001,G040,G041,G042,G043'),
(179, 38, 'G001,G002,G003'),
(180, 38, 'G040,G041,G042,G043'),
(181, 38, 'G041,G042,G043'),
(182, 38, 'G001,G002,G003'),
(183, 38, 'G040,G041,G042,G043'),
(184, 38, 'G001,G002,G003,G004'),
(185, 38, 'G001,G002,G003,G004,G005'),
(186, 38, 'G036,G040,G041'),
(187, 38, 'G001,G042,G043'),
(188, 38, 'G001,G002,G003'),
(189, 38, 'G041,G042,G043'),
(190, 38, 'G041,G042,G043'),
(191, 38, 'G041,G042,G043'),
(192, 38, 'G041,G042,G043'),
(193, 38, 'G041,G042,G043'),
(194, 38, 'G041,G042,G043'),
(195, 38, 'G041,G042,G043'),
(196, 38, 'G041,G042,G043'),
(197, 38, 'G041,G042,G043'),
(198, 38, 'G041,G042,G043'),
(199, 38, 'G041,G042,G043'),
(200, 38, 'G041,G042,G043'),
(201, 38, 'G039,G040,G041'),
(202, 38, 'G001,G002,G003'),
(203, 38, 'G001,G002,G003'),
(204, 38, 'G001,G002,G003,G040,G041,G042'),
(205, 38, 'G040,G041,G042,G043'),
(206, 38, 'G040,G041,G042,G043'),
(207, 38, 'G040,G041,G042,G043'),
(208, 38, 'G001,G002,G003,G004,G005,G006,G007'),
(209, 38, 'G037,G038,G039,G040,G041,G042,G043'),
(210, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G010,G011,G012,G013,G014,G015,G043'),
(211, 38, 'G001,G002,G003'),
(212, 38, 'G041,G042,G043'),
(213, 38, 'G001,G002,G005,G006,G007,G040,G041,G042,G043'),
(214, 41, 'G001,G002,G003'),
(215, 41, 'G040,G041,G042,G043'),
(216, 41, 'G041,G042,G043'),
(217, 41, 'G040,G041,G042,G043'),
(218, 41, 'G041,G042,G043'),
(219, 41, 'G001,G002,G003'),
(220, 41, 'G001,G002,G003'),
(221, 41, 'G040,G041,G042,G043'),
(222, 41, 'G001,G002,G003'),
(223, 41, 'G041,G042,G043'),
(224, 41, 'G001,G002,G005,G006,G007,G039,G040,G041,G042,G043'),
(225, 41, 'G001,G002,G043'),
(226, 41, 'G001,G002,G043'),
(227, 41, 'G039,G040,G041,G042,G043'),
(228, 41, 'G001,G002,G003,G041,G042,G043'),
(229, 38, 'G001,G002,G003'),
(230, 38, 'G001,G002,G005,G006,G007'),
(231, 38, 'G001,G002,G005,G006,G007,G043'),
(232, 38, 'G001,G002,G003,G004'),
(233, 38, 'G036,G037,G038,G039,G040,G041,G042,G043'),
(234, 38, 'G040,G041,G042,G043'),
(235, 38, 'G001,G002,G003'),
(236, 38, 'G001,G002,G003'),
(237, 38, 'G001,G042,G043'),
(238, 38, 'G041,G042,G043'),
(239, 38, 'G041,G042,G043'),
(240, 38, 'G003,G004,G005'),
(241, 38, 'G021,G022,G023'),
(242, 38, 'G001,G003,G043'),
(243, 38, 'G001,G002,G003,G004'),
(244, 38, 'G001,G004,G007'),
(245, 38, 'G001,G002,G003,G004,G005,G006,G007,G043'),
(246, 38, 'G001,G004,G005,G006,G041,G042'),
(247, 50, 'G001,G002,G003'),
(248, 50, 'G001,G003,G004'),
(249, 50, 'G001,G002,G003,G004'),
(250, 38, 'G001,G003,G004'),
(251, 38, 'G001,G003,G004,G005,G006,G007,G043'),
(252, 38, 'G001,G003,G004'),
(253, 38, 'G001,G002,G003,G004,G005,G006,G007,G008,G043'),
(254, 38, 'G041,G042,G043'),
(255, 38, 'G001,G002,G004'),
(256, 38, 'G007,G008,G009'),
(257, 38, 'G034,G035,G036'),
(258, 58, 'G001,G002,G003'),
(259, 38, 'G001,G002,G003,G041,G042,G043'),
(260, 38, 'G001,G002,G003,G041,G042,G043'),
(261, 38, 'G001,G002,G003,G004,G005,G006,G040,G041,G042,G043'),
(262, 38, 'G001,G002,G003,G004,G039,G040,G041,G042,G043'),
(263, 38, 'G001,G002,G003,G004'),
(264, 38, 'G001,G002,G003'),
(265, 38, 'G001,G028,G029,G030,G031,G032,G033,G034,G035,G036'),
(266, 38, 'G007,G018,G019,G020'),
(267, 38, 'G001,G002,G003'),
(268, 38, 'G001,G002,G003'),
(269, 38, 'G041,G042,G043'),
(270, 38, 'G001,G002,G003,G004,G005,G006,G007,G039,G040,G041,G042,G043'),
(271, 38, 'G028,G029,G030'),
(272, 38, 'G001,G002,G038'),
(273, 38, 'G001,G002,G003,G005'),
(274, 38, 'G001,G002,G003,G004,G005'),
(275, 38, 'G031,G032,G033');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `kodepenyakit` varchar(5) NOT NULL,
  `namapenyakit` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `solusipengobatan` text NOT NULL,
  `foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`kodepenyakit`, `namapenyakit`, `deskripsi`, `solusipengobatan`, `foto`) VALUES
('P001', 'Gingivitis Ulseratif Nekrosisakut', 'Thalassemia mayor adalah jenis anemia yang parah yang disebabkan oleh kekurangan produksi hemoglobin. Penderita mengalami gejala anemia berat, yang dapat mencakup kelelahan, kelemahan, dan kulit pucat. Gangguan ini biasanya memerlukan transfusi darah secara rutin.', 'Transfusi darah secara teratur.\r\nTerapi chelasi untuk menghilangkan kelebihan zat besi akibat transfusi.\r\nPerawatan suportif dan pemantauan kesehatan secara berkala.\r\nDalam beberapa kasus, transplantasi sumsum tulang mungkin dipertimbangkan.', 'Beta Thalassemia.jpg'),
('P002', '2.  Trench Mouth', 'Thalassemia intermedia adalah bentuk thalassemia yang lebih ringan daripada mayor, tetapi lebih parah dibandingkan dengan thalassemia minor. Penderita mungkin mengalami anemia, tetapi tidak seberat thalassemia mayor dan seringkali tidak memerlukan transfusi darah rutin.\r\n', 'Manajemen gejala anemia, termasuk transfusi darah jika diperlukan.\r\nTerapi chelasi untuk mengelola kadar zat besi.\r\nPemantauan kesehatan dan konseling genetik.', 'Beta Thalassemia.jpg'),
('P003', 'Candidiasis Oral', 'Thalassemia minor biasanya tidak menyebabkan gejala signifikan dan sering kali terdeteksi secara kebetulan. Penderita memiliki satu salinan gen yang bermutasi, dan dapat memiliki sedikit anemia.', 'Umumnya tidak memerlukan perawatan medis.\nPemberian suplemen zat besi tidak dianjurkan, karena dapat memperburuk kondisi.\nKonseling genetik bagi pasangan yang berencana untuk memiliki anak.', 'Beta Thalassemia.jpg'),
('P004', '4. Abses Periodental', 'Anemia adalah kondisi ketika jumlah sel darah merah atau kadar hemoglobin dalam darah rendah, mengakibatkan kurangnya oksigen ke jaringan tubuh. Gejalanya meliputi kelelahan, kelemahan, dan sesak napas.', 'Mengidentifikasi penyebab anemia (seperti kekurangan zat besi, vitamin B12, atau asam folat).\r\nSuplemen zat besi, vitamin B12, atau asam folat sesuai kebutuhan.\r\nDiet seimbang yang kaya akan zat besi (daging merah, sayuran hijau, biji-bijian).', 'Beta Thalassemia.jpg'),
('P005', '5. Glosistis', ' Kekurangan vitamin B12 dapat menyebabkan anemia megaloblastik, yang ditandai dengan sel darah merah yang besar dan tidak normal. Gejala mungkin termasuk kelelahan, kelemahan, dan gangguan neurologis.', 'Suplemen vitamin B12, baik oral atau melalui injeksi, tergantung pada tingkat keparahan kekurangan.\r\nMeningkatkan konsumsi makanan kaya vitamin B12 (daging, ikan, produk susu, telur).\r\nMemperhatikan diet vegetarian atau vegan yang mungkin membutuhkan suplemen.', 'Beta Thalassemia.jpg'),
('P006', '6. Abses Periapikal', 'Abses Periapikal Abses Periapikal Abses Periapikal Abses Periapikal Abses Periapikal', 'Abses Periapikal Abses Periapikal Abses Periapikal Abses Periapikal Abses Periapikal', 'Beta Thalassemia.jpg'),
('P007', '7. Herpes Labialis', 'Herpes Labialis Herpes Labialis Herpes Labialis Herpes Labialis Herpes Labialis ', 'Herpes Labialis Herpes Labialis Herpes Labialis Herpes Labialis Herpes Labialis ', 'Beta Thalassemia.jpg'),
('P008', '8. Stomatitis Angularis', 'Stomatitis Angularis Stomatitis Angularis Stomatitis Angularis Stomatitis Angularis Stomatitis Angularis', 'Stomatitis Angularis Stomatitis Angularis Stomatitis Angularis Stomatitis Angularis Stomatitis Angularis', 'Beta Thalassemia.jpg'),
('P009', '9. Gingivostomatitis', 'Gingivostomatitis Gingivostomatitis Gingivostomatitis Gingivostomatitis Gingivostomatitis Gingivostomatitis ', 'Gingivostomatitis Gingivostomatitis Gingivostomatitis Gingivostomatitis Gingivostomatitis Gingivostomatitis ', 'Beta Thalassemia.jpg');

--
-- Triggers `penyakit`
--
DELIMITER $$
CREATE TRIGGER `kodepenyakit_otomatis` BEFORE INSERT ON `penyakit` FOR EACH ROW BEGIN
    DECLARE maxKode VARCHAR(5);
    DECLARE nextKode INT;

    -- Ambil kode penyakit tertinggi 
    SELECT MAX(kodepenyakit) INTO maxKode FROM penyakit; 

    -- Ekstrak nomor urut dari kode penyakit terakhir
    SET nextKode = IFNULL(CAST(SUBSTRING(maxKode, 2) AS UNSIGNED) + 1, 1);

    -- Generate kode penyakit baru
    SET NEW.kodepenyakit = CONCAT('P', LPAD(nextKode, 3, '0')); 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `namalengkap` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` tinyint(4) DEFAULT 0,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `namalengkap`, `email`, `password`, `created_at`, `role`, `tanggal_lahir`, `jenis_kelamin`, `alamat`) VALUES
(38, 'Mamad', 'muhammad121@gmail.com', '$2y$10$s/PKOHGER0n7W.C7LYpH4.44.A1gdnxOPGTWgo6UTBq6c6a4zerwe', '2024-11-19 10:36:15', 0, '2024-11-19', 'Laki-laki', 'Bandung Barat\r\n\r\n\r\n\r\n'),
(41, 'Dina', 'dina@gmail.com', '$2y$10$onNeiTu2Y3NxH6kKEJsHXee.dcZBIzsSjbdVtm8piu/KgWt2Cubxm', '2024-11-28 07:42:12', 0, '2024-11-28', 'Laki-laki', 'Cilacap'),
(43, 'Sinta', 'sinta@gmail.com', '$2y$10$.VW.VjtgNnzLvKxuLM4eI.Tn1VjgSNSegTsQX.B6JLBxKV3gTDmqO', '2024-11-28 12:24:20', 0, '2024-11-28', 'Laki-laki', 'Semarang Kota\r\n'),
(49, 'Dinda', 'dinda@gmailcom', '$2y$10$/iGg3RMNXNJhuEHRfgtGGOsaZ8sSd2shxl9/IMu2ByMW2gwsK23qG', '2024-11-28 15:37:02', 1, '2024-11-28', 'Perempuan', 'Purwokerto'),
(50, 'Amanda', 'Amanda@gmail.com', '$2y$10$gm2xLzI4BPTnhMen479Shux.BHH/7tYmf265/I5Kvqiro.cSOM3he', '2024-12-03 04:05:48', 0, '2024-12-03', 'Perempuan', 'Wangon'),
(51, 'Diva Naya', 'ana@gmail.com', '$2y$10$bEe/yxQGqk01DEwWHin6cOa2lTipfs3OR87YdNjTlg2sDllBYIWrO', '2024-12-05 19:22:29', 0, '2024-12-06', 'Laki-laki', 'Wangon'),
(52, 'Ayu', 'ayu@gmail.com', '$2y$10$aYJnFNcz6nBGqbo.DOO4suGZacV3VyNg/Gd.5/4lUetTqWXeCd6TW', '2024-12-05 19:28:49', 0, '2024-12-06', 'Laki-laki', 'Wangon\r\n'),
(53, 'dima', 'dima@gmail.com', '$2y$10$s1YJi7uGTWX77eWU/uz3yOEWzUMkC0lPSC/chYd8z/WUdlbKQ7vVC', '2024-12-05 19:32:14', 0, '2024-12-06', 'Laki-laki', 'Wangon'),
(54, 'kan', 'kan@gmail.com', '$2y$10$Le0b/vxmuitgx70y3vrTg.RCxc7zLjZp3radIChpLVqERHkXN.NmK', '2024-12-05 19:46:34', 0, '2024-12-06', 'Perempuan', 'Wangon\r\n'),
(58, 'Rahma Setiani ', 'rahmasetiani200@gmail.com', '$2y$10$4E2XhSK781HYHDfmJkW5GeR8mUsvsQBGb/5Yu8s8boHzv2CwJbCiG', '2024-12-07 07:36:10', 1, '2024-12-07', 'Perempuan', 'Jatilawang'),
(61, 'Yasmin', 'yasmin@gmail.com', '$2y$10$Nx3ACR7xu.o2US6FQ2ShiuRwTItsl31feoswSFCa0E9PeRu21rG/G', '2024-12-07 15:59:40', 2, '2024-12-07', 'Perempuan', 'lalala');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ambang_batas`
--
ALTER TABLE `ambang_batas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `basiskasus`
--
ALTER TABLE `basiskasus`
  ADD PRIMARY KEY (`kodebasiskasus`),
  ADD KEY `kodepenyakit` (`kodepenyakit`);

--
-- Indexes for table `basiskasus_gejala`
--
ALTER TABLE `basiskasus_gejala`
  ADD PRIMARY KEY (`kodebasiskasus`,`kodegejala`),
  ADD KEY `kodegejala` (`kodegejala`);

--
-- Indexes for table `gejala`
--
ALTER TABLE `gejala`
  ADD PRIMARY KEY (`kodegejala`),
  ADD UNIQUE KEY `namagejala` (`namagejala`);

--
-- Indexes for table `hasil`
--
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`idhasil`);

--
-- Indexes for table `pasien_gejala`
--
ALTER TABLE `pasien_gejala`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`kodepenyakit`),
  ADD UNIQUE KEY `namapenyakit` (`namapenyakit`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ambang_batas`
--
ALTER TABLE `ambang_batas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hasil`
--
ALTER TABLE `hasil`
  MODIFY `idhasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=550;

--
-- AUTO_INCREMENT for table `pasien_gejala`
--
ALTER TABLE `pasien_gejala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `basiskasus`
--
ALTER TABLE `basiskasus`
  ADD CONSTRAINT `basiskasus_ibfk_1` FOREIGN KEY (`kodepenyakit`) REFERENCES `penyakit` (`kodepenyakit`);

--
-- Constraints for table `basiskasus_gejala`
--
ALTER TABLE `basiskasus_gejala`
  ADD CONSTRAINT `basiskasus_gejala_ibfk_1` FOREIGN KEY (`kodebasiskasus`) REFERENCES `basiskasus` (`kodebasiskasus`) ON DELETE CASCADE,
  ADD CONSTRAINT `basiskasus_gejala_ibfk_2` FOREIGN KEY (`kodegejala`) REFERENCES `gejala` (`kodegejala`) ON DELETE CASCADE;

--
-- Constraints for table `pasien_gejala`
--
ALTER TABLE `pasien_gejala`
  ADD CONSTRAINT `pasien_gejala_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
