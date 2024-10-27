-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2024 at 10:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
('BK003', 'P001'),
('BK004', 'P001'),
('BK005', 'P001'),
('BK006', 'P001'),
('BK007', 'P001'),
('BK008', 'P001'),
('BK009', 'P001'),
('BK012', 'P001'),
('BK013', 'P001'),
('BK014', 'P001'),
('BK015', 'P001'),
('BK010', 'P005'),
('BK002', 'P007');

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
('BK002', 'G013'),
('BK002', 'G015'),
('BK003', 'G013'),
('BK004', 'G013'),
('BK005', 'G013'),
('BK005', 'G014'),
('BK005', 'G015'),
('BK005', 'G016'),
('BK006', 'G013'),
('BK006', 'G014'),
('BK006', 'G015'),
('BK007', 'G013'),
('BK007', 'G014'),
('BK007', 'G015'),
('BK007', 'G016'),
('BK008', 'G013'),
('BK008', 'G014'),
('BK008', 'G016'),
('BK009', 'G013'),
('BK010', 'G017'),
('BK012', 'G030'),
('BK013', 'G014'),
('BK014', 'G013'),
('BK015', 'G013');

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
('G013', 'Demam', 6),
('G014', 'Batuk Kering', 46),
('G015', 'Sesak Napas', 0),
('G016', 'Nyeri Dada', 0),
('G017', 'Kelelahan', 0),
('G018', 'Sakit Kepala', 0),
('G019', 'Mual', 0),
('G020', 'Muntah', 0),
('G021', 'Diare', 0),
('G022', 'Sakit Perut', 0),
('G023', 'Sakit Tenggorokan', 0),
('G024', 'Bersin', 0),
('G025', 'Pusing', 0),
('G026', 'Kedinginan', 0),
('G027', 'Keringat Berlebih', 0),
('G028', 'Ruam Kulit', 0),
('G029', 'Nyeri Sendi', 0),
('G030', 'Sakit Punggung', 0),
('G031', 'Rasa Tidak Enak di Perut', 0),
('G032', 'Kesulitan Bernafas', 0),
('G033', 'Pingsan', 4),
('G034', 'f', 3),
('G035', 'ddddddddddddddddddddddddddddddddd', 5);

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
('P001', 'Thalassemia baur', 'dd', 'ssssd', 'WhatsApp Image 2024-10-24 at 12.03.52.jpeg'),
('P002', 'Thalassemia ', 's', 's', '../../asset/image/penyakit/Articles - Mindd Foundation.jpg'),
('P004', 'Thalassemia Minor', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', 'Kidney Dialysis Equipment Market Analysis, Size, Trends And Forecast 2019-2027 (1).jpg'),
('P005', 'Anemia', 'rr', 'dd', 'Beta Thalassemia.jpg'),
('P006', 'Thalassemia ssss', 'ddd', 'ddd', 'Articles - Mindd Foundation.jpg'),
('P007', 'Thalassemia Intermedia', 's', 's', 'WhatsApp Image 2024-10-24 at 12.03.52.jpeg');

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
  `role` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `namalengkap`, `email`, `password`, `created_at`, `role`) VALUES
(21, 'rahma setiani', 'dinda@gmail.com', '$2y$10$gAFDNckhyTfHxGOYIVd2LO6xEF4ZbLVRCYwl.qom801ET7oV6e01a', '2024-10-25 09:01:34', 0),
(22, 'ee', 'dscmsdc@dc', '$2y$10$0fjFK3YzK/RnNS0qxsArQOI3th1hljdM4qhQWNYNroo2ku6QKeMEy', '2024-10-25 09:02:45', 0),
(23, 'rahma', '12e@fdv', '$2y$10$G21pAgct3hM/RIdUha3p1eWYLrLC1h/f.5AGU2B8w7/MCAIZW5Z9G', '2024-10-25 09:03:40', 0),
(24, 'Rahma Setiani', 'kanza@gmail.com', '$2y$10$ShWOLxtZI2Guc7c5fglROuvCKhHwZk/ir/IUuEimptQy0WrTgvo9S', '2024-10-25 09:06:26', 1),
(26, 'rahma setiani', 'rahmasetiani200@gmail.com', '$2y$10$t9FG96UPk/UmexunLreKP.Sy15vWpuwzBY02oL.nP0XRCPHCfp9J.', '2024-10-25 14:43:18', 1);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
