-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 05:56 PM
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
-- Database: `ramstardb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bus_tracking`
--

CREATE TABLE `bus_tracking` (
  `id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `tracked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deactivated_accounts`
--

CREATE TABLE `deactivated_accounts` (
  `id` int(11) NOT NULL,
  `original_account_number` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `address` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `deactivated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deactivated_accounts`
--

INSERT INTO `deactivated_accounts` (`id`, `original_account_number`, `firstname`, `middlename`, `lastname`, `birthday`, `age`, `gender`, `address`, `balance`, `deactivated_at`) VALUES
(6, '0011768983', 'Archie', 'Diaz', 'Vicente', '2003-06-29', 21, 'Male', 'TAPAT NG TRIPLE GGG GAS STATION', 1000.00, '2024-11-02 13:57:39'),
(7, '0013438657', 'Archie', 'Diaz', 'Vicente', '2003-06-29', 21, 'Male', 'TAPAT NG TRIPLE GGG GAS STATION', 1000.00, '2024-11-02 14:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `journeys`
--

CREATE TABLE `journeys` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `start_latitude` decimal(10,7) NOT NULL,
  `start_longitude` decimal(10,7) NOT NULL,
  `end_latitude` decimal(10,7) DEFAULT NULL,
  `end_longitude` decimal(10,7) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` timestamp NULL DEFAULT NULL,
  `fare_amount` decimal(10,2) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journeys`
--

INSERT INTO `journeys` (`id`, `user_id`, `start_latitude`, `start_longitude`, `end_latitude`, `end_longitude`, `start_time`, `end_time`, `fare_amount`, `is_completed`) VALUES
(3, 92, 15.4296929, 120.9305937, 15.4296929, 120.9305937, '2024-10-28 14:08:08', '2024-10-28 14:08:39', 1.00, 1),
(4, 92, 15.4296929, 120.9305937, 15.4296929, 120.9305937, '2024-10-28 14:09:18', '2024-10-28 14:09:24', 1.00, 1),
(5, 92, 15.4296927, 120.9306012, 15.4296927, 120.9306012, '2024-10-28 14:09:53', '2024-10-28 14:10:14', 1.00, 1),
(6, 92, 15.4296927, 120.9306012, 15.4296927, 120.9306012, '2024-10-28 14:11:41', '2024-10-28 14:12:25', 1.00, 1),
(7, 92, 15.4296927, 120.9306012, 15.4296927, 120.9306012, '2024-10-28 14:13:33', '2024-10-28 14:13:38', 1.00, 1),
(8, 92, 15.4318294, 120.9374221, 15.4318294, 120.9374221, '2024-10-28 14:19:00', '2024-10-28 14:19:11', 1.00, 1),
(9, 109, 15.4225914, 120.9396983, 15.4225914, 120.9396983, '2024-11-04 06:12:20', '2024-11-04 06:12:23', 1.00, 1),
(10, 109, 15.4225914, 120.9396983, 15.4225914, 120.9396983, '2024-11-04 06:12:42', '2024-11-04 06:12:46', 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `revenue`
--

CREATE TABLE `revenue` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('debit','credit') NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `account_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`id`, `user_id`, `amount`, `transaction_type`, `transaction_date`, `account_number`) VALUES
(1, 92, 1000.00, 'debit', '2024-10-28 14:08:39', ''),
(2, 92, 1.00, 'debit', '2024-10-28 14:09:24', ''),
(3, 92, 1.00, 'debit', '2024-10-28 14:10:14', ''),
(4, 92, 1.00, 'debit', '2024-10-28 14:12:25', ''),
(5, 92, 1.00, 'debit', '2024-10-28 14:13:38', ''),
(6, 92, 1.00, 'debit', '2024-10-28 14:19:11', ''),
(7, 109, 1.00, 'debit', '2024-11-04 06:12:23', ''),
(8, 109, 0.00, 'debit', '2024-11-04 06:12:46', '');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_number` varchar(250) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('Load','Deduct') NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `account_number`, `amount`, `transaction_type`, `transaction_date`) VALUES
(1, 92, '0011768983', 1000.00, 'Load', '2024-10-28 14:08:04'),
(2, 108, '0012212828', 500.00, 'Load', '2024-11-04 04:01:42'),
(3, 109, '0006977439', 500.00, 'Load', '2024-11-04 05:45:56'),
(4, 109, '0006977439', 500.00, 'Load', '2024-11-04 06:36:17'),
(5, 109, '0006977439', 20.00, 'Load', '2024-11-04 06:56:31'),
(6, 106, '0012814036', 5.00, 'Load', '2024-11-04 14:40:29'),
(7, 106, '0012814036', 90.00, 'Load', '2024-11-04 14:41:02'),
(8, 106, '0012814036', 5.00, 'Load', '2024-11-04 14:45:24'),
(9, 106, '0012814036', 50.00, 'Load', '2024-11-04 15:35:51'),
(10, 106, '0012814036', 60.00, 'Load', '2024-11-04 15:43:01'),
(11, 0, '0012814036', 60.00, 'Deduct', '2024-11-04 15:49:39'),
(12, 106, '0012814036', 100.00, 'Load', '2024-11-04 15:49:59'),
(13, 106, '0012814036', 50.00, 'Load', '2024-11-04 15:51:27'),
(14, 106, '0012814036', 50.00, 'Load', '2024-11-04 15:51:28'),
(15, 106, '0012814036', 50.00, 'Load', '2024-11-04 15:52:15'),
(16, 106, '0012814036', 50.00, 'Load', '2024-11-04 15:53:47'),
(17, 106, '0012814036', 50.00, 'Load', '2024-11-04 15:53:47'),
(18, 106, '0012814036', 50.00, 'Load', '2024-11-04 15:57:32'),
(19, 106, '0012814036', 50.00, 'Load', '2024-11-04 15:59:00'),
(20, 0, '0012814036', 50.00, 'Deduct', '2024-11-04 15:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `useracc`
--

CREATE TABLE `useracc` (
  `id` int(11) UNSIGNED NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birthday` date NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactnumber` varchar(15) NOT NULL,
  `province` varchar(250) NOT NULL,
  `municipality` varchar(250) NOT NULL,
  `barangay` varchar(250) NOT NULL,
  `address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `role` enum('User','Admin','Cashier') DEFAULT 'User',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_activated` tinyint(1) DEFAULT 0,
  `id_type` varchar(50) NOT NULL,
  `id_file` varchar(255) NOT NULL,
  `points` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useracc`
--

INSERT INTO `useracc` (`id`, `account_number`, `firstname`, `profile_picture`, `lastname`, `middlename`, `suffix`, `birthday`, `age`, `gender`, `email`, `contactnumber`, `province`, `municipality`, `barangay`, `address`, `password`, `balance`, `role`, `created_at`, `is_activated`, `id_type`, `id_file`, `points`) VALUES
(92, '0011768983', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'archiediaz29@gmail.com', '12335654323', '034900000', '34928000', '34928023', 'TAPAT NG TRIPLE GGG GAS STATION', '40362563791c06d521db25d58d066b71', 1000.00, 'User', '2024-10-28 13:34:00', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 50.00),
(94, '0011841717', 'Lyn Marie', NULL, 'Mapoy', 'Lubo', '', '2003-03-01', 21, 'Female', 'lynmariemapoy@gmail.com', '9754681523', '34900000', '34912000', '34912027', '123', '2637a5c30af69a7bad877fdb65fbd78b', 0.00, 'Cashier', '2024-11-02 11:43:27', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(95, '0008303510', 'Gencel Kaye', NULL, 'Beley', 'Muncal', '', '2002-12-06', 21, 'Female', 'gencelbeley06@gmail.com', '98765456789', '34900000', '34928000', '34928027', '123', '04c8873a49fd163df2a074015d3928bd', 0.00, 'User', '2024-11-02 11:55:21', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 0.00),
(105, '0006695015', 'LynMarie', NULL, 'vicente', 'asdasd', 'Jr', '2002-03-03', 22, 'Male', 'jemusu96@gmail.com', '12123121222', '34900000', '34928000', '34928023', 'sadas', '2637a5c30af69a7bad877fdb65fbd78b', 0.00, 'Cashier', '2024-11-02 16:38:44', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(106, '0012814036', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'vicentearchiediaz29@gmail.com', '9755102091', '34900000', '34928000', '34928023', '', '2637a5c30af69a7bad877fdb65fbd78b', 400.00, 'Admin', '2024-11-03 11:46:11', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 28.00),
(107, '0013438657', 'LynMarie', NULL, 'Mapoy', 'Lubo', '', '2003-03-01', 21, 'Female', 'lynmariemapoy7@gmail.com', '91234567899', '34900000', '34912000', '34912027', '', 'ab974df2ea1472c3cbdc1fafe76bea88', 0.00, 'Cashier', '2024-11-03 12:41:29', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(108, '0012212828', 'Diana Rose', NULL, 'Maglalang', 'Rufino', '', '2002-10-18', 22, 'Female', 'dianarosemaglalang25@gmail.com', '12345678999', '34900000', '34928000', '34928002', '131', '852a9d7fdbbe6c9597b3d925b21353d9', 500.00, 'User', '2024-11-04 03:33:48', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 25.00),
(109, '0006977439', 'Carl Justin', NULL, 'Velasco', 'De lara', '', '2002-03-16', 22, 'Male', 'carljustindlvelasco@gmail.com', '12345678987', '34900000', '34928000', '34928002', '', '51a2981bc0ebfb859f60266fb615327d', 1069.00, 'User', '2024-11-04 05:43:03', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 1.00),
(110, '0006863857', 'Alexa', NULL, 'Lavesores', 'asd', '', '2002-06-10', 22, 'Female', 'aisharicaalexalavesores@gmail.com', '12345678976', '37700000', '37701000', '37701010', '123', '022f5965aac6fa9ef0e89cfffdbdb1b8', 0.00, 'User', '2024-11-04 05:49:08', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `user_deactivation_history`
--

CREATE TABLE `user_deactivation_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT NULL,
  `deactivation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bus_tracking`
--
ALTER TABLE `bus_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deactivated_accounts`
--
ALTER TABLE `deactivated_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journeys`
--
ALTER TABLE `journeys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `revenue`
--
ALTER TABLE `revenue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `account_number` (`account_number`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `useracc`
--
ALTER TABLE `useracc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `account_number` (`account_number`);

--
-- Indexes for table `user_deactivation_history`
--
ALTER TABLE `user_deactivation_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bus_tracking`
--
ALTER TABLE `bus_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deactivated_accounts`
--
ALTER TABLE `deactivated_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `journeys`
--
ALTER TABLE `journeys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `useracc`
--
ALTER TABLE `useracc`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `user_deactivation_history`
--
ALTER TABLE `user_deactivation_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `journeys`
--
ALTER TABLE `journeys`
  ADD CONSTRAINT `journeys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useracc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `revenue`
--
ALTER TABLE `revenue`
  ADD CONSTRAINT `revenue_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useracc` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
