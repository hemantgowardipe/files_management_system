-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2025 at 07:34 PM
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
(1, '2025-02-19', 'Hemant Gowardipe', '9881976415', 'rajugowardipe0@gmail.com', 'IMG_20250131_155750.jpg', 'hemant@2005', 'Active'),
(2, '2025-02-20', 'Akanksha Gowardipe', '9923190543', 'rajugowardipe94@gmail.com', 'IMG-20240130-WA0106.jpg', 'akanksha@31', 'Active'),
(4, '2025-02-21', 'hemant Gowardipe', '09881976415', 'rajugowardipe0@gmail.com', '20240130_164025.jpg', 'hemant@21', 'Active');

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
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `user_id`, `file_name`, `file_path`, `file_type`, `file_size`, `upload_time`, `uploaded_at`) VALUES
(1, 1, 'IMG_20240130_161923_239.jpg', 'uploads/1739953965_IMG_20240130_161923_239.jpg', 'image', 5838749, '2025-02-19 08:32:45', '2025-02-19 09:20:09'),
(3, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954110_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:10', '2025-02-19 09:20:09'),
(4, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954116_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:16', '2025-02-19 09:20:09'),
(5, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954140_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:40', '2025-02-19 09:20:09'),
(6, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954147_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:35:47', '2025-02-19 09:20:09'),
(7, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954192_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:36:32', '2025-02-19 09:20:09'),
(8, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954229_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:37:09', '2025-02-19 09:20:09'),
(9, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954260_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:37:40', '2025-02-19 09:20:09'),
(10, 1, 'Round-1ProblemStatements.pdf', 'uploads/1739954267_Round-1ProblemStatements.pdf', 'folder', 53054, '2025-02-19 08:37:47', '2025-02-19 09:20:09'),
(11, 1, 'Screen Recording 2025-02-19 140933.mp4', 'uploads/1739954384_Screen Recording 2025-02-19 140933.mp4', 'video', 16915255, '2025-02-19 08:39:44', '2025-02-19 09:20:09'),
(12, 1, 'Screen Recording 2025-02-19 140933.mp4', 'uploads/1739958628_Screen Recording 2025-02-19 140933.mp4', 'video', 16915255, '2025-02-19 09:50:28', '2025-02-19 09:50:28'),
(13, 1, 'Screen Recording 2025-02-19 140933.mp4', 'uploads/1739958681_Screen Recording 2025-02-19 140933.mp4', 'video', 16915255, '2025-02-19 09:51:21', '2025-02-19 09:51:21'),
(14, 1, 'IMG_20250131_155750.jpg', 'uploads/1739958691_IMG_20250131_155750.jpg', 'image', 22790412, '2025-02-19 09:51:31', '2025-02-19 09:51:31'),
(15, 1, 'DSA PLan.pdf', 'uploads/1739971933_DSA PLan.pdf', 'folder', 29706, '2025-02-19 13:32:13', '2025-02-19 13:32:13'),
(17, 1, 'Chhatrapati-Shivaji-Maharaj-The-Fearless-Warrior-Status-Videos.mp4', 'uploads/1739972185_Chhatrapati-Shivaji-Maharaj-The-Fearless-Warrior-Status-Videos.mp4', 'video', 7143580, '2025-02-19 13:36:25', '2025-02-19 13:36:25'),
(18, 2, 'IMG-20240130-WA0151.jpg', 'uploads/1740078795_IMG-20240130-WA0151.jpg', 'image', 149180, '2025-02-20 19:13:15', '2025-02-20 19:13:15'),
(19, 2, 'IMG_20240130_161923_239.jpg', 'uploads/1740078802_IMG_20240130_161923_239.jpg', 'image', 5838749, '2025-02-20 19:13:22', '2025-02-20 19:13:22'),
(20, 2, 'HemantGowardipe Resume.pdf', 'uploads/1740078834_HemantGowardipe Resume.pdf', 'folder', 158363, '2025-02-20 19:13:54', '2025-02-20 19:13:54'),
(21, 2, '12th Marksheet.pdf', 'uploads/1740079567_12th Marksheet.pdf', 'folder', 186388, '2025-02-20 19:26:07', '2025-02-20 19:26:07'),
(22, 2, 'Hemant_Gowardipe_-_Wed_Developer.pdf', 'uploads/1740079845_Hemant_Gowardipe_-_Wed_Developer.pdf', 'folder', 156400, '2025-02-20 19:30:45', '2025-02-20 19:30:45'),
(23, 1, '10th Marksheet.pdf', 'uploads/1740118818_10th Marksheet.pdf', 'folder', 178900, '2025-02-21 06:20:18', '2025-02-21 06:20:18'),
(24, 1, '10th Marksheet.pdf', 'uploads/1740118822_10th Marksheet.pdf', 'folder', 178900, '2025-02-21 06:20:22', '2025-02-21 06:20:22');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
