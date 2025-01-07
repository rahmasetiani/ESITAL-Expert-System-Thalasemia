-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 03:54 AM
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
(1, 70.00);

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
('BK006', 'P001'),
('BK011', 'P001'),
('BK016', 'P001'),
('BK021', 'P001'),
('BK026', 'P001'),
('BK002', 'P002'),
('BK007', 'P002'),
('BK012', 'P002'),
('BK017', 'P002'),
('BK022', 'P002'),
('BK027', 'P002'),
('BK003', 'P003'),
('BK008', 'P003'),
('BK013', 'P003'),
('BK018', 'P003'),
('BK023', 'P003'),
('BK028', 'P003'),
('BK004', 'P004'),
('BK009', 'P004'),
('BK014', 'P004'),
('BK019', 'P004'),
('BK024', 'P004'),
('BK029', 'P004'),
('BK005', 'P005'),
('BK010', 'P005'),
('BK015', 'P005'),
('BK020', 'P005'),
('BK025', 'P005'),
('BK030', 'P005');

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
('BK001', 'G020'),
('BK001', 'G021'),
('BK001', 'G022'),
('BK001', 'G023'),
('BK001', 'G026'),
('BK002', 'G001'),
('BK002', 'G009'),
('BK002', 'G018'),
('BK002', 'G019'),
('BK002', 'G024'),
('BK002', 'G025'),
('BK003', 'G001'),
('BK003', 'G010'),
('BK003', 'G011'),
('BK003', 'G012'),
('BK003', 'G017'),
('BK004', 'G002'),
('BK004', 'G004'),
('BK004', 'G008'),
('BK004', 'G013'),
('BK004', 'G014'),
('BK005', 'G003'),
('BK005', 'G006'),
('BK005', 'G007'),
('BK005', 'G015'),
('BK005', 'G016'),
('BK006', 'G001'),
('BK006', 'G002'),
('BK006', 'G005'),
('BK006', 'G023'),
('BK007', 'G001'),
('BK007', 'G009'),
('BK007', 'G018'),
('BK008', 'G001'),
('BK008', 'G010'),
('BK008', 'G017'),
('BK009', 'G002'),
('BK009', 'G004'),
('BK009', 'G008'),
('BK010', 'G003'),
('BK010', 'G006'),
('BK010', 'G007'),
('BK011', 'G021'),
('BK011', 'G022'),
('BK011', 'G023'),
('BK011', 'G026'),
('BK012', 'G019'),
('BK012', 'G024'),
('BK012', 'G025'),
('BK013', 'G011'),
('BK013', 'G012'),
('BK013', 'G017'),
('BK014', 'G008'),
('BK014', 'G013'),
('BK014', 'G014'),
('BK015', 'G007'),
('BK015', 'G015'),
('BK015', 'G016'),
('BK016', 'G001'),
('BK016', 'G002'),
('BK016', 'G021'),
('BK016', 'G022'),
('BK017', 'G001'),
('BK017', 'G009'),
('BK017', 'G019'),
('BK017', 'G024'),
('BK018', 'G001'),
('BK018', 'G010'),
('BK018', 'G011'),
('BK018', 'G017'),
('BK019', 'G002'),
('BK019', 'G004'),
('BK019', 'G008'),
('BK019', 'G013'),
('BK020', 'G006'),
('BK020', 'G007'),
('BK020', 'G015'),
('BK021', 'G005'),
('BK021', 'G020'),
('BK021', 'G023'),
('BK021', 'G026'),
('BK022', 'G009'),
('BK022', 'G018'),
('BK022', 'G024'),
('BK022', 'G025'),
('BK023', 'G001'),
('BK023', 'G011'),
('BK023', 'G012'),
('BK023', 'G017'),
('BK024', 'G002'),
('BK024', 'G004'),
('BK024', 'G008'),
('BK024', 'G014'),
('BK025', 'G003'),
('BK025', 'G007'),
('BK025', 'G015'),
('BK025', 'G016'),
('BK026', 'G005'),
('BK026', 'G021'),
('BK026', 'G022'),
('BK026', 'G023'),
('BK027', 'G009'),
('BK027', 'G018'),
('BK027', 'G019'),
('BK028', 'G001'),
('BK028', 'G011'),
('BK028', 'G012'),
('BK029', 'G002'),
('BK029', 'G008'),
('BK029', 'G014'),
('BK030', 'G003'),
('BK030', 'G015'),
('BK030', 'G016');

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
('G001', 'Ada riwayat keluarga yang mengalami penyakit thalassemia', 5),
('G002', 'Wajah tampak pucat', 5),
('G003', 'Kulit wajah atau tubuh tampak kemerahan.', 5),
('G004', 'Kulit terasa dingin pada ekstremitas', 1),
('G005', 'Warna kulit menjadi gelap atau kebiruan (Pigmentasi)', 3),
('G006', 'Gatal terutama setelah mandi air hangat (Pruritus)', 1),
('G007', 'Gangguan penglihatan seperti pandangan kabur.', 3),
('G008', 'Tubuh mudah merasa lemas/ kelelahan', 5),
('G009', 'Tubuh mudah mengalami infeksi', 5),
('G010', 'Sering merasa pusing atau sakit kepala', 3),
('G011', 'Berkurangnya nafsu makan', 3),
('G012', 'Penurunan berat badan yang tidak dapat dijelaskan', 1),
('G013', 'Jantung berdetak lebih cepat dan tidak teratur', 3),
('G014', 'Sesak nafas dan nyeri dada', 3),
('G015', 'Sering mengalami mimisan atau perdarahan lainnya.', 5),
('G016', 'Kesemutan atau mati rasa di tangan dan kaki.', 3),
('G017', 'Kuku rapuh dan mudah patah', 1),
('G018', 'Timbul patah tulang tanpa sebab (Fraktur Patologis)', 3),
('G019', 'Mengalami keterlambatan pertumbuhan dan perkembangan', 5),
('G020', 'Perawakan badan pendek', 3),
('G021', 'Leher Membesar', 1),
('G022', 'Penonjolan tulang pipi', 5),
('G023', 'Wajah dengan dahi menonjol dan hidung datar (Mongoloid)', 3),
('G024', 'Perut terlihat lebih buncit', 3),
('G025', 'Pembengkakan perut bagian kanan atas / hati (Hepatomegali)', 5),
('G026', 'Pembengkakan perut bagian kiri atas / limpa (Splenomegali)', 5);

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
(578, 52, 'Ayu', '2024-12-06', 'Wangon\r\n', 'Perempuan', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Wajah tampak pucat, Kulit wajah atau tubuh tampak kemerahan., Kulit terasa dingin pada ekstremitas', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2024-12-31 03:45:10', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[33.33,19.23,38.46,35.29,29.41,62.5,38.46,55.56,54.55,55.56,0,0,0,0,0,62.5,27.78,41.67,42.86,0,0,0,50,42.86,31.25,0,0,55.56,38.46,38.46]', 'pending'),
(580, 66, 'Rahma Setiani', '2024-12-31', 'JTL', 'Perempuan', 'Wajah tampak pucat, Kulit terasa dingin pada ekstremitas, Warna kulit menjadi gelap atau kebiruan (Pigmentasi), Tubuh mudah merasa lemas/ kelelahan, Sering merasa pusing atau sakit kepala', 'Anemia ', 100.00, '2024-12-31 03:59:51', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[26.67,0,23.08,64.71,0,50,0,33.33,100,0,0,0,0,45.45,0,31.25,0,25,78.57,0,21.43,0,0,78.57,0,25,0,0,76.92,0]', 'pending'),
(583, 66, 'Rahma Setiani', '2003-08-20', 'Jatilawang\r\n', 'Perempuan', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Wajah tampak pucat, Berkurangnya nafsu makan, Perut terlihat lebih buncit', 'Thalassemia Minor', 88.89, '2024-12-31 06:40:12', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[33.33,30.77,61.54,29.41,0,62.5,38.46,55.56,45.45,0,0,23.08,60,0,0,62.5,44.44,66.67,35.71,0,0,18.75,80,35.71,0,0,0,88.89,38.46,0]', 'pending'),
(584, 66, 'Rahma Setiani', '2003-08-20', 'Jatilawang\r\n', 'Perempuan', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Wajah tampak pucat, Kulit wajah atau tubuh tampak kemerahan.', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2024-12-31 12:45:33', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[33.33,19.23,38.46,29.41,29.41,62.5,38.46,55.56,45.45,55.56,0,0,0,0,0,62.5,27.78,41.67,35.71,0,0,0,50,35.71,31.25,0,0,55.56,38.46,38.46]', 'rejected'),
(585, 52, 'Akbar Riwanda', '2001-12-25', 'Tegal\r\n', 'Laki-laki', 'Wajah tampak pucat, Kulit wajah atau tubuh tampak kemerahan., Kulit terasa dingin pada ekstremitas, Gatal terutama setelah mandi air hangat (Pruritus), Gangguan penglihatan seperti pandangan kabur.', 'Polisitemia', 100.00, '2024-12-31 16:49:01', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[16.67,0,0,35.29,52.94,31.25,0,0,54.55,100,0,0,0,0,27.27,31.25,0,0,42.86,44.44,0,0,0,42.86,50,0,0,0,38.46,38.46]', 'pending'),
(586, 52, 'Akbar Riwanda', '2001-12-25', 'Tegal\r\n', 'Laki-laki', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Tubuh mudah mengalami infeksi, Timbul patah tulang tanpa sebab (Fraktur Patologis), Perut terlihat lebih buncit', 'Thalassemia Intermedia', 100.00, '2024-12-31 16:51:40', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[16.67,61.54,38.46,0,0,31.25,100,55.56,0,0,0,23.08,0,0,0,31.25,72.22,41.67,0,0,0,68.75,50,0,0,0,61.54,55.56,0,0]', 'pending'),
(587, 52, 'Akbar Riwanda', '2001-12-25', 'Tegal\r\n', 'Laki-laki', 'Tubuh mudah merasa lemas/ kelelahan, Sering merasa pusing atau sakit kepala, Sering mengalami mimisan atau perdarahan lainnya.', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2024-12-31 16:52:34', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[0,0,23.08,29.41,29.41,0,0,33.33,45.45,0,0,0,0,45.45,45.45,0,0,25,35.71,55.56,0,0,0,35.71,31.25,0,0,0,38.46,38.46]', 'rejected'),
(588, 52, 'Akbar Riwanda', '2001-12-25', 'Tegal\r\n', 'Laki-laki', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Tubuh mudah merasa lemas/ kelelahan, Sering merasa pusing atau sakit kepala, Sering mengalami mimisan atau perdarahan lainnya.', 'Thalassemia Minor', 88.89, '2024-12-31 16:52:54', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[16.67,19.23,61.54,29.41,29.41,31.25,38.46,88.89,45.45,0,0,0,0,45.45,45.45,31.25,27.78,66.67,35.71,55.56,0,0,50,35.71,31.25,0,0,55.56,38.46,38.46]', 'pending'),
(590, 52, 'Akbar Riwanda', '2001-12-25', 'Tegal\r\n', 'Laki-laki', 'Penonjolan tulang pipi, Wajah dengan dahi menonjol dan hidung datar (Mongoloid), Pembengkakan perut bagian kiri atas / limpa (Splenomegali)', 'Thalassemia Mayor', 92.86, '2024-12-31 16:55:41', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[43.33,0,0,0,0,18.75,0,0,0,0,92.86,0,0,0,0,31.25,0,0,0,0,57.14,0,0,0,0,66.67,0,0,0,0]', 'pending'),
(592, 62, 'Achmad Putra', '2001-11-10', 'Jakarta Barat', 'Laki-laki', 'Wajah tampak pucat, Tubuh mudah merasa lemas/ kelelahan, Sering merasa pusing atau sakit kepala, Sesak nafas dan nyeri dada', 'Anemia ', 100.00, '2024-12-31 17:03:57', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[16.67,0,23.08,76.47,0,31.25,0,33.33,90.91,0,0,0,0,72.73,0,31.25,0,25,71.43,0,0,0,0,92.86,0,0,0,0,100,0]', 'pending'),
(594, 62, 'Achmad Putra', '2001-11-10', 'Jakarta Barat', 'Laki-laki', 'Perawakan badan pendek, Leher Membesar, Perut terlihat lebih buncit, Pembengkakan perut bagian kanan atas / hati (Hepatomegali)', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2024-12-31 17:05:21', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[13.33,30.77,0,0,0,0,0,0,0,0,7.14,61.54,0,0,0,6.25,16.67,0,0,0,21.43,50,0,0,0,8.33,0,0,0,0]', 'pending'),
(595, 62, 'Achmad Putra', '2001-11-10', 'Jakarta Barat', 'Laki-laki', 'Tubuh mudah merasa lemas/ kelelahan, Tubuh mudah mengalami infeksi, Perut terlihat lebih buncit, Pembengkakan perut bagian kanan atas / hati (Hepatomegali)', 'Thalassemia Intermedia', 81.25, '2024-12-31 17:05:35', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[0,50,0,29.41,0,0,38.46,0,45.45,0,0,61.54,0,45.45,0,0,44.44,0,35.71,0,0,81.25,0,35.71,0,0,38.46,0,38.46,0]', 'pending'),
(596, 62, 'Achmad Putra', '2001-11-10', 'Jakarta Barat', 'Laki-laki', 'Gangguan penglihatan seperti pandangan kabur., Tubuh mudah merasa lemas/ kelelahan, Tubuh mudah mengalami infeksi, Sering mengalami mimisan atau perdarahan lainnya.', 'Polisitemia', 88.89, '2024-12-31 17:07:20', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[0,19.23,0,29.41,47.06,0,38.46,0,45.45,33.33,0,0,0,45.45,72.73,0,27.78,0,35.71,88.89,0,31.25,0,35.71,50,0,38.46,0,38.46,38.46]', 'pending'),
(597, 62, 'Achmad Putra', '2001-11-10', 'Jakarta Barat', 'Laki-laki', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Leher Membesar, Pembengkakan perut bagian kiri atas / limpa (Splenomegali)', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2024-12-31 17:08:48', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[36.67,19.23,38.46,0,0,31.25,38.46,55.56,0,0,42.86,0,0,0,0,37.5,27.78,41.67,0,0,35.71,0,50,0,0,8.33,0,55.56,0,0]', 'rejected'),
(598, 62, 'Achmad Putra', '2001-11-10', 'Jakarta Barat', 'Laki-laki', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Perawakan badan pendek, Leher Membesar, Pembengkakan perut bagian kiri atas / limpa (Splenomegali)', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2024-12-31 17:09:11', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[46.67,19.23,38.46,0,0,31.25,38.46,55.56,0,0,42.86,0,0,0,0,37.5,27.78,41.67,0,0,57.14,0,50,0,0,8.33,0,55.56,0,0]', 'pending'),
(599, 62, 'Achmad Putra', '2001-11-10', 'Jakarta Barat', 'Laki-laki', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Perawakan badan pendek, Leher Membesar, Wajah dengan dahi menonjol dan hidung datar (Mongoloid), Pembengkakan perut bagian kiri atas / limpa (Splenomegali)', 'Thalassemia Mayor', 78.57, '2024-12-31 17:09:19', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[56.67,19.23,38.46,0,0,50,38.46,55.56,0,0,64.29,0,0,0,0,37.5,27.78,41.67,0,0,78.57,0,50,0,0,33.33,0,55.56,0,0]', 'pending'),
(600, 58, 'Dinda Meilani', '2005-05-21', 'Jatilawang', 'Perempuan', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Wajah tampak pucat, Kulit wajah atau tubuh tampak kemerahan., Kulit terasa dingin pada ekstremitas', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2025-01-03 07:57:44', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[33.33,19.23,38.46,35.29,29.41,62.5,38.46,55.56,54.55,55.56,0,0,0,0,0,62.5,27.78,41.67,42.86,0,0,0,50,42.86,31.25,0,0,55.56,38.46,38.46]', 'pending'),
(601, 58, 'Dinda Meilani', '2005-05-21', 'Jatilawang', 'Perempuan', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Wajah tampak pucat, Kulit wajah atau tubuh tampak kemerahan., Kulit terasa dingin pada ekstremitas', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2025-01-06 05:39:52', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[33.33,19.23,38.46,35.29,29.41,62.5,38.46,55.56,54.55,55.56,0,0,0,0,0,62.5,27.78,41.67,42.86,0,0,0,50,42.86,31.25,0,0,55.56,38.46,38.46]', 'pending'),
(602, 58, 'Dinda Meilani', '2005-05-21', 'Jatilawang', 'Perempuan', 'Timbul patah tulang tanpa sebab (Fraktur Patologis), Leher Membesar, Penonjolan tulang pipi, Wajah dengan dahi menonjol dan hidung datar (Mongoloid), Perut terlihat lebih buncit', 'Thalassemia Mayor', 75.00, '2025-01-06 05:42:51', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[30,23.08,0,0,0,18.75,23.08,0,0,0,64.29,23.08,0,0,0,37.5,16.67,0,0,0,21.43,37.5,0,0,0,75,23.08,0,0,0]', 'pending'),
(603, 58, 'Dinda Meilani', '2005-05-21', 'Jatilawang', 'Perempuan', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Wajah tampak pucat, Berkurangnya nafsu makan, Perut terlihat lebih buncit', 'Thalassemia Minor', 88.89, '2025-01-06 06:12:32', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[33.33,30.77,61.54,29.41,0,62.5,38.46,55.56,45.45,0,0,23.08,60,0,0,62.5,44.44,66.67,35.71,0,0,18.75,80,35.71,0,0,0,88.89,38.46,0]', 'pending'),
(604, 58, 'Dinda Meilani', '2005-05-21', 'Jatilawang', 'Perempuan', 'Wajah tampak pucat, Kulit terasa dingin pada ekstremitas, Warna kulit menjadi gelap atau kebiruan (Pigmentasi), Tubuh mudah merasa lemas/ kelelahan, Sering merasa pusing atau sakit kepala', 'Anemia ', 100.00, '2025-01-06 06:13:16', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[26.67,0,23.08,64.71,0,50,0,33.33,100,0,0,0,0,45.45,0,31.25,0,25,78.57,0,21.43,0,0,78.57,0,25,0,0,76.92,0]', 'pending'),
(605, 58, 'Dinda Meilani', '2005-05-21', 'Jatilawang', 'Perempuan', 'Wajah tampak pucat, Kulit wajah atau tubuh tampak kemerahan., Kulit terasa dingin pada ekstremitas, Gatal terutama setelah mandi air hangat (Pruritus), Gangguan penglihatan seperti pandangan kabur.', 'Polisitemia', 100.00, '2025-01-06 06:13:58', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[16.67,0,0,35.29,52.94,31.25,0,0,54.55,100,0,0,0,0,27.27,31.25,0,0,42.86,44.44,0,0,0,42.86,50,0,0,0,38.46,38.46]', 'pending'),
(606, 58, 'Dinda Meilani', '2005-05-21', 'Jatilawang', 'Perempuan', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Tubuh mudah mengalami infeksi, Timbul patah tulang tanpa sebab (Fraktur Patologis), Perut terlihat lebih buncit', 'Thalassemia Intermedia', 100.00, '2025-01-06 06:15:00', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[16.67,61.54,38.46,0,0,31.25,100,55.56,0,0,0,23.08,0,0,0,31.25,72.22,41.67,0,0,0,68.75,50,0,0,0,61.54,55.56,0,0]', 'pending'),
(607, 58, 'Dinda Meilani', '2005-05-21', 'Jatilawang', 'Perempuan', 'Ada riwayat keluarga yang mengalami penyakit thalassemia, Kulit wajah atau tubuh tampak kemerahan., Kulit terasa dingin pada ekstremitas', 'Tidak Teridentifikasi Penyakit Thalassemia', NULL, '2025-01-06 06:15:46', '[\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\",\"Thalassemia Mayor\",\"Thalassemia Intermedia\",\"Thalassemia Minor\",\"Anemia \",\"Polisitemia\"]', '[16.67,19.23,38.46,5.88,29.41,31.25,38.46,55.56,9.09,55.56,0,0,0,0,0,31.25,27.78,41.67,7.14,0,0,0,50,7.14,31.25,0,0,55.56,0,38.46]', 'pending');

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
(275, 38, 'G031,G032,G033'),
(276, 38, 'G001,G034,G043'),
(277, 62, 'G003,G004,G007'),
(278, 62, 'G001,G002,G003,G004'),
(279, 52, 'G001,G002,G003,G004'),
(280, 52, 'G001,G002,G003,G004'),
(281, 52, 'G001,G002,G003,G041'),
(282, 52, 'G001,G002,G003,G004,G005,G039,G040,G041,G042,G043'),
(283, 52, 'G001,G002,G003'),
(284, 52, 'G001,G002,G003'),
(285, 52, 'G001,G002,G003,G040,G041,G042,G043'),
(286, 52, 'G001,G002,G005,G006,G007,G009,G043'),
(287, 52, 'G001,G002,G009'),
(288, 52, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G043'),
(289, 52, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G043'),
(290, 52, 'G001,G002,G003,G004,G007'),
(291, 52, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G043'),
(292, 52, 'G041,G042,G043'),
(293, 52, 'G001,G002,G003,G004,G005,G006,G007,G008,G009,G043'),
(294, 58, 'G001,G002,G003,G004'),
(295, 58, 'G001,G002,G003,G004'),
(296, 58, 'G008,G009,G010'),
(297, 58, 'G008,G009,G010'),
(298, 58, 'G004,G007,G008,G012,G013,G015'),
(299, 52, 'G019,G020,G021,G022'),
(300, 52, 'G001,G002,G003,G004'),
(301, 52, 'G009,G010,G011'),
(302, 52, 'G001,G002,G003,G013,G017,G026'),
(303, 52, 'G001,G002,G005'),
(304, 52, 'G001,G002,G003,G004'),
(305, 52, 'G002,G003,G004,G006,G007'),
(306, 66, 'G002,G004,G005,G008,G010'),
(307, 66, 'G001,G002,G011,G024'),
(308, 66, 'G001,G002,G011,G024'),
(309, 66, 'G001,G002,G011,G024'),
(310, 66, 'G001,G002,G003'),
(311, 52, 'G002,G003,G004,G006,G007'),
(312, 52, 'G001,G009,G018,G024'),
(313, 52, 'G008,G010,G015'),
(314, 52, 'G001,G008,G010,G015'),
(315, 52, 'G022,G023,G026'),
(316, 52, 'G022,G023,G026'),
(317, 62, 'G011,G012,G014'),
(318, 62, 'G002,G008,G010,G014'),
(319, 62, 'G002,G008,G010,G014'),
(320, 62, 'G020,G021,G024,G025'),
(321, 62, 'G008,G009,G024,G025'),
(322, 62, 'G007,G008,G009,G015'),
(323, 62, 'G001,G021,G026'),
(324, 62, 'G001,G020,G021,G026'),
(325, 62, 'G001,G020,G021,G023,G026'),
(326, 58, 'G001,G002,G003,G004'),
(327, 58, 'G001,G002,G003,G004'),
(328, 58, 'G018,G021,G022,G023,G024'),
(329, 58, 'G001,G002,G011,G024'),
(330, 58, 'G002,G004,G005,G008,G010'),
(331, 58, 'G002,G003,G004,G006,G007'),
(332, 58, 'G001,G009,G018,G024'),
(333, 58, 'G001,G003,G004');

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
('P001', 'Thalassemia Mayor', 'Thlassemia merupakan kelainan yang diwarisan (inherited) dan masuk ke dalam kelompok hemoglobinopati, yakni kelainan yang disebabkan oleh gangguan sintesis hemoglobin akibat mutasi di dalam atau dekat gen globin. Sehingga menggakibatkan sel  hemoglobinopati mudah rusak. Thalassemia mayor adalah bentuk thalassemia yang paling parah', 'Segera konsultasikan ke dokter spesialis hematologi untuk pengelolaan penyakit. Rutin melakukan transfusi darah sesuai jadwal yang ditentukan oleh dokter. Diskusikan mengenai terapi kelasi besi untuk mengurangi kadar zat besi berlebih akibat transfusi darah.', 'mayor.jpg'),
('P002', 'Thalassemia Intermedia', 'Thlassemia merupakan kelainan yang diwarisan (inherited) dan masuk ke dalam kelompok hemoglobinopati, yakni kelainan yang disebabkan oleh gangguan sintesis hemoglobin akibat mutasi di dalam atau dekat gen globin. Sehingga menggakibatkan sel  hemoglobinopati mudah rusak. Thalassemia intermedia merupakan bentuk yang lebih ringan daripada thalassemia mayor, tetapi lebih parah dibandingkan thalassemia minor. ', 'Segera konsultasikan ke dokter spesialis hemato-onkologi untuk memastikan hasil deteksi penyakit anda. Lakukan pengelolaan penyakit sesuai saran dokter seperti transfusi darah rutin,  Tingkatkan pola makan dengan gizi seimbang, terutama yang kaya zat besi, folat, dan vitamin B12.', 'intermedia.jpg'),
('P003', 'Thalassemia Minor', 'Thalassemia minor adalah bentuk ringan dari thalassemia yang terjadi ketika seseorang mewarisi satu gen thalassemia dari salah satu orangtua. Penderita thalassemia minor biasanya tidak menunjukkan gejala yang serius dan tidak memerlukan pengobatan khusus. Kadar hemoglobin penderika sedikit lebih rendah dibandingkan dengan individu normal, tetapi masih tetap dapat menjalani kehidupan sehari-hari tanpa masalah kesehatan yang signifikan', ' Segera konsultasikan ke dokter spesialis hemato-onkologi untuk memastikan hasil deteksi penyakit anda, Penderita thalassemia minor disarankan melakukan pemeriksaan genetik jika berencana menikah untuk mencegah kelahiran anak dengan kondisi yang lebih parah.', 'minor.jpg'),
('P004', 'Anemia ', 'Anemia adalah kondisi medis di mana tubuh memiliki jumlah sel darah merah (eritrosit) atau kadar hemoglobin yang lebih rendah dari normal. Hemoglobin adalah protein dalam sel darah merah yang bertugas mengangkut oksigen dari paru-paru ke seluruh tubuh. Ketika kadar hemoglobin rendah, organ dan jaringan tubuh tidak mendapatkan oksigen yang cukup untuk berfungsi dengan baik.', 'Segera konsultasikan ke dokter, Konsumsi makanan kaya nutrisi (zat besi, vitamin B12, dan asam folat), Hindari paparan bahan kimia berbahaya, Lakukan pemeriksaan rutin kadar hemoglobin untuk mendeteksi anemia kondisi sejak dini.', 'anemia.jpg'),
('P005', 'Polisitemia', 'Kelebihan Sel Darah Merah atau polisitemia adalah kondisi di mana jumlah sel darah merah (eritrosit) dalam darah meningkat melebihi batas normal. Sel darah merah bertugas membawa oksigen dari paru-paru ke seluruh tubuh dan membawa karbon dioksida kembali ke paru-paru untuk dikeluarkan. Namun, ketika jumlahnya berlebihan, hal ini dapat menyebabkan masalah kesehatan.', 'Sekera konsultasi ke dokter spesialis hemato-onkologi, Berhenti merokok dan hindari polusi udara, Terapkan pola hidup sehat seperti rajin berolahraga dan jaga pola makan. Lakukan kontrol kesehatan rutin jika memiliki faktor risiko, seperti penyakit jantung atau paru-paru.', 'polisitemisaKlikDokterjpg.jpg');

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
(38, 'Muhammad', 'muhammad@gmail.com', '$2y$10$s/PKOHGER0n7W.C7LYpH4.44.A1gdnxOPGTWgo6UTBq6c6a4zerwe', '2024-11-19 10:36:15', 1, '2024-11-19', 'Laki-laki', 'Bandung Barat\r\n\r\n\r\n\r\n'),
(41, 'Dina', 'dina@gmail.com', '$2y$10$onNeiTu2Y3NxH6kKEJsHXee.dcZBIzsSjbdVtm8piu/KgWt2Cubxm', '2024-11-28 07:42:12', 0, '2024-11-28', 'Laki-laki', 'Cilacap'),
(43, 'Sinta', 'sinta@gmail.com', '$2y$10$.VW.VjtgNnzLvKxuLM4eI.Tn1VjgSNSegTsQX.B6JLBxKV3gTDmqO', '2024-11-28 12:24:20', 0, '2024-11-28', 'Laki-laki', 'Semarang Kota\r\n'),
(49, 'Dinda', 'dinda@gmailcom', '$2y$10$/iGg3RMNXNJhuEHRfgtGGOsaZ8sSd2shxl9/IMu2ByMW2gwsK23qG', '2024-11-28 15:37:02', 0, '2024-11-28', 'Perempuan', 'Purwokerto'),
(50, 'Amanda', 'Amanda@gmail.com', '$2y$10$gm2xLzI4BPTnhMen479Shux.BHH/7tYmf265/I5Kvqiro.cSOM3he', '2024-12-03 04:05:48', 0, '2024-12-03', 'Perempuan', 'Wangon'),
(51, 'Diva Naya', 'ana@gmail.com', '$2y$10$bEe/yxQGqk01DEwWHin6cOa2lTipfs3OR87YdNjTlg2sDllBYIWrO', '2024-12-05 19:22:29', 0, '2012-09-18', 'Perempuan', 'Wangon'),
(52, 'Akbar Riwanda', 'akbar@gmail.com', '$2y$10$aYJnFNcz6nBGqbo.DOO4suGZacV3VyNg/Gd.5/4lUetTqWXeCd6TW', '2024-12-05 19:28:49', 0, '2001-12-25', 'Laki-laki', 'Tegal\r\n'),
(53, 'Zaky Nirwanda', 'zaky@gmail.com', '$2y$10$k7dscKb74iZw9ysVvwQOCuDQMZpKlebWSbMsNfBzOZ471QiLZfaj2', '2024-12-05 19:32:14', 0, '2003-05-23', 'Laki-laki', 'Baturaden\r\n'),
(54, 'Kanza Syahda', 'kan@gmail.com', '$2y$10$Le0b/vxmuitgx70y3vrTg.RCxc7zLjZp3radIChpLVqERHkXN.NmK', '2024-12-05 19:46:34', 0, '2010-06-28', 'Perempuan', 'Wangon\r\n'),
(58, 'Dinda Meilani', 'dinda@gmail.com', '$2y$10$4E2XhSK781HYHDfmJkW5GeR8mUsvsQBGb/5Yu8s8boHzv2CwJbCiG', '2024-12-07 07:36:10', 0, '2005-05-21', 'Perempuan', 'Jatilawang'),
(61, 'Yasmin Intan Putri', 'yasmin@gmail.com', '$2y$10$Nx3ACR7xu.o2US6FQ2ShiuRwTItsl31feoswSFCa0E9PeRu21rG/G', '2024-12-07 15:59:40', 0, '2003-10-22', 'Perempuan', 'Brebes\r\n'),
(62, 'Achmad Putra', 'achmad@gmail.com', '$2y$10$6wU4/OK5EVbNJcxcJBb8w.KP.FbXay1.Hw8bgp0f.kB8yUr7J6FHS', '2024-12-19 10:00:24', 0, '2001-11-10', 'Laki-laki', 'Jakarta Barat'),
(63, 'Rahma Setiani', 'rahmasetiani@gmail.com', '$2y$10$gIMFRiqwJLWZDxpjXhGKueZOde2A9gbTZj9Pvju53v.34s2Anz.Se', '2024-12-24 04:12:47', 1, '2003-08-20', 'Perempuan', 'Jatilawang'),
(65, 'Ns. Rozali Arsyad Kurniawan, S.Kep., M.Kep', 'ramaurialee@gmail.com', '$2y$10$yW8gvPjTI4J7y2FWqhnrwuLyCvedy3.8xfBkoAelFIPWFEyLqOa/a', '2024-12-30 07:02:05', 2, '1982-04-24', 'Laki-laki', 'Wangon'),
(66, 'Rahma Setiani', 'rahmasetiani200@gmail.com', '$2y$10$QtSOMQmOZHzT1sfGdyhxy.WXNtsP.ftWtX/ayhpteoq41DWK3fWdW', '2024-12-31 03:58:14', 0, '2003-08-20', 'Perempuan', 'Jatilawang\r\n');

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
  MODIFY `idhasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=608;

--
-- AUTO_INCREMENT for table `pasien_gejala`
--
ALTER TABLE `pasien_gejala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=334;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

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
