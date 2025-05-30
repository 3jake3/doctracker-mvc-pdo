-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 10:03 AM
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
-- Database: `db_doctrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_docs`
--

CREATE TABLE `tb_docs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` enum('Pending','In Review','Approved','Rejected','For Signature','Done','Cancelled') DEFAULT NULL,
  `date_due` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `docpath` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_docs`
--

INSERT INTO `tb_docs` (`id`, `title`, `description`, `file_path`, `status`, `date_due`, `created_at`, `updated_at`, `docpath`, `created_by`) VALUES
(112, 'Title 1', 'Description 1', 'Path 1', 'In Review', '2025-06-02 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(113, 'Title 2', 'Description 2', 'Path 2', 'Approved', '2025-06-03 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(114, 'Title 3', 'Description 3', 'Path 3', 'In Review', '2025-06-04 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(115, 'Title 4', 'Description 4', 'Path 4', 'In Review', '2025-06-05 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(116, 'Title 5', 'Description 5', 'Path 5', 'Pending', '2025-06-06 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(117, 'Title 6', 'Description 6', 'Path 6', 'Rejected', '2025-06-07 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(118, 'Title 7', 'Description 7', 'Path 7', 'In Review', '2025-06-08 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(119, 'Title 8', 'Description 8', 'Path 8', 'Pending', '2025-06-09 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(120, 'Title 9', 'Description 9', 'Path 9', 'In Review', '2025-06-10 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(121, 'Title 10', 'Description 10', 'Path 10', 'In Review', '2025-06-11 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(122, 'Title 11', 'Description 11', 'Path 11', 'Pending', '2025-06-12 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(123, 'Title 12', 'Description 12', 'Path 12', 'Approved', '2025-06-13 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(124, 'Title 13', 'Description 13', 'Path 13', 'In Review', '2025-06-14 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(125, 'Title 14', 'Description 14', 'Path 14', 'In Review', '2025-06-15 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(126, 'Title 15', 'Description 15', 'Path 15', 'Rejected', '2025-06-16 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(127, 'Title 16', 'Description 16', 'Path 16', 'Approved', '2025-06-17 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(128, 'Title 17', 'Description 17', 'Path 17', 'Approved', '2025-06-18 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(129, 'Title 18', 'Description 18', 'Path 18', 'In Review', '2025-06-19 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(130, 'Title 19', 'Description 19', 'Path 19', 'Pending', '2025-06-20 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(131, 'Title 20', 'Description 20', 'Path 20', 'Rejected', '2025-06-21 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(132, 'Title 21', 'Description 21', 'Path 21', 'Pending', '2025-06-22 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(133, 'Title 22', 'Description 22', 'Path 22', 'Approved', '2025-06-23 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(134, 'Title 23', 'Description 23', 'Path 23', 'In Review', '2025-06-24 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(135, 'Title 24', 'Description 24', 'Path 24', 'Rejected', '2025-06-25 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(136, 'Title 25', 'Description 25', 'Path 25', 'Pending', '2025-06-26 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(137, 'Title 26', 'Description 26', 'Path 26', 'In Review', '2025-06-27 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(138, 'Title 27', 'Description 27', 'Path 27', 'In Review', '2025-06-28 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(139, 'Title 28', 'Description 28', 'Path 28', 'In Review', '2025-06-29 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(140, 'Title 29', 'Description 29', 'Path 29', 'Approved', '2025-06-30 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(141, 'Title 30', 'Description 30', 'Path 30', 'Pending', '2025-07-01 10:00:00', '2025-05-27 20:09:21', '2025-05-30 08:03:21', '1748592201_UKT_EP3_April_2_poster.png', NULL),
(142, 'Title 31', 'Description 31', 'Path 31', 'In Review', '2025-07-02 10:00:00', '2025-05-27 20:09:21', '2025-05-27 20:09:21', '', NULL),
(218, 'Ty', 'Yu', 'To Ard', 'For Signature', '2025-05-31 10:51:00', '2025-05-30 02:49:23', '2025-05-30 08:03:13', '1748592193_1748572917_1748506038_FEBRUARY_2025__1_.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'jake', '$2y$10$63FB7Xop9PZUVwuaAjGr4.7McvrvJNOsgOtOuzwbcXSD.y8k3nLl2', 'admin', '2025-05-26 07:57:24'),
(2, 'cage', '$2y$10$63FB7Xop9PZUVwuaAjGr4.7McvrvJNOsgOtOuzwbcXSD.y8k3nLl2', 'staff', '2025-05-26 07:58:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_docs`
--
ALTER TABLE `tb_docs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_docs`
--
ALTER TABLE `tb_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_docs`
--
ALTER TABLE `tb_docs`
  ADD CONSTRAINT `fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
