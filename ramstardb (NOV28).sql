-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 07:01 PM
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
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `bus_number` varchar(20) NOT NULL,
  `status` varchar(10) DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`bus_number`, `status`) VALUES
('12345', 'assigned'),
('12346', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `bus_info`
--

CREATE TABLE `bus_info` (
  `bus_id` int(11) NOT NULL,
  `passenger_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bus_passenger_count`
--

CREATE TABLE `bus_passenger_count` (
  `id` int(11) NOT NULL,
  `bus_number` int(11) DEFAULT NULL,
  `passengers_count` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 3, '', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `driver_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_sessions`
--

CREATE TABLE `driver_sessions` (
  `id` int(11) NOT NULL,
  `bus_number` varchar(50) NOT NULL,
  `driver_account_number` varchar(50) NOT NULL,
  `session_start_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver_sessions`
--

INSERT INTO `driver_sessions` (`id`, `bus_number`, `driver_account_number`, `session_start_time`) VALUES
(1, '12345', '0012814036', '2024-11-20 12:23:42'),
(2, '12345', '0012814036', '2024-11-20 12:25:24'),
(3, '12345', '0012814036', '2024-11-20 12:52:31'),
(4, '12345', '0012814036', '2024-11-20 12:59:09'),
(5, '12345', '0012814036', '2024-11-20 13:08:39'),
(6, '12345', '0012814036', '2024-11-20 13:14:00'),
(7, '12345', '0012814036', '2024-11-20 13:16:46'),
(8, '12345', '0012814036', '2024-11-20 13:21:48'),
(9, '12345', '0012814036', '2024-11-20 13:32:36');

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `id` int(11) NOT NULL,
  `bus_no` varchar(20) DEFAULT NULL,
  `conductor_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `total_earning` decimal(10,2) DEFAULT NULL
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
  `additional_fare` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fare_settings`
--

INSERT INTO `fare_settings` (`id`, `base_fare`, `additional_fare`) VALUES
(1, 14.00, 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `journey`
--

CREATE TABLE `journey` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `passengers`
--

CREATE TABLE `passengers` (
  `id` int(11) NOT NULL,
  `rfid` varchar(255) NOT NULL,
  `from_route_id` int(11) NOT NULL,
  `to_route_id` int(11) NOT NULL,
  `fare` decimal(10,2) NOT NULL,
  `status` enum('onBoard','completed') NOT NULL DEFAULT 'onBoard',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `bus_number` varchar(50) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `transaction_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger_logs`
--

INSERT INTO `passenger_logs` (`id`, `rfid`, `from_route`, `to_route`, `fare`, `conductor_name`, `bus_number`, `timestamp`, `transaction_number`) VALUES
(1, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL CENTRO', 38.00, 'Archie Vicente', '12345', '2024-11-27 23:42:38', NULL),
(2, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12345', '2024-11-27 23:43:37', NULL),
(3, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-27 23:47:42', 'TXN202411271647422524'),
(4, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-27 23:49:33', 'TXN202411271649333496'),
(5, '0006977439', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-27 23:49:44', 'TXN202411271649441688'),
(6, 'cash', 'LAKEWOOD/PACIFIC', 'SUMACAB', 14.00, 'Archie Vicente', '12345', '2024-11-27 23:55:09', 'TXN202411271655095765'),
(7, 'cash', 'LAKEWOOD/PACIFIC', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-27 23:56:53', 'TXN202411271656533263'),
(8, 'cash', 'SUMACAB', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-27 23:57:28', 'TXN202411271657284135'),
(9, 'cash', 'STA. ROSA INTERSECTION', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:05:00', 'TXN202411271705007488'),
(10, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:07:36', 'TXN202411271707363867'),
(11, 'cash', 'SUMACAB', 'DEEP WELL (STA ROSA)', 18.00, 'Archie Vicente', '12345', '2024-11-28 00:07:54', 'TXN202411271707547172'),
(12, 'cash', 'STA. ROSA INTERSECTION', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:09:19', 'TXN202411271709192381'),
(13, 'cash', 'STA. ROSA INTERSECTION', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:11:31', 'TXN202411271711315577'),
(14, 'cash', 'STA. ROSA INTERSECTION', 'SAN JOSEPH', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:13:05', 'TXN202411271713051615'),
(15, 'cash', 'LAKEWOOD/PACIFIC', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:21:47', 'TXN202411271721476949'),
(16, 'cash', 'LAFUENTE', 'SAN JOSEPH', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:22:11', 'TXN202411271722115582'),
(17, 'cash', 'SUMACAB', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:22:36', 'TXN202411271722368727'),
(18, 'cash', 'SUMACAB', 'DEEP WELL (STA ROSA)', 18.00, 'Archie Vicente', '12345', '2024-11-28 00:24:02', 'TXN202411271724024219'),
(19, 'cash', 'LAFUENTE', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:24:50', 'TXN202411271724507637'),
(20, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:25:56', 'TXN202411271725565627'),
(21, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-28 00:26:06', 'TXN202411271726065904'),
(22, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12345', '2024-11-28 00:32:17', 'rms6747499187d35'),
(23, 'cash', 'SUMACAB', 'LAKEWOOD/PACIFIC', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:33:27', 'rms674749d707465'),
(24, 'cash', 'SAN JOSEPH', 'SAN JOSEPH', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:33:58', 'rms674749f63ec2b'),
(25, 'cash', 'SUMACAB', 'SUMACAB', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:40:14', 'TXN-1732725614-8425'),
(26, 'cash', 'STO ROSARIO (SN. PEDRO)', 'STA CRUZ', 24.00, 'Archie Vicente', '12345', '2024-11-28 00:43:31', NULL),
(27, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:48:07', '2024112717327260874624'),
(28, 'cash', 'SUMACAB', 'SUMACAB', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:49:06', '2024112717327261461910'),
(29, 'cash', 'STA. ROSA INTERSECTION', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:50:08', '2024112717327262085153'),
(30, 'cash', 'SUMACAB', 'INSPECTOR', 22.00, 'Archie Vicente', '12345', '2024-11-28 00:51:04', '2024112717327262646745'),
(31, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-28 00:51:24', '2024112717327262844197'),
(32, 'cash', 'STA. ROSA INTERSECTION', 'DEEP WELL (STA ROSA)', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:52:02', NULL),
(33, 'cash', 'STA. ROSA INTERSECTION', 'STO ROSARIO (SN. PEDRO)', 16.00, 'Archie Vicente', '12345', '2024-11-28 00:52:24', NULL),
(34, 'cash', 'LAFUENTE', 'SAN JOSEPH', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:58:15', NULL),
(35, '0006977439', 'SUMACAB', 'DEEP WELL (STA ROSA)', 18.00, 'Archie Vicente', '12345', '2024-11-28 01:00:43', NULL),
(36, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:01:08', NULL),
(37, 'cash', 'SUMACAB', 'INSPECTOR', 22.00, 'Archie Vicente', '12345', '2024-11-28 01:02:42', NULL),
(38, 'cash', 'H. ROMERO', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-28 01:03:55', NULL),
(39, '0006977439', 'MALABON', 'MALABON', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:04:47', NULL),
(40, '0006977439', 'INSPECTOR', 'MALABON', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:05:14', NULL),
(41, '0006977439', 'RAJAL (SUR NORTE)', 'INSPECTOR', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:05:55', NULL),
(42, '0006977439', 'RAJAL CENTRO', 'INSPECTOR', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:07:14', NULL),
(43, 'cash', 'MALABON', 'CARMEN (PANTOC)', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:08:09', NULL),
(44, 'cash', 'H. ROMERO', 'RAJAL (SUR NORTE)', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:09:46', NULL),
(45, 'cash', 'CARMEN (PANTOC)', 'RAJAL (SUR NORTE)', 18.00, 'Archie Vicente', '12345', '2024-11-28 01:10:19', NULL),
(46, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:13:33', NULL),
(47, 'cash', 'LAKEWOOD/PACIFIC', 'SAN JOSEPH', 16.00, 'Archie Vicente', '12345', '2024-11-28 01:14:56', NULL),
(48, 'cash', 'SUMACAB', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:16:35', NULL),
(49, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 18.00, 'Archie Vicente', '12345', '2024-11-28 01:37:57', NULL),
(50, 'cash', 'RAJAL (SUR NORTE)', 'RAJAL CENTRO', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:38:33', NULL),
(51, 'cash', 'RAJAL CENTRO', 'STA. ROSA INTERSECTION', 24.00, 'Archie Vicente', '12345', '2024-11-28 01:39:29', NULL),
(52, 'cash', 'H. ROMERO', 'MALABON', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:44:31', NULL),
(53, 'cash', 'CARMEN (PANTOC)', 'MALABON', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:45:00', NULL),
(54, 'cash', 'STA. ROSA INTERSECTION', 'H. ROMERO', 28.00, 'Archie Vicente', '12345', '2024-11-28 01:48:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `remittances`
--

CREATE TABLE `remittances` (
  `id` int(11) NOT NULL,
  `bus_no` varchar(20) DEFAULT NULL,
  `conductor_id` int(11) DEFAULT NULL,
  `remit_date` date DEFAULT NULL,
  `total_earning` decimal(10,2) DEFAULT NULL,
  `total_deductions` decimal(10,2) DEFAULT NULL,
  `net_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remittances`
--

INSERT INTO `remittances` (`id`, `bus_no`, `conductor_id`, `remit_date`, `total_earning`, `total_deductions`, `net_amount`) VALUES
(1, '123', 123, '2024-11-19', 0.00, 100.00, -100.00),
(2, '12346', 12814036, '2024-11-21', 600.00, 0.00, 600.00),
(3, '12345', 12814036, '2024-11-21', 1100.00, 0.00, 1100.00);

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
(4, 'Zaragoza', 'Santa Rosa', 15.00),
(5, 'Zaragoza', 'Cabanatuan Terminal', 25.00),
(6, 'Santa Rosa', 'Cabanatuan Terminal', 10.00),
(10, 'cabanatuan terminal / lakewood ave', 'lakewood/pacific', 0.00),
(11, 'lakewood/pacific', 'sumacab', 4.00),
(12, 'sumacab', 'sta. rosa intersection', 5.00),
(13, 'sta. rosa intersection', 'lafuente', 7.00),
(14, 'lafuente', 'san joseph', 8.00),
(15, 'san joseph', 'deep well (sta rosa)', 11.00),
(16, 'deep well (sta rosa)', 'sto rosario (sn. pedro)', 12.00),
(17, 'sto rosario (sn. pedro)', 'inspector', 13.00),
(18, 'inspector', 'rajal (sur norte)', 14.00),
(19, 'rajal (sur norte)', 'rajal centro', 16.00),
(20, 'rajal centro', 'malabon', 17.00),
(21, 'malabon', 'h. romero', 18.00),
(22, 'h. romero', 'carmen (pantoc)', 20.00),
(23, 'carmen (pantoc)', 'sta cruz', 21.00),
(24, 'sta cruz', 'zaragoza (sn. isidro)', 23.00),
(25, 'zaragoza (sn. isidro)', 'sto rosario old', 24.00),
(26, 'sto rosario old', 'control', 28.00),
(27, 'control', 'lapaz (sn. isidro)', 31.00),
(28, 'lapaz (sn. isidro)', 'caramutan', 32.00),
(29, 'caramutan', 'laungcupang', 34.00),
(30, 'laungcupang', 'amucao', 36.00),
(31, 'amucao', 'balingcanaway', 38.00),
(32, 'balingcanaway', 'san manuel', 40.00),
(33, 'san manuel', 'sn. jose', 42.00),
(34, 'sn. jose', 'maliwalo', 47.00),
(35, 'maliwalo', 'matatalaib', 48.00),
(36, 'matatalaib', 'tarlac terminal / st. marys (metro town)', 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `tap_in_out`
--

CREATE TABLE `tap_in_out` (
  `id` int(11) NOT NULL,
  `rfid_id` varchar(255) NOT NULL,
  `start_stop` varchar(255) NOT NULL,
  `tap_in_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `tap_out_time` timestamp NULL DEFAULT NULL,
  `end_stop` varchar(255) DEFAULT NULL,
  `fare` decimal(10,2) DEFAULT NULL,
  `processed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tap_in_out`
--

INSERT INTO `tap_in_out` (`id`, `rfid_id`, `start_stop`, `tap_in_time`, `tap_out_time`, `end_stop`, `fare`, `processed`) VALUES
(1, '0006977439', 'Zaragoza', '2024-11-12 13:19:41', '2024-11-12 13:24:45', 'Santa Rosa', 36.00, 0),
(2, '0006977439', 'Zaragoza', '2024-11-12 13:19:41', '2024-11-12 13:24:51', 'Santa Rosa', 36.00, 0),
(3, '0006977439', 'Zaragoza', '2024-11-12 13:24:52', '2024-11-12 13:24:58', 'Santa Rosa', 36.00, 0),
(4, '0006977439', 'Zaragoza', '2024-11-12 13:24:52', '2024-11-12 13:25:02', 'Santa Rosa', 36.00, 0),
(5, '0006977439', 'Zaragoza', '2024-11-12 13:25:04', '2024-11-12 13:25:34', 'Santa Rosa', 36.00, 0),
(6, '0013412479', 'Zaragoza', '2024-11-12 13:25:09', '2024-11-12 13:25:17', 'Santa Rosa', 36.00, 0),
(7, '0013412479', 'Zaragoza', '2024-11-12 13:25:21', '2024-11-12 13:25:22', 'Santa Rosa', 36.00, 0),
(8, '0013412479', 'Zaragoza', '2024-11-12 13:25:22', NULL, NULL, NULL, 0),
(9, '0006977439', 'Zaragoza', '2024-11-12 13:25:38', '2024-11-12 13:25:44', 'Santa Rosa', 36.00, 0),
(10, '0006977439', 'Zaragoza', '2024-11-12 13:25:48', '2024-11-12 13:25:50', 'Santa Rosa', 36.00, 0),
(11, '0006977439', 'Zaragoza', '2024-11-12 13:25:48', '2024-11-12 13:36:38', 'Santa Rosa', 36.00, 0),
(12, '0006977439', 'Zaragoza', '2024-11-12 13:37:29', '2024-11-12 13:37:32', 'Santa Rosa', 36.00, 0),
(13, '0006977439', 'Zaragoza', '2024-11-12 13:54:16', '2024-11-12 13:54:20', 'Santa Rosa', 36.00, 0),
(14, '0006977439', 'Zaragoza', '2024-11-12 13:55:00', '2024-11-12 13:55:04', 'Santa Rosa', 36.00, 0),
(15, '0006977439', 'Zaragoza', '2024-11-12 13:57:52', '2024-11-12 13:58:05', 'Santa Rosa', 36.00, 0),
(16, '0006977439', 'Zaragoza', '2024-11-12 13:59:13', '2024-11-12 14:18:33', 'Cabanatuan Terminal', 56.00, 0),
(17, '0012212828', 'Zaragoza', '2024-11-12 13:59:22', '2024-11-12 13:59:57', 'Santa Rosa', 36.00, 0),
(18, '0006863857', 'Zaragoza', '2024-11-12 13:59:47', '2024-11-12 14:18:09', 'Santa Rosa', 36.00, 0),
(19, '0006977439', 'Zaragoza', '2024-11-12 14:18:43', '2024-11-12 14:18:52', 'Santa Rosa', 36.00, 0),
(20, '0006863857', 'Zaragoza', '2024-11-12 14:21:42', '2024-11-12 14:22:03', 'Cabanatuan Terminal', 56.00, 0),
(21, '0006977439', 'Zaragoza', '2024-11-12 14:21:50', '2024-11-12 14:22:39', 'Cabanatuan Terminal', 56.00, 0),
(22, '0006863857', 'Zaragoza', '2024-11-12 14:22:50', '2024-11-12 14:23:07', 'Santa Rosa', 36.00, 0),
(23, '0006863857', 'Zaragoza', '2024-11-12 14:23:00', '2024-11-12 14:23:07', 'Santa Rosa', 36.00, 0),
(24, '0006977439', 'Zaragoza', '2024-11-12 14:28:52', '2024-11-12 14:49:20', 'Santa Rosa', 36.00, 0),
(25, '0006863857', 'Zaragoza', '2024-11-12 14:47:53', NULL, NULL, NULL, 0),
(26, '0006863857', 'Zaragoza', '2024-11-12 14:47:53', NULL, NULL, NULL, 0),
(27, '0006977439', 'Zaragoza', '2024-11-12 14:49:14', '2024-11-12 14:49:20', 'Santa Rosa', 36.00, 0),
(28, '0006977439', 'Zaragoza', '2024-11-12 14:49:14', '2024-11-12 14:49:20', 'Santa Rosa', 36.00, 0),
(29, '0006977439', 'Zaragoza', '2024-11-12 14:49:47', '2024-11-12 14:49:53', 'Santa Rosa', 36.00, 0),
(30, '0006977439', 'Zaragoza', '2024-11-12 14:49:47', '2024-11-12 14:49:53', 'Santa Rosa', 36.00, 0),
(31, '0006977439', 'Zaragoza', '2024-11-12 14:50:05', '2024-11-12 14:50:11', 'Santa Rosa', 36.00, 0),
(32, '0006977439', 'Zaragoza', '2024-11-12 14:50:05', '2024-11-12 14:50:11', 'Santa Rosa', 36.00, 0),
(33, '0006863857', 'Zaragoza', '2024-11-12 14:50:30', NULL, NULL, NULL, 0),
(34, '0006863857', 'Zaragoza', '2024-11-12 14:50:34', NULL, NULL, NULL, 0),
(35, '0006977439', 'Santa Rosa', '2024-11-12 15:00:29', '2024-11-12 15:01:56', 'Santa Rosa', 36.00, 0),
(36, '0006977439', 'Santa Rosa', '2024-11-12 15:00:48', '2024-11-12 15:01:56', 'Santa Rosa', 36.00, 0),
(37, '0006977439', 'Santa Rosa', '2024-11-12 15:01:02', '2024-11-12 15:01:56', 'Santa Rosa', 36.00, 0),
(38, '0006977439', 'Santa Rosa', '2024-11-12 15:01:03', '2024-11-12 15:01:56', 'Santa Rosa', 36.00, 0),
(39, '0006977439', 'Santa Rosa', '2024-11-12 15:01:04', '2024-11-12 15:01:56', 'Santa Rosa', 36.00, 0),
(40, '0006977439', 'Santa Rosa', '2024-11-12 15:01:04', '2024-11-12 15:01:56', 'Santa Rosa', 36.00, 0),
(41, '0006977439', 'Santa Rosa', '2024-11-12 15:02:15', '2024-11-12 15:02:30', 'Cabanatuan Terminal', 26.00, 0),
(42, '0006977439', 'Cabanatuan Terminal', '2024-11-12 15:10:41', '2024-11-12 15:15:10', 'Santa Rosa', 36.00, 0),
(43, '0006977439', 'Cabanatuan Terminal', '2024-11-12 15:10:41', '2024-11-12 15:15:10', 'Santa Rosa', 36.00, 0),
(44, '0006977439', 'Cabanatuan Terminal', '2024-11-12 15:15:18', '2024-11-12 15:15:25', 'Santa Rosa', 36.00, 0),
(48, '0006977439', 'Cabanatuan Terminal', '2024-11-12 15:22:43', '2024-11-12 15:23:19', 'Cabanatuan Terminal', 56.00, 0),
(49, '0012814036', 'Zaragoza', '2024-11-12 15:23:11', '2024-11-12 15:35:05', 'Santa Rosa', 36.00, 0),
(50, '0012814036', 'Cabanatuan Terminal', '2024-11-12 15:35:11', '2024-11-12 15:39:26', 'Santa Rosa', 26.00, 0),
(51, '0012814036', 'Cabanatuan Terminal', '2024-11-12 15:35:11', '2024-11-12 15:39:26', 'Santa Rosa', 26.00, 0),
(52, '0006977439', 'Santa Rosa', '2024-11-12 15:39:19', '2024-11-12 15:39:34', 'Zaragoza', 36.00, 0),
(53, '0006977439', 'Zaragoza', '2024-11-12 15:43:49', '2024-11-12 15:44:20', 'Santa Rosa', 36.00, 0),
(54, '0006977439', 'Zaragoza', '2024-11-12 15:46:03', '2024-11-12 15:46:11', 'Santa Rosa', 36.00, 0),
(55, '0006977439', 'Zaragoza', '2024-11-12 15:46:03', '2024-11-12 15:46:11', 'Santa Rosa', 36.00, 0),
(56, '0006977439', 'Zaragoza', '2024-11-12 16:05:15', '2024-11-12 16:05:31', 'Cabanatuan Terminal', 56.00, 0),
(57, '0006977439', 'Santa Rosa', '2024-11-12 16:06:31', '2024-11-12 16:06:46', 'Cabanatuan Terminal', 26.00, 0),
(58, '0006977439', 'Cabanatuan Terminal', '2024-11-13 13:28:38', '2024-11-13 13:32:31', 'Zaragoza', 56.00, 0),
(59, '0006977439', 'Cabanatuan Terminal', '2024-11-13 13:28:51', '2024-11-13 13:32:31', 'Zaragoza', 56.00, 0),
(60, '0006977439', 'Cabanatuan Terminal', '2024-11-13 13:29:04', '2024-11-13 13:32:31', 'Zaragoza', 56.00, 0),
(61, '0006977439', 'Cabanatuan Terminal', '2024-11-13 13:29:59', '2024-11-13 13:32:31', 'Zaragoza', 56.00, 0),
(62, '0006977439', 'Zaragoza', '2024-11-13 13:32:51', '2024-11-13 13:33:03', 'Santa Rosa', 36.00, 0),
(63, '0006977439', 'Santa Rosa', '2024-11-14 05:16:45', '2024-11-14 05:16:58', 'Zaragoza', 36.00, 0),
(64, '0006977439', 'Zaragoza', '2024-11-14 05:17:18', '2024-11-19 07:55:28', 'Cabanatuan Terminal', 56.00, 0),
(65, '0006977439', 'Zaragoza', '2024-11-14 05:27:58', '2024-11-19 07:55:28', 'Cabanatuan Terminal', 56.00, 0),
(66, '0012814036', 'Zaragoza', '2024-11-14 05:28:06', '2024-11-14 05:28:35', 'Santa Rosa', 36.00, 0),
(67, '0012212828', 'Zaragoza', '2024-11-14 05:28:43', NULL, NULL, NULL, 0),
(68, '0012195534', 'Zaragoza', '2024-11-14 05:28:49', NULL, NULL, NULL, 0),
(69, '0013438657', 'Zaragoza', '2024-11-14 05:28:53', NULL, NULL, NULL, 0),
(70, '0006863857', 'Zaragoza', '2024-11-14 05:28:58', NULL, NULL, NULL, 0),
(71, '0012814036', 'Zaragoza', '2024-11-14 05:29:03', '2024-11-14 06:06:23', 'Cabanatuan Terminal', 56.00, 0),
(72, '0012212828', 'Zaragoza', '2024-11-14 05:29:10', NULL, NULL, NULL, 0),
(73, '0013438657', 'Zaragoza', '2024-11-14 05:29:25', NULL, NULL, NULL, 0),
(74, '0006863857', 'Zaragoza', '2024-11-14 05:29:34', NULL, NULL, NULL, 0),
(75, '0012814036', 'Zaragoza', '2024-11-14 06:06:05', '2024-11-14 06:06:23', 'Cabanatuan Terminal', 56.00, 0),
(76, '0012814036', 'Zaragoza', '2024-11-14 06:06:13', '2024-11-14 06:06:23', 'Cabanatuan Terminal', 56.00, 0),
(77, '0006977439', 'Zaragoza', '2024-11-19 07:55:16', '2024-11-19 07:55:28', 'Cabanatuan Terminal', 56.00, 0),
(78, '0006977439', 'Cabanatuan Terminal', '2024-11-19 08:01:07', '2024-11-19 08:01:30', 'Santa Rosa', 26.00, 0),
(79, '0006977439', 'Zaragoza', '2024-11-19 08:02:22', '2024-11-19 08:02:28', 'Santa Rosa', 36.00, 0),
(80, '0006977439', 'Zaragoza', '2024-11-19 08:13:21', '2024-11-19 08:13:38', 'Santa Rosa', 36.00, 0),
(81, '0006977439', 'Zaragoza', '2024-11-19 08:18:56', '2024-11-19 08:19:16', 'Santa Rosa', 36.00, 0),
(82, '0008303510', 'Zaragoza', '2024-11-19 08:40:14', NULL, NULL, NULL, 0),
(83, '0006977439', 'Zaragoza', '2024-11-19 08:40:37', '2024-11-19 08:40:49', 'Cabanatuan Terminal', 56.00, 0);

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
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `account_number`, `amount`, `transaction_type`, `bus_number`, `conductor_id`, `transaction_date`) VALUES
(1, 92, '0011768983', 1000.00, 'Load', '', '', '2024-10-28 14:08:04'),
(2, 108, '0012212828', 500.00, 'Load', '', '', '2024-11-04 04:01:42'),
(3, 109, '0006977439', 500.00, 'Load', '', '', '2024-11-04 05:45:56'),
(4, 109, '0006977439', 500.00, 'Load', '', '', '2024-11-04 06:36:17'),
(5, 109, '0006977439', 20.00, 'Load', '', '', '2024-11-04 06:56:31'),
(6, 106, '0012814036', 5.00, 'Load', '', '', '2024-11-04 14:40:29'),
(7, 106, '0012814036', 90.00, 'Load', '', '', '2024-11-04 14:41:02'),
(8, 106, '0012814036', 5.00, 'Load', '', '', '2024-11-04 14:45:24'),
(9, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:35:51'),
(10, 106, '0012814036', 60.00, 'Load', '', '', '2024-11-04 15:43:01'),
(11, 0, '0012814036', 60.00, 'Deduct', '', '', '2024-11-04 15:49:39'),
(12, 106, '0012814036', 100.00, 'Load', '', '', '2024-11-04 15:49:59'),
(13, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:51:27'),
(14, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:51:28'),
(15, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:52:15'),
(16, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:53:47'),
(17, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:53:47'),
(18, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:57:32'),
(19, 106, '0012814036', 50.00, 'Load', '', '', '2024-11-04 15:59:00'),
(20, 0, '0012814036', 50.00, 'Deduct', '', '', '2024-11-04 15:59:40'),
(21, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-06 18:08:17'),
(22, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:09:49'),
(23, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:12:42'),
(24, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:14:18'),
(25, 0, '0006977439', 41.00, 'Deduct', '', '', '2024-11-06 18:15:27'),
(26, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:17:58'),
(27, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:19:31'),
(28, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:20:17'),
(29, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:21:14'),
(30, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:21:54'),
(31, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:22:28'),
(32, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:23:09'),
(33, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:25:07'),
(34, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:28:07'),
(35, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:30:42'),
(36, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:32:05'),
(37, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:33:12'),
(38, 0, '0006977439', 400.00, 'Deduct', '', '', '2024-11-06 18:34:07'),
(39, 0, '0006977439', 500.00, 'Deduct', '', '', '2024-11-06 18:34:35'),
(40, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:34:46'),
(41, 0, '0006977439', 100.00, 'Deduct', '', '', '2024-11-06 18:37:03'),
(42, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 18:42:52'),
(43, 109, '0006977439', 100.00, 'Deduct', '', '', '2024-11-06 19:02:02'),
(44, 109, '0006977439', 100.00, 'Deduct', '', '', '2024-11-06 19:03:03'),
(45, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-06 19:08:47'),
(46, 106, '0012814036', 100.00, 'Load', '', '', '2024-11-08 02:51:32'),
(47, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-08 03:32:33'),
(48, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-08 03:33:54'),
(49, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-12 06:06:04'),
(50, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-12 15:06:42'),
(51, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-14 15:07:10'),
(52, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-19 13:22:28'),
(53, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:48:47'),
(54, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:49:02'),
(55, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:52:44'),
(56, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:54:36'),
(57, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:57:08'),
(58, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 12:59:21'),
(59, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:01:33'),
(60, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:03:07'),
(61, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:05:32'),
(62, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:08:53'),
(63, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:11:22'),
(64, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:13:18'),
(65, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:14:31'),
(66, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:32:49'),
(67, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:37:34'),
(68, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:39:56'),
(69, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:42:02'),
(70, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:46:43'),
(71, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:50:02'),
(72, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 13:52:11'),
(73, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:02:46'),
(74, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:03:57'),
(75, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:08:01'),
(76, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:10:14'),
(77, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:12:17'),
(78, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:15:51'),
(79, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:19:22'),
(80, 109, '0006977439', 1000.00, 'Load', '', '', '2024-11-20 14:21:30'),
(81, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:25:46'),
(82, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:26:24'),
(83, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:29:17'),
(84, 109, '0006977439', 100.00, 'Load', '1234', '0012814036', '2024-11-20 14:33:24'),
(85, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:34:24'),
(86, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:36:45'),
(87, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:38:39'),
(88, 109, '0006977439', 100.00, 'Load', '', '', '2024-11-20 14:41:38'),
(89, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-20 14:59:04'),
(90, 109, '0006977439', 500.00, 'Load', '12346', '0012814036', '2024-11-20 15:49:38'),
(91, 109, '0006977439', 100.00, 'Load', '12346', '0011841717', '2024-11-20 15:52:51'),
(92, 106, '0012814036', 100.00, 'Load', '12346', '0012814036', '2024-11-20 16:06:42'),
(93, 109, '0006977439', 500.00, 'Load', '', '', '2024-11-21 06:05:16'),
(94, 109, '0006977439', 300.00, 'Load', '', '', '2024-11-21 06:08:26'),
(95, 109, '0006977439', 1000.00, 'Load', '12345', '0012814036', '2024-11-21 14:42:50'),
(96, 109, '0006977439', 200.00, 'Load', '12345', '0012814036', '2024-11-21 16:23:40'),
(97, 109, '0006977439', 200.00, 'Load', '12345', '0012814036', '2024-11-26 08:08:25'),
(98, 109, '0006977439', 1000.00, 'Load', '12346', '0012814036', '2024-11-27 13:31:36'),
(99, 109, '0006977439', 1000.00, 'Load', '12346', '0012814036', '2024-11-27 13:31:36'),
(100, 109, '0006977439', 100.00, 'Load', '12346', '0012814036', '2024-11-27 14:13:42'),
(101, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:32:52'),
(102, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:32:52'),
(103, 109, '0006977439', 150.00, 'Load', '12345', '0012814036', '2024-11-27 15:33:14'),
(104, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:33:43'),
(105, 109, '0006977439', 150.00, 'Load', '12345', '0012814036', '2024-11-27 15:33:59'),
(106, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:34:20'),
(107, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 15:34:33'),
(108, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 17:26:49'),
(109, 109, '0006977439', 100.00, 'Load', '12345', '0012814036', '2024-11-27 17:27:01');

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
  `role` enum('User','Admin','Cashier','Conductor') DEFAULT 'User',
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
(92, '0011768983', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'archiediaz29@gmail.com', '12335654323', '034900000', '34928000', '34928023', 'TAPAT NG TRIPLE GGG GAS STATION', '40362563791c06d521db25d58d066b71', 892.00, 'User', '2024-10-28 13:34:00', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 50.00),
(95, '0008303510', 'Gencel Kaye', NULL, 'Beley', 'Muncal', '', '2002-12-06', 21, 'Female', 'gencelbeley06@gmail.com', '98765456789', '34900000', '34928000', '34928027', '123', '04c8873a49fd163df2a074015d3928bd', 0.00, 'User', '2024-11-02 11:55:21', 0, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 0.00),
(105, '0011841717', 'LynMarie', NULL, 'vicente', 'asdasd', 'Jr', '2002-03-03', 22, 'Male', 'jemusu96@gmail.com', '12123121222', '34900000', '34928000', '34928023', 'sadas', '2637a5c30af69a7bad877fdb65fbd78b', 0.00, 'Conductor', '2024-11-02 16:38:44', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(106, '0012814036', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'vicentearchiediaz29@gmail.com', '9755102091', '34900000', '34928000', '34928023', '', '2637a5c30af69a7bad877fdb65fbd78b', 1.50, 'Conductor', '2024-11-03 11:46:11', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 38.00),
(107, '0013438657', 'LynMarie', NULL, 'Mapoy', 'Lubo', '', '2003-03-01', 21, 'Female', 'lynmariemapoy7@gmail.com', '91234567899', '34900000', '34912000', '34912027', '', 'ab974df2ea1472c3cbdc1fafe76bea88', 0.00, 'Admin', '2024-11-03 12:41:29', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(108, '0012212828', 'Diana Rose', NULL, 'Maglalang', 'Rufino', '', '2002-10-18', 22, 'Female', 'dianarosemaglalang25@gmail.com', '12345678999', '34900000', '34928000', '34928002', '131', '852a9d7fdbbe6c9597b3d925b21353d9', 464.00, 'User', '2024-11-04 03:33:48', 0, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 25.00),
(109, '0006977439', 'Carl Justin', NULL, 'Velasco', 'De lara', '', '2002-03-16', 22, 'Male', 'carljustindlvelasco@gmail.com', '12345678987', '34900000', '34928000', '34928002', '', '51a2981bc0ebfb859f60266fb615327d', 8345.00, 'User', '2024-11-04 05:43:03', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 934.00),
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
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`bus_number`);

--
-- Indexes for table `bus_info`
--
ALTER TABLE `bus_info`
  ADD PRIMARY KEY (`bus_id`);

--
-- Indexes for table `bus_passenger_count`
--
ALTER TABLE `bus_passenger_count`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_sessions`
--
ALTER TABLE `driver_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_account_number` (`driver_account_number`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `journey`
--
ALTER TABLE `journey`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journeys`
--
ALTER TABLE `journeys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `passengers`
--
ALTER TABLE `passengers`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tap_in_out`
--
ALTER TABLE `tap_in_out`
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
-- AUTO_INCREMENT for table `bus_info`
--
ALTER TABLE `bus_info`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bus_passenger_count`
--
ALTER TABLE `bus_passenger_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `deductions`
--
ALTER TABLE `deductions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_sessions`
--
ALTER TABLE `driver_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
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
-- AUTO_INCREMENT for table `journey`
--
ALTER TABLE `journey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journeys`
--
ALTER TABLE `journeys`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `passengers`
--
ALTER TABLE `passengers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passenger_logs`
--
ALTER TABLE `passenger_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `remittances`
--
ALTER TABLE `remittances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tap_in_out`
--
ALTER TABLE `tap_in_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

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
-- Constraints for table `deductions`
--
ALTER TABLE `deductions`
  ADD CONSTRAINT `deductions_ibfk_1` FOREIGN KEY (`remit_id`) REFERENCES `remittances` (`id`);

--
-- Constraints for table `driver_sessions`
--
ALTER TABLE `driver_sessions`
  ADD CONSTRAINT `driver_sessions_ibfk_1` FOREIGN KEY (`driver_account_number`) REFERENCES `useracc` (`account_number`) ON DELETE CASCADE;

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
