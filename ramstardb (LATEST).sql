-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 03:18 AM
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
(18, '0011768983', 'Archie', 'Diaz', 'Vicente', '2003-06-29', 21, 'Male', 'TAPAT NG TRIPLE GGG GAS STATION', 1000.00, '2024-11-06 15:00:45'),
(20, '0012212828', 'Diana Rose', 'Rufino', 'Maglalang', '2002-10-18', 22, 'Female', '131', 500.00, '2024-11-06 15:41:28'),
(21, '0006695015', 'Diana Rose', 'Rufino', 'Maglalang', '2002-10-18', 22, 'Female', '131', 500.00, '2024-11-06 15:42:47');

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
(10, 109, 15.4225914, 120.9396983, 15.4225914, 120.9396983, '2024-11-04 06:12:42', '2024-11-04 06:12:46', 0.00, 1),
(11, 109, 15.4229690, 120.9389910, 15.4229690, 120.9389910, '2024-11-05 08:10:38', '2024-11-05 08:11:14', 1.00, 1),
(12, 109, 15.4228790, 120.9391570, 15.4228820, 120.9390820, '2024-11-05 08:11:38', '2024-11-05 08:13:54', 4.03, 1),
(13, 109, 15.4228820, 120.9390820, 15.4228820, 120.9390820, '2024-11-05 08:14:01', '2024-11-05 08:14:05', 1.00, 1),
(14, 109, 15.4228820, 120.9390820, 15.4228820, 120.9390820, '2024-11-05 08:15:17', '2024-11-05 08:15:42', 1.00, 1),
(15, 109, 15.4228870, 120.9391020, 15.4228870, 120.9391020, '2024-11-05 08:17:15', '2024-11-05 08:17:31', 1.00, 1),
(16, 109, 15.4228870, 120.9391020, 15.4226008, 120.9396181, '2024-11-05 08:17:53', '2024-11-05 08:18:23', 31.92, 1),
(17, 109, 15.4228870, 120.9391020, 15.4226008, 120.9396181, '2024-11-05 08:18:33', '2024-11-05 08:18:39', 31.92, 1),
(18, 109, 15.4226008, 120.9396181, 15.4228820, 120.9390820, '2024-11-05 08:18:58', '2024-11-05 08:19:10', 32.72, 1),
(19, 109, 15.4225817, 120.9396344, 15.4225817, 120.9396344, '2024-11-05 08:26:37', '2024-11-05 08:27:25', 1.00, 1),
(20, 109, 15.4225817, 120.9396344, 15.4225817, 120.9396344, '2024-11-05 08:27:28', '2024-11-05 08:27:49', 1.00, 1),
(21, 109, 15.4225817, 120.9396344, 15.4225817, 120.9396344, '2024-11-05 08:28:11', '2024-11-05 08:28:23', 1.00, 1),
(23, 109, 15.4226317, 120.9396955, 15.4226317, 120.9396955, '2024-11-05 08:30:00', '2024-11-05 08:30:14', 1.00, 1),
(24, 109, 15.4226317, 120.9396955, 15.4226081, 120.9396725, '2024-11-05 08:30:19', '2024-11-05 08:31:07', 1.81, 1),
(25, 109, 15.4226081, 120.9396725, 15.4226081, 120.9396725, '2024-11-05 08:31:14', '2024-11-05 08:33:40', 1.00, 1),
(26, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:39:09', '2024-11-05 08:39:12', 1.00, 1),
(27, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:40:33', '2024-11-05 08:40:49', 1.00, 1),
(28, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:43:23', '2024-11-05 08:46:37', 1.00, 1),
(29, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:53:55', '2024-11-05 08:53:59', 1.00, 1),
(30, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:54:23', '2024-11-05 08:55:04', 1.00, 1),
(31, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:55:14', '2024-11-05 08:55:18', 1.00, 1),
(32, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:55:22', '2024-11-05 08:55:24', 1.00, 1),
(33, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:55:25', '2024-11-05 08:55:26', 1.00, 1),
(34, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:55:30', '2024-11-05 08:55:32', 1.00, 1),
(35, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-05 08:55:38', '2024-11-05 08:55:41', 1.00, 1),
(36, 109, 15.4908000, 120.9693000, 15.4908000, 120.9693000, '2024-11-05 08:56:18', '2024-11-05 08:56:31', 1.00, 1),
(37, 109, 15.4908000, 120.9693000, 15.4908000, 120.9693000, '2024-11-05 08:57:05', '2024-11-05 08:57:20', 1.00, 1),
(38, 109, 15.4345355, 120.8836751, 15.4345435, 120.8836845, '2024-11-06 17:00:08', '2024-11-06 17:03:35', 1.00, 1),
(39, 109, 15.4345265, 120.8836737, 15.4345265, 120.8836737, '2024-11-06 17:06:44', '2024-11-06 17:06:49', 1.00, 1),
(40, 109, 15.4345265, 120.8836737, 15.4345265, 120.8836737, '2024-11-06 17:06:57', '2024-11-06 17:07:19', 1.00, 1),
(41, 109, 15.4345231, 120.8836726, 15.4345231, 120.8836726, '2024-11-06 17:11:13', '2024-11-06 17:11:49', 0.10, 1),
(42, 109, 15.4345231, 120.8836726, 15.4345231, 120.8836726, '2024-11-06 17:12:03', '2024-11-06 17:12:17', 0.10, 1),
(43, 109, 15.4345231, 120.8836726, 15.4345231, 120.8836726, '2024-11-06 17:12:50', '2024-11-06 17:13:28', 0.10, 1),
(44, 109, 15.4345231, 120.8836726, 15.4345219, 120.8836725, '2024-11-06 17:13:31', '2024-11-06 17:34:22', 0.20, 1),
(45, 109, 15.4345248, 120.8836726, 15.4345248, 120.8836726, '2024-11-06 17:35:10', '2024-11-06 17:35:16', 0.10, 1),
(46, 109, 15.4345248, 120.8836726, 15.4345248, 120.8836726, '2024-11-06 17:35:37', '2024-11-06 17:36:20', 0.10, 1),
(47, 109, 15.4345248, 120.8836726, 15.4345248, 120.8836726, '2024-11-06 17:36:46', '2024-11-06 17:36:56', 0.10, 1),
(48, 109, 15.4345248, 120.8836726, 15.4345248, 120.8836726, '2024-11-06 17:37:02', '2024-11-06 17:37:05', 0.10, 1),
(49, 109, 15.4345248, 120.8836726, 15.4345248, 120.8836726, '2024-11-06 17:38:04', '2024-11-06 17:38:11', 0.10, 1),
(51, 109, 15.4345241, 120.8836749, 15.4345241, 120.8836749, '2024-11-06 17:52:24', '2024-11-06 17:52:31', 0.10, 1),
(52, 109, 15.4345241, 120.8836749, 15.4345241, 120.8836749, '2024-11-06 17:53:53', '2024-11-06 17:56:28', 0.10, 1),
(53, 109, 15.4345363, 120.8836852, 15.4345363, 120.8836852, '2024-11-06 18:01:25', '2024-11-06 18:02:03', 0.10, 1),
(55, 106, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-06 20:00:01', '2024-11-06 20:05:25', 0.10, 1),
(57, 106, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-06 20:06:02', '2024-11-06 20:06:20', 0.10, 1),
(59, 109, 15.4183603, 120.9302491, 15.4225797, 120.9395340, '2024-11-07 06:03:10', '2024-11-07 06:04:23', 1100.31, 1),
(60, 106, 15.4183603, 120.9302491, 15.4183603, 120.9302491, '2024-11-07 06:03:21', '2024-11-07 06:04:51', 0.10, 1),
(63, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-07 06:16:56', '2024-11-07 06:17:04', 0.10, 1),
(64, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-07 06:17:13', '2024-11-07 06:18:30', 0.10, 1),
(65, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-07 06:18:57', '2024-11-07 06:19:15', 0.10, 1),
(66, 106, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-07 06:19:06', '2024-11-07 06:20:03', 0.10, 1),
(67, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-07 06:19:20', '2024-11-07 06:20:50', 0.10, 1),
(68, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-07 06:22:43', '2024-11-07 06:23:06', 1.00, 1),
(72, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-07 06:26:21', '2024-11-07 06:28:37', 1.00, 1),
(74, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-08 03:00:07', '2024-11-08 03:03:19', 1.00, 1),
(75, 106, 15.1352000, 120.5897000, 15.1352000, 120.5897000, '2024-11-08 03:00:38', '2024-11-08 03:04:43', 0.10, 1),
(76, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-08 03:03:25', '2024-11-08 03:05:11', 1.00, 1),
(79, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-08 03:20:39', '2024-11-08 03:20:44', 12.00, 1),
(80, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-08 03:24:20', '2024-11-08 03:24:28', 12.00, 1),
(81, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-08 03:27:51', '2024-11-08 03:28:02', 12.00, 1),
(82, 109, 15.1449853, 120.5887029, 15.1449853, 120.5887029, '2024-11-08 03:28:55', '2024-11-08 03:29:31', 12.00, 1);

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
(8, 109, 0.00, 'debit', '2024-11-04 06:12:46', ''),
(9, 109, 1.00, 'debit', '2024-11-05 08:11:15', ''),
(10, 109, 4.03, 'debit', '2024-11-05 08:13:54', ''),
(11, 109, 1.00, 'debit', '2024-11-05 08:14:05', ''),
(12, 109, 1.00, 'debit', '2024-11-05 08:15:42', ''),
(13, 109, 1.00, 'debit', '2024-11-05 08:17:31', ''),
(14, 109, 31.92, 'debit', '2024-11-05 08:18:23', ''),
(15, 109, 31.92, 'debit', '2024-11-05 08:18:39', ''),
(16, 109, 32.72, 'debit', '2024-11-05 08:19:10', ''),
(17, 109, 1.00, 'debit', '2024-11-05 08:27:25', ''),
(18, 109, 1.00, 'debit', '2024-11-05 08:27:49', ''),
(19, 109, 1.00, 'debit', '2024-11-05 08:28:23', ''),
(20, 109, 1.00, 'debit', '2024-11-05 08:30:14', ''),
(21, 109, 1.81, 'debit', '2024-11-05 08:31:07', ''),
(22, 109, 1.00, 'debit', '2024-11-05 08:33:40', ''),
(23, 109, 1.00, 'debit', '2024-11-05 08:39:12', ''),
(24, 109, 1.00, 'debit', '2024-11-05 08:40:49', ''),
(25, 109, 1.00, 'debit', '2024-11-05 08:46:37', ''),
(26, 109, 1.00, 'debit', '2024-11-05 08:53:59', ''),
(27, 109, 1.00, 'debit', '2024-11-05 08:55:04', ''),
(28, 109, 1.00, 'debit', '2024-11-05 08:55:18', ''),
(29, 109, 1.00, 'debit', '2024-11-05 08:55:24', ''),
(30, 109, 1.00, 'debit', '2024-11-05 08:55:26', ''),
(31, 109, 1.00, 'debit', '2024-11-05 08:55:32', ''),
(32, 109, 1.00, 'debit', '2024-11-05 08:55:41', ''),
(33, 109, 1.00, 'debit', '2024-11-05 08:56:31', ''),
(34, 109, 1.00, 'debit', '2024-11-05 08:57:20', ''),
(35, 109, 1.00, 'debit', '2024-11-06 17:03:35', ''),
(36, 109, 1.00, 'debit', '2024-11-06 17:06:49', ''),
(37, 109, 1.00, 'debit', '2024-11-06 17:07:19', ''),
(38, 109, 0.10, 'debit', '2024-11-06 17:11:49', ''),
(39, 109, 0.10, 'debit', '2024-11-06 17:12:17', ''),
(40, 109, 0.10, 'debit', '2024-11-06 17:13:28', ''),
(41, 109, 0.20, 'debit', '2024-11-06 17:34:22', ''),
(42, 109, 0.10, 'debit', '2024-11-06 17:35:16', ''),
(43, 109, 0.10, 'debit', '2024-11-06 17:36:20', ''),
(44, 109, 0.10, 'debit', '2024-11-06 17:36:56', ''),
(45, 109, 0.10, 'debit', '2024-11-06 17:37:05', ''),
(46, 109, 0.10, 'debit', '2024-11-06 17:38:11', ''),
(47, 109, 0.10, 'debit', '2024-11-06 17:52:31', ''),
(48, 109, 0.10, 'debit', '2024-11-06 17:56:28', ''),
(49, 109, 0.10, 'debit', '2024-11-06 18:02:04', ''),
(50, 106, 0.10, 'debit', '2024-11-06 20:05:25', ''),
(51, 106, 0.10, 'debit', '2024-11-06 20:06:20', ''),
(52, 109, 1100.31, 'debit', '2024-11-07 06:04:23', ''),
(53, 106, 0.10, 'debit', '2024-11-07 06:04:51', ''),
(54, 109, 0.10, 'debit', '2024-11-07 06:17:04', ''),
(55, 109, 0.10, 'debit', '2024-11-07 06:18:30', ''),
(56, 109, 0.10, 'debit', '2024-11-07 06:19:15', ''),
(57, 106, 0.10, 'debit', '2024-11-07 06:20:03', ''),
(58, 109, 0.10, 'debit', '2024-11-07 06:20:50', ''),
(59, 109, 1.00, 'debit', '2024-11-07 06:23:06', ''),
(60, 109, 1.00, 'debit', '2024-11-07 06:28:37', ''),
(61, 109, 1.00, 'debit', '2024-11-08 03:03:19', ''),
(62, 106, 0.10, 'debit', '2024-11-08 03:04:43', ''),
(63, 109, 1.00, 'debit', '2024-11-08 03:05:11', ''),
(64, 109, 12.00, 'debit', '2024-11-08 03:20:44', ''),
(65, 109, 12.00, 'debit', '2024-11-08 03:24:28', ''),
(66, 109, 12.00, 'debit', '2024-11-08 03:28:02', ''),
(67, 109, 12.00, 'debit', '2024-11-08 03:29:31', '');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `start_point` varchar(50) NOT NULL,
  `end_point` varchar(50) NOT NULL,
  `distance_km` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `start_point`, `end_point`, `distance_km`) VALUES
(1, 'Zaragoza', 'Santa Rosa', 15.00),
(2, 'Santa Rosa', 'Cabanatuan Terminal', 10.00),
(3, 'Zaragoza', 'Cabanatuan Terminal', 25.00);

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
(20, 0, '0012814036', 50.00, 'Deduct', '2024-11-04 15:59:40'),
(21, 109, '0006977439', 1000.00, 'Load', '2024-11-06 18:08:17'),
(22, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:09:49'),
(23, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:12:42'),
(24, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:14:18'),
(25, 0, '0006977439', 41.00, 'Deduct', '2024-11-06 18:15:27'),
(26, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:17:58'),
(27, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:19:31'),
(28, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:20:17'),
(29, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:21:14'),
(30, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:21:54'),
(31, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:22:28'),
(32, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:23:09'),
(33, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:25:07'),
(34, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:28:07'),
(35, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:30:42'),
(36, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:32:05'),
(37, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:33:12'),
(38, 0, '0006977439', 400.00, 'Deduct', '2024-11-06 18:34:07'),
(39, 0, '0006977439', 500.00, 'Deduct', '2024-11-06 18:34:35'),
(40, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:34:46'),
(41, 0, '0006977439', 100.00, 'Deduct', '2024-11-06 18:37:03'),
(42, 109, '0006977439', 100.00, 'Load', '2024-11-06 18:42:52'),
(43, 109, '0006977439', 100.00, 'Deduct', '2024-11-06 19:02:02'),
(44, 109, '0006977439', 100.00, 'Deduct', '2024-11-06 19:03:03'),
(45, 109, '0006977439', 100.00, 'Load', '2024-11-06 19:08:47'),
(46, 106, '0012814036', 100.00, 'Load', '2024-11-08 02:51:32'),
(47, 109, '0006977439', 100.00, 'Load', '2024-11-08 03:32:33'),
(48, 109, '0006977439', 100.00, 'Load', '2024-11-08 03:33:54');

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
(95, '0008303510', 'Gencel Kaye', NULL, 'Beley', 'Muncal', '', '2002-12-06', 21, 'Female', 'gencelbeley06@gmail.com', '98765456789', '34900000', '34928000', '34928027', '123', '04c8873a49fd163df2a074015d3928bd', 0.00, 'User', '2024-11-02 11:55:21', 0, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 0.00),
(105, '0011841717', 'LynMarie', NULL, 'vicente', 'asdasd', 'Jr', '2002-03-03', 22, 'Male', 'jemusu96@gmail.com', '12123121222', '34900000', '34928000', '34928023', 'sadas', '2637a5c30af69a7bad877fdb65fbd78b', 0.00, 'Cashier', '2024-11-02 16:38:44', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(106, '0012814036', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'vicentearchiediaz29@gmail.com', '9755102091', '34900000', '34928000', '34928023', '', '2637a5c30af69a7bad877fdb65fbd78b', 463.50, 'Admin', '2024-11-03 11:46:11', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 33.00),
(107, '0013438657', 'LynMarie', NULL, 'Mapoy', 'Lubo', '', '2003-03-01', 21, 'Female', 'lynmariemapoy7@gmail.com', '91234567899', '34900000', '34912000', '34912027', '', 'ab974df2ea1472c3cbdc1fafe76bea88', 0.00, 'Cashier', '2024-11-03 12:41:29', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(108, '0012212828', 'Diana Rose', NULL, 'Maglalang', 'Rufino', '', '2002-10-18', 22, 'Female', 'dianarosemaglalang25@gmail.com', '12345678999', '34900000', '34928000', '34928002', '131', '852a9d7fdbbe6c9597b3d925b21353d9', 500.00, 'User', '2024-11-04 03:33:48', 0, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 25.00),
(109, '0006977439', 'Carl Justin', NULL, 'Velasco', 'De lara', '', '2002-03-16', 22, 'Male', 'carljustindlvelasco@gmail.com', '12345678987', '34900000', '34928000', '34928002', '', '51a2981bc0ebfb859f60266fb615327d', 600.00, 'User', '2024-11-04 05:43:03', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 105.00),
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
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `journeys`
--
ALTER TABLE `journeys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

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
