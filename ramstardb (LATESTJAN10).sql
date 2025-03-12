-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2025 at 02:02 AM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `performed_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `performed_by`, `created_at`) VALUES
(1, 119, 'Activated', 'Archie Vicente', '2024-12-15 15:00:44'),
(7, 111, 'Deactivated', 'Archie Vicente', '2024-12-15 15:25:03'),
(8, 111, 'Activated', 'Archie Vicente', '2024-12-15 15:25:10'),
(9, 111, 'Transferred Funds And Disabled', 'Archie Vicente', '2024-12-15 15:31:20'),
(11, 105, 'Activated', 'Archie Vicente', '2024-12-17 12:55:07'),
(14, 107, 'Activated', 'Archie Vicente', '2024-12-17 12:55:44'),
(15, 111, 'Activated', 'Archie Vicente', '2024-12-17 12:56:19'),
(24, 92, 'Deactivated', 'Archie Vicente', '2024-12-18 15:38:20'),
(25, 92, 'Activated', 'Archie Vicente', '2024-12-18 15:38:28'),
(26, 92, 'Deactivated', 'Archie Vicente', '2024-12-18 15:42:18'),
(27, 92, 'Activated', 'Archie Vicente', '2024-12-18 15:42:38'),
(28, 121, 'Activated', 'Archie Vicente', '2024-12-20 11:27:30'),
(31, 122, 'Activated', 'Archie Vicente', '2024-12-20 12:10:10'),
(32, 123, 'Activated', 'Archie Vicente', '2024-12-20 12:48:41'),
(33, 92, 'Deactivated', 'Ramstar Zaragoza', '2024-12-20 14:52:57'),
(34, 92, 'Activated', 'Ramstar Zaragoza', '2024-12-20 14:53:06'),
(35, 125, 'Activated', 'Ramstar Zaragoza', '2024-12-21 05:14:54'),
(36, 125, 'Deactivated', 'Ramstar Zaragoza', '2024-12-21 05:15:05'),
(37, 125, 'Activated', 'Ramstar Zaragoza', '2024-12-21 05:18:31'),
(38, 92, 'Deactivated', 'Archie Vicente', '2024-12-22 12:27:29'),
(39, 105, 'Deactivated', 'Archie Vicente', '2024-12-22 12:41:06'),
(40, 92, 'Activated', 'Archie Vicente', '2024-12-22 12:44:06'),
(41, 105, 'Activated', 'Archie Vicente', '2024-12-22 12:44:15'),
(42, 92, 'Deactivated', 'Archie Vicente', '2024-12-22 12:46:28'),
(44, 92, 'Activated', 'Archie Vicente', '2024-12-26 04:01:33'),
(45, 92, 'Deactivated', 'Archie Vicente', '2024-12-26 04:01:39'),
(47, 146, 'Deactivated', 'Archie Vicente', '2024-12-26 08:13:32'),
(48, 146, 'Activated', 'Archie Vicente', '2024-12-26 08:13:40'),
(49, 146, 'Activated', 'Archie Vicente', '2024-12-26 08:14:00'),
(50, 92, 'Activated', 'Archie Vicente', '2024-12-26 08:38:56'),
(51, 92, 'Deactivated', 'Archie Vicente', '2024-12-26 08:41:26'),
(52, 92, 'Activated', 'Archie Vicente', '2024-12-26 08:41:30'),
(53, 105, 'Deactivated', 'Archie Vicente', '2024-12-26 08:41:56'),
(54, 105, 'Activated', 'Archie Vicente', '2024-12-26 08:42:05'),
(55, 109, 'Deactivated', 'Archie Vicente', '2024-12-26 08:42:26'),
(56, 105, 'Deactivated', 'Archie Vicente', '2024-12-26 08:42:32'),
(57, 105, 'Activated', 'Archie Vicente', '2024-12-26 08:42:35'),
(58, 105, 'Deactivated', 'Archie Vicente', '2024-12-26 08:48:12'),
(59, 105, 'Activated', 'Archie Vicente', '2024-12-26 08:48:16'),
(60, 105, 'Deactivated', 'Archie Vicente', '2024-12-26 08:49:14'),
(61, 105, 'Activated', 'Archie Vicente', '2024-12-26 08:49:21'),
(62, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 08:49:57'),
(63, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 08:58:42'),
(64, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 09:00:25'),
(65, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 09:33:59'),
(66, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 09:34:14'),
(67, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 09:50:38'),
(68, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 09:50:44'),
(69, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 10:11:16'),
(70, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 10:11:22'),
(71, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 10:16:00'),
(72, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 10:16:05'),
(73, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 10:16:20'),
(74, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 10:18:47'),
(75, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 10:19:04'),
(76, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 10:20:13'),
(77, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 10:20:18'),
(78, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 10:21:25'),
(79, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 10:21:41'),
(80, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 10:26:03'),
(81, 157, 'Activated with account number', 'Archie Vicente', '2024-12-26 10:27:32'),
(82, 109, 'Activated without account number', 'Archie Vicente', '2024-12-26 10:32:20'),
(83, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 15:17:38'),
(84, 157, 'Activated without account number', 'Archie Vicente', '2024-12-26 15:17:41'),
(85, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 15:19:06'),
(86, 157, 'Deactivated', 'Archie Vicente', '2024-12-26 18:27:19'),
(87, 157, 'Activated without account number', 'Archie Vicente', '2024-12-26 18:27:24'),
(91, 125, 'Transferred Funds And Disabled', 'Archie Vicente', '2025-01-09 22:05:43'),
(92, 125, 'Transferred Funds And Disabled', 'Archie Vicente', '2025-01-09 22:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `businfo`
--

CREATE TABLE `businfo` (
  `bus_id` int(11) NOT NULL,
  `bus_number` varchar(50) NOT NULL,
  `plate_number` varchar(50) NOT NULL,
  `bus_type` enum('regular','air-conditioned') NOT NULL,
  `capacity` int(11) NOT NULL,
  `statusofbus` enum('active','inactive') NOT NULL,
  `registration_date` date NOT NULL,
  `last_service_date` date NOT NULL,
  `bus_model` varchar(255) DEFAULT NULL,
  `vehicle_color` varchar(50) DEFAULT NULL,
  `driverName` varchar(250) NOT NULL,
  `conductorName` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `businfo`
--

INSERT INTO `businfo` (`bus_id`, `bus_number`, `plate_number`, `bus_type`, `capacity`, `statusofbus`, `registration_date`, `last_service_date`, `bus_model`, `vehicle_color`, `driverName`, `conductorName`, `status`) VALUES
(1, '01A', 'CCC133', 'regular', 30, 'active', '0000-00-00', '2024-12-04', 'REG', 'White', '', '', ' available'),
(2, '02B', 'CCC132', 'regular', 30, 'active', '0000-00-00', '2024-12-04', 'JMC', 'White', '', '', ' available'),
(4, '1234', 'xxx222', 'regular', 30, '', '0000-00-00', '2024-12-15', 'JMC', 'blue', '', '', 'Available'),
(5, '01b', 'CCC1335', 'regular', 30, '', '0000-00-00', '2024-12-17', 'JMC', 'White', '', '', 'Available'),
(6, '02A', 'xxx22', 'regular', 30, '', '0000-00-00', '2024-12-16', 'model2', 'White', '', '', 'Available');

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
(25, '0006863857', 'Alexa', 'asd', 'Lavesores', '2002-06-10', 22, 'Female', '123', 0.00, '2024-12-06 05:22:39'),
(26, '0006977439', 'Carl Justin', 'De lara', 'Velasco', '2002-03-16', 22, 'Male', '', 7835.80, '2024-12-06 09:19:46'),
(27, '0011841717', 'Carl Justin', 'De lara', 'Velasco', '2002-03-16', 22, 'Male', '', 7835.80, '2024-12-06 09:23:52'),
(28, '0011768983', 'Archie', 'Diaz', 'Vicente', '2003-06-29', 21, 'Male', 'TAPAT NG TRIPLE GGG GAS STATION', 892.00, '2024-12-09 06:25:03'),
(29, '0006977430', 'EJ', 'a', 'Lajom', '2002-12-04', 22, 'Male', 'a', 0.00, '2024-12-15 15:31:20'),
(30, '0011841719', 'Diana Rose', 'Rufino', 'Maglalang', '2002-10-18', 22, 'Female', '131', 464.00, '2024-12-17 14:11:46'),
(31, '0012195534', 'Diana Rose', 'Rufino', 'Maglalang', '2002-10-18', 22, 'Female', '131', 464.00, '2024-12-17 14:17:14'),
(32, '0009082006', 'Ronel', 'D', 'Peralta', '1986-10-30', 38, 'Male', '131', 1200.00, '2025-01-09 22:05:43'),
(33, '0009082077', 'Ronel', 'D', 'Peralta', '1986-10-30', 38, 'Male', '131', 1200.00, '2025-01-09 22:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `deductions`
--

CREATE TABLE `deductions` (
  `id` int(11) NOT NULL,
  `remit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deductions`
--

INSERT INTO `deductions` (`id`, `remit_id`, `description`, `amount`) VALUES
(1, 1, 'Gas', 100.00),
(2, 2, '', 0.00),
(3, 3, '', 0.00),
(4, 4, '', 0.00),
(5, 5, '', 0.00),
(6, 6, '', 0.00),
(7, 7, '', 0.00),
(8, 8, '', 0.00),
(9, 9, '', 0.00),
(10, 10, '', 0.00),
(11, 11, '', 0.00),
(12, 12, '', 0.00),
(13, 13, '', 0.00),
(14, 14, '', 0.00),
(15, 15, '', 0.00),
(16, 16, '', 0.00),
(17, 17, '', 0.00),
(18, 18, '', 0.00),
(19, 19, '', 0.00),
(20, 20, '', 0.00),
(21, 21, '', 0.00),
(22, 22, '', 0.00),
(23, 23, '', 0.00),
(24, 24, '', 0.00),
(25, 25, '', 0.00),
(26, 26, '', 0.00),
(27, 27, '', 0.00),
(28, 28, '', 0.00),
(29, 29, '', 0.00),
(30, 30, '', 0.00),
(31, 31, '', 0.00),
(32, 32, '', 0.00),
(33, 33, '', 0.00),
(34, 34, '100', 100.00),
(35, 35, 'a', 100.00),
(36, 36, '', 0.00),
(37, 37, '', 0.00),
(38, 38, '', 0.00),
(39, 39, '', 0.00),
(40, 40, '', 0.00),
(41, 41, '', 0.00),
(42, 42, '', 0.00),
(43, 43, '', 0.00),
(44, 44, '', 0.00),
(45, 45, '', 0.00),
(46, 46, '', 0.00),
(47, 47, '', 0.00),
(48, 50, '', 0.00),
(49, 51, '', 0.00),
(50, 52, '', 0.00),
(51, 53, '', 0.00),
(52, 54, '', 0.00),
(53, 55, '', 0.00),
(54, 56, '', 0.00),
(55, 57, '', 0.00),
(56, 58, '', 0.00),
(57, 59, '', 0.00),
(58, 60, '', 0.00),
(59, 61, '', 0.00),
(60, 61, '', 0.00),
(61, 61, '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_type` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fare_routes`
--

CREATE TABLE `fare_routes` (
  `id` int(11) NOT NULL,
  `route_name` varchar(255) NOT NULL,
  `post` int(11) NOT NULL,
  `province` varchar(255) NOT NULL,
  `regular_fare` decimal(10,2) NOT NULL,
  `discounted_fare` decimal(10,2) NOT NULL,
  `special_fare` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fare_routes`
--

INSERT INTO `fare_routes` (`id`, `route_name`, `post`, `province`, `regular_fare`, `discounted_fare`, `special_fare`) VALUES
(1, 'CABANATUAN TERMINAL / LAKEWOOD AVE', 0, 'NUEVA ECIJA', 0.00, 0.00, 0.00),
(2, 'LAKEWOOD/PACIFIC', 4, 'NUEVA ECIJA', 15.00, 12.00, 8.00),
(3, 'SUMACAB', 5, 'NUEVA ECIJA', 17.00, 14.00, 9.00),
(4, 'STA. ROSA INTERSECTION', 7, 'NUEVA ECIJA', 21.00, 17.00, 11.00),
(5, 'LAFUENTE', 8, 'NUEVA ECIJA', 23.00, 18.00, 12.00),
(6, 'SAN JOSEPH', 9, 'NUEVA ECIJA', 25.00, 20.00, 13.00),
(7, 'DEEP WELL (STA ROSA)', 11, 'NUEVA ECIJA', 29.00, 23.00, 15.00),
(8, 'STO ROSARIO (SN. PEDRO)', 12, 'NUEVA ECIJA', 31.00, 25.00, 16.00),
(9, 'INSPECTOR', 13, 'NUEVA ECIJA', 33.00, 26.00, 17.00),
(10, 'RAJAL (SUR NORTE)', 14, 'NUEVA ECIJA', 35.00, 28.00, 18.00),
(11, 'RAJAL CENTRO', 16, 'NUEVA ECIJA', 39.00, 31.00, 20.00),
(12, 'MALABON', 17, 'NUEVA ECIJA', 41.00, 33.00, 21.00),
(13, 'H. ROMERO', 18, 'NUEVA ECIJA', 43.00, 34.00, 22.00),
(14, 'CARMEN (PANTOC)', 20, 'NUEVA ECIJA', 47.00, 38.00, 24.00),
(15, 'STA CRUZ', 21, 'NUEVA ECIJA', 49.00, 39.00, 25.00),
(16, 'ZARAGOZA (SN. ISIDRO)', 23, 'NUEVA ECIJA', 53.00, 42.00, 27.00),
(17, 'STO ROSARIO OLD', 24, 'NUEVA ECIJA', 55.00, 44.00, 28.00),
(18, 'CONTROL', 28, 'NUEVA ECIJA', 63.00, 50.00, 32.00),
(19, 'LAPAZ (SN. ISIDRO)', 31, 'NUEVA ECIJA', 69.00, 55.00, 35.00),
(20, 'CARAMUTAN', 32, 'NUEVA ECIJA', 71.00, 57.00, 36.00),
(21, 'LAUNGCUPANG', 34, 'NUEVA ECIJA', 75.00, 60.00, 38.00),
(22, 'AMUCAO', 36, 'NUEVA ECIJA', 79.00, 63.00, 40.00),
(23, 'BALINGCANAWAY', 38, 'NUEVA ECIJA', 83.00, 66.00, 42.00),
(24, 'SAN MANUEL', 40, 'NUEVA ECIJA', 87.00, 70.00, 44.00),
(25, 'SN. JOSE', 42, 'NUEVA ECIJA', 91.00, 73.00, 46.00),
(26, 'MALIWALO', 47, 'NUEVA ECIJA', 101.00, 81.00, 51.00),
(27, 'MATATALAIB', 48, 'NUEVA ECIJA', 103.00, 82.00, 52.00),
(28, 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 50, 'NUEVA ECIJA', 107.00, 86.00, 54.00);

-- --------------------------------------------------------

--
-- Table structure for table `fare_settings`
--

CREATE TABLE `fare_settings` (
  `id` int(11) NOT NULL,
  `base_fare` decimal(10,2) NOT NULL,
  `additional_fare` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(5,2) DEFAULT 20.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fare_settings`
--

INSERT INTO `fare_settings` (`id`, `base_fare`, `additional_fare`, `discount_percentage`) VALUES
(1, 14.00, 2.00, 20.00);

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
-- Table structure for table `modalload`
--

CREATE TABLE `modalload` (
  `balance` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modalload`
--

INSERT INTO `modalload` (`balance`) VALUES
(100),
(100),
(200);

-- --------------------------------------------------------

--
-- Table structure for table `passenger_logs`
--

CREATE TABLE `passenger_logs` (
  `id` int(11) NOT NULL,
  `rfid` varchar(50) DEFAULT NULL,
  `from_route` varchar(255) DEFAULT NULL,
  `to_route` varchar(255) DEFAULT NULL,
  `fare` decimal(10,2) DEFAULT NULL,
  `conductor_name` varchar(255) DEFAULT NULL,
  `driver_name` varchar(250) NOT NULL,
  `driver_id` varchar(250) NOT NULL,
  `bus_number` varchar(50) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `transaction_number` varchar(50) DEFAULT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'notremitted',
  `rating` int(11) DEFAULT 0,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger_logs`
--

INSERT INTO `passenger_logs` (`id`, `rfid`, `from_route`, `to_route`, `fare`, `conductor_name`, `driver_name`, `driver_id`, `bus_number`, `timestamp`, `transaction_number`, `status`, `rating`, `feedback`) VALUES
(81, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '02A', '2024-12-04 23:01:16', '17333244759984293', 'notremitted', 0, NULL),
(82, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Archie Vicente', 'Cj asdasd', '', '02A', '2024-12-04 23:01:21', '17333244817199817', 'notremitted', 0, NULL),
(83, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-04 23:28:35', '17333261156481340', 'notremitted', 0, NULL),
(84, 'cash', 'STA. ROSA INTERSECTION', 'SUMACAB', 14.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-05 13:46:19', '17333775794595923', 'notremitted', 0, NULL),
(85, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-05 13:48:09', '17333776898368347', 'notremitted', 0, NULL),
(86, '0006977439', 'DEEP WELL (STA ROSA)', 'STA CRUZ', 20.80, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-05 14:31:17', '17333802753069988', 'notremitted', 0, NULL),
(87, '0006977439', 'H. ROMERO', 'STA. ROSA INTERSECTION', 22.40, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-05 14:32:57', '17333803769179624', 'notremitted', 0, NULL),
(88, 'cash', 'MALABON', 'INSPECTOR', 14.00, 'LynMarie vicente', 'Cj asdasd', '', '01A', '2024-12-05 14:45:31', '17333811315962401', 'notremitted', 0, NULL),
(89, '0006977439', 'STA. ROSA INTERSECTION', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 16.00, 'LynMarie vicente', 'Cj asdasd', '', '01A', '2024-12-05 14:46:54', '17333812130843469', 'notremitted', 0, NULL),
(90, '0006977499', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-06 14:14:51', '17334656901755559', 'notremitted', 0, NULL),
(91, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-06 14:29:36', '17334665768238399', 'notremitted', 0, NULL),
(92, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL CENTRO', 38.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 16:55:05', '17334753053163573', 'notremitted', 0, NULL),
(93, 'cash', 'RAJAL CENTRO', 'STO ROSARIO (SN. PEDRO)', 14.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 16:55:49', '17334753499391276', 'notremitted', 0, NULL),
(94, 'cash', 'SAN JOSEPH', 'AMUCAO', 60.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 16:58:07', '17334754519334574', 'notremitted', 0, NULL),
(96, 'cash', 'SAN JOSEPH', 'AMUCAO', 60.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 16:59:32', '17334754969257422', 'notremitted', 0, NULL),
(99, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 16:59:55', '17334755939121349', 'notremitted', 0, NULL),
(101, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 17:00:35', '17334756159927706', 'notremitted', 0, NULL),
(102, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 17:01:00', '17334756580221290', 'notremitted', 0, NULL),
(103, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 17:03:07', '17334757809994748', 'notremitted', 0, NULL),
(105, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 17:03:26', '17334758008795456', 'notremitted', 0, NULL),
(107, '0006977439', 'STO ROSARIO (SN. PEDRO)', 'DEEP WELL (STA ROSA)', 14.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-06 17:04:06', '17334758438335658', 'notremitted', 0, NULL),
(108, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'LynMarie vicente', 'Cj asdasd', '', '01A', '2024-12-07 19:28:27', '17335709069811627', 'notremitted', 0, NULL),
(109, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'LynMarie vicente', 'Cj asdasd', '', '01A', '2024-12-07 19:28:48', '17335709265408175', 'notremitted', 0, NULL),
(110, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 106.00, 'LynMarie vicente', 'Cj asdasd', '', '01A', '2024-12-07 19:32:24', '17335711447595093', 'notremitted', 0, NULL),
(111, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CARMEN (PANTOC)', 46.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-09 13:38:21', '17337227018482032', 'notremitted', 0, NULL),
(112, 'cash', 'MALABON', 'STA. ROSA INTERSECTION', 20.80, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-09 14:16:49', '17337250098156832', 'notremitted', 0, NULL),
(113, 'cash', 'RAJAL CENTRO', 'H. ROMERO', 12.00, 'Archie Vicente', 'Cj asdasd', '', '02B', '2024-12-10 00:45:08', '17337627081833157', 'notremitted', 0, NULL),
(114, 'cash', 'CARMEN (PANTOC)', 'MALABON', 15.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-10 18:17:10', '17338258301562723', 'notremitted', 0, NULL),
(115, 'cash', 'CARMEN (PANTOC)', 'MALABON', 15.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-10 18:50:45', '17338278453174601', 'notremitted', 0, NULL),
(116, '0006977439', 'DEEP WELL (STA ROSA)', 'STO ROSARIO (SN. PEDRO)', 15.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-10 18:50:56', '17338278546133028', 'notremitted', 0, NULL),
(117, 'cash', 'STO ROSARIO (SN. PEDRO)', 'STO ROSARIO OLD', 39.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-10 18:53:50', '17338280306101828', 'notremitted', 0, NULL),
(118, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 115.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-13 22:07:39', '17340988594784451', 'notremitted', 0, NULL),
(119, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'ZARAGOZA (SN. ISIDRO)', 166.40, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-13 22:08:43', '17340989219035175', 'notremitted', 0, NULL),
(120, 'cash', 'LAKEWOOD/PACIFIC', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 11.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-13 22:23:04', '17340997849166425', 'notremitted', 0, NULL),
(121, '0006977439', 'LAKEWOOD/PACIFIC', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 28.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-13 22:23:21', '17340997993016152', 'notremitted', 0, NULL),
(122, '0006977439', 'STO ROSARIO (SN. PEDRO)', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-13 22:24:00', '17340998385172687', 'notremitted', 0, NULL),
(123, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 108.80, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-13 22:50:43', '17341014378793642', 'notremitted', 0, NULL),
(124, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO OLD', 162.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 19:55:33', '17341773338045639', 'notremitted', 0, NULL),
(125, 'cash', 'STA. ROSA INTERSECTION', 'CONTROL', 48.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 19:56:19', '17341773796494176', 'notremitted', 0, NULL),
(126, 'cash', 'CONTROL', 'STO ROSARIO OLD', 14.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 19:56:31', '17341773910263618', 'notremitted', 0, NULL),
(127, 'cash', 'STO ROSARIO OLD', 'INSPECTOR', 28.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 19:56:40', '17341774007742935', 'notremitted', 0, NULL),
(128, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 19:56:54', '17341774142366294', 'notremitted', 0, NULL),
(129, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 19:57:08', '17341774284075414', 'notremitted', 0, NULL),
(130, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:03:17', '17341777974667241', 'notremitted', 0, NULL),
(131, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:03:58', '17341778385248942', 'notremitted', 0, NULL),
(132, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAFUENTE', 110.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:04:09', '17341778498103494', 'notremitted', 0, NULL),
(133, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:08:23', '17341781039179179', 'notremitted', 0, NULL),
(134, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:09:48', '17341781882858901', 'notremitted', 0, NULL),
(135, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:10:37', '17341782377482705', 'notremitted', 0, NULL),
(136, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:11:12', '17341782728669523', 'notremitted', 0, NULL),
(137, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 150.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:11:53', '17341783133806484', 'notremitted', 0, NULL),
(138, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 18.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:12:17', '17341783379316261', 'notremitted', 0, NULL),
(139, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 140.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:14:38', '17341784774416613', 'notremitted', 0, NULL),
(140, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 100.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:14:59', '17341784987559937', 'notremitted', 0, NULL),
(141, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 320.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:16:14', '17341785740979147', 'notremitted', 0, NULL),
(142, 'cash', 'STO ROSARIO (SN. PEDRO)', 'STA CRUZ', 24.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 20:34:47', '17341796878336670', 'notremitted', 0, NULL),
(143, 'cash', 'LAFUENTE', 'STO ROSARIO (SN. PEDRO)', 70.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 22:45:39', '17341875390843010', 'notremitted', 0, NULL),
(144, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 160.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-14 23:01:10', '17341884709666480', 'notremitted', 0, NULL),
(145, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 90.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-15 00:03:42', '17341922220646310', 'remitted', 0, NULL),
(146, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAPAZ (SN. ISIDRO)', 272.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-15 00:14:41', '17341928818089557', 'remitted', 0, NULL),
(147, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'ZARAGOZA (SN. ISIDRO)', 520.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-15 00:38:15', '17341942953443106', 'remitted', 0, NULL),
(148, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CONTROL', 124.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-15 00:41:32', '17341944921861991', 'remitted', 0, NULL),
(149, '0006977439', 'INSPECTOR', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 25.60, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-15 15:27:09', '17342476272532318', 'notremitted', 0, NULL),
(150, 'cash', 'DEEP WELL (STA ROSA)', 'RAJAL CENTRO', 13.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-16 14:55:26', '17343321264466063', 'notremitted', 0, NULL),
(151, 'cash', 'SUMACAB', 'MALABON', 60.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-16 14:55:57', '17343321576558447', 'notremitted', 0, NULL),
(152, 'cash', 'INSPECTOR', 'SAN JOSEPH', 11.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-16 14:56:46', '17343322067435465', 'notremitted', 0, NULL),
(153, 'cash', 'RAJAL (SUR NORTE)', 'RAJAL CENTRO', 45.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 14:57:59', '17343322790961840', 'notremitted', 0, NULL),
(154, '0006977439', 'RAJAL CENTRO', 'RAJAL (SUR NORTE)', 14.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 20:59:21', '17343539603686123', 'notremitted', 0, NULL),
(155, 'cash', 'INSPECTOR', 'MALABON', 14.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:46:10', '17343567707934851', 'notremitted', 0, NULL),
(156, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 160.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:46:33', '17343567938816762', 'notremitted', 0, NULL),
(157, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:47:20', '17343568403223692', 'notremitted', 0, NULL),
(158, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:47:31', '17343568510105633', 'notremitted', 0, NULL),
(159, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 100.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:47:49', '17343568694021945', 'notremitted', 0, NULL),
(160, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 100.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:48:06', '17343568866963931', 'notremitted', 0, NULL),
(161, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:48:17', '17343568969787444', 'notremitted', 0, NULL),
(162, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:48:35', '17343569157933025', 'notremitted', 0, NULL),
(163, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:48:48', '17343569285759380', 'notremitted', 0, NULL),
(164, 'cash', 'SUMACAB', 'LAKEWOOD/PACIFIC', 70.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:49:52', '17343569927406729', 'notremitted', 0, NULL),
(165, 'cash', 'LAKEWOOD/PACIFIC', 'SUMACAB', 14.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:50:11', '17343570118234609', 'notremitted', 0, NULL),
(166, 'cash', 'LAFUENTE', 'ZARAGOZA (SN. ISIDRO)', 180.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:50:55', '17343570555286130', 'notremitted', 0, NULL),
(167, 'cash', 'SAN JOSEPH', 'ZARAGOZA (SN. ISIDRO)', 68.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:51:34', '17343570944689412', 'notremitted', 0, NULL),
(168, 'cash', 'STO ROSARIO (SN. PEDRO)', 'ZARAGOZA (SN. ISIDRO)', 140.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:52:15', '17343571352683989', 'notremitted', 0, NULL),
(169, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 636.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:53:23', '17343572038621708', 'notremitted', 0, NULL),
(170, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 106.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:53:51', '17343572319272258', 'notremitted', 0, NULL),
(171, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 85.00, 'Archie Vicente', 'Cj asdasd', '', '1234', '2024-12-16 21:54:04', '17343572448405149', 'notremitted', 0, NULL),
(172, 'cash', 'LAFUENTE', 'CARMEN (PANTOC)', 24.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02A', '2024-12-17 21:16:49', '17344412263909741', 'notremitted', 0, NULL),
(173, 'cash', 'LAFUENTE', 'CARMEN (PANTOC)', 24.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02A', '2024-12-17 21:18:21', '17344413180567831', 'notremitted', 0, NULL),
(174, 'cash', 'STO ROSARIO (SN. PEDRO)', 'SUMACAB', 20.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02A', '2024-12-17 21:20:45', '17344414615094645', 'notremitted', 0, NULL),
(176, 'cash', 'STO ROSARIO (SN. PEDRO)', 'SUMACAB', 20.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02A', '2024-12-17 21:20:57', '17344414749545757', 'notremitted', 0, NULL),
(178, 'cash', 'STO ROSARIO (SN. PEDRO)', 'SUMACAB', 20.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02A', '2024-12-17 21:21:29', '17344415041447484', 'notremitted', 0, NULL),
(180, 'cash', 'STO ROSARIO (SN. PEDRO)', 'SUMACAB', 20.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02A', '2024-12-17 21:21:49', '17344415276704497', 'notremitted', 0, NULL),
(181, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02A', '2024-12-17 21:22:18', '17344415450635113', 'notremitted', 0, NULL),
(183, 'cash', 'RAJAL CENTRO', 'STA CRUZ', 16.00, 'Archie Vicente', 'Cj asdasd', '', '02A', '2024-12-17 21:23:51', '17344416464316826', 'notremitted', 0, NULL),
(185, 'cash', 'RAJAL CENTRO', 'STA CRUZ', 16.00, 'Archie Vicente', 'Cj asdasd', '', '02A', '2024-12-17 21:24:00', '17344416557279767', 'notremitted', 0, NULL),
(186, '0006977439', 'RAJAL CENTRO', 'STA CRUZ', 16.00, 'Archie Vicente', 'Cj asdasd', '', '02A', '2024-12-17 21:24:36', '17344416930143350', 'notremitted', 0, NULL),
(187, '0006977439', 'SUMACAB', 'LAFUENTE', 14.00, 'Archie Vicente', 'Cj asdasd', '', '02A', '2024-12-17 21:24:56', '17344417136258815', 'notremitted', 0, NULL),
(188, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', 'Cj asdasd', '', '02A', '2024-12-17 21:25:18', '17344417332522024', 'notremitted', 0, NULL),
(190, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-18 21:46:03', '17345295603958024', 'notremitted', 0, NULL),
(191, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-18 21:46:22', '17345295806997143', 'notremitted', 0, NULL),
(192, '0006977439', 'SUMACAB', 'SAN JOSEPH', 14.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-18 21:46:40', '17345295989352270', 'notremitted', 0, NULL),
(193, '0006977439', 'LAKEWOOD/PACIFIC', 'SUMACAB', 14.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-18 21:52:53', '17345299713107629', 'notremitted', 0, NULL),
(194, '0006977439', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-18 21:53:30', '17345300078785740', 'notremitted', 0, NULL),
(195, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-18 21:53:55', '17345300353767728', 'notremitted', 0, NULL),
(196, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', 'Cj asdasd', '', '01A', '2024-12-18 21:54:03', '17345300416739337', 'notremitted', 0, NULL),
(197, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'LynMarie vicente', 'Cj asdasd', '', '01A', '2024-12-18 23:21:48', '17345353046806659', 'notremitted', 0, NULL),
(198, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'LynMarie vicente', 'Cj asdasd', '', '01A', '2024-12-18 23:22:30', '17345353486478120', 'notremitted', 0, NULL),
(199, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAFUENTE', 22.00, 'LynMarie vicente', 'Cj asdasd', '', '01A', '2024-12-18 23:23:04', '17345353826479899', 'notremitted', 0, NULL),
(200, '0012212828', 'LAKEWOOD/PACIFIC', 'STA. ROSA INTERSECTION', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02C', '2024-12-20 19:03:40', '17346925961385169', 'notremitted', 0, NULL),
(201, '0012212828', 'MALABON', 'LAPAZ (SN. ISIDRO)', 34.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 19:05:17', '17346927080057391', 'remitted', 0, NULL),
(202, '0006863857', 'H. ROMERO', 'STA CRUZ', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 19:50:44', '17346954429237698', 'remitted', 0, NULL),
(203, '0009036016', 'MALABON', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 32.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:14:10', '17346968493154030', 'remitted', 0, NULL),
(204, '0009036016', 'LAKEWOOD/PACIFIC', 'STA CRUZ', 32.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:15:07', '17346969058565144', 'remitted', 0, NULL),
(205, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:15:24', '17346969241822406', 'remitted', 0, NULL),
(206, '0009036016', 'LAFUENTE', 'SAN JOSEPH', 11.20, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:19:01', '17346971401761530', 'remitted', 0, NULL),
(207, '0009036016', 'LAKEWOOD/PACIFIC', 'H. ROMERO', 34.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:19:21', '17346971591523966', 'remitted', 0, NULL),
(208, '0009036016', 'STA. ROSA INTERSECTION', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 80.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:27:09', '17346976269325420', 'remitted', 0, NULL),
(209, '0009036016', 'DEEP WELL (STA ROSA)', 'STA CRUZ', 26.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:28:58', '17346977350897427', 'remitted', 0, NULL),
(210, '0009036016', 'STA CRUZ', 'LAFUENTE', 32.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:30:20', '17346978191015956', 'remitted', 0, NULL),
(211, '0012212828', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 25.60, 'Carl Justin Velasco', 'Cj asdasd', '', '01A', '2024-12-20 20:54:10', '17346992472564991', 'remitted', 0, NULL),
(212, '0009036016', 'LAFUENTE', 'STA CRUZ', 25.60, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 22:35:01', '17347052979697170', 'remitted', 0, NULL),
(213, '0009036016', 'STA. ROSA INTERSECTION', 'H. ROMERO', 28.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 22:35:42', '17347053402719902', 'remitted', 0, NULL),
(214, 'cash', 'MALABON', 'SUMACAB', 30.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 22:58:30', '17347067109709390', 'remitted', 0, NULL),
(215, 'cash', 'H. ROMERO', 'CONTROL', 26.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 22:59:34', '17347067740713285', 'remitted', 0, NULL),
(216, '0009036016', 'LAKEWOOD/PACIFIC', 'STO ROSARIO OLD', 46.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 22:59:47', '17347067848425474', 'remitted', 0, NULL),
(217, '0009036016', 'CONTROL', 'SUMACAB', 41.60, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 23:00:03', '17347068022113906', 'remitted', 0, NULL),
(218, '0009036016', 'RAJAL (SUR NORTE)', 'H. ROMERO', 11.20, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 23:01:56', '17347069132753741', 'remitted', 0, NULL),
(219, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA CRUZ', 48.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 23:10:52', '17347074526431211', 'remitted', 0, NULL),
(220, '0006977499', 'LAKEWOOD/PACIFIC', 'STA. ROSA INTERSECTION', 14.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 23:11:45', '17347074608085253', 'remitted', 0, NULL),
(221, '0006977499', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '01A', '2024-12-20 23:13:28', '17347076026084696', 'remitted', 0, NULL),
(222, 'cash', 'STA. ROSA INTERSECTION', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 100.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-20 23:15:08', '17347077081863733', 'notremitted', 0, NULL),
(223, '0012212828', 'RAJAL CENTRO', 'ZARAGOZA (SN. ISIDRO)', 20.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '1234', '2024-12-21 00:14:39', '17347112723632661', 'remitted', 0, NULL),
(224, '0012212828', 'LAFUENTE', 'LAPAZ (SN. ISIDRO)', 52.00, 'Ramstar Zaragoza', 'Cj asdasd', '', '1234', '2024-12-21 00:15:07', '17347113008613816', 'remitted', 0, NULL),
(225, '0009036016', 'ZARAGOZA (SN. ISIDRO)', 'ZARAGOZA (SN. ISIDRO)', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-21 09:34:38', '17347448745287309', 'notremitted', 0, NULL),
(226, '0012212828', 'ZARAGOZA (SN. ISIDRO)', 'CONTROL', 16.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-21 09:40:16', '17347452026598644', 'notremitted', 0, NULL),
(227, '0009036016', 'H. ROMERO', 'LAKEWOOD/PACIFIC', 34.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-21 09:54:18', '17347460535832881', 'notremitted', 0, NULL),
(228, '0012212828', 'MALABON', 'H. ROMERO', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-21 10:50:11', '17347494064056359', 'notremitted', 0, NULL),
(229, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAFUENTE', 22.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-23 23:38:18', '17349682983493218', 'notremitted', 0, NULL),
(230, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-23 23:40:33', '17349684336899224', 'notremitted', 0, NULL),
(231, 'cash', 'MALABON', 'INSPECTOR', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-23 23:57:12', '17349694321462910', 'notremitted', 0, NULL),
(232, 'cash', 'H. ROMERO', 'INSPECTOR', 16.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-23 23:57:42', '17349694622683557', 'notremitted', 0, NULL),
(233, 'cash', 'LAKEWOOD/PACIFIC', 'SAN JOSEPH', 16.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-23 23:58:03', '17349694829698743', 'notremitted', 0, NULL),
(234, 'cash', 'H. ROMERO', 'RAJAL CENTRO', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-23 23:58:45', '17349695253752320', 'notremitted', 0, NULL),
(235, 'cash', 'MALABON', 'INSPECTOR', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-23 23:59:47', '17349695879189389', 'notremitted', 0, NULL),
(236, 'cash', 'SAN MANUEL', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 602.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-24 00:01:49', '17349697095152677', 'notremitted', 0, NULL),
(237, 'cash', 'SUMACAB', 'CARMEN (PANTOC)', 36.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01b', '2024-12-24 00:25:00', '17349711005722620', 'notremitted', 0, NULL),
(238, 'cash', 'DEEP WELL (STA ROSA)', 'DEEP WELL (STA ROSA)', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01b', '2024-12-26 12:23:53', '17351870338078637', 'notremitted', 0, NULL),
(239, 'cash', 'SUMACAB', 'RAJAL CENTRO', 28.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 14:50:32', '17351958329151922', 'notremitted', 0, NULL),
(240, 'cash', 'H. ROMERO', 'STO ROSARIO (SN. PEDRO)', 18.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01b', '2024-12-26 15:22:45', '17351977656525996', 'notremitted', 0, NULL),
(241, 'cash', 'CARMEN (PANTOC)', 'STO ROSARIO (SN. PEDRO)', 22.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 15:25:35', '17351979353376495', 'notremitted', 0, NULL),
(242, '0006695007', 'H. ROMERO', 'STO ROSARIO (SN. PEDRO)', 18.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 15:53:00', '17351995780874445', 'notremitted', 0, NULL),
(243, 'cash', 'H. ROMERO', 'H. ROMERO', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 15:58:39', '17351999192772998', 'notremitted', 0, NULL),
(244, 'cash', 'STO ROSARIO (SN. PEDRO)', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 30.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:33:59', '17352092394271089', 'notremitted', 0, NULL),
(245, 'cash', 'STA. ROSA INTERSECTION', 'ZARAGOZA (SN. ISIDRO)', 38.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:34:42', '17352092824895572', 'notremitted', 0, NULL),
(246, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:40:47', '17352096475175942', 'notremitted', 0, NULL),
(247, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:41:04', '17352096649455049', 'notremitted', 0, NULL),
(248, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:43:02', '17352097825289046', 'notremitted', 0, NULL),
(249, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:43:47', '17352098274577048', 'notremitted', 0, NULL),
(250, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:44:41', '17352098810032052', 'notremitted', 0, NULL),
(251, '0006977499', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:45:48', '17352099470736127', 'notremitted', 0, NULL),
(252, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:47:35', '17352100558075884', 'notremitted', 0, NULL),
(253, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SUMACAB', 16.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:50:37', '17352102378223641', 'notremitted', 0, NULL),
(254, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 18:51:22', '17352102822477803', 'notremitted', 0, NULL),
(255, '0006977499', 'LAFUENTE', 'LAFUENTE', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01b', '2024-12-26 22:07:40', '17352220582617721', 'notremitted', 0, NULL),
(256, 'cash', 'SUMACAB', 'STO ROSARIO (SN. PEDRO)', 20.00, 'Carl Justin Velasco', 'Cj asdasd', '', '02A', '2024-12-26 23:41:27', '17352276879669596', 'notremitted', 0, NULL),
(257, '0012212829', 'MALABON', 'STO ROSARIO (SN. PEDRO)', 16.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-26 23:44:48', '17352278867446597', 'notremitted', 5, 'sadasdasd'),
(258, '0012212829', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'MALABON', 40.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-27 00:03:52', '17352290119555812', 'remitted', 5, 'sadasdasdsad'),
(259, '0012212829', 'STO ROSARIO (SN. PEDRO)', 'STA. ROSA INTERSECTION', 16.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-27 00:04:29', '17352290678505173', 'remitted', 4, 'adadasdasd'),
(260, '0012212829', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Carl Justin Velasco', 'Cj asdasd', '', '1234', '2024-12-27 00:06:46', '17352292033665506', 'remitted', 5, 'sadasdsd'),
(261, 'cash', 'MALABON', 'RAJAL (SUR NORTE)', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '', '01b', '2024-12-27 00:13:16', '17352295963684501', 'remitted', 0, NULL),
(262, 'cash', 'LAFUENTE', 'DEEP WELL (STA ROSA)', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '001234560000000426', '01b', '2024-12-27 00:18:43', '17352299231838359', 'remitted', 0, NULL),
(263, 'cash', 'SUMACAB', 'LAFUENTE', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '001234560000000426', '01b', '2024-12-27 00:20:46', '17352300464939455', 'remitted', 0, NULL),
(264, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAFUENTE', 22.00, 'Carl Justin Velasco', 'Cj asdasd', '001234560000000426', '01b', '2024-12-27 00:21:03', '17352300630937012', 'remitted', 0, NULL),
(265, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SUMACAB', 16.00, 'Carl Justin Velasco', 'Cj asdasd', '001234560000000426', '01b', '2024-12-27 00:21:20', '17352300809566557', 'remitted', 0, NULL),
(266, 'cash', 'RAJAL CENTRO', 'INSPECTOR', 14.00, 'Carl Justin Velasco', 'unknown driver', 'name', 'Unknown Bus Number', '2024-12-27 00:37:11', '17352310315366038', 'notremitted', 0, NULL),
(267, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 14.00, 'Carl Justin Velasco', '', '', '01b', '2024-12-27 00:51:55', '17352319158318466', 'remitted', 0, NULL),
(268, 'cash', 'RAJAL CENTRO', 'STO ROSARIO (SN. PEDRO)', 14.00, 'Carl Justin Velasco', 'Cj asdasd 001234560000000426', 'Cj asdasd 001234560000000426', '01b', '2024-12-27 01:02:12', '17352325322844944', 'remitted', 0, NULL),
(269, 'cash', 'MALABON', 'STO ROSARIO (SN. PEDRO)', 16.00, 'Carl Justin Velasco', 'Cj asdasd 001234560000000426', 'Cj asdasd 001234560000000426', '01b', '2024-12-27 01:02:56', '17352325768858726', 'remitted', 0, NULL),
(270, 'cash', 'LAFUENTE', 'CABANATUAN TERM...', 22.00, 'Carl Justin Vel...', 'Cj asdasd', '001234560000000426', '01b', '2024-12-27 01:06:20', '173523271932952...', 'remitted', 0, NULL),
(272, 'cash', 'MALABON', 'RAJAL CENTRO', 14.00, 'Carl Justin Velasco', 'Cj asdasd', '001234560000000426', '01b', '2024-12-27 01:06:33', '17352327932765788', 'remitted', 0, NULL),
(273, 'cash', 'MALABON', 'RAJAL (SUR NORTE)', 14.00, 'Carl Justin Velasco', 'Cj asdasd 001234560000000426', '', '1234', '2024-12-27 01:12:52', '17352331724452225', 'remitted', 0, NULL),
(274, 'cash', 'ZARAGOZA (SN. ISIDRO)', 'MALABON', 18.00, 'Carl Justin Velasco', 'Cj asdasd 001234560000000426', '', '1234', '2024-12-27 01:13:34', '17352332147865058', 'remitted', 0, NULL),
(275, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Carl Justin Velasco', 'Cj asdasd 001234560000000426', '', '1234', '2024-12-27 01:42:41', '17352349617227162', 'remitted', 0, NULL),
(276, 'cash', 'INSPECTOR', 'STO ROSARIO (SN. PEDRO)', 70.00, 'Carl Justin Velasco', 'Cj asdasd 001234560000000426', '', '1234', '2024-12-27 01:46:53', '17352352131849283', 'remitted', 0, NULL),
(277, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Carl Justin Velasco', 'Cj asdasd 001234560000000426', '', '02A', '2024-12-27 02:19:41', '17352371812109036', 'notremitted', 0, NULL),
(278, '0006977439', 'STA. ROSA INTERSECTION', 'SUMACAB', 14.00, 'Carl Justin Velasco', 'Archie asdas 0012345611223', '', '01b', '2024-12-27 02:46:15', '17352387720823389', 'remitted', 0, NULL),
(279, 'cash', 'SAN JOSEPH', 'MALABON', 22.00, 'Carl Justin Velasco', 'Archie asdas 0012345611223', '', '01b', '2024-12-27 02:46:27', '17352387875747029', 'remitted', 0, NULL),
(280, 'cash', 'LAFUENTE', 'STA. ROSA INTERSECTION', 14.00, 'Carl Justin Velasco', 'Archie asdas 0012345611223', '', '01b', '2024-12-27 02:57:32', '17352394527541428', 'remitted', 0, NULL),
(281, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'MALABON', 40.00, 'Carl Justin Velasco', 'Archie asdas 0012345611223', '', '01b', '2025-01-10 07:21:32', '17364648921424778', 'notremitted', 0, NULL),
(282, '0006695007', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CARMEN (PANTOC)', 46.00, 'Carl Justin Velasco', 'Archie asdas 0012345611223', '', '1234', '2025-01-10 07:27:11', '17364652288349277', 'notremitted', 5, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `remittances`
--

CREATE TABLE `remittances` (
  `id` int(11) NOT NULL,
  `bus_no` varchar(20) DEFAULT NULL,
  `conductor_id` varchar(25) NOT NULL,
  `remit_date` date DEFAULT NULL,
  `total_earning` decimal(10,2) DEFAULT NULL,
  `total_deductions` decimal(10,2) DEFAULT NULL,
  `net_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remittances`
--

INSERT INTO `remittances` (`id`, `bus_no`, `conductor_id`, `remit_date`, `total_earning`, `total_deductions`, `net_amount`) VALUES
(1, '123', '123', '2024-11-19', 0.00, 100.00, -100.00),
(2, '12346', '0012814036', '2024-11-21', 600.00, 0.00, 600.00),
(3, '12345', '0012814036', '2024-11-21', 1100.00, 0.00, 1100.00),
(4, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(5, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(6, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(7, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(8, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(9, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(10, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(11, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(12, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(13, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(14, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(15, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(16, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(17, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(18, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(19, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(20, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(21, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(22, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(23, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(24, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(25, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(26, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(27, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(28, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(29, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(30, '01A', '0012814036', '2024-12-06', 10000.00, 0.00, 10000.00),
(31, '01A', '0012814036', '2024-12-14', 650.00, 0.00, 650.00),
(32, '01A', '0012814036', '2024-12-14', 400.00, 0.00, 400.00),
(33, '01A', '0012814036', '2024-12-14', 500.00, 0.00, 500.00),
(34, '01A', '0012814036', '2024-12-14', 400.00, 100.00, 0.00),
(35, '01A', '0012814036', '2024-12-14', 400.00, 100.00, 300.00),
(36, '01A', '0012814036', '2024-12-14', 1000.00, 0.00, 1090.00),
(37, '01A', '0012814036', '2024-12-14', 0.00, 0.00, 90.00),
(38, '01A', '0012814036', '2024-12-14', 0.00, 0.00, 90.00),
(39, '01A', '0012814036', '2024-12-14', 0.00, 0.00, 90.00),
(40, '01A', '0012814036', '2024-12-14', 0.00, 0.00, 272.00),
(41, '01A', '0012814036', '2024-12-14', 1000.00, 0.00, 1000.00),
(42, '01A', '0012814036', '2024-12-14', 1000.00, 0.00, 1000.00),
(43, '01A', '0012814036', '2024-12-14', 1000.00, 0.00, 1000.00),
(44, '01A', '0012814036', '2024-12-14', 300.00, 0.00, 300.00),
(45, '01A', '0012814036', '2024-12-14', 900.00, 0.00, 900.00),
(46, '01A', '0012814036', '2024-12-14', 750.00, 0.00, 750.00),
(47, '01A', '0012814036', '2024-12-14', 1000.00, 0.00, 1000.00),
(48, '01A', '0012814036', '2024-12-14', 500.00, 0.00, 500.00),
(49, '01A', '0012814036', '2024-12-14', 500.00, 0.00, 500.00),
(50, '01A', '0012814036', '2024-12-14', 500.00, 0.00, 500.00),
(51, '01A', '0012814036', '2024-12-14', 0.00, 0.00, 520.00),
(52, '01A', '0012814036', '2024-12-14', 124.00, 0.00, 124.00),
(53, '02B', '0012814036', '2024-12-15', 0.00, 0.00, 100.00),
(54, '02B', '0012814036', '2024-12-16', 0.00, 0.00, 0.00),
(55, '01A', '0009112065', '2024-12-20', 100.00, 0.00, 204.00),
(56, '1234', '0006977439', '2024-12-20', 0.00, 0.00, 0.00),
(57, '01b', '0006977439', '2024-12-26', 100.00, 0.00, 238.00),
(58, '1234', '0006977439', '2024-12-26', 100.00, 0.00, 162.00),
(59, '1234', '0006977439', '2024-12-26', 0.00, 0.00, 70.00),
(60, '1234', '0006977439', '2024-12-26', 1000.00, 0.00, 1000.00),
(61, '01b', '0006977439', '2024-12-26', 223.00, 0.00, 259.00);

-- --------------------------------------------------------

--
-- Table structure for table `remit_logs`
--

CREATE TABLE `remit_logs` (
  `id` int(11) NOT NULL,
  `remit_id` int(11) NOT NULL,
  `bus_no` varchar(50) NOT NULL,
  `conductor_id` varchar(50) NOT NULL,
  `total_load` decimal(10,2) NOT NULL,
  `total_cash` decimal(10,2) NOT NULL,
  `total_deductions` decimal(10,2) NOT NULL,
  `net_amount` decimal(10,2) NOT NULL,
  `remit_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remit_logs`
--

INSERT INTO `remit_logs` (`id`, `remit_id`, `bus_no`, `conductor_id`, `total_load`, `total_cash`, `total_deductions`, `net_amount`, `remit_date`, `created_at`) VALUES
(1, 47, '01A', '0012814036', 1000.00, 0.00, 0.00, 1000.00, '2024-12-14', '2024-12-14 16:34:01'),
(2, 50, '01A', '0012814036', 500.00, 0.00, 0.00, 500.00, '2024-12-14', '2024-12-14 16:37:54'),
(3, 51, '01A', '0012814036', 0.00, 0.00, 0.00, 520.00, '2024-12-14', '2024-12-14 16:38:25'),
(4, 52, '01A', '0012814036', 124.00, 0.00, 0.00, 124.00, '2024-12-14', '2024-12-14 16:42:36'),
(5, 53, '02B', '0012814036', 0.00, 0.00, 0.00, 100.00, '2024-12-15', '2024-12-15 14:14:33'),
(6, 54, '02B', '0012814036', 0.00, 0.00, 0.00, 0.00, '2024-12-16', '2024-12-16 07:25:48'),
(7, 55, '01A', '0009112065', 100.00, 0.00, 0.00, 204.00, '2024-12-20', '2024-12-20 15:27:18'),
(8, 56, '1234', '0006977439', 0.00, 0.00, 0.00, 0.00, '2024-12-20', '2024-12-20 16:17:49'),
(9, 57, '01b', '0006977439', 100.00, 138.00, 0.00, 238.00, '2024-12-26', '2024-12-26 17:41:45'),
(10, 58, '1234', '0006977439', 100.00, 62.00, 0.00, 162.00, '2024-12-26', '2024-12-26 17:44:23'),
(11, 59, '1234', '0006977439', 0.00, 70.00, 0.00, 70.00, '2024-12-26', '2024-12-26 17:47:01'),
(12, 60, '1234', '0006977439', 1000.00, 0.00, 0.00, 1000.00, '2024-12-26', '2024-12-26 17:47:35'),
(13, 61, '01b', '0006977439', 223.00, 36.00, 0.00, 259.00, '2024-12-26', '2024-12-26 18:59:06');

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
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_number` varchar(250) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_type` enum('Load','Deduct') NOT NULL,
  `bus_number` varchar(250) NOT NULL,
  `conductor_id` varchar(250) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(250) NOT NULL DEFAULT 'notremitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `account_number`, `amount`, `transaction_type`, `bus_number`, `conductor_id`, `transaction_date`, `status`) VALUES
(1, 92, '0011768983', 1000.00, 'Load', '', '', '2024-10-28 14:08:04', 'notremitted'),
(2, 108, '0012212828', 500.00, 'Load', '', '', '2024-11-04 04:01:42', 'notremitted'),
(3, 109, '0006977439', 500.00, 'Load', '', '', '2024-11-04 05:45:56', 'notremitted'),
(4, 109, '0006977439', 500.00, 'Load', '', '', '2024-11-04 06:36:17', 'notremitted'),
(5, 109, '0006977439', 20.00, 'Load', '', '', '2024-11-04 06:56:31', 'notremitted'),
(6, 106, '0012814036', 5.00, 'Load', '', '', '2024-11-04 14:40:29', 'notremitted'),
(7, 106, '0012814036', 90.00, 'Load', '', '', '2024-11-04 14:41:02', 'notremitted'),
(8, 106, '0012814036', 5.00, 'Load', '', '', '2024-11-04 14:45:24', 'notremitted'),
(9, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:35:51', 'notremitted'),
(10, 106, '0012814036', 60.00, 'Load', '', '', '2024-11-04 15:43:01', 'notremitted'),
(11, 0, '0012814036', 60.00, 'Deduct', '', '', '2024-11-04 15:49:39', 'notremitted'),
(12, 106, '0012814036', 100.00, 'Load', '', '', '2024-11-04 15:49:59', 'notremitted'),
(13, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:51:27', 'notremitted'),
(14, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:51:28', 'notremitted'),
(15, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:52:15', 'notremitted'),
(16, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:53:47', 'notremitted'),
(17, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:53:47', 'notremitted'),
(18, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:57:32', 'notremitted'),
(19, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:59:00', 'notremitted'),
(20, 0, '0012814036', 50.00, 'Deduct', '', '', '2024-11-04 15:59:40', 'notremitted'),
(21, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-06 18:08:17', 'notremitted'),
(22, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:09:49', 'notremitted'),
(23, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:12:42', 'notremitted'),
(24, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:14:18', 'notremitted'),
(25, 0, '0006977439', 41.00, 'Deduct', '', '', '2024-11-06 18:15:27', 'notremitted'),
(26, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:17:58', 'notremitted'),
(27, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:19:31', 'notremitted'),
(28, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:20:17', 'notremitted'),
(29, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:21:14', 'notremitted'),
(30, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:21:54', 'notremitted'),
(31, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:22:28', 'notremitted'),
(32, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:23:09', 'notremitted'),
(33, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:25:07', 'notremitted'),
(34, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:28:07', 'notremitted'),
(35, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:30:42', 'notremitted'),
(36, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:32:05', 'notremitted'),
(37, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:33:12', 'notremitted'),
(38, 0, '0006977439', 400.00, 'Deduct', '', '', '2024-11-06 18:34:07', 'notremitted'),
(39, 0, '0006977439', 500.00, 'Deduct', '', '', '2024-11-06 18:34:35', 'notremitted'),
(40, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:34:46', 'notremitted'),
(41, 0, '0006977439', 100.00, 'Deduct', '', '', '2024-11-06 18:37:03', 'notremitted'),
(42, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:42:52', 'notremitted'),
(43, 109, '0006977439', 100.00, 'Deduct', '', '', '2024-11-06 19:02:02', 'notremitted'),
(44, 109, '0006977439', 100.00, 'Deduct', '', '', '2024-11-06 19:03:03', 'notremitted'),
(45, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 19:08:47', 'notremitted'),
(46, 106, '0012814036', 100.00, 'Load', '', '', '2024-11-08 02:51:32', 'notremitted'),
(47, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-08 03:32:33', 'notremitted'),
(48, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-08 03:33:54', 'notremitted'),
(49, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-12 06:06:04', 'notremitted'),
(50, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-12 15:06:42', 'notremitted'),
(51, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-14 15:07:10', 'notremitted'),
(52, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-19 13:22:28', 'notremitted'),
(53, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:48:47', 'notremitted'),
(54, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:49:02', 'notremitted'),
(55, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:52:44', 'notremitted'),
(56, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:54:36', 'notremitted'),
(57, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:57:08', 'notremitted'),
(58, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:59:21', 'notremitted'),
(59, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:01:33', 'notremitted'),
(60, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:03:07', 'notremitted'),
(61, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:05:32', 'notremitted'),
(62, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:08:53', 'notremitted'),
(63, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:11:22', 'notremitted'),
(64, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:13:18', 'notremitted'),
(65, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:14:31', 'notremitted'),
(66, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:32:49', 'notremitted'),
(67, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:37:34', 'notremitted'),
(68, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:39:56', 'notremitted'),
(69, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:42:02', 'notremitted'),
(70, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:46:43', 'notremitted'),
(71, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:50:02', 'notremitted'),
(72, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:52:11', 'notremitted'),
(73, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:02:46', 'notremitted'),
(74, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:03:57', 'notremitted'),
(75, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:08:01', 'notremitted'),
(76, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:10:14', 'notremitted'),
(77, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:12:17', 'notremitted'),
(78, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:15:51', 'notremitted'),
(79, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:19:22', 'notremitted'),
(80, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-20 14:21:30', 'notremitted'),
(81, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:25:46', 'notremitted'),
(82, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:26:24', 'notremitted'),
(83, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:29:17', 'notremitted'),
(84, 109, '0006977439', 100.00, 'Load', '1234', '0012814036', '2024-11-20 14:33:24', 'notremitted'),
(85, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:34:24', 'notremitted'),
(86, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:36:45', 'notremitted'),
(87, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:38:39', 'notremitted'),
(88, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:41:38', 'notremitted'),
(89, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-20 14:59:04', 'notremitted'),
(90, 109, '0006977439', 500.00, 'Load', '12346', '0012814036', '2024-11-20 15:49:38', 'notremitted'),
(91, 109, '0006977439', 100.00, 'Load', '12346', '0011841717', '2024-11-20 15:52:51', 'notremitted'),
(92, 106, '0012814036', 100.00, 'Load', '12346', '0012814036', '2024-11-20 16:06:42', 'notremitted'),
(93, 109, '0006977439', 500.00, 'Load', '', '', '2024-11-21 06:05:16', 'notremitted'),
(94, 109, '0006977439', 300.00, 'Load', '', '', '2024-11-21 06:08:26', 'notremitted'),
(95, 109, '0006977439', 1000.00, 'Load', '12345', '0012814036', '2024-11-21 14:42:50', 'notremitted'),
(96, 109, '0006977439', 200.00, 'Load', '12345', '0012814036', '2024-11-21 16:23:40', 'notremitted'),
(97, 109, '0006977439', 200.00, 'Load', '12345', '0012814036', '2024-11-26 08:08:25', 'notremitted'),
(98, 109, '0006977439', 1000.00, 'Load', '12346', '0012814036', '2024-11-27 13:31:36', 'notremitted'),
(99, 109, '0006977439', 1000.00, 'Load', '12346', '0012814036', '2024-11-27 13:31:36', 'notremitted'),
(100, 109, '0006977439', 100.00, 'Load', '12346', '0012814036', '2024-11-27 14:13:42', 'notremitted'),
(101, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:32:52', 'notremitted'),
(102, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:32:52', 'notremitted'),
(103, 109, '0006977439', 150.00, 'Load', '12345', '0012814036', '2024-11-27 15:33:14', 'notremitted'),
(104, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:33:43', 'notremitted'),
(105, 109, '0006977439', 150.00, 'Load', '12345', '0012814036', '2024-11-27 15:33:59', 'notremitted'),
(106, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:34:20', 'notremitted'),
(107, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:34:33', 'notremitted'),
(108, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 17:26:49', 'notremitted'),
(109, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 17:27:01', 'notremitted'),
(110, 113, '0006977499', 0.00, 'Load', '01A', '0012814036', '2024-12-06 06:14:08', 'notremitted'),
(111, 109, '0006977439', 123.00, 'Load', '', '', '2024-12-07 10:13:35', 'notremitted'),
(112, 109, '0006977439', 150.00, 'Load', '', '', '2024-12-09 06:35:41', 'notremitted'),
(113, 109, '0006977439', 0.00, 'Load', '01A', '0012814036', '2024-12-13 14:04:43', 'notremitted'),
(114, 106, '0012814036', 0.00, 'Load', '01A', '0012814036', '2024-12-13 14:10:10', 'notremitted'),
(115, 109, '0006977439', 0.00, 'Load', '01A', '0012814036', '2024-12-13 14:10:47', 'notremitted'),
(116, 109, '0006977439', 0.00, 'Load', '01A', '0012814036', '2024-12-13 14:51:53', 'notremitted'),
(117, 109, '0006977439', 0.00, 'Load', '01A', '0012814036', '2024-12-14 12:17:45', 'notremitted'),
(118, 109, '0006977439', 0.00, 'Load', '01A', '0012814036', '2024-12-14 12:18:09', 'notremitted'),
(119, 109, '0006977439', 100.00, 'Load', '01A', '0012814036', '2024-12-14 14:07:23', 'notremitted'),
(120, 109, '0006977439', 0.00, 'Load', '01A', '0012814036', '2024-12-14 16:04:07', 'remitted'),
(121, 109, '0006977439', 1000.00, 'Load', '01A', '0012814036', '2024-12-14 16:15:53', 'remitted'),
(122, 109, '0006977439', 1000.00, 'Load', '01A', '0012814036', '2024-12-14 16:17:28', 'remitted'),
(123, 109, '0006977439', 1000.00, 'Load', '01A', '0012814036', '2024-12-14 16:20:07', 'remitted'),
(124, 109, '0006977439', 300.00, 'Load', '01A', '0012814036', '2024-12-14 16:21:33', 'remitted'),
(125, 109, '0006977439', 900.00, 'Load', '01A', '0012814036', '2024-12-14 16:24:18', 'remitted'),
(126, 109, '0006977439', 750.00, 'Load', '01A', '0012814036', '2024-12-14 16:25:04', 'remitted'),
(127, 109, '0006977439', 1000.00, 'Load', '01A', '0012814036', '2024-12-14 16:33:47', 'remitted'),
(128, 109, '0006977439', 500.00, 'Load', '01A', '0012814036', '2024-12-14 16:36:47', 'remitted'),
(129, 106, '0012814036', 100.00, 'Load', '02B', '0012814036', '2024-12-15 14:13:39', 'remitted'),
(130, 109, '0006977439', 900.00, 'Load', '01b', '0012814036', '2024-12-17 13:02:51', 'notremitted'),
(131, 109, '0006977439', 100.00, 'Load', '', '', '2024-12-18 14:17:57', 'notremitted'),
(132, 109, '0006977439', 100.00, 'Load', 'Cashier', 'LynMarie vicente', '2024-12-18 14:23:16', 'notremitted'),
(133, 109, '0006977439', 150.00, 'Load', 'Cashier', 'LynMarie vicente', '2024-12-18 14:24:45', 'notremitted'),
(134, 109, '0006977439', 100.00, 'Load', 'Cashier', 'LynMarie vicente', '2024-12-18 14:42:20', 'notremitted'),
(135, 109, '0006977439', 100.00, 'Load', 'Cashier', '0012245507', '2024-12-18 14:44:49', 'notremitted'),
(136, 109, '0006977439', 150.00, 'Load', 'Cashier', '0012245507', '2024-12-18 14:48:22', 'notremitted'),
(137, 109, '0006977439', 1000.00, 'Load', 'Cashier', '0012245507', '2024-12-18 14:56:33', 'notremitted'),
(138, 109, '0006977439', 1000.00, 'Deduct', '', '', '2024-12-18 14:58:01', 'notremitted'),
(139, 109, '0006977439', 100.00, 'Deduct', '', '', '2024-12-18 14:58:28', 'notremitted'),
(140, 109, '0006977439', 1.00, 'Deduct', '', '', '2024-12-18 14:58:51', 'notremitted'),
(141, 109, '0006977439', 1.00, 'Load', 'Cashier', '0012245507', '2024-12-18 15:02:21', 'notremitted'),
(142, 109, '0006977439', 1.00, 'Deduct', 'Cashier', '0012245507', '2024-12-18 15:03:15', 'notremitted'),
(143, 109, '0006977439', 100.00, 'Load', '01A', '0012245507', '2024-12-18 15:11:10', 'notremitted'),
(144, 109, '0006977439', 200.00, 'Load', '01A', '0012245507', '2024-12-18 15:11:26', 'notremitted'),
(145, 109, '0006977439', 100.00, 'Load', '01A', '0012245507', '2024-12-18 15:13:16', 'notremitted'),
(146, 109, '0006977439', 250.00, 'Load', '01A', '0012245507', '2024-12-18 15:14:22', 'notremitted'),
(147, 109, '0006977439', 100.00, 'Load', 'Cashier', '0012245507', '2024-12-18 15:17:14', 'notremitted'),
(148, 109, '0006977439', 100.00, 'Load', '01A', '0012245507', '2024-12-18 15:19:12', 'notremitted'),
(149, 109, '0006977439', 100.00, 'Deduct', 'Conductor', '0012245507', '2024-12-18 15:19:20', 'notremitted'),
(150, 110, '0006863857', 1000.00, 'Load', '01A', '0006977439', '2024-12-20 11:50:28', 'remitted'),
(151, 122, '0009036016', 1000.00, 'Load', '01A', '0006977439', '2024-12-20 12:13:50', 'remitted'),
(152, 122, '0009036016', 1000.00, 'Load', 'Cashier', '0013438657', '2024-12-20 12:31:58', 'notremitted'),
(153, 123, '0012212828', 1000.00, 'Load', '01A', '0006977439', '2024-12-20 12:51:57', 'remitted'),
(154, 123, '0012212828', 1000.00, 'Deduct', '01A', '0006977439', '2024-12-20 12:52:40', 'remitted'),
(155, 123, '0012212828', 1000.00, 'Load', '01A', '0006977439', '2024-12-20 12:53:26', 'remitted'),
(156, 123, '0012212828', 100.00, 'Load', '1234', '0006977439', '2024-12-20 15:17:43', 'notremitted'),
(157, 121, '0009112065', 100.00, 'Load', '01A', '0009112065', '2024-12-20 15:27:01', 'remitted'),
(158, 123, '0012212828', 100.00, 'Load', 'Cashier', '0013438657', '2024-12-20 16:00:34', 'notremitted'),
(159, 123, '0012212828', 1.00, 'Deduct', 'Cashier', '0013438657', '2024-12-20 16:03:36', 'notremitted'),
(160, 123, '0012212828', 1.00, 'Deduct', 'Cashier', '0013438657', '2024-12-20 16:04:02', 'notremitted'),
(161, 123, '0012212828', 100.00, 'Load', 'Cashier', '0013438657', '2024-12-20 16:11:18', 'notremitted'),
(162, 123, '0012212828', 50.00, 'Deduct', 'Cashier', '0013438657', '2024-12-20 16:11:25', 'notremitted'),
(163, 123, '0012212828', 1000.00, 'Load', '1234', '0006977439', '2024-12-21 01:35:01', 'notremitted'),
(164, 122, '0009036016', 750.00, 'Load', '1234', '0006977439', '2024-12-21 01:55:22', 'notremitted'),
(165, 122, '0009036016', 200.00, 'Deduct', '1234', '0006977439', '2024-12-21 01:55:30', 'notremitted'),
(166, 123, '0012212828', 750.00, 'Load', '1234', '0006977439', '2024-12-21 02:50:25', 'notremitted'),
(167, 125, '0009082006', 1000.00, 'Load', '1234', '0006977439', '2024-12-21 05:21:56', 'notremitted'),
(168, 125, '0009082006', 200.00, 'Load', '1234', '0006977439', '2024-12-21 05:23:15', 'notremitted'),
(169, 123, '0012212828', 100.00, 'Load', '1234', '0006977439', '2024-12-26 07:42:12', 'notremitted'),
(170, 157, '0012212829', 100.00, 'Load', '1234', '0006977439', '2024-12-26 11:03:41', 'notremitted'),
(171, 113, '0006977499', 850.00, 'Load', '01b', '0006977439', '2024-12-26 14:08:11', 'notremitted'),
(172, 157, '0012212829', 5.00, 'Load', 'Cashier', '0013438657', '2024-12-26 15:27:44', 'notremitted'),
(173, 157, '0012212829', 5.00, 'Load', 'Cashier', '0013438657', '2024-12-26 15:27:48', 'notremitted'),
(174, 157, '0012212829', 100.00, 'Load', '01b', '0006977439', '2024-12-26 16:08:57', 'remitted'),
(175, 109, '0006977439', 1.00, 'Load', 'Cashier', '0013438657', '2024-12-26 17:26:39', 'notremitted'),
(176, 109, '0006977439', 100.00, 'Load', '1234', '0006977439', '2024-12-26 17:43:05', 'remitted'),
(177, 113, '0006977499', 1000.00, 'Load', '1234', '0006977439', '2024-12-26 17:47:22', 'remitted'),
(178, 109, '0006977439', 100.00, 'Load', 'Cashier', '0013438657', '2024-12-26 18:36:55', 'notremitted'),
(179, 109, '0006977439', 100.00, 'Load', 'Cashier', '0013438657', '2024-12-26 18:37:12', 'notremitted'),
(180, 109, '0006977439', 123.00, 'Load', '01b', '0006977439', '2024-12-26 18:46:42', 'remitted'),
(181, 109, '0006977439', 100.00, 'Load', '01b', '0006977439', '2024-12-26 18:51:35', 'remitted'),
(182, 0, '0009082078', 9082078.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:41:43', 'notremitted'),
(183, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:45:45', 'notremitted'),
(184, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:45:56', 'notremitted'),
(185, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:46:28', 'notremitted'),
(186, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:46:42', 'notremitted'),
(187, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:47:11', 'notremitted'),
(188, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:47:23', 'notremitted'),
(189, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:47:46', 'notremitted'),
(190, 0, '0009082078', 200.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:48:52', 'notremitted'),
(191, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:49:01', 'notremitted'),
(192, 0, '0009082078', 100.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:49:13', 'notremitted'),
(193, 0, '0009082078', 1500.00, 'Load', 'Cashier', '0013438657', '2025-01-09 22:51:57', 'notremitted'),
(194, 0, '0009036016', 100.00, 'Load', 'Cashier', '0006977439', '2025-01-09 23:16:42', 'notremitted'),
(195, 0, '0009036016', 1000.00, 'Load', 'Cashier', '0006977439', '2025-01-09 23:17:00', 'notremitted');

-- --------------------------------------------------------

--
-- Table structure for table `useracc`
--

CREATE TABLE `useracc` (
  `id` int(11) UNSIGNED NOT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `firstname` varchar(100) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `lastname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `suffix` varchar(10) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactnumber` varchar(15) NOT NULL,
  `province` varchar(250) DEFAULT NULL,
  `municipality` varchar(250) DEFAULT NULL,
  `barangay` varchar(250) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `role` enum('User','Admin','Cashier','Conductor','Superadmin','Driver') DEFAULT 'User',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_activated` tinyint(1) DEFAULT 0,
  `points` decimal(10,2) DEFAULT 0.00,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `driverLicense` varchar(250) DEFAULT NULL,
  `driverStatus` enum('driving','notdriving') NOT NULL DEFAULT 'notdriving'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useracc`
--

INSERT INTO `useracc` (`id`, `account_number`, `firstname`, `profile_picture`, `lastname`, `middlename`, `suffix`, `birthday`, `age`, `gender`, `email`, `contactnumber`, `province`, `municipality`, `barangay`, `address`, `password`, `balance`, `role`, `created_at`, `is_activated`, `points`, `otp`, `otp_expiry`, `driverLicense`, `driverStatus`) VALUES
(92, '0006977432', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'archiediaz29@gmail.com', '12335654323', '034900000', '34928000', '34928023', 'TAPAT NG TRIPLE GGG GAS STATION', '40362563791c06d521db25d58d066b71', 892.00, 'User', '2024-10-28 13:34:00', 1, 50.00, NULL, NULL, '', 'driving'),
(105, '0012245507', 'LynMarie', NULL, 'vicente', 'asdasd', 'Jr', '2002-03-03', 22, 'Male', 'jemusu96@gmail.com', '12123121222', '34900000', '34928000', '34928023', 'sadas', '2637a5c30af69a7bad877fdb65fbd78b', 0.00, 'User', '2024-11-02 16:38:44', 1, 0.00, '150428', '2024-12-22 17:48:40', '', 'driving'),
(106, '0012814036', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'vicentearchiediaz29@gmail.com', '9755102091', '34900000', '34928000', '34928023', '', '2637a5c30af69a7bad877fdb65fbd78b', 0.00, 'Admin', '2024-11-03 11:46:11', 1, 0.00, '814907', '2024-12-26 15:14:45', '', 'driving'),
(107, '0013438657', 'LynMarie', NULL, 'Mapoy', 'Lubo', '', '2003-03-01', 21, 'Female', 'lynmariemapoy7@gmail.com', '91234567899', '34900000', '34912000', '34912027', '', 'ab974df2ea1472c3cbdc1fafe76bea88', 0.00, 'Cashier', '2024-11-03 12:41:29', 1, 0.00, NULL, NULL, '', 'driving'),
(109, '0006977439', 'Carl Justin', NULL, 'Velasco', 'De lara', '', '2002-03-16', 22, 'Male', 'carljustindlvelasco@gmail.com', '12345678987', '34900000', '34928000', '34928002', '', '1393871e4cd07854b1bdee83cb2a6414', 610.00, 'Conductor', '2024-11-04 05:43:03', 1, 30.00, NULL, NULL, '', 'driving'),
(111, '0006977431', 'EJ', NULL, 'Lajom', 'a', '', '2002-12-04', 22, 'Male', 'kundolatpatola4@gmail.com', '12345678123', '34900000', '34928000', '34928002', 'a', '7df56eca11075c2a05705a70604d4f89', 0.00, 'User', '2024-12-05 11:50:59', 1, 0.00, NULL, NULL, '', 'driving'),
(113, '0006977499', 'Mc Edjhen ', NULL, 'ta', 'm', '', '2003-03-01', 21, '', '19122018@holycross.edu.ph', '12321342143', '34900000', '34928000', '34928025', 'Del Pilar', '2637a5c30af69a7bad877fdb65fbd78b', 11750.00, 'User', '2024-12-06 06:07:50', 1, 592.00, NULL, NULL, '', 'driving'),
(115, '0006695015', 'John Philip', NULL, 'Diamat', 'Nagaño', '', '2002-10-17', 22, 'Male', 'jpdiamat11@gmail.com', '12145432134', '34900000', '34928000', '34928011', 'a', '976897d24b590887794458eaf9e1a35a', 0.00, 'User', '2024-12-06 08:32:30', 1, 0.00, NULL, NULL, '', 'driving'),
(119, '0006695007', 'James Andrew', NULL, 'Beley', 'Adriano', '', '2002-04-07', 22, 'Male', 'jemusubeley@gmail.com', '9168628698', '34900000', '34928000', '34928016', 'sa tabi tabi', '2637a5c30af69a7bad877fdb65fbd78b', 36.00, 'User', '2024-12-14 11:49:33', 1, 0.00, '730895', '2025-01-10 00:37:50', '', 'driving'),
(121, '0009112065', 'Ramstar', NULL, 'Zaragoza', '', '', '2000-01-01', 24, 'Male', 'ramstarzaragoza@gmail.com', '0', '34900000', '34932000', '34932021', '', 'f1f34f15a246f158df4a08f0da4bb81e', 100.00, 'Superadmin', '2024-12-20 11:25:58', 1, 5.00, NULL, NULL, '', 'driving'),
(122, '0009036016', 'Diana Rose', NULL, 'Maglalang', 'Rufino', '', '2002-10-18', 22, 'Female', 'dianarosemaglalang25@gmail.com', '9168628696', '34900000', '34928000', '34928002', '131', '8ccb29db1ea08e210d6d54002ada3c23', 2902.40, 'User', '2024-12-20 12:07:54', 0, 112.00, NULL, NULL, '', 'driving'),
(123, '0012212828', 'Gencel ', NULL, 'Beley', 'M.', '', '2002-12-06', 22, 'Female', 'gencelbeley06@gmail.com', '9079488845', '34900000', '34928000', '34928027', '#21 purok 1  ', 'e10adc3949ba59abbe56e057f20f883e', 1928.40, 'User', '2024-12-20 12:48:22', 1, 113.00, '076185', '2024-12-26 04:31:04', '', 'driving'),
(125, '0009082078', 'Ronel', NULL, 'Peralta', 'D', '', '1986-10-30', 38, 'Male', 'peraltaronelevan@holycross.edu.ph', '23456788765', '21500000', '21512000', '21512015', '131', '8d9a0da4a21f82f9483a6322a67a22f6', 9085878.00, 'User', '2024-12-21 05:13:43', 0, 60.00, NULL, NULL, '', 'driving'),
(145, '001234560000000425', 'aaaa', NULL, 'aaaa', 'aaaaaa', NULL, '2024-12-11', 0, 'Female', 'cashierhcc111@gmail.com', '12123123123', '', '', '', 'asdsd', '29628ffd5334b5701b23085c27e1faa9', 0.00, 'Cashier', '0000-00-00 00:00:00', 1, 0.00, NULL, NULL, '', 'driving'),
(146, '001234560000000426', 'Cj', NULL, 'asdasd', 'asdasd', NULL, '2024-12-11', 0, 'Male', 'cashierh11cc@gmail.com', '12123123123', '', '', '', 'asdasd', '29628ffd5334b5701b23085c27e1faa9', 0.00, 'Driver', '0000-00-00 00:00:00', 1, 0.00, NULL, NULL, 'asdasd', 'notdriving'),
(154, '0012345611223', 'Archie', NULL, 'asdas', 'asd', NULL, '2024-12-18', 0, 'Male', 'hccmis11@gmail.com', '31232131555', '', '', '', 'asdsd', '29628ffd5334b5701b23085c27e1faa9', 0.00, 'Driver', '0000-00-00 00:00:00', 1, 0.00, NULL, NULL, '', 'notdriving'),
(157, '0012212829', 'Diana', NULL, 'Diana', 'Diana', '', '2002-10-11', 22, 'Female', 'grantmikhaildelacruz@gmail.com', '23223212463', '0', '0', '0', '', '2637a5c30af69a7bad877fdb65fbd78b', 314.00, 'User', '2024-12-26 08:06:10', 1, 700.00, '708429', '2024-12-27 02:26:34', NULL, 'notdriving'),
(173, '', 'James', NULL, 'Beley', 'Andrew', '', '2017-12-24', 0, '', 'beley@gmail.com', '1234567890', '34900000', '0', '0', 'Angeles St', 'cb636dcfe300529d56d03e201a905152', 0.00, '', '2025-01-10 01:01:22', 0, 0.00, NULL, NULL, NULL, 'notdriving');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `businfo`
--
ALTER TABLE `businfo`
  ADD PRIMARY KEY (`bus_id`),
  ADD UNIQUE KEY `busnumber` (`bus_number`);

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
-- Indexes for table `deductions`
--
ALTER TABLE `deductions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remit_id` (`remit_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `fare_routes`
--
ALTER TABLE `fare_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fare_settings`
--
ALTER TABLE `fare_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journeys`
--
ALTER TABLE `journeys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `passenger_logs`
--
ALTER TABLE `passenger_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_number` (`transaction_number`);

--
-- Indexes for table `remittances`
--
ALTER TABLE `remittances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `remit_logs`
--
ALTER TABLE `remit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remit_id` (`remit_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `businfo`
--
ALTER TABLE `businfo`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bus_tracking`
--
ALTER TABLE `bus_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deactivated_accounts`
--
ALTER TABLE `deactivated_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fare_routes`
--
ALTER TABLE `fare_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `fare_settings`
--
ALTER TABLE `fare_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `journeys`
--
ALTER TABLE `journeys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `passenger_logs`
--
ALTER TABLE `passenger_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT for table `remittances`
--
ALTER TABLE `remittances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `remit_logs`
--
ALTER TABLE `remit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT for table `useracc`
--
ALTER TABLE `useracc`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useracc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `deductions`
--
ALTER TABLE `deductions`
  ADD CONSTRAINT `deductions_ibfk_1` FOREIGN KEY (`remit_id`) REFERENCES `remittances` (`id`);

--
-- Constraints for table `journeys`
--
ALTER TABLE `journeys`
  ADD CONSTRAINT `journeys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useracc` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `remit_logs`
--
ALTER TABLE `remit_logs`
  ADD CONSTRAINT `remit_logs_ibfk_1` FOREIGN KEY (`remit_id`) REFERENCES `remittances` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `revenue`
--
ALTER TABLE `revenue`
  ADD CONSTRAINT `revenue_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useracc` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
