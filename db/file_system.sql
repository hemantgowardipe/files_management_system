-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2025 at 07:37 AM
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
-- Database: `file_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `recently_deleted`
--

CREATE TABLE `recently_deleted` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('folder','video','image') NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recently_deleted`
--

INSERT INTO `recently_deleted` (`id`, `user_id`, `file_name`, `file_path`, `file_type`, `deleted_at`) VALUES
(4, 15, 'Screenshot 2025-03-05 235609.png', 'uploads/1741846499_Screenshot 2025-03-05 235609.png', 'image', '2025-03-13 06:27:04'),
(5, 15, 'ps_2 practicle 7.pdf', 'uploads/1741847413_ps_2 practicle 7.pdf', 'video', '2025-03-13 06:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `date`, `name`, `mobile`, `email`, `photo`, `pass`, `status`) VALUES
(1, '2025-02-19', 'Hemant Gowardipe', '9881976415', 'rajugowardipe0@gmail.com', 'profile_1741799968.png', 'hemant@2005', 'Active'),
(15, '2025-02-26', 'Geeta Gowardipe ', '09881976415', 'rajugowardipe94@gmail.com', 'profile_1740571994.jpg', 'raju@134', 'Active'),
(16, '2025-03-03', 'Akanksha Gowardipe ', '9923190543', 'geetagowardipe@gmail.com', 'profile_1741011920.jpg', 'akanksha@2011', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('folder','video','image') NOT NULL,
  `file_size` int(11) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `shareable_link` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `user_id`, `file_name`, `file_path`, `file_type`, `file_size`, `upload_time`, `uploaded_at`, `shareable_link`, `deleted_at`) VALUES
(1, 1, 'IMG_20240130_161923_239.jpg', 'uploads/1739953965_IMG_20240130_161923_239.jpg', 'image', 5838749, '2025-02-19 08:32:45', '2025-02-19 09:20:09', NULL, NULL),
(2, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954110_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:10', '2025-02-19 09:20:09', NULL, NULL),
(3, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954116_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:16', '2025-02-19 09:20:09', NULL, NULL),
(4, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954140_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:40', '2025-02-19 09:20:09', NULL, NULL),
(5, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954147_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:47', '2025-02-19 09:20:09', NULL, NULL),
(6, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954192_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:36:32', '2025-02-19 09:20:09', NULL, NULL),
(7, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954229_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:37:09', '2025-02-19 09:20:09', NULL, NULL),
(8, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954260_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:37:40', '2025-02-19 09:20:09', NULL, NULL),
(10, 1, 'Screen Recording 2025-02-19 140933.mp4', 'uploads/1739954384_Screen Recording 2025-02-19 140933.mp4', 'video', 16915255, '2025-02-19 08:39:44', '2025-02-19 09:20:09', NULL, NULL),
(11, 1, 'IMG_20250131_155750.jpg', 'uploads/1739958691_IMG_20250131_155750.jpg', 'image', 22790412, '2025-02-19 09:51:31', '2025-02-19 09:51:31', NULL, NULL),
(12, 1, 'DSA PLan.pdf', 'uploads/1739971933_DSA PLan.pdf', 'folder', 29706, '2025-02-19 13:32:13', '2025-02-19 13:32:13', NULL, NULL),
(13, 1, 'Chhatrapati-Shivaji-Maharaj-The-Fearless-Warrior-Status-Videos.mp4', 'uploads/1739972185_Chhatrapati-Shivaji-Maharaj-The-Fearless-Warrior-Status-Videos.mp4', 'video', 7143580, '2025-02-19 13:36:25', '2025-02-19 13:36:25', NULL, NULL),
(14, 1, '10th Marksheet.pdf', 'uploads/1740118818_10th Marksheet.pdf', 'folder', 178900, '2025-02-21 06:20:18', '2025-02-21 06:20:18', NULL, NULL),
(15, 1, 'car', 'uploads/1740563588_car_drift.mp4', 'video', 13634329, '2025-02-26 09:53:08', '2025-02-26 09:53:08', NULL, NULL),
(16, 1, 'IMG_20250131_155806.jpg', 'uploads/1740564348_IMG_20250131_155806.jpg', 'image', 163342, '2025-02-26 10:05:48', '2025-02-26 10:05:48', NULL, NULL),
(20, 1, 'gitprofile.jpg', 'uploads/1740838034_gitprofile.jpg', 'image', 1615855, '2025-03-01 14:07:14', '2025-03-01 14:07:14', NULL, NULL),
(22, 1, 'gitprofile (1).jpg', 'uploads/1740852589_gitprofile (1).jpg', 'image', 430051, '2025-03-01 18:09:49', '2025-03-01 18:09:49', NULL, NULL),
(23, 1, '20240130_162012.jpg', 'uploads/1740907444_20240130_162012.jpg', 'image', 5932064, '2025-03-02 09:25:37', '2025-03-02 09:25:37', NULL, NULL),
(31, 15, 'Screenshot 2025-03-05 235203.png', 'uploads/1741845063_Screenshot 2025-03-05 235203.png', 'image', 0, '2025-03-13 06:20:14', '2025-03-13 06:20:14', NULL, NULL),
(32, 15, 'Frontend_Performance report.pdf', 'uploads/1741847214_Frontend_Performance report.pdf', 'video', 258236, '2025-03-13 06:26:54', '2025-03-13 06:26:54', NULL, NULL),
(33, 15, 'RTFMS_System_Architecture.png', 'uploads/1741847354_RTFMS_System_Architecture.png', 'folder', 400735, '2025-03-13 06:29:14', '2025-03-13 06:29:14', NULL, NULL),
(34, 15, 'Voiceover_Script.pdf', 'uploads/1741847386_Voiceover_Script.pdf', 'folder', 21033, '2025-03-13 06:29:46', '2025-03-13 06:29:46', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `user_id`, `login_time`, `logout_time`, `duration`) VALUES
(2, 1, '2025-03-02 12:17:05', '2025-03-02 12:17:34', 29),
(3, 1, '2025-03-02 12:26:28', '2025-03-02 12:27:24', 56),
(4, 1, '2025-03-02 12:30:48', '2025-03-02 12:35:22', 274),
(5, 15, '2025-03-02 12:43:45', '2025-03-02 12:44:57', 72),
(6, 15, '2025-03-02 12:56:31', '2025-03-02 13:04:33', 482),
(7, 1, '2025-03-02 14:30:27', NULL, 0),
(8, 1, '2025-03-02 14:58:27', '2025-03-02 15:47:33', 2946),
(9, 16, '2025-03-03 19:56:00', '2025-03-03 19:56:58', 58),
(10, 1, '2025-03-03 19:58:07', '2025-03-03 20:03:37', 330),
(11, 1, '2025-03-03 20:32:31', '2025-03-03 20:35:22', 171),
(12, 1, '2025-03-12 22:38:54', NULL, 0),
(13, 15, '2025-03-13 11:07:01', '2025-03-13 12:01:09', 3248);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recently_deleted`
--
ALTER TABLE `recently_deleted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recently_deleted`
--
ALTER TABLE `recently_deleted`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
