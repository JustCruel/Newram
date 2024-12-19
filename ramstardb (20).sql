-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 10:27 PM
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
(4, 95, 'Activated', 'Archie Vicente', '2024-12-15 15:15:58'),
(5, 95, 'Activated', 'Archie Vicente', '2024-12-15 15:17:16'),
(6, 95, 'Deactivated', 'Archie Vicente', '2024-12-15 15:17:27'),
(7, 111, 'Deactivated', 'Archie Vicente', '2024-12-15 15:25:03'),
(8, 111, 'Activated', 'Archie Vicente', '2024-12-15 15:25:10'),
(9, 111, 'Transferred Funds And Disabled', 'Archie Vicente', '2024-12-15 15:31:20'),
(10, 120, 'Activated', 'Archie Vicente', '2024-12-17 12:49:55'),
(11, 105, 'Activated', 'Archie Vicente', '2024-12-17 12:55:07'),
(12, 95, 'Activated', 'Archie Vicente', '2024-12-17 12:55:15'),
(13, 110, 'Activated', 'Archie Vicente', '2024-12-17 12:55:32'),
(14, 107, 'Activated', 'Archie Vicente', '2024-12-17 12:55:44'),
(15, 111, 'Activated', 'Archie Vicente', '2024-12-17 12:56:19'),
(22, 123, 'Activated', 'LynMarie vicente', '2024-12-18 13:13:42'),
(23, 105, 'Deactivated', 'LynMarie vicente', '2024-12-18 13:16:23'),
(24, 105, 'Activated', 'LynMarie vicente', '2024-12-18 13:16:31'),
(25, 105, 'Deactivated', 'LynMarie vicente', '2024-12-18 13:17:26'),
(26, 105, 'Activated', 'LynMarie vicente', '2024-12-18 13:17:32'),
(27, 105, 'Deactivated', 'LynMarie vicente', '2024-12-18 13:20:01'),
(28, 105, 'Activated', 'LynMarie vicente', '2024-12-18 13:20:07'),
(29, 95, 'Transferred Funds And Disabled', 'Archie Vicente', '2024-12-19 18:03:36'),
(30, 95, 'Activated', 'Archie Vicente', '2024-12-19 18:03:46'),
(31, 119, 'Transferred Funds And Disabled', 'Archie Vicente', '2024-12-19 18:05:04');

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
(1, '01A', 'CCC133', 'regular', 30, 'active', '0000-00-00', '2024-12-04', 'REG', 'White', 'Andrew Beley', 'Archie Vicente', ' In Transit'),
(2, '02B', 'CCC132', 'regular', 30, 'active', '0000-00-00', '2024-12-04', 'REG', 'White', 'Andrew Beley', 'Archie Vicente', ' In Transit'),
(4, '1234', 'xxx222', 'regular', 30, '', '0000-00-00', '2024-12-15', 'JMC', 'blue', 'Andrew Beley', 'Archie Vicente', ' In Transit'),
(5, '01b', 'CCC1335', 'regular', 30, '', '0000-00-00', '2024-12-17', 'JMC', 'White', 'A', 'Carl Justin Velasco', 'Available'),
(6, '02A', 'xxx22', 'regular', 30, '', '0000-00-00', '2024-12-16', 'model2', 'White', 'andrew', 'Archie Vicente', ' In Transit'),
(7, '02C', 'CCC134', 'regular', 30, '', '0000-00-00', '2024-12-18', 'JMC', 'Red', 'Andrew Beley', 'Archie Vicente', 'Available');

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
(57, 59, '', 0.00);

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
  `transaction_number` varchar(50) DEFAULT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'notremitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger_logs`
--

INSERT INTO `passenger_logs` (`id`, `rfid`, `from_route`, `to_route`, `fare`, `conductor_name`, `bus_number`, `timestamp`, `transaction_number`, `status`) VALUES
(1, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL CENTRO', 38.00, 'Archie Vicente', '12345', '2024-11-27 23:42:38', NULL, 'notremitted'),
(2, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12345', '2024-11-27 23:43:37', NULL, 'notremitted'),
(3, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-27 23:47:42', 'TXN202411271647422524', 'notremitted'),
(4, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-27 23:49:33', 'TXN202411271649333496', 'notremitted'),
(5, '0006977439', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-27 23:49:44', 'TXN202411271649441688', 'notremitted'),
(6, 'cash', 'LAKEWOOD/PACIFIC', 'SUMACAB', 14.00, 'Archie Vicente', '12345', '2024-11-27 23:55:09', 'TXN202411271655095765', 'notremitted'),
(7, 'cash', 'LAKEWOOD/PACIFIC', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-27 23:56:53', 'TXN202411271656533263', 'notremitted'),
(8, 'cash', 'SUMACAB', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-27 23:57:28', 'TXN202411271657284135', 'notremitted'),
(9, 'cash', 'STA. ROSA INTERSECTION', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:05:00', 'TXN202411271705007488', 'notremitted'),
(10, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:07:36', 'TXN202411271707363867', 'notremitted'),
(11, 'cash', 'SUMACAB', 'DEEP WELL (STA ROSA)', 18.00, 'Archie Vicente', '12345', '2024-11-28 00:07:54', 'TXN202411271707547172', 'notremitted'),
(12, 'cash', 'STA. ROSA INTERSECTION', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:09:19', 'TXN202411271709192381', 'notremitted'),
(13, 'cash', 'STA. ROSA INTERSECTION', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:11:31', 'TXN202411271711315577', 'notremitted'),
(14, 'cash', 'STA. ROSA INTERSECTION', 'SAN JOSEPH', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:13:05', 'TXN202411271713051615', 'notremitted'),
(15, 'cash', 'LAKEWOOD/PACIFIC', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:21:47', 'TXN202411271721476949', 'notremitted'),
(16, 'cash', 'LAFUENTE', 'SAN JOSEPH', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:22:11', 'TXN202411271722115582', 'notremitted'),
(17, 'cash', 'SUMACAB', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:22:36', 'TXN202411271722368727', 'notremitted'),
(18, 'cash', 'SUMACAB', 'DEEP WELL (STA ROSA)', 18.00, 'Archie Vicente', '12345', '2024-11-28 00:24:02', 'TXN202411271724024219', 'notremitted'),
(19, 'cash', 'LAFUENTE', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:24:50', 'TXN202411271724507637', 'notremitted'),
(20, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:25:56', 'TXN202411271725565627', 'notremitted'),
(21, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-28 00:26:06', 'TXN202411271726065904', 'notremitted'),
(22, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12345', '2024-11-28 00:32:17', 'rms6747499187d35', 'notremitted'),
(23, 'cash', 'SUMACAB', 'LAKEWOOD/PACIFIC', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:33:27', 'rms674749d707465', 'notremitted'),
(24, 'cash', 'SAN JOSEPH', 'SAN JOSEPH', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:33:58', 'rms674749f63ec2b', 'notremitted'),
(25, 'cash', 'SUMACAB', 'SUMACAB', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:40:14', 'TXN-1732725614-8425', 'notremitted'),
(26, 'cash', 'STO ROSARIO (SN. PEDRO)', 'STA CRUZ', 24.00, 'Archie Vicente', '12345', '2024-11-28 00:43:31', NULL, 'notremitted'),
(27, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:48:07', '2024112717327260874624', 'notremitted'),
(28, 'cash', 'SUMACAB', 'SUMACAB', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:49:06', '2024112717327261461910', 'notremitted'),
(29, 'cash', 'STA. ROSA INTERSECTION', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:50:08', '2024112717327262085153', 'notremitted'),
(30, 'cash', 'SUMACAB', 'INSPECTOR', 22.00, 'Archie Vicente', '12345', '2024-11-28 00:51:04', '2024112717327262646745', 'notremitted'),
(31, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-28 00:51:24', '2024112717327262844197', 'notremitted'),
(32, 'cash', 'STA. ROSA INTERSECTION', 'DEEP WELL (STA ROSA)', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:52:02', NULL, 'notremitted'),
(33, 'cash', 'STA. ROSA INTERSECTION', 'STO ROSARIO (SN. PEDRO)', 16.00, 'Archie Vicente', '12345', '2024-11-28 00:52:24', NULL, 'notremitted'),
(34, 'cash', 'LAFUENTE', 'SAN JOSEPH', 14.00, 'Archie Vicente', '12345', '2024-11-28 00:58:15', NULL, 'notremitted'),
(35, '0006977439', 'SUMACAB', 'DEEP WELL (STA ROSA)', 18.00, 'Archie Vicente', '12345', '2024-11-28 01:00:43', NULL, 'notremitted'),
(36, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:01:08', NULL, 'notremitted'),
(37, 'cash', 'SUMACAB', 'INSPECTOR', 22.00, 'Archie Vicente', '12345', '2024-11-28 01:02:42', NULL, 'notremitted'),
(38, 'cash', 'H. ROMERO', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '12345', '2024-11-28 01:03:55', NULL, 'notremitted'),
(39, '0006977439', 'MALABON', 'MALABON', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:04:47', NULL, 'notremitted'),
(40, '0006977439', 'INSPECTOR', 'MALABON', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:05:14', NULL, 'notremitted'),
(41, '0006977439', 'RAJAL (SUR NORTE)', 'INSPECTOR', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:05:55', NULL, 'notremitted'),
(42, '0006977439', 'RAJAL CENTRO', 'INSPECTOR', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:07:14', NULL, 'notremitted'),
(43, 'cash', 'MALABON', 'CARMEN (PANTOC)', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:08:09', NULL, 'notremitted'),
(44, 'cash', 'H. ROMERO', 'RAJAL (SUR NORTE)', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:09:46', NULL, 'notremitted'),
(45, 'cash', 'CARMEN (PANTOC)', 'RAJAL (SUR NORTE)', 18.00, 'Archie Vicente', '12345', '2024-11-28 01:10:19', NULL, 'notremitted'),
(46, 'cash', 'SUMACAB', 'STA. ROSA INTERSECTION', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:13:33', NULL, 'notremitted'),
(47, 'cash', 'LAKEWOOD/PACIFIC', 'SAN JOSEPH', 16.00, 'Archie Vicente', '12345', '2024-11-28 01:14:56', NULL, 'notremitted'),
(48, 'cash', 'SUMACAB', 'LAFUENTE', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:16:35', NULL, 'notremitted'),
(49, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 18.00, 'Archie Vicente', '12345', '2024-11-28 01:37:57', NULL, 'notremitted'),
(50, 'cash', 'RAJAL (SUR NORTE)', 'RAJAL CENTRO', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:38:33', NULL, 'notremitted'),
(51, 'cash', 'RAJAL CENTRO', 'STA. ROSA INTERSECTION', 24.00, 'Archie Vicente', '12345', '2024-11-28 01:39:29', NULL, 'notremitted'),
(52, 'cash', 'H. ROMERO', 'MALABON', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:44:31', NULL, 'notremitted'),
(53, 'cash', 'CARMEN (PANTOC)', 'MALABON', 14.00, 'Archie Vicente', '12345', '2024-11-28 01:45:00', NULL, 'notremitted'),
(54, 'cash', 'STA. ROSA INTERSECTION', 'H. ROMERO', 28.00, 'Archie Vicente', '12345', '2024-11-28 01:48:19', NULL, 'notremitted'),
(55, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Archie Vicente', '12345', '2024-12-04 15:17:44', NULL, 'notremitted'),
(56, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Archie Vicente', '12345', '2024-12-04 15:17:58', NULL, 'notremitted'),
(57, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Archie Vicente', '12345', '2024-12-04 15:18:01', NULL, 'notremitted'),
(58, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Archie Vicente', '12345', '2024-12-04 15:18:13', NULL, 'notremitted'),
(59, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '12345', '2024-12-04 15:19:44', NULL, 'notremitted'),
(60, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 106.00, 'Archie Vicente', '12345', '2024-12-04 18:08:43', NULL, 'notremitted'),
(61, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '12347', '2024-12-04 18:10:27', NULL, 'notremitted'),
(62, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '12347', '2024-12-04 18:11:10', NULL, 'notremitted'),
(63, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'LynMarie vicente', '12345', '2024-12-04 18:12:16', NULL, 'notremitted'),
(64, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'H. ROMERO', 42.00, 'Archie Vicente', '12345', '2024-12-04 18:33:17', NULL, 'notremitted'),
(65, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 106.00, 'Archie Vicente', '12346', '2024-12-04 19:29:17', NULL, 'notremitted'),
(66, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 106.00, 'Archie Vicente', '12346', '2024-12-04 19:30:59', NULL, 'notremitted'),
(67, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 14.00, 'Archie Vicente', '12346', '2024-12-04 19:32:34', NULL, 'notremitted'),
(68, 'cash', 'LAKEWOOD/PACIFIC', 'LAFUENTE', 14.00, 'Archie Vicente', '12346', '2024-12-04 19:33:01', NULL, 'notremitted'),
(69, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12346', '2024-12-04 19:35:12', NULL, 'notremitted'),
(70, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 106.00, 'Archie Vicente', '12346', '2024-12-04 20:08:36', NULL, 'notremitted'),
(71, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12346', '2024-12-04 20:13:49', NULL, 'notremitted'),
(72, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12346', '2024-12-04 20:16:04', NULL, 'notremitted'),
(73, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAFUENTE', 22.00, 'Archie Vicente', '12346', '2024-12-04 20:18:40', '17333223098521205', 'notremitted'),
(74, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12346', '2024-12-04 21:59:02', '17333223098521277', 'notremitted'),
(75, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SUMACAB', 16.00, 'Archie Vicente', '12346', '2024-12-04 22:03:43', '17333223098521212', 'notremitted'),
(76, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '12346', '2024-12-04 22:15:47', '17333223098521208', 'notremitted'),
(77, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 14.00, 'Archie Vicente', '12346', '2024-12-04 22:17:23', NULL, 'notremitted'),
(78, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SUMACAB', 16.00, 'Archie Vicente', '12346', '2024-12-04 22:21:40', NULL, 'notremitted'),
(79, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 14.00, 'Archie Vicente', '12346', '2024-12-04 22:22:25', '17333221458164018', 'notremitted'),
(80, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '12346', '2024-12-04 22:25:23', '17333223098521201', 'notremitted'),
(81, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '02A', '2024-12-04 23:01:16', '17333244759984293', 'notremitted'),
(82, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Archie Vicente', '02A', '2024-12-04 23:01:21', '17333244817199817', 'notremitted'),
(83, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '01A', '2024-12-04 23:28:35', '17333261156481340', 'notremitted'),
(84, 'cash', 'STA. ROSA INTERSECTION', 'SUMACAB', 14.00, 'Archie Vicente', '02B', '2024-12-05 13:46:19', '17333775794595923', 'notremitted'),
(85, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '02B', '2024-12-05 13:48:09', '17333776898368347', 'notremitted'),
(86, '0006977439', 'DEEP WELL (STA ROSA)', 'STA CRUZ', 20.80, 'Archie Vicente', '02B', '2024-12-05 14:31:17', '17333802753069988', 'notremitted'),
(87, '0006977439', 'H. ROMERO', 'STA. ROSA INTERSECTION', 22.40, 'Archie Vicente', '02B', '2024-12-05 14:32:57', '17333803769179624', 'notremitted'),
(88, 'cash', 'MALABON', 'INSPECTOR', 14.00, 'LynMarie vicente', '01A', '2024-12-05 14:45:31', '17333811315962401', 'notremitted'),
(89, '0006977439', 'STA. ROSA INTERSECTION', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 16.00, 'LynMarie vicente', '01A', '2024-12-05 14:46:54', '17333812130843469', 'notremitted'),
(90, '0006977499', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '01A', '2024-12-06 14:14:51', '17334656901755559', 'notremitted'),
(91, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'Archie Vicente', '01A', '2024-12-06 14:29:36', '17334665768238399', 'notremitted'),
(92, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL CENTRO', 38.00, 'Archie Vicente', '02B', '2024-12-06 16:55:05', '17334753053163573', 'notremitted'),
(93, 'cash', 'RAJAL CENTRO', 'STO ROSARIO (SN. PEDRO)', 14.00, 'Archie Vicente', '02B', '2024-12-06 16:55:49', '17334753499391276', 'notremitted'),
(94, 'cash', 'SAN JOSEPH', 'AMUCAO', 60.00, 'Archie Vicente', '02B', '2024-12-06 16:58:07', '17334754519334574', 'notremitted'),
(96, 'cash', 'SAN JOSEPH', 'AMUCAO', 60.00, 'Archie Vicente', '02B', '2024-12-06 16:59:32', '17334754969257422', 'notremitted'),
(99, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'Archie Vicente', '02B', '2024-12-06 16:59:55', '17334755939121349', 'notremitted'),
(101, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'Archie Vicente', '02B', '2024-12-06 17:00:35', '17334756159927706', 'notremitted'),
(102, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 34.00, 'Archie Vicente', '02B', '2024-12-06 17:01:00', '17334756580221290', 'notremitted'),
(103, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', '02B', '2024-12-06 17:03:07', '17334757809994748', 'notremitted'),
(105, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', '02B', '2024-12-06 17:03:26', '17334758008795456', 'notremitted'),
(107, '0006977439', 'STO ROSARIO (SN. PEDRO)', 'DEEP WELL (STA ROSA)', 14.00, 'Archie Vicente', '02B', '2024-12-06 17:04:06', '17334758438335658', 'notremitted'),
(108, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'LynMarie vicente', '01A', '2024-12-07 19:28:27', '17335709069811627', 'notremitted'),
(109, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'LynMarie vicente', '01A', '2024-12-07 19:28:48', '17335709265408175', 'notremitted'),
(110, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 106.00, 'LynMarie vicente', '01A', '2024-12-07 19:32:24', '17335711447595093', 'notremitted'),
(111, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CARMEN (PANTOC)', 46.00, 'Archie Vicente', '01A', '2024-12-09 13:38:21', '17337227018482032', 'notremitted'),
(112, 'cash', 'MALABON', 'STA. ROSA INTERSECTION', 20.80, 'Archie Vicente', '01A', '2024-12-09 14:16:49', '17337250098156832', 'notremitted'),
(113, 'cash', 'RAJAL CENTRO', 'H. ROMERO', 12.00, 'Archie Vicente', '02B', '2024-12-10 00:45:08', '17337627081833157', 'notremitted'),
(114, 'cash', 'CARMEN (PANTOC)', 'MALABON', 15.00, 'Archie Vicente', '01A', '2024-12-10 18:17:10', '17338258301562723', 'notremitted'),
(115, 'cash', 'CARMEN (PANTOC)', 'MALABON', 15.00, 'Archie Vicente', '01A', '2024-12-10 18:50:45', '17338278453174601', 'notremitted'),
(116, '0006977439', 'DEEP WELL (STA ROSA)', 'STO ROSARIO (SN. PEDRO)', 15.00, 'Archie Vicente', '01A', '2024-12-10 18:50:56', '17338278546133028', 'notremitted'),
(117, 'cash', 'STO ROSARIO (SN. PEDRO)', 'STO ROSARIO OLD', 39.00, 'Archie Vicente', '01A', '2024-12-10 18:53:50', '17338280306101828', 'notremitted'),
(118, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 115.00, 'Archie Vicente', '01A', '2024-12-13 22:07:39', '17340988594784451', 'notremitted'),
(119, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'ZARAGOZA (SN. ISIDRO)', 166.40, 'Archie Vicente', '01A', '2024-12-13 22:08:43', '17340989219035175', 'notremitted'),
(120, 'cash', 'LAKEWOOD/PACIFIC', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 11.00, 'Archie Vicente', '01A', '2024-12-13 22:23:04', '17340997849166425', 'notremitted'),
(121, '0006977439', 'LAKEWOOD/PACIFIC', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 28.00, 'Archie Vicente', '01A', '2024-12-13 22:23:21', '17340997993016152', 'notremitted'),
(122, '0006977439', 'STO ROSARIO (SN. PEDRO)', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', '01A', '2024-12-13 22:24:00', '17340998385172687', 'notremitted'),
(123, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL (SUR NORTE)', 108.80, 'Archie Vicente', '01A', '2024-12-13 22:50:43', '17341014378793642', 'notremitted'),
(124, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO OLD', 162.00, 'Archie Vicente', '01A', '2024-12-14 19:55:33', '17341773338045639', 'notremitted'),
(125, 'cash', 'STA. ROSA INTERSECTION', 'CONTROL', 48.00, 'Archie Vicente', '01A', '2024-12-14 19:56:19', '17341773796494176', 'notremitted'),
(126, 'cash', 'CONTROL', 'STO ROSARIO OLD', 14.00, 'Archie Vicente', '01A', '2024-12-14 19:56:31', '17341773910263618', 'notremitted'),
(127, 'cash', 'STO ROSARIO OLD', 'INSPECTOR', 28.00, 'Archie Vicente', '01A', '2024-12-14 19:56:40', '17341774007742935', 'notremitted'),
(128, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '01A', '2024-12-14 19:56:54', '17341774142366294', 'notremitted'),
(129, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '01A', '2024-12-14 19:57:08', '17341774284075414', 'notremitted'),
(130, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '01A', '2024-12-14 20:03:17', '17341777974667241', 'notremitted'),
(131, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '01A', '2024-12-14 20:03:58', '17341778385248942', 'notremitted'),
(132, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAFUENTE', 110.00, 'Archie Vicente', '01A', '2024-12-14 20:04:09', '17341778498103494', 'notremitted'),
(133, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '01A', '2024-12-14 20:08:23', '17341781039179179', 'notremitted'),
(134, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '01A', '2024-12-14 20:09:48', '17341781882858901', 'notremitted'),
(135, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', '01A', '2024-12-14 20:10:37', '17341782377482705', 'notremitted'),
(136, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '01A', '2024-12-14 20:11:12', '17341782728669523', 'notremitted'),
(137, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 150.00, 'Archie Vicente', '01A', '2024-12-14 20:11:53', '17341783133806484', 'notremitted'),
(138, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 18.00, 'Archie Vicente', '01A', '2024-12-14 20:12:17', '17341783379316261', 'notremitted'),
(139, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 140.00, 'Archie Vicente', '01A', '2024-12-14 20:14:38', '17341784774416613', 'notremitted'),
(140, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 100.00, 'Archie Vicente', '01A', '2024-12-14 20:14:59', '17341784987559937', 'notremitted'),
(141, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 320.00, 'Archie Vicente', '01A', '2024-12-14 20:16:14', '17341785740979147', 'notremitted'),
(142, 'cash', 'STO ROSARIO (SN. PEDRO)', 'STA CRUZ', 24.00, 'Archie Vicente', '01A', '2024-12-14 20:34:47', '17341796878336670', 'notremitted'),
(143, 'cash', 'LAFUENTE', 'STO ROSARIO (SN. PEDRO)', 70.00, 'Archie Vicente', '01A', '2024-12-14 22:45:39', '17341875390843010', 'notremitted'),
(144, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 160.00, 'Archie Vicente', '01A', '2024-12-14 23:01:10', '17341884709666480', 'notremitted'),
(145, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 90.00, 'Archie Vicente', '01A', '2024-12-15 00:03:42', '17341922220646310', 'remitted'),
(146, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAPAZ (SN. ISIDRO)', 272.00, 'Archie Vicente', '01A', '2024-12-15 00:14:41', '17341928818089557', 'remitted'),
(147, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'ZARAGOZA (SN. ISIDRO)', 520.00, 'Archie Vicente', '01A', '2024-12-15 00:38:15', '17341942953443106', 'remitted'),
(148, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'CONTROL', 124.00, 'Archie Vicente', '01A', '2024-12-15 00:41:32', '17341944921861991', 'remitted'),
(149, '0006977439', 'INSPECTOR', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 25.60, 'Archie Vicente', '01A', '2024-12-15 15:27:09', '17342476272532318', 'notremitted'),
(150, 'cash', 'DEEP WELL (STA ROSA)', 'RAJAL CENTRO', 13.00, 'Carl Justin Velasco', '1234', '2024-12-16 14:55:26', '17343321264466063', 'notremitted'),
(151, 'cash', 'SUMACAB', 'MALABON', 60.00, 'Carl Justin Velasco', '1234', '2024-12-16 14:55:57', '17343321576558447', 'notremitted'),
(152, 'cash', 'INSPECTOR', 'SAN JOSEPH', 11.00, 'Carl Justin Velasco', '1234', '2024-12-16 14:56:46', '17343322067435465', 'notremitted'),
(153, 'cash', 'RAJAL (SUR NORTE)', 'RAJAL CENTRO', 45.00, 'Archie Vicente', '1234', '2024-12-16 14:57:59', '17343322790961840', 'notremitted'),
(154, '0006977439', 'RAJAL CENTRO', 'RAJAL (SUR NORTE)', 14.00, 'Archie Vicente', '1234', '2024-12-16 20:59:21', '17343539603686123', 'notremitted'),
(155, 'cash', 'INSPECTOR', 'MALABON', 14.00, 'Archie Vicente', '1234', '2024-12-16 21:46:10', '17343567707934851', 'notremitted'),
(156, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 160.00, 'Archie Vicente', '1234', '2024-12-16 21:46:33', '17343567938816762', 'notremitted'),
(157, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '1234', '2024-12-16 21:47:20', '17343568403223692', 'notremitted'),
(158, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Archie Vicente', '1234', '2024-12-16 21:47:31', '17343568510105633', 'notremitted'),
(159, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 100.00, 'Archie Vicente', '1234', '2024-12-16 21:47:49', '17343568694021945', 'notremitted'),
(160, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 100.00, 'Archie Vicente', '1234', '2024-12-16 21:48:06', '17343568866963931', 'notremitted'),
(161, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '1234', '2024-12-16 21:48:17', '17343568969787444', 'notremitted'),
(162, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '1234', '2024-12-16 21:48:35', '17343569157933025', 'notremitted'),
(163, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '1234', '2024-12-16 21:48:48', '17343569285759380', 'notremitted'),
(164, 'cash', 'SUMACAB', 'LAKEWOOD/PACIFIC', 70.00, 'Archie Vicente', '1234', '2024-12-16 21:49:52', '17343569927406729', 'notremitted'),
(165, 'cash', 'LAKEWOOD/PACIFIC', 'SUMACAB', 14.00, 'Archie Vicente', '1234', '2024-12-16 21:50:11', '17343570118234609', 'notremitted'),
(166, 'cash', 'LAFUENTE', 'ZARAGOZA (SN. ISIDRO)', 180.00, 'Archie Vicente', '1234', '2024-12-16 21:50:55', '17343570555286130', 'notremitted'),
(167, 'cash', 'SAN JOSEPH', 'ZARAGOZA (SN. ISIDRO)', 68.00, 'Archie Vicente', '1234', '2024-12-16 21:51:34', '17343570944689412', 'notremitted'),
(168, 'cash', 'STO ROSARIO (SN. PEDRO)', 'ZARAGOZA (SN. ISIDRO)', 140.00, 'Archie Vicente', '1234', '2024-12-16 21:52:15', '17343571352683989', 'notremitted'),
(169, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 636.00, 'Archie Vicente', '1234', '2024-12-16 21:53:23', '17343572038621708', 'notremitted'),
(170, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 106.00, 'Archie Vicente', '1234', '2024-12-16 21:53:51', '17343572319272258', 'notremitted'),
(171, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'TARLAC TERMINAL / ST. MARYS (METRO TOWN)', 85.00, 'Archie Vicente', '1234', '2024-12-16 21:54:04', '17343572448405149', 'notremitted'),
(172, 'cash', 'LAFUENTE', 'CARMEN (PANTOC)', 24.00, 'Carl Justin Velasco', '02A', '2024-12-17 21:16:49', '17344412263909741', 'notremitted'),
(173, 'cash', 'LAFUENTE', 'CARMEN (PANTOC)', 24.00, 'Carl Justin Velasco', '02A', '2024-12-17 21:18:21', '17344413180567831', 'notremitted'),
(174, 'cash', 'STO ROSARIO (SN. PEDRO)', 'SUMACAB', 20.00, 'Carl Justin Velasco', '02A', '2024-12-17 21:20:45', '17344414615094645', 'notremitted'),
(176, 'cash', 'STO ROSARIO (SN. PEDRO)', 'SUMACAB', 20.00, 'Carl Justin Velasco', '02A', '2024-12-17 21:20:57', '17344414749545757', 'notremitted'),
(178, 'cash', 'STO ROSARIO (SN. PEDRO)', 'SUMACAB', 20.00, 'Carl Justin Velasco', '02A', '2024-12-17 21:21:29', '17344415041447484', 'notremitted'),
(180, 'cash', 'STO ROSARIO (SN. PEDRO)', 'SUMACAB', 20.00, 'Carl Justin Velasco', '02A', '2024-12-17 21:21:49', '17344415276704497', 'notremitted'),
(181, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'INSPECTOR', 32.00, 'Carl Justin Velasco', '02A', '2024-12-17 21:22:18', '17344415450635113', 'notremitted'),
(183, 'cash', 'RAJAL CENTRO', 'STA CRUZ', 16.00, 'Archie Vicente', '02A', '2024-12-17 21:23:51', '17344416464316826', 'notremitted'),
(185, 'cash', 'RAJAL CENTRO', 'STA CRUZ', 16.00, 'Archie Vicente', '02A', '2024-12-17 21:24:00', '17344416557279767', 'notremitted'),
(186, '0006977439', 'RAJAL CENTRO', 'STA CRUZ', 16.00, 'Archie Vicente', '02A', '2024-12-17 21:24:36', '17344416930143350', 'notremitted'),
(187, '0006977439', 'SUMACAB', 'LAFUENTE', 14.00, 'Archie Vicente', '02A', '2024-12-17 21:24:56', '17344417136258815', 'notremitted'),
(188, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '02A', '2024-12-17 21:25:18', '17344417332522024', 'notremitted'),
(190, 'cash', 'STA. ROSA INTERSECTION', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 32.00, 'Carl Justin Velasco', '01b', '2024-12-18 21:51:25', '17345298852282841', 'notremitted'),
(191, 'cash', 'STO ROSARIO (SN. PEDRO)', 'MALABON', 16.00, 'Carl Justin Velasco', '01b', '2024-12-18 21:53:28', '17345300024018934', 'notremitted'),
(192, 'cash', 'STO ROSARIO (SN. PEDRO)', 'MALABON', 16.00, 'Carl Justin Velasco', '01b', '2024-12-18 21:53:33', '17345300110483816', 'notremitted'),
(193, '0012212828', 'STO ROSARIO (SN. PEDRO)', 'MALABON', 16.00, 'Carl Justin Velasco', '01b', '2024-12-18 21:55:18', '17345301125288242', 'notremitted'),
(194, '0012212828', 'STA. ROSA INTERSECTION', 'RAJAL CENTRO', 24.00, 'Carl Justin Velasco', '01b', '2024-12-18 21:55:32', '17345301308969978', 'notremitted'),
(195, 'cash', 'STA. ROSA INTERSECTION', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 20.00, 'Carl Justin Velasco', '01b', '2024-12-18 21:56:20', '17345301804989026', 'notremitted'),
(196, '0012212828', 'STA. ROSA INTERSECTION', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 32.00, 'Carl Justin Velasco', '01b', '2024-12-18 21:56:48', '17345302060833367', 'notremitted'),
(197, 'cash', 'MALABON', 'H. ROMERO', 14.00, 'Carl Justin Velasco', '01b', '2024-12-19 15:34:43', '17345936833794259', 'notremitted'),
(198, 'cash', 'LAFUENTE', 'CARMEN (PANTOC)', 24.00, 'Carl Justin Velasco', '01b', '2024-12-19 16:14:35', '17345960754597933', 'notremitted'),
(199, 'cash', 'LAFUENTE', 'CARMEN (PANTOC)', 24.00, 'Carl Justin Velasco', '01b', '2024-12-19 16:15:06', '17345961059807640', 'notremitted'),
(200, 'cash', 'H. ROMERO', 'DEEP WELL (STA ROSA)', 20.00, 'Carl Justin Velasco', '01b', '2024-12-19 16:15:25', '17345961250512558', 'notremitted'),
(201, 'cash', 'H. ROMERO', 'DEEP WELL (STA ROSA)', 20.00, 'Carl Justin Velasco', '01b', '2024-12-19 16:16:22', '17345961823532177', 'notremitted'),
(202, 'cash', 'RAJAL (SUR NORTE)', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 34.00, 'Carl Justin Velasco', '01b', '2024-12-19 16:16:38', '17345961986631366', 'notremitted'),
(203, 'cash', 'SAN JOSEPH', 'MALIWALO', 82.00, 'Carl Justin Velasco', '01b', '2024-12-19 16:17:08', '17345962288426251', 'notremitted'),
(204, 'cash', 'H. ROMERO', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '01b', '2024-12-19 16:29:59', '17345969992596213', 'notremitted'),
(205, 'cash', 'INSPECTOR', 'LAKEWOOD/PACIFIC', 48.00, 'Archie Vicente', '01b', '2024-12-19 16:31:34', '17345970943319962', 'notremitted'),
(206, 'cash', 'INSPECTOR', 'STO ROSARIO (SN. PEDRO)', 11.00, 'Carl Justin Velasco', '01b', '2024-12-19 20:55:55', '17346129553469749', 'notremitted'),
(207, 'cash', 'INSPECTOR', 'STO ROSARIO (SN. PEDRO)', 34.00, 'Carl Justin Velasco', '01b', '2024-12-19 20:56:08', '17346129683794236', 'notremitted'),
(208, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 14.00, 'Carl Justin Velasco', '02C', '2024-12-19 21:54:00', '17346164404583345', 'notremitted'),
(209, 'cash', 'INSPECTOR', 'INSPECTOR', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:04:00', '17346278400376871', 'notremitted'),
(210, 'cash', 'INSPECTOR', 'INSPECTOR', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:04:12', '17346278526347886', 'notremitted'),
(211, 'cash', 'STA. ROSA INTERSECTION', 'RAJAL CENTRO', 24.00, 'Archie Vicente', '02C', '2024-12-20 01:04:31', '17346278714806700', 'notremitted'),
(212, 'cash', 'ZARAGOZA (SN. ISIDRO)', 'INSPECTOR', 26.00, 'Archie Vicente', '02C', '2024-12-20 01:06:34', '17346279948591522', 'notremitted'),
(213, 'cash', 'MALABON', 'STA CRUZ', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:07:15', '17346280357411554', 'notremitted'),
(214, '0006977439', 'CARMEN (PANTOC)', 'STO ROSARIO (SN. PEDRO)', 22.00, 'Archie Vicente', '02C', '2024-12-20 01:08:29', '17346281063266817', 'notremitted'),
(215, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Archie Vicente', '02C', '2024-12-20 01:08:50', '17346281304148325', 'notremitted'),
(216, 'cash', 'MALABON', 'MALIWALO', 66.00, 'Archie Vicente', '02C', '2024-12-20 01:09:45', '17346281857196157', 'notremitted'),
(217, 'cash', 'RAJAL (SUR NORTE)', 'STO ROSARIO (SN. PEDRO)', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:12:08', '17346283288045393', 'notremitted'),
(218, 'cash', 'MALABON', 'STO ROSARIO (SN. PEDRO)', 16.00, 'Archie Vicente', '02C', '2024-12-20 01:12:45', '17346283651393362', 'notremitted'),
(219, 'cash', 'MALABON', 'INSPECTOR', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:14:07', '17346284475535314', 'notremitted'),
(220, 'cash', 'STO ROSARIO (SN. PEDRO)', 'INSPECTOR', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:14:51', '17346284912356268', 'notremitted'),
(221, 'cash', 'RAJAL CENTRO', 'LAFUENTE', 22.00, 'Archie Vicente', '02C', '2024-12-20 01:15:24', '17346285243532465', 'notremitted'),
(222, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'LAFUENTE', 22.00, 'Archie Vicente', '02C', '2024-12-20 01:26:07', '17346291671641694', 'notremitted'),
(223, 'cash', 'INSPECTOR', 'DEEP WELL (STA ROSA)', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:27:15', '17346292354831021', 'notremitted'),
(224, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Archie Vicente', '02C', '2024-12-20 01:28:17', '17346292979567328', 'notremitted'),
(225, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SUMACAB', 16.00, 'Archie Vicente', '02C', '2024-12-20 01:31:07', '17346294676663984', 'notremitted'),
(226, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Archie Vicente', '02C', '2024-12-20 01:31:21', '17346294809949239', 'notremitted'),
(227, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STA. ROSA INTERSECTION', 20.00, 'Archie Vicente', '02C', '2024-12-20 01:32:25', '17346295451844961', 'notremitted'),
(228, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '02C', '2024-12-20 01:34:16', '17346296561445832', 'notremitted'),
(229, 'cash', 'LAKEWOOD/PACIFIC', 'DEEP WELL (STA ROSA)', 20.00, 'Archie Vicente', '02C', '2024-12-20 01:36:59', '17346298198952886', 'notremitted'),
(230, 'cash', 'STO ROSARIO (SN. PEDRO)', 'STO ROSARIO (SN. PEDRO)', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:37:40', '17346298608639079', 'notremitted'),
(231, 'cash', 'RAJAL CENTRO', 'MALABON', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:38:20', '17346299005133728', 'notremitted'),
(232, 'cash', 'INSPECTOR', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 32.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:39:23', '17346299629661740', 'remitted'),
(233, 'cash', 'H. ROMERO', 'RAJAL CENTRO', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:40:11', '17346300118611973', 'notremitted'),
(234, 'cash', 'RAJAL (SUR NORTE)', 'DEEP WELL (STA ROSA)', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:41:39', '17346300991429421', 'notremitted'),
(235, 'cash', 'RAJAL (SUR NORTE)', 'DEEP WELL (STA ROSA)', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:42:53', '17346301738378855', 'notremitted'),
(236, 'cash', 'MALABON', 'RAJAL (SUR NORTE)', 14.00, 'Archie Vicente', '02C', '2024-12-20 01:44:04', '17346302446256943', 'notremitted'),
(237, 'cash', 'RAJAL CENTRO', 'DEEP WELL (STA ROSA)', 16.00, 'Archie Vicente', '02C', '2024-12-20 01:45:05', '17346303059725930', 'notremitted'),
(238, 'cash', 'STA. ROSA INTERSECTION', 'INSPECTOR', 18.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:45:15', '17346303157196041', 'remitted'),
(239, 'cash', 'RAJAL CENTRO', 'RAJAL (SUR NORTE)', 14.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:46:08', '17346303683874468', 'remitted'),
(240, 'cash', 'RAJAL CENTRO', 'STO ROSARIO (SN. PEDRO)', 14.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:46:40', '17346304003872812', 'remitted'),
(241, 'cash', 'MALABON', 'RAJAL CENTRO', 14.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:48:12', '17346304926303070', 'remitted'),
(242, '0006977439', 'RAJAL CENTRO', 'STA. ROSA INTERSECTION', 24.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:48:26', '17346305021298797', 'remitted'),
(243, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'STO ROSARIO (SN. PEDRO)', 30.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:50:04', '17346306014065075', 'remitted'),
(244, 'cash', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'DEEP WELL (STA ROSA)', 28.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:51:14', '17346306741205631', 'remitted'),
(245, '0006977439', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'SAN JOSEPH', 24.00, 'Carl Justin Velasco', '01b', '2024-12-20 01:51:22', '17346306800244928', 'remitted'),
(246, '0008303510', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 'RAJAL CENTRO', 38.00, 'Carl Justin Velasco', '02C', '2024-12-20 01:59:40', '17346311778759084', 'notremitted'),
(247, 'cash', 'MALABON', 'RAJAL (SUR NORTE)', 14.00, 'Carl Justin Velasco', '01b', '2024-12-20 02:53:09', '17346343896426481', 'remitted'),
(248, 'cash', 'SUMACAB', 'LAFUENTE', 14.00, 'Carl Justin Velasco', '01b', '2024-12-20 03:06:05', '17346351658064335', 'remitted'),
(249, 'cash', 'STO ROSARIO (SN. PEDRO)', 'CABANATUAN TERMINAL / LAKEWOOD AVE', 180.00, 'Carl Justin Velasco', '01b', '2024-12-20 03:15:46', '17346357464108659', 'remitted');

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
(55, '02C', '12814036', '2024-12-19', 300.00, 0.00, 300.00),
(56, '01b', '0012814036', '2024-12-19', 226.00, 0.00, 1032.00),
(57, '01b', '0012814036', '2024-12-19', 0.00, 0.00, 1032.00),
(58, '01b', '', '2024-12-19', 0.00, 0.00, 1032.00),
(59, '01b', '', '2024-12-19', 0.00, 0.00, 1032.00);

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
(7, 56, '01b', '0012814036', 226.00, 0.00, 0.00, 1032.00, '2024-12-19', '2024-12-19 19:14:33'),
(8, 57, '01b', '0012814036', 0.00, 0.00, 0.00, 1032.00, '2024-12-19', '2024-12-19 19:14:41');

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
(156, 109, '0006977439', 400.00, 'Load', '02C', '0012814036', '2024-12-19 18:41:05', 'notremitted'),
(157, 95, '0008303510', 100.00, 'Load', '02C', '0012814036', '2024-12-19 18:41:42', 'notremitted'),
(158, 109, '0006977439', 100.00, 'Load', '01b', '0006977439', '2024-12-19 19:11:56', 'remitted'),
(159, 95, '0008303510', 1000.00, 'Load', '01b', '0006977439', '2024-12-19 19:15:15', 'remitted'),
(160, 95, '0008303510', 100.00, 'Load', '02C', '0012814036', '2024-12-19 19:26:42', 'notremitted'),
(161, 95, '0008303510', 100.00, 'Load', '02C', '0012814036', '2024-12-19 19:27:09', 'notremitted'),
(162, 95, '0008303510', 100.00, 'Deduct', '', '', '2024-12-19 19:32:41', 'notremitted'),
(163, 95, '0008303510', 100.00, 'Deduct', '', '', '2024-12-19 19:34:08', 'notremitted'),
(164, 95, '0008303510', 100.00, 'Deduct', '', '', '2024-12-19 19:34:54', 'notremitted'),
(165, 95, '0008303510', 100.00, 'Deduct', '', '', '2024-12-19 19:35:53', 'notremitted'),
(166, 95, '0008303510', 100.00, 'Deduct', '', '', '2024-12-19 19:37:27', 'notremitted'),
(167, 109, '0006977439', 120.00, 'Deduct', '02C', '0012814036', '2024-12-19 20:31:19', 'notremitted'),
(168, 95, '0008303510', 100.00, 'Deduct', '', '', '2024-12-19 20:32:14', 'notremitted'),
(169, 109, '0006977439', 110.00, 'Deduct', '02C', '0012814036', '2024-12-19 20:33:00', 'notremitted'),
(170, 95, '0008303510', 100.00, 'Deduct', '01b', '0006977439', '2024-12-19 20:34:09', 'notremitted'),
(171, 106, '0012814036', 200.00, 'Load', '01b', '0006977439', '2024-12-19 20:38:32', 'notremitted'),
(172, 106, '0012814036', 150.00, 'Load', '01b', '0006977439', '2024-12-19 20:49:14', 'notremitted');

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
  `role` enum('User','Admin','Cashier','Conductor','Superadmin') DEFAULT 'User',
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
(92, '0006977432', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'archiediaz29@gmail.com', '12335654323', '034900000', '34928000', '34928023', 'TAPAT NG TRIPLE GGG GAS STATION', '40362563791c06d521db25d58d066b71', 892.00, 'User', '2024-10-28 13:34:00', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 50.00),
(95, '0008303510', 'Gencel Kaye', NULL, 'Beley', 'Muncal', '', '2002-12-06', 21, 'Female', 'gencelbeley06@gmail.com', '98765456789', '34900000', '34928000', '34928027', '123', '04c8873a49fd163df2a074015d3928bd', 2162.00, 'User', '2024-11-02 11:55:21', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 15.00),
(105, '0012245507', 'LynMarie', NULL, 'vicente', 'asdasd', 'Jr', '2002-03-03', 22, 'Male', 'jemusu96@gmail.com', '12123121222', '34900000', '34928000', '34928023', 'sadas', '2637a5c30af69a7bad877fdb65fbd78b', 0.00, 'User', '2024-11-02 16:38:44', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(106, '0012814036', 'Archie', NULL, 'Vicente', 'Diaz', '', '2003-06-29', 21, 'Male', 'vicentearchiediaz29@gmail.com', '9755102091', '34900000', '34928000', '34928023', '', '2637a5c30af69a7bad877fdb65fbd78b', 554.50, 'Superadmin', '2024-11-03 11:46:11', 1, 'National ID', '../assets/uploads/1ea456a9-41e1-416c-a95d-18c2a1b3a736.jpg', 62.00),
(107, '0013438657', 'LynMarie', NULL, 'Mapoy', 'Lubo', '', '2003-03-01', 21, 'Female', 'lynmariemapoy7@gmail.com', '91234567899', '34900000', '34912000', '34912027', '', 'ab974df2ea1472c3cbdc1fafe76bea88', 0.00, 'Cashier', '2024-11-03 12:41:29', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(109, '0006977439', 'Carl Justin', NULL, 'Velasco', 'De lara', '', '2002-03-16', 22, 'Male', 'carljustindlvelasco@gmail.com', '12345678987', '34900000', '34928000', '34928002', '', '51a2981bc0ebfb859f60266fb615327d', 19233.00, 'Conductor', '2024-11-04 05:43:03', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 1542.00),
(110, '0011768982', 'Alexa', NULL, 'Lavesores', 'asd', '', '2002-06-10', 22, 'Female', 'aisharicaalexalavesores@gmail.com', '12345678976', '37700000', '37701000', '37701010', '123', '022f5965aac6fa9ef0e89cfffdbdb1b8', 0.00, 'User', '2024-11-04 05:49:08', 1, 'National ID', '../assets/uploads/national-id_2022-11-21_21-58-01.jpg', 0.00),
(111, '0006977431', 'EJ', NULL, 'Lajom', 'a', '', '2002-12-04', 22, 'Male', 'kundolatpatola4@gmail.com', '12345678123', '34900000', '34928000', '34928002', 'a', '7df56eca11075c2a05705a70604d4f89', 0.00, 'User', '2024-12-05 11:50:59', 1, 'National ID', 'national-id_2022-11-21_21-58-01.jpg', 0.00),
(115, '0006695015', 'John Philip', NULL, 'Diamat', 'Nagaño', '', '2002-10-17', 22, 'Male', 'jpdiamat11@gmail.com', '12145432134', '34900000', '34928000', '34928011', 'a', '976897d24b590887794458eaf9e1a35a', 0.00, 'User', '2024-12-06 08:32:30', 1, 'National ID', '462573133_928421985472156_4742743932728315884_n.jpg', 0.00),
(119, '0006695007', 'James Andrew', NULL, 'Beley', 'Adriano', '', '2002-04-07', 22, 'Male', 'jemusubeley@gmail.com', '9168628698', '34900000', '34928000', '34928016', 'sa tabi tabi', '16d97fd984b4cfd289d80e499c6aba7f', 500.00, 'User', '2024-12-14 11:49:33', 1, '', '', 24.00),
(120, '0011841717', 'Aisharica Alexa', NULL, 'Lavesores', '', '', '2002-12-23', 21, 'Female', 'lavesoresalex@gmail.com', '9920380332', '34900000', '34928000', '34928029', '197 purok 5', 'f4cc657b969e75bebd4e0b6954636462', 28492.00, 'User', '2024-12-17 12:48:50', 1, '', '', 1430.00),
(123, '0012212828', 'Diana Rose', NULL, 'Maglalang', 'Rufino', '', '2002-10-18', 22, 'Female', 'dianarosemaglalang25@gmail.com', '9168628696', '34900000', '34928000', '34928002', '131', '2637a5c30af69a7bad877fdb65fbd78b', 1428.00, 'User', '2024-12-18 13:13:09', 1, '', '', 180.00);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `businfo`
--
ALTER TABLE `businfo`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT for table `remittances`
--
ALTER TABLE `remittances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `remit_logs`
--
ALTER TABLE `remit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `useracc`
--
ALTER TABLE `useracc`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

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
